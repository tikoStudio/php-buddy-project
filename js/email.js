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
        let errorEmail = document.createElement('p');
        errorEmail.innerHTML = result.body;
        document.querySelector(".form__error").appendChild(errorEmail);
    })
    .catch((error) => {
    console.error('Error:', error);
    });
});