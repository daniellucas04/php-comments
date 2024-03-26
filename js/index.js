function submitOnEnter(event) {
    if(event.key === 'Enter'){
        event.preventDefault();
        document.getElementById("submit").click();
    }
}

let input = document.getElementById("comments");
input.addEventListener("keypress", submitOnEnter);