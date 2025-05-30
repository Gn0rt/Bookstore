const iconArrowUp = document.querySelector('.backToTop__icon');

console.log(iconArrowUp);
console.log(window.scrollY > 500)

window.addEventListener('scroll', () => {
    console.log(window.scrollY)
    if (window.scrollY > 800) {
        iconArrowUp.style.visibility = "unset";
    }
    else {
        iconArrowUp.style.visibility = "hidden";
    }
})

iconArrowUp.addEventListener('click', () => {
    window.scrollTo({
        top: 0,
        behavior: "smooth"
    })
    iconArrowUp.style.visibility = "hidden";

})
