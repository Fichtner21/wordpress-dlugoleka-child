import Cookies from "js-cookie";

document.addEventListener("DOMContentLoaded", function () {
  // Fonts
  const fontButtons = document.querySelectorAll(".font__button");
  const cookieName = "font";

  let fontSizeValue = 62.5;

  if (Cookies.get("font")) {
    document.documentElement.style.fontSize = `${Cookies.get("font")}%`;
  }

  fontButtons.forEach((button) => {
    button.addEventListener("click", function (e) {
      const thisDataAction = this.dataset.action;

      if (thisDataAction === "font-smaller") {
        if (fontSizeValue > 42.5) {
          document.documentElement.style.fontSize = `${(fontSizeValue -= 5)}%`;

          Cookies.set(cookieName, fontSizeValue);
        }
      } else if (thisDataAction === "font-bigger") {
        if (fontSizeValue < 82.5) {
          document.documentElement.style.fontSize = `${(fontSizeValue += 5)}%`;

          Cookies.set(cookieName, fontSizeValue);
        }
      } else {
        fontSizeValue = 62.5;

        document.documentElement.style.fontSize = `${fontSizeValue}%`;

        Cookies.set(cookieName, fontSizeValue);
      }
    });
  });
});
