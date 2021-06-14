(function ($) {
  $(document).ready(function () {
    $("#filter").submit(function () {
      var filter = $("#filter");

      $.ajax({
        url: filter.attr("action"),
        data: filter.serialize(), // form data
        type: filter.attr("method"), // POST
        beforeSend: function (xhr) {
          filter.find("button").text("W toku..."); // changing the button label
        },
        success: function (data) {
          filter.find("button").text("Filtruj"); // changing the button label back
          // window.location.href = `${window.location.origin}${window.location.pathname}?term=${selectVal}`;
          if (document.querySelector(".archive-sidebar")) {
            $(".archive-sidebar .posts-loop").html(data);
          } else if (document.querySelector(".posts-front")) {
            $(".posts-front .posts-loop").html(data);
          }
        },
      });

      return false;
    });
  });
})(jQuery);
