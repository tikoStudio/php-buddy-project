document.querySelector("#email").addEventListener("keyup", function() {
    let email = document.querySelector("#email").value;

    let formData = new FormData();
    formData.append('email', email);

    fetch('ajax/validateEmail.php', {
    method: 'POST',
    body: formData
    })
    .then((response) => response.json())
    .then((result) => {
        let errorEmail = result.body;
        console.log(email)
        document.querySelector(".form__error").innerHTML = `<p>${errorEmail}</p>`;

    })
    .catch((error) => {
    console.error('Error:', error);
    });
});