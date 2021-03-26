document.addEventListener("DOMContentLoaded", function () {
  //
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
  //
  const is = document.querySelectorAll("i");
  const svgs = document.querySelectorAll("svg");

  is.forEach((i) => {
    const iClass = i.classList[0];
    const iIconClass = i.classList[1];

    if (iClass != null && iClass != undefined && iClass.includes("fa")) {
      const iParent = i.parentNode;
      const iParentTag = iParent.tagName;

      i.setAttribute("focusable", "false");
      i.setAttribute("title", iIconClass);
      i.setAttribute("aria-hidden", "true");
      i.setAttribute("aria-labelledby", iIconClass);

      if ((iParentTag == "A" || iParentTag == "BUTTON") && iParent.getAttribute("aria-label") == null) {
        iParent.setAttribute("aria-label", iIconClass);
      }
    }
  });
  //
  if (document.querySelector(".page-template-declaration")) {
    const declarationBody = document.querySelector(".page-template-declaration");
    const declarationCont = declarationBody.querySelector("main .custom-container");

    declarationCont.id = "primary";
  }
  //
  const allSvgNodeList = document.querySelectorAll("svg");
  const allSvgArray = [...allSvgNodeList];

  allSvgArray.forEach((el) => {
    let dataIcon = el.dataset.icon;

    el.setAttribute("role", "img");
    el.setAttribute("aria-label", dataIcon);
  });
  //
  const aTags = document.querySelectorAll("a");

  aTags.forEach((a) => {
    if (!a.getAttribute("title")) a.setAttribute("title", a.textContent);
  });
});
