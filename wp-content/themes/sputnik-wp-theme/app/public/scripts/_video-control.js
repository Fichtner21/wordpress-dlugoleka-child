document.addEventListener("DOMContentLoaded", function () {
  if (document.querySelectorAll(".wp-block-audio audio").length >= 1) {
    const audio = document.querySelectorAll(".wp-block-audio audio");

    audio.forEach((au) => {
      // Audio container
      const container = au.parentNode;
      // Audio control elements
      const play = document.createElement("button");
      const stop = document.createElement("button");
      const reset = document.createElement("button");
      const scroll_by_10_minus = document.createElement("button");
      const scroll_by_10_plus = document.createElement("button");

      play.className = "audio__play";
      stop.className = "audio__stop";
      reset.className = "audio__reset";
      scroll_by_10_plus.className = "audio__scroll_by_10_plus";
      scroll_by_10_minus.className = "audio__scroll_by_10_minus";

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
        this.parentNode.querySelector("audio").play();
      });

      stop.addEventListener("click", function () {
        this.parentNode.querySelector("audio").pause();
      });

      reset.addEventListener("click", function () {
        this.parentNode.querySelector("audio").currentTime = 0;
      });

      scroll_by_10_minus.addEventListener("click", function () {
        this.parentNode.querySelector("audio").currentTime = this.parentNode.querySelector("audio").currentTime - 10;
      });

      scroll_by_10_plus.addEventListener("click", function () {
        this.parentNode.querySelector("audio").currentTime = this.parentNode.querySelector("audio").currentTime + 10;
      });
    });
  }
});
