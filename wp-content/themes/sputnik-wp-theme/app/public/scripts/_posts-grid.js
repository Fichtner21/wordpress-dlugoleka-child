document.addEventListener("DOMContentLoaded", function () {
  if (document.querySelectorAll(".events .posts-loop article").length > 1) {
    const eventsPosts = document.querySelectorAll(".events .posts-loop article");

    eventsPosts.forEach((post) => {
      const postImage = post.querySelector("img");

      if (postImage.width > postImage.height) {
        post.classList.add("horizontal-post");
      } else if (postImage.width < postImage.height) {
        post.classList.add("vertical-post");
      }
    });
  }
});
