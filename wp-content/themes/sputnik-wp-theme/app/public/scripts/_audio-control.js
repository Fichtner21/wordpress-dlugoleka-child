document.addEventListener("DOMContentLoaded", function () {
  if (document.querySelectorAll(".wp-block-audio audio").length >= 1) {
    const video = document.querySelectorAll(".wp-block-video video");

    video.forEach((vid) => {
      // Audio container
      const container = vid.parentNode;
      // Audio control elements
      const play = document.createElement("button");
      const stop = document.createElement("button");
      const reset = document.createElement("button");
      const scroll_by_10_minus = document.createElement("button");
      const scroll_by_10_plus = document.createElement("button");

      play.className = "video__play";
      stop.className = "video__stop";
      reset.className = "video__reset";
      scroll_by_10_plus.className = "video__scroll_by_10_plus";
      scroll_by_10_minus.className = "video__scroll_by_10_minus";

      play.textContent = "Odtwarzaj";
      stop.textContent = "Zatrzymaj";
      reset.textContent = "Resetuj";
      scroll_by_10_plus.textContent = "Przewiń o 10 sekund do przodu";
      scroll_by_10_minus.textContent = "Przewiń o 10 sekund do tyłu";

      play.title = "Odtwarzaj";
      stop.title = "Zatrzymaj";
      reset.title = "Resetuj";
      scroll_by_10_plus.title = "Przewiń o 10 sekund do przodu";
      scroll_by_10_minus.title = "Przewiń o 10 sekund do tyłu";

      container.appendChild(scroll_by_10_minus);
      container.appendChild(play);
      container.appendChild(stop);
      container.appendChild(reset);
      container.appendChild(scroll_by_10_plus);

      play.addEventListener("click", function () {
        this.parentNode.querySelector("video").play();
      });

      stop.addEventListener("click", function () {
        this.parentNode.querySelector("video").pause();
      });

      reset.addEventListener("click", function () {
        this.parentNode.querySelector("video").currentTime = 0;
      });

      scroll_by_10_minus.addEventListener("click", function () {
        this.parentNode.querySelector("video").currentTime = this.parentNode.querySelector("video").currentTime - 10;
      });

      scroll_by_10_plus.addEventListener("click", function () {
        this.parentNode.querySelector("video").currentTime = this.parentNode.querySelector("video").currentTime + 10;
      });
    });
  }
});
