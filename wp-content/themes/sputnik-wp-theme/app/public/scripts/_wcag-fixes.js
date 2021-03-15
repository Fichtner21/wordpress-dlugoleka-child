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

  const is = document.querySelectorAll("i");

  is.forEach((i) => {
    const iClass = i.classList[0];
    const iIconClass = i.classList[1];

    if (iClass.includes("fa")) {
      const iParent = i.parentNode;
      const iParentTag = iParent.tagName;

      i.setAttribute("focusable", "false");
      i.setAttribute("title", iIconClass);
      i.setAttribute("aria-labelledby", iIconClass);

      if ((iParentTag == "A" || iParentTag == "BUTTON") && iParent.getAttribute("aria-label") == null) {
        iParent.setAttribute("aria-label", iIconClass);
      }
    }
  });
});

//Add title to iframe
document.getElementsByTagName('iframe').title = 'Mapa';
// mapTitle.setAttribute('title', 'mapa');