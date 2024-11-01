const boutonFaireDon = document.getElementById("boutonFaireDon");
const formulaireDon = document.getElementById("formulaireDon");
let montantDon = document.getElementById("montant-don");
const montantAffiche = document.getElementById("montant-affiche");
const autreMontantBtn = document.getElementById("autre-montant");
let autreMontantSaisie = document.getElementById("autre-montant-saisie");
let montantCustom = document.getElementById("montant-custom");
const validerDonBtn = document.getElementById("validerDon");


boutonFaireDon.addEventListener("click", () => {
  if (formulaireDon.style.display === "none") {
    formulaireDon.style.display = "block";
    montantAffiche.textContent = "25" + " €";
    montantDon.value = 25;
    montantCustom.value = "";
    autreMontantSaisie.style.display = "none";
  } else {
    formulaireDon.style.display = "none";
  }
});

montantDon.addEventListener("input", () => {
  montantAffiche.textContent = montantDon.value + " €";
  montantCustom.value = "";
});

autreMontantBtn.addEventListener("click", () => {
  if (autreMontantSaisie.style.display === "none") {
    autreMontantSaisie.style.display = "block";
  } else {
    autreMontantSaisie.style.display = "none";
  }
});



validerDonBtn.addEventListener("click", () => {
  const montant = montantDon.value;
  let montantFinal = montant;
  if (montantCustom.value !== "") {
    montantFinal = montantCustom.value;
  }

  alert(`Merci pour votre don de ${montantFinal} € !`);

  formulaireDon.style.display = "none";
});
