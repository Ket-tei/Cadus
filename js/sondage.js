document.addEventListener("DOMContentLoaded", function () {
    fetch("../php/app/recupQuestions.php")
        .then(response => response.text())
        .then(html => {
            const formulaire = document.getElementById("sondage-formulaire");
            formulaire.innerHTML = html;

            const boutonEnvoyer = document.createElement("button");
            boutonEnvoyer.classList.add("EnvoiFormulaire");
            boutonEnvoyer.textContent = "Envoyer le formulaire";
            formulaire.appendChild(boutonEnvoyer);
        })
        .catch(error => console.error("Prb chargement", error));
});
