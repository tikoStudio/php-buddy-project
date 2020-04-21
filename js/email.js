document.querySelector("#email").addEventListener("click", function() {
    let email = this.dataset.id;
    let text = document.querySelector("#email").value;

    console.log(email);
    console.log(text);
});