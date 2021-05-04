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

          const selectVal = $("#filter select").val();

          console.log(data);

          $("#ajax_term_ID").text(`TermID: ${selectVal}`);
          // window.location.href = `${window.location.origin}${window.location.pathname}?term=${selectVal}`;
          $(".posts-front .posts-loop").html(data); // insert data
        },
      });

      return false;
    });
  });
})(jQuery);
