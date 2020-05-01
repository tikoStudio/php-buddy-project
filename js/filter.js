let removeFilterBtn = document.querySelector('.a__filterRemove')
let filter = document.querySelector('.filter')

removeFilterBtn.addEventListener('click', (e) => {
    filter.style.display = "none"
})