document.addEventListener("DOMContentLoaded", function () {
  if (document.querySelectorAll(".menu .menu-item a").length > 0) {
    const menuAnchors = document.querySelectorAll(".menu .menu-item a");

    menuAnchors.forEach((anchor) => {
      if (anchor.querySelector(".menu-item__title")) {
        const correctTitle = anchor.querySelector(".menu-item__title").textContent;

        if (anchor.title != correctTitle) {
          anchor.title = anchor.querySelector(".menu-item__title").textContent;
        }
      }
    });
  }
});
