const observer = new IntersectionObserver(entries => {entries.forEach(entry=> {
    if(entry.isIntersecting){
        document.querySelectorAll(".animated")[0].classList.add("fadeinr1");
        document.querySelectorAll(".animated")[1].classList.add("fadeinl1");
        document.querySelectorAll(".animated")[2].classList.add("fadeinr2");
        document.querySelectorAll(".animated")[3].classList.add("fadeint0");
        document.querySelectorAll(".animated")[4].classList.add("fadeinl2");
        document.querySelectorAll(".animated")[5].classList.add("fadeinr3");
        document.querySelectorAll(".animated")[6].classList.add("fadeinl3");
    }
})})

observer.observe(document.querySelector(".lastwork-grid"));
const showBtn = document.querySelector('.navBtn');
const topNav = document.querySelector('.top-nav');

showBtn.addEventListener('click', function(){
    if(topNav.classList.contains('showNav')){
        topNav.classList.remove('showNav');
        showBtn.innerHTML = '<i class = "fas fa-bars"></i>';
    } else {
        topNav.classList.add('showNav');
        showBtn.innerHTML = '<i class = "fas fa-times"></i>';
    }
});

