import Cookies from "js-cookie";

document.addEventListener('DOMContentLoaded',function() {
  // Contrast
  const contrastButton = document.querySelector(".contrast__button");
  const cookieName = "contrast";

  contrastButton.addEventListener("click", function (e) {
    const thisDataAction = this.dataset.action;

    if (Cookies.get(cookieName) === thisDataAction) {
      document.documentElement.classList.remove(thisDataAction);

      Cookies.set(cookieName, "");
    } else {
        document.documentElement.classList.add(thisDataAction);

      Cookies.set(cookieName, `${thisDataAction}`);
    }
  });
});

