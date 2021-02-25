document.addEventListener("DOMContentLoaded", function () {
  if (document.querySelector(".levels-menu")) {
    const activeClass = "active";

    const levelsMenuItems = [...document.querySelectorAll(".levels-menu-list li")];

    levelsMenuItems.forEach((item) => {
      if (item.classList.contains("page_item_has_children")) {
        const toggleIcon = document.createElement("button");

        toggleIcon.className = "levels-menu-list__toggle";
        toggleIcon.textContent = "+";

        item.appendChild(toggleIcon);

        toggleIcon.addEventListener("click", function () {
          this.classList.toggle(activeClass);

          if (this.classList.contains(activeClass)) {
            this.textContent = "-";
            this.parentNode.classList.add(activeClass);
          } else {
            this.textContent = "+";
            this.parentNode.classList.remove(activeClass);
          }
        });
      }
    });
  }
});
