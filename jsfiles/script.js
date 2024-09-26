const slides = document.querySelector(".slider-inner-container").children;

let index = 0;

function changeSlide() {
  for (let i = 0; i < slides.length; i++) {
    slides[i].classList.remove("active");
  }
  slides[index].classList.add("active");
}

const prev = document.querySelector(".prev");
const next = document.querySelector(".next");

function nextSlide() {
  if (index == slides.length - 1) {
    index = 0;
  } else {
    index++;
  }
  changeSlide();
}

function prevSlide() {
  if (index == 0) {
    index = slides.length - 1;
  } else {
    index--;
  }
  changeSlide();
}
prev.addEventListener("click", function () {
  prevSlide();
});
next.addEventListener("click", function () {
  nextSlide();
});
function nextSlide() {
  if (index == slides.length - 1) {
    index = 0;
  } else {
    index++;
  }
  changeSlide();
}

// swiping
let touchstartX = 0;
let touchendX = 0;

function checkDirection() {
  if (touchendX < touchstartX) {
    nextSlide();
  }
  if (touchendX > touchstartX) {
    prevSlide();
  }
}

document.addEventListener("touchstart", (e) => {
  touchstartX = e.changedTouches[0].screenX;
});

document.addEventListener("touchend", (e) => {
  touchendX = e.changedTouches[0].screenX;
  checkDirection();
});

// showing and hididng
function open_gallery() {
  document.getElementById("gallery_container").style.display = "block";
  // disable scrolling
  document.body.style.overflow = "hidden";
}
function close_gallery() {
  document.getElementById("gallery_container").style.display = "none";
  // Enable scrolling
  document.body.style.overflow = "";
}
