document.querySelector("#email").addEventListener("click", function() {
    let text = document.querySelector("#email").value;

    // post naar databank
    let formData = new FormData();

    formData.append('text', text);

    fetch('ajax/validateEmail.php', {
    method: 'POST',
    body: formData
    })
    .then((response) => response.json())
    .then((result) => {
    console.log('Success:', result);
    })
    .catch((error) => {
    console.error('Error:', error);
    });
});