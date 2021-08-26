function searchFunction() {
    let boxtr = document.getElementsByClassName("boxtr");
    let input = document.getElementById("search");
    let filter = input.value.toUpperCase();
    let titles = document.getElementsByClassName("title");
    for (i = 0; i < boxtr.length; i++) {
        for (i = 0; i < titles.length; i++) {
            title = titles[i];
            txtValue = title.textContent || title.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                boxtr[i].style.display = "";
            } else {
                boxtr[i].style.display = "none";
            }
        }
    }
}

