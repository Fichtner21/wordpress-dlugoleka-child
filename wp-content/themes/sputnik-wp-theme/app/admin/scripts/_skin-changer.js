document.addEventListener("DOMContentLoaded", function () {
  if(document.getElementById('js-skin-changer')) {
    const skinChangeToggle = document.querySelector(".skin-changer-toggle");
    const skinChangeForm = document.querySelector(".skin-changer-form");

    skinChangeToggle.addEventListener("click", function () {
      skinChangeForm.classList.toggle("active");
    });
  }
});
