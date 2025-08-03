document.addEventListener("DOMContentLoaded", function () {
    console.log("[DEBUG] Mulai Inisialisasi Monitoring");

    let sensorChart;
    const canvas = document.getElementById("sensorChart");
    const ctx = canvas?.getContext("2d");

    function initChart(labels, suhuData, kelembapanData, ketinggianData) {
        if (sensorChart) sensorChart.destroy();

        sensorChart = new Chart(ctx, {
            type: "line",
            data: {
                labels,
                datasets: [
                    {
                        label: "Suhu (°C)",
                        data: suhuData,
                        borderColor: "rgba(255, 99, 132, 1)",
                        backgroundColor: "rgba(255,99,132,0.1)",
                        fill: true,
                        tension: 0.4,
                    },
                    {
                        label: "Kelembapan (%)",
                        data: kelembapanData,
                        borderColor: "rgba(54, 162, 235, 1)",
                        backgroundColor: "rgba(54, 162, 235, 0.1)",
                        fill: true,
                        tension: 0.4,
                    },
                    {
                        label: "Ketinggian Air (cm)",
                        data: ketinggianData,
                        borderColor: "rgba(255, 206, 86, 1)",
                        backgroundColor: "rgba(255, 206, 86, 0.1)",
                        fill: true,
                        tension: 0.4,
                    },
                ],
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: "top",
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
            },
        });
    }

    function updateChartData(labels, suhuData, kelembapanData, ketinggianData) {
        if (!sensorChart) return;
        sensorChart.data.labels = labels;
        sensorChart.data.datasets[0].data = suhuData;
        sensorChart.data.datasets[1].data = kelembapanData;
        sensorChart.data.datasets[2].data = ketinggianData;
        sensorChart.update();
    }

    async function fetchSensorData() {
        try {
            const response = await fetch("/api/sensor-terbaru");
            if (!response.ok) throw new Error("Gagal mengambil data sensor");
            const data = await response.json();

            updateSensorCards(data);
            updateStatus(data.ketinggian_air);
            updateDateDisplay(data.tanggal);

            const chartRes = await fetch("/api/sensor-chart");
            if (!chartRes.ok) throw new Error("Gagal mengambil data grafik");
            const chartData = await chartRes.json();
            updateChartData(
                chartData.labels,
                chartData.suhu,
                chartData.kelembapan,
                chartData.ketinggian
            );
        } catch (error) {
            console.error("[ERROR fetchSensorData]", error);
        }
    }

    function updateSensorCards(data) {
        const suhu = document.getElementById("suhu");
        const kelembapan = document.getElementById("kelembapan");
        const ketinggian = document.getElementById("ketinggian");

        if (suhu) suhu.innerHTML = `${data.suhu} <span class="fs-5">°C</span>`;
        else console.warn("[WARN] Element #suhu tidak ditemukan");

        if (kelembapan)
            kelembapan.innerHTML = `${data.kelembapan} <span class="fs-5">%</span>`;
        else console.warn("[WARN] Element #kelembapan tidak ditemukan");

        if (ketinggian)
            ketinggian.innerHTML = `${data.ketinggian_air} <span class="fs-5">cm</span>`;
        else console.warn("[WARN] Element #ketinggian tidak ditemukan");
    }

    function updateStatus(ketinggian) {
        const statusBox = document.getElementById("statusBox");
        const statusText = document.getElementById("statusText");
        const statusIcon = document.getElementById("statusIcon");

        statusBox.classList.remove(
            "status-aman",
            "status-waspada",
            "status-bahaya"
        );

        if (ketinggian <= 1) {
            statusBox.classList.add("status-aman");
            statusText.textContent =
                "Aman: Ketinggian air masih dalam batas normal.";
            statusIcon.textContent = "✅";
        } else if (ketinggian <= 3) {
            statusBox.classList.add("status-waspada");
            statusText.textContent = "Waspada! Ketinggian air mulai meningkat.";
            statusIcon.textContent = "⚠️";
        } else {
            statusBox.classList.add("status-bahaya");
            statusText.textContent = "Bahaya! Ketinggian air sudah tinggi!";
            statusIcon.textContent = "🚨";
        }
    }

    function updateDateDisplay(tanggal) {
        const tgl = new Date(tanggal);
        const formattedDate = tgl.toLocaleDateString("id-ID", {
            day: "2-digit",
            month: "short",
            year: "numeric",
        });

        document.querySelectorAll(".tanggal").forEach((el) => {
            el.textContent = formattedDate;
        });
    }

    async function refreshHistoryTable() {
        try {
            const response = await fetch("/api/sensor-history");
            if (!response.ok) throw new Error("Gagal mengambil data riwayat");
            const data = await response.json();
            const tbody = document.querySelector("table tbody");
            tbody.innerHTML = "";

            data.forEach((item, index) => {
                const date = new Date(item.tanggal);
                const row = `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${date.toLocaleDateString("id-ID", {
                            day: "2-digit",
                            month: "short",
                            year: "numeric",
                            hour: "2-digit",
                            minute: "2-digit",
                            second: "2-digit",
                        })}</td>
                        <td>${item.suhu}</td>
                        <td>${item.kelembapan}</td>
                        <td>${item.ketinggian_air}</td>
                    </tr>
                `;
                tbody.innerHTML += row;
            });
        } catch (error) {
            console.error("[ERROR refreshHistoryTable]", error);
        }
    }

    // Init chart pertama
    if (window.chartInitData) {
        initChart(
            window.chartInitData.labels,
            window.chartInitData.suhu,
            window.chartInitData.kelembapan,
            window.chartInitData.ketinggian
        );
    }

    // Jalankan fetch pertama kali
    fetchSensorData();
    refreshHistoryTable();

    // Auto refresh detik
    setInterval(() => {
        fetchSensorData();
        refreshHistoryTable();
    }, 7000);
    console.log("[DEBUG] Selesai fetchSensorData");
});
