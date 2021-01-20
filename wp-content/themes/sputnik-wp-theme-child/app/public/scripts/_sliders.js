// Import Swiper and modules
import { Swiper, Navigation, Pagination, Autoplay } from "swiper/swiper.esm.js";

Swiper.use([Navigation, Pagination, Autoplay]);

document.addEventListener("DOMContentLoaded", function () {
  //* Always check if element exist for secure
  if (document.getElementById("communicat")) {
    const messagesSlider = new Swiper("#communicat", {
      spaceBetween: 0,
      // centeredSlides: true,
      speed: 7000,
      autoplay: {
        delay: 1,
      },
      loop: true,
      slidesPerView: 2,
      allowTouchMove: false,
      disableOnInteraction: true,

      // ! Get from _responsive.scss breakpoints
      breakpoints: {
        360: {},
        580: {},
        768: {},
        992: {},
        1170: {},
      },
    });
  }

  if (document.querySelector(".hero")) {
    const heroSlider = new Swiper(".hero .swiper-container", {
      loop: false,
      speed: 500,
      spaceBetween: 0,
      slidesPerView: 1,

      // If we need pagination
      pagination: {
        el: ".hero .swiper-pagination",
      },

      // Navigation arrows
      navigation: {
        prevEl: ".hero .swiper-button-prev",
        nextEl: ".hero .swiper-button-next",
      },

      // ! Get from _responsive.scss breakpoints
      breakpoints: {
        360: {},
        580: {},
        768: {},
        992: {},
        1170: {},
      },
    });
  }

  if (document.querySelector(".menu-pod-banerem-glownym")) {
    const slidesVisible = document.querySelector(".menu-pod-banerem-glownym").dataset.slidesVisible;

    const underHeroSlider = new Swiper(".menu-pod-banerem-glownym", {
      loop: false,
      speed: 500,
      spaceBetween: 30,
      slidesPerView: slidesVisible,

      // Navigation arrows
      navigation: {
        prevEl: ".slider-icon-links .swiper-button-prev",
        nextEl: ".slider-icon-links .swiper-button-next",
      },

      // ! Get from _responsive.scss breakpoints
      breakpoints: {
        360: {},
        580: {},
        768: {},
        992: {},
        1170: {},
      },
    });
  }

  if (document.querySelector(".menu-numery-alarmowe")) {
    const slidesVisible = document.querySelector(".menu-numery-alarmowe").dataset.slidesVisible;

    const emergencyNumbersSlider = new Swiper(".menu-numery-alarmowe", {
      loop: false,
      speed: 500,
      spaceBetween: 15,
      slidesPerView: slidesVisible,

      // Navigation arrows
      navigation: {
        prevEl: ".emergency-numbers .swiper-button-prev",
        nextEl: ".emergency-numbers .swiper-button-next",
      },

      // ! Get from _responsive.scss breakpoints
      breakpoints: {
        360: {},
        580: {},
        768: {},
        992: {},
        1170: {},
      },
    });
  }
});
