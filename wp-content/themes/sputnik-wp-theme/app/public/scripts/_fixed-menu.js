document.addEventListener("DOMContentLoaded", function () {
  if (document.getElementById("masthead")) {
    const masthead = document.getElementById("masthead");
    const messages = document.querySelector(".module-messages");
    const wpadminbar = document.getElementById("wpadminbar");

    const activeClass = "active";

    const mastheadHeight = masthead.offsetHeight;
    const messagesHeight = messages.offsetHeight;

    let wpadminbarHeight;

    if (wpadminbar) {
      wpadminbarHeight = wpadminbar.offsetHeight;
    } else {
      wpadminbarHeight = 0;
    }

    window.addEventListener("scroll", function () {
      if (this.scrollY > mastheadHeight + messagesHeight + wpadminbarHeight + 100) {
        messages.style.marginBottom = mastheadHeight + "px";
        masthead.classList.add(activeClass);

        if (wpadminbarHeight > 0) {
          masthead.style.top = wpadminbarHeight + "px";
        }
      } else {
        messages.style.marginBottom = 0;
        masthead.classList.remove(activeClass);
        masthead.style.top = 0;
      }
    });
  }
});
