if (jQuery) {
  (function ($) {
    "use strict";

    $(document).ready(function () {
      // initialize the megamenu
      const $topLevelItems = $("#primary-menu > li.menu-item-has-children");

      $.each($topLevelItems, function (index, value) {
        $(value).attr("data-megamenu-ID", `megamenu-${index}`);
        $(value).find(".sub-menu").attr("id", `megamenu-${index}`);
      });

      $topLevelItems.find("a:first").attr("aria-expanded", "false");
      $topLevelItems.find("a:first").attr("aria-haspopup", "true");

      function toggleMegaMenu(e) {
        e.preventDefault();

        const $megaMenu = $(this).next();

        const prevEl = $(this).parent().prev().find("a:first");
        const nextEl = $(this).parent().next().find("a:first");

        if (prevEl.attr("aria-expanded") == "true") {
          prevEl.attr("aria-expanded", "false");
          prevEl.next().removeClass("focus");
        } else if (nextEl.attr("aria-expanded") == "true") {
          nextEl.attr("aria-expanded", "false");
          nextEl.next().removeClass("focus");
        }

        if ($(this).attr("aria-expanded") === "true") {
          $(this).attr("aria-expanded", "false");
          $megaMenu.removeClass("focus");
        } else {
          $(this).attr("aria-expanded", "true");
          $megaMenu.addClass("focus");
        }
      }

      $topLevelItems.find("a:first").on("click", toggleMegaMenu);

      const $menuItems = $("#primary-menu > li");

      $menuItems.find("a:first").on("focus", function () {
        if (!$(this).parent().hasClass("menu-item-has-children")) {
          $(".sub-menu").removeClass("focus");
        } else {
          if ($(this).parent().prev().find("a:first").attr("aria-expanded") === "true") {
            $(this).parent().prev().find("a:first").attr("aria-expanded", "false");
            $(this).parent().prev().find("a:first").next().removeClass("focus");

            $(this).next().addClass("focus");
            $(this).attr("aria-expanded", "true");
          }
        }
      });

      $(document).click(function (event) {
        const myTarget = $(".nav-menu");

        if (!myTarget.is(event.target) && myTarget.has(event.target).length === 0) {
          $(".focus").hide();
        } else {
          $(".focus").show();
        }
      });
    });
  })(jQuery);
}
