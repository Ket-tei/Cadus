document.addEventListener("DOMContentLoaded", function () {
  let lecture = new SpeechSynthesisUtterance();
  let enLecture = false;
  let enPause = false;

  //Langue française
  lecture.lang = "fr-FR";

  //initialise le texte à lire au début
  function initialiserLecture() {
    lecture.text = document.getElementById("content").textContent;
  }
  //lance la lecture
  document.getElementById("toggleAudio").addEventListener("click", function () {
    if (!enLecture) {
      if (enPause) {
        window.speechSynthesis.resume();
        enPause = false;
        this.innerHTML = '<i class="fas fa-pause"></i>';
      } else {
        initialiserLecture();
        window.speechSynthesis.speak(lecture);
      }
      enLecture = true;
      this.innerHTML = '<i class="fas fa-pause"></i>';
    } else {
      window.speechSynthesis.pause();
      enPause = true;
      enLecture = false;
      this.innerHTML = '<i class="fas fa-play"></i>';
    }
  });

  //relancer la lecture depuis le début
  document.getElementById("resetAudio").addEventListener("click", function () {
    window.speechSynthesis.cancel();
    initialiserLecture();
    window.speechSynthesis.speak(lecture);
    document.getElementById("toggleAudio").innerHTML =
      '<i class="fas fa-pause"></i>';
    enLecture = true;
    enPause = false;
  });
});
