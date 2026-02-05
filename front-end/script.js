// --- NAV MENU ---
const hamburger = document.querySelector('.hamburger-menu');
const navLinks = document.querySelector('.nav-links');

hamburger.addEventListener('click', () => {
  navLinks.classList.toggle('active');
});

// --- MAIN CAROUSEL ---
const slides = document.querySelectorAll(".slide");
const dots = document.querySelectorAll(".dot");
let currentIndex = 0;
let interval1;

function showMainSlide(index) {
  if (index >= slides.length) index = 0;
  if (index < 0) index = slides.length - 1;

  document.querySelector(".carousel-part1").style.transform = `translateX(-${index * 100}%)`;

  dots.forEach(dot => dot.classList.remove("active"));
  dots[index].classList.add("active");

  currentIndex = index;
}

function startMainAutoSlide() {
  interval1 = setInterval(() => {
    showMainSlide(currentIndex + 1);
  }, 3000);
}

dots.forEach((dot, index) => {
  dot.addEventListener("click", () => {
    showMainSlide(index);
    clearInterval(interval1);
    startMainAutoSlide();
  });
});

// Initialize main carousel
showMainSlide(currentIndex);
startMainAutoSlide();


// --- SIDE BOX + SECOND CAROUSEL ---
const box = document.querySelector(".side-box");
const slides2 = document.querySelectorAll(".slide2");
let currentIndex2 = 0;
let interval2;

function showSideSlide(index) {
  if (index >= slides2.length) index = 0;
  if (index < 0) index = slides2.length - 1;

  document.querySelector(".carousel2-part").style.transform = `translateX(-${index * 100}%)`;
  currentIndex2 = index;
}

function startSideAutoSlide() {
  interval2 = setInterval(() => {
    showSideSlide(currentIndex2 + 1);
  }, 3800);
}

// --- SLIDE IN/OUT CONTROL ---
function startBoxSlideLoop() {
  function cycle() {
    box.classList.add("show"); // slide in
    setTimeout(() => {
      box.classList.remove("show"); // slide out
      setTimeout(cycle, 1500); // wait before sliding in again
    }, 3500); // stay visible for 5s
  }
  cycle();
}

// Initialize side carousel + motion
showSideSlide(currentIndex2);
startSideAutoSlide();
startBoxSlideLoop();


