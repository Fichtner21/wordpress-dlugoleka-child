if (jQuery) {
  (function ($) {
    "use strict";

    $(document).ready(function () {
      // initialize the megamenu
      $(".menu-item-has-children > a:first").attr("aria-expanded", false);
      $(".menu-item-has-children > a:first").attr("aria-haspopup", true);

      $(".menu-item-has-children > a:first").on("click", function (e) {
        e.preventDefault();

        const $megaMenu = $(this).next();

        $megaMenu.toggleClass("focus");

        if ($megaMenu.hasClass("focus")) {
          $(this).attr("aria-expanded", true);
        } else {
          $(this).attr("aria-expanded", false);
        }
      });

      $(".menu-item-has-children > a:first > .sub-menu").on("focusout", function (e) {
        $(this).removeClass("focus");
      });

      const $allSubmenuLinks = $(".menu-item-has-children .sub-menu a");

      $($allSubmenuLinks[$allSubmenuLinks.length - 1]).on("blur focusout", function (e) {
        $(this).parent().parent().parent().parent().removeClass("focus");
        console.log($(this).parent().parent().parent().parent());
      });
    });
  })(jQuery);
}
