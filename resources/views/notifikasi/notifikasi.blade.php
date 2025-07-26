@section('script')
<script>
function toggleCard() {
    var card = document.getElementById("expandable-card");
    var link = document.getElementById("expand-link");

    if (card.classList.contains("collapsed-card")) {
        card.classList.remove("collapsed-card");
        card.classList.add("expanded-card");
        link.innerHTML = "Lebih sedikit";
    } else {
        card.classList.remove("expanded-card");
        card.classList.add("collapsed-card");
        link.innerHTML = "Selengkapnya";
    }
}
</script>
@endsection