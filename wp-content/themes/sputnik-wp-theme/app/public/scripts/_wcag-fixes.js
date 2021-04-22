import $ from "jquery";
import "webpack-jquery-ui/tooltip";

document.addEventListener("DOMContentLoaded", function () {

  const $title = $("a,input,p,label,textarea[title],button");

  jQuery.each($title, function (index, value) {
    jQuery(this).tooltip({
      show: {
        effect: "explode",
        delay: 250,
      },
      hide: {
        effect: "explode",
        delay: 250,
      },
      tooltipClass: "mytooltip",
    });
  });
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
  //

  const searchForm = document.getElementById("sputnik-search-form");
  const searchFormSinputs = searchForm.querySelectorAll('input[id="s"]');

  if (searchFormSinputs[1] != undefined) {
    searchFormSinputs[1].id = `${searchFormSinputs[1].id}-1`;
    searchFormSinputs[1].name = searchFormSinputs[1].id;
    searchFormSinputs[1].parentNode.querySelector("label").setAttribute("for", searchFormSinputs[1].id);
  }

  searchForm.classList.add("hidden");

  function searchFormTabIndex() {
    if (!searchForm.classList.contains("sputnik-search-form--active")) {
      searchForm.querySelector("button").setAttribute("tabindex", "-1");
      searchForm.querySelectorAll("input").forEach((input) => {
        input.setAttribute("tabindex", "-1");
      });
      searchForm.querySelector("button").addEventListener("blur", function () {
        this.parentNode.parentNode.parentNode.parentNode.classList.remove("active");
      });
    } else {
      searchForm.querySelector("button").setAttribute("tabindex", "0");
      searchForm.querySelectorAll("input").forEach((input) => {
        input.setAttribute("tabindex", "0");
      });
    }
  }

  window.addEventListener("load", searchFormTabIndex);
  document.querySelector(".sputnik-search-form__toggle").addEventListener("click", searchFormTabIndex);
  document.querySelector(".sputnik-search-form__toggle").addEventListener("click", function () {
    searchForm.classList.toggle("active");
  });
  //
  aTags.forEach((a) => {
    if (a.target === "_blank") {
      const aSpan = document.createElement("span");

      aSpan.className = "screen-reader-text";
      aSpan.textContent = "(Otworzy się w nowej zakładce)";

      a.title = `${a.title} (Otworzy się w nowej zakładce)`;

      a.appendChild(aSpan);     
    }
  }); 

  // DODANIE ALERTU
  // $('a[target="_blank"]').click(function( event ) {
  //   event.preventDefault();    
  //   var yesno = confirm("Uwaga! Strona otworzy się w nowej zakładce.");
  //   if (yesno) window.open($(this).attr('href'));
  // });
});
