const bouton = document.querySelector(".bouton");
const formulaire = document.querySelector(".contact-dynamique");
const page = document.createElement("div");

page.classList.add("arriere-plan");
document.body.appendChild(page);
page.style.display = "none";
formulaire.style.display = "none";

bouton.addEventListener("click", () => {
  if (formulaire.style.display === "none") {
    formulaire.style.display = "block";
    page.style.display = "block";
  } else {
    formulaire.style.display = "none";
    page.style.display = "none";
  }
});

page.addEventListener("click", () => {
  formulaire.style.display = "none";
  page.style.display = "none";
});
