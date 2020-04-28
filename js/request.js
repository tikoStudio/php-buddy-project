function request(button) {
    let userId1 = button.dataset.userid1;
    let userId2 = button.dataset.userid2;
    //post naar database (ajax)
    let formData = new FormData();
    formData.append('userId1', userId1);
    formData.append('userId2', userId2);
    fetch('ajax/requestMatch.php', {
        method: 'POST',
        body: formData
    })
    .then((response) => response)
    .then((result) => {
       document.querySelector('.buddyConfirm').style.display = "flex"
    })
    .catch((error) => {
        console.error('Error:', error);
    });
}
