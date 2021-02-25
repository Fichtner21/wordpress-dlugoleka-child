require("fslightbox");

document.addEventListener("DOMContentLoaded", function () {
  if (document.querySelectorAll(".wp-block-gallery .blocks-gallery-item").length > 0) {
    const galleryItems = document.querySelectorAll(".wp-block-gallery .blocks-gallery-item");

    galleryItems.forEach((item) => {
      const itemImage = item.querySelector("img");

      const itemLink = document.createElement("a");

      itemLink.setAttribute("data-fslightbox", "wp-gallery");

      if (itemImage.dataset.fullUrl) {
        itemLink.setAttribute("href", itemImage.dataset.fullUrl);
      } else if (itemImage.src) {
        itemLink.setAttribute("href", itemImage.src);
      }

      itemLink.appendChild(itemImage);

      //   itemImage.remove();

      item.querySelector("figure").appendChild(itemLink);
    });

    refreshFsLightbox();
  }
});
