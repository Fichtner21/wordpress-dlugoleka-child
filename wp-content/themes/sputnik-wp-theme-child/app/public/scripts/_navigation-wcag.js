document.addEventListener("DOMContentLoaded", function () {
  (function () {
    const siteNavigation = document.getElementById("js-wcag-navigation");

    // Return early if the navigation don't exist.
    if (!siteNavigation) {
      return;
    }

    const button = siteNavigation.getElementsByTagName("button")[0];

    // Return early if the button don't exist.
    if ("undefined" === typeof button) {
      return;
    }

    const wcagContent = siteNavigation.querySelector(".wcag-nav__content");

    const activeClass = "active";

    const bodyOverlay = document.createElement("div");

    bodyOverlay.className = "js-body-overlay-wcag";

    document.body.appendChild(bodyOverlay);

    // Toggle the .toggled class and the aria-expanded value each time the button is clicked.
    button.addEventListener("click", function () {
      siteNavigation.classList.toggle("toggled");

      if (button.getAttribute("aria-expanded") === "true") {
        button.setAttribute("aria-expanded", "false");
        button.classList.remove(activeClass);
        wcagContent.classList.remove(activeClass);
        bodyOverlay.classList.remove(activeClass);
      } else {
        button.setAttribute("aria-expanded", "true");
        button.classList.add(activeClass);
        wcagContent.classList.add(activeClass);
        bodyOverlay.classList.add(activeClass);
      }
    });

    // Remove the .toggled class and set aria-expanded to false when the user clicks outside the navigation.
    document.addEventListener("click", function (event) {
      const isClickInside = siteNavigation.contains(event.target);

      if (!isClickInside) {
        siteNavigation.classList.remove("toggled");
        button.setAttribute("aria-expanded", "false");
        wcagContent.classList.remove(activeClass);
        button.classList.remove(activeClass);
        bodyOverlay.classList.remove(activeClass);
      }
    });
  })();
});
