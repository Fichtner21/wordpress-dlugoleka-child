document.addEventListener("DOMContentLoaded", function () {
  if (document.querySelector(".levels-menu")) {
    const activeClass = "active";

    const levelsMenuItems = [...document.querySelectorAll(".levels-menu-list li")];

    levelsMenuItems.forEach((item, index) => {
      if (item.classList.contains("page_item_has_children")) {
        const toggleIcon = document.createElement("button");

        toggleIcon.className = "levels-menu-list__toggle";
        toggleIcon.textContent = "+";
        toggleIcon.setAttribute("data-menu-item", "item-" + index);

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

    if (levelsMenuItems[0].classList.contains("page_item_has_children")) {
      levelsMenuItems[0].classList.add(activeClass);
      levelsMenuItems[0].querySelector("button[data-menu-item='item-0']").textContent = "-";
      levelsMenuItems[0].querySelector("button[data-menu-item='item-0']").classList.add(activeClass);
    }
  }
});
