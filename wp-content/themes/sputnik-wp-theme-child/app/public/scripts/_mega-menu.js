if (jQuery) {
  (function ($) {
    "use strict";

    $(document).ready(function () {
      // initialize the megamenu
      const $topLevelItems = $("#primary-menu > li.menu-item-has-children");

      $topLevelItems.find("a:first").attr("aria-expanded", "false");
      $topLevelItems.find("a:first").attr("aria-haspopup", "true");

      $topLevelItems.find("a:first").on("click", function (e) {
        e.preventDefault();

        const $megaMenu = $(this).next();
        const $allSubmenus = $(".sub-menu");

        $allSubmenus.removeClass("focus");

        if ($(this).attr("aria-expanded") === "true") {
          $(this).attr("aria-expanded", "false");
          $megaMenu.removeClass("focus");
        } else {
          $(this).attr("aria-expanded", "true");
          $megaMenu.addClass("focus");
        }

        const $allMegaMenuLinks = $megaMenu.find("a");
      });
    });
  })(jQuery);
}
