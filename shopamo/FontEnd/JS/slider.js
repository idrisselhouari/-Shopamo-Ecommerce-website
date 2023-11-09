
const slideImage = document.querySelectorAll(".slide-image");
const mainSlider = document.querySelector(".main-slider");
const nextBtn = document.querySelector(".next-btn");
const prevBtn = document.querySelector(".prev-btn");
const navigationDots = document.querySelector(".navigation-dots");
//let slideWidth=slideImage[0].clientWidth;
let numberOfImage = slideImage.length;
let currentSlide = 0;

// generation for the slides images
function slideUnit(){
    /*
    slideImage[0] = 0
let slideWidth = slideImage[0].clientWidth;
    slideImage[1] = 100%
    slideImage[2] = 200%
    */
    slideImage.forEach((img, i)=>{
        img.style.left = i * 100 + "%";
    });
    slideImage[0].classList.add("active");
    createNavigaionDots();
}
slideUnit();

//Function for create navigation dots

function createNavigaionDots(){
    for(let i = 0; i<numberOfImage;i++){
        const dot = document.createElement("div");
        dot.classList.add("single-dot");
        navigationDots.appendChild(dot);

        dot.addEventListener("click",() =>{
            goToSlide(i);
        })
    }
    navigationDots.children[0].classList.add("active");
}
//Next button
nextBtn.addEventListener("click", ()=>{
    if(currentSlide >= numberOfImage -1){
        goToSlide(0);
        return;
    }
    currentSlide++;
    goToSlide(currentSlide);
})
//Prev button
prevBtn.addEventListener("click", ()=>{
    if(currentSlide <= 0){
        goToSlide(numberOfImage -1);
        return;
    }
    currentSlide--;
    goToSlide(currentSlide);
})
//Function for create go to slide 
function goToSlide(slideNumber){
    mainSlider.style.transform = "translateX(-" +
    640 * slideNumber + "px)";

    currentSlide = slideNumber;
    setActiveClass()
}

// Set Active Class
function setActiveClass(){
    //set active class for slide image
    let currentActive= document.querySelector(".slide-image.active");
    currentActive.classList.remove("active");
    slideImage[currentSlide].classList.add("active");

    //set Active class for navigation dots
    let currentDot= document.querySelector(".single-dot.active");
    currentDot.classList.remove("active");
    navigationDots.children[currentSlide].classList.add("active");
    
}