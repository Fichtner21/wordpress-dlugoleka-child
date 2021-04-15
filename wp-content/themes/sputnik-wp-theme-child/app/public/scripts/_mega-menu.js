if (jQuery) {
  (function ($) {
    "use strict";

    $(document).ready(function () {
      // initialize the megamenu
      const $topLevelItems = $("#primary-menu > li.menu-item-has-children");

      $topLevelItems.find("a:first").attr("aria-expanded", "false");
      $topLevelItems.find("a:first").attr("aria-haspopup", "true");

      function toggleMegaMenu(e) {
        e.preventDefault();

        const $megaMenu = $(this).next();
        const $allSubmenus = $(".sub-menu");

        $allSubmenus.removeClass("focus");

        $.each($allSubmenus, function (index, menu) {
          $(menu).removeClass("focus");
          $(menu).parent().find("a:first").attr("aria-expanded", "false");
        });

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

          $(this).on("keyup", function (e) {
            e.preventDefault();

            // if (e.keyCode === 32) toggleMegaMenu();
          });
        }
      });
    });
  })(jQuery);
}
