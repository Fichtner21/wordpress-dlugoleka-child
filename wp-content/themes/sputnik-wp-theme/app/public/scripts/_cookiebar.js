import Cookies from "js-cookie";

document.addEventListener("DOMContentLoaded", function () {
  const cookieBar = document.createElement("div");
  const cookieBarText = document.createElement("p");
  const cookieBarAccept = document.createElement("button");

  cookieBar.className = "cookie-bar";
  cookieBarText.className = "cookie-bar__text";
  cookieBarAccept.className = "btn btn--primary cookie-bar__btn";

  cookieBarAccept.textContent = "Ok";
  cookieBarText.textContent =
    "Strona korzysta z plików cookies w celu realizacji usług. Możesz określić warunki przechowywania lub dostępu do plików cookies w Twojej przeglądarce.";

  cookieBar.appendChild(cookieBarText);
  cookieBar.appendChild(cookieBarAccept);

  if (!Cookies.get("cookieBar")) document.body.appendChild(cookieBar);

  cookieBarAccept.addEventListener("click", function () {
    this.parentNode.remove();

    Cookies.set("cookieBar", "accepted");
  });
});
