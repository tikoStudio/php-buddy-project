function request(button) {
    let userId1 = button.dataset.userid1;
    let userId2 = button.dataset.userid2;
    let buddyEmail = button.dataset.buddyemail;
    //post naar database (ajax)
    let formData = new FormData();
    formData.append('userId1', userId1);
    formData.append('userId2', userId2);
    formData.append('buddyEmail', buddyEmail);
    fetch('ajax/requestMatch.php', {
        method: 'POST',
        body: formData
    })
    .then((response) => response.json())
    .then((result) => {
       window.location.href = "index.php";
    })
    .catch((error) => {
        console.error('Error:', error);
    });
}
