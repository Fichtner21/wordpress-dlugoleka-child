document.addEventListener("DOMContentLoaded", function () {
  if (document.getElementById("js-save-to-pdf")) {
    const saveToPdfButton = document.getElementById("js-save-to-pdf");

    saveToPdfButton.addEventListener("click", function () {
      window.print();
    });
  }
});
