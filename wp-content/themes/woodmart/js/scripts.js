document.addEventListener("DOMContentLoaded", function () {
  const slider = document.querySelector(".mySwiper");
  if (slider && typeof Swiper !== "undefined") {
    new Swiper(".mySwiper", {
      loop: true,
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
      autoplay: {
        delay: 5000,
      },
      speed: 800,
    });
  }

  const burger = document.getElementById("burger");
  const navLinks = document.getElementById("mobile-nav");
  if (burger && navLinks) {
    burger.addEventListener("click", function () {
      navLinks.classList.toggle("active");
    });
  }
});
