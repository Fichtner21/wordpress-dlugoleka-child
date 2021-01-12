document.addEventListener("DOMContentLoaded", function () {
  if(document.getElementById('languages-btn')) {
    const chooseLanguageBtn = document.getElementById('languages-btn');
    const languagesList = document.querySelector(".languages-list");
    const languagesListItems = [...document.querySelectorAll(".languages-list .glink")];

    const activeClass = "active";

    chooseLanguageBtn.addEventListener("click", function () {
      if (!this.classList.contains(activeClass)) {
        this.classList.add(activeClass);

        languagesList.classList.add(activeClass);

        languagesList.style.maxHeight = `${languagesList.scrollHeight}px`;
      } else {
        this.classList.remove(activeClass);

        languagesList.classList.remove(activeClass);

        languagesList.style.maxHeight = 0;
      }
    });

    languagesListItems.forEach((language) => {
      language.addEventListener("click", function () {
        const activeLanguage = document.querySelector(".active-language");

        activeLanguage.textContent = language.textContent;
      });
    });
  }
});
