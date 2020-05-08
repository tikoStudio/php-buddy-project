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
        const errorField = document.querySelector(".form__error"); 

        if(result['status'] === "succes") {
            errorField.innerHTML = `<p style='color: green;'>${errorEmail}</p>`;
        }
        else {
            errorField.innerHTML = `<p style='color: red;'>${errorEmail}</p>`;
        }
    })
    .catch((error) => {
    console.error('Error:', error);
    });
});