let removeFilterBtn = document.querySelector('.a__filterRemove')
let filter = document.querySelector('.filter')

removeFilterBtn.addEventListener('click', (e) => {
    console.log("hey")
    filter.style.display = "none"
})