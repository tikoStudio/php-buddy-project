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
        //let errorEmail = result.body;
        const errorEmail = document.querySelector(".form__error"); //.innerHTML = `<p>${errorEmail}</p>`;

        if(result['status'] === "succes") {
            errorEmail.innerHTML = `<p style='color: green;'>Email is bruikbaar</p>`;
        }
        else {
            errorEmail.innerHTML = `<p style='color: red;'>Email is al in gebruik</p>`;
        }

    })
    .catch((error) => {
    console.error('Error:', error);
    });
});