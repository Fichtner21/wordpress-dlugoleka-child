// Import Swiper and modules
import { Swiper, Navigation, Pagination, Autoplay } from "swiper/swiper.esm.js";

Swiper.use([Navigation, Pagination, Autoplay]);

document.addEventListener("DOMContentLoaded", function () {
  // * Always check if element exist for secure
  if (document.querySelector(".module-messages")) {
    const messagesSlider = new Swiper(".module-messages .swiper-container", {
      loop: true,
      speed: 3000,
      spaceBetween: 20,
      slidesPerView: 1,
      centeredSlides: true,
      autoplay: {
        delay: 0,
        waitForTransition: false,
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

  if (document.querySelector(".menu-pod-bannerem-glownym")) {
    const slidesVisible = document.querySelector(".menu-pod-bannerem-glownym").dataset.slidesVisible;

    const underHeroSlider = new Swiper(".menu-pod-bannerem-glownym.swiper-container", {
      loop: false,
      speed: 500,
      spaceBetween: 30,
      slidesPerView: slidesVisible,

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

    const emergencyNumbersSlider = new Swiper(".menu-numery-alarmowe.swiper-container", {
      loop: false,
      speed: 500,
      spaceBetween: 15,
      slidesPerView: slidesVisible,

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
