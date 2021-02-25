require("fslightbox");

document.addEventListener("DOMContentLoaded", function () {
  if (document.querySelectorAll(".wp-block-gallery .blocks-gallery-item").length > 0) {
    const galleryItems = document.querySelectorAll(".wp-block-gallery .blocks-gallery-item");

    console.log(galleryItems);

    galleryItems.forEach((item) => {
      const itemImage = item.querySelector("img");

      const itemLink = document.createElement("a");

      itemLink.setAttribute("data-fslightbox", "wp-gallery");
      itemLink.setAttribute("href", itemImage.dataset.fullUrl);

      itemLink.appendChild(itemImage);

      item.querySelector("figure").appendChild(itemLink);
    });

    refreshFsLightbox();
  }
});
