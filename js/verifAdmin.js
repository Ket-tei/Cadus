document.addEventListener("DOMContentLoaded", function () {
    fetch('../php/app/verifConnexionAdmin.php')
        .then(response => response.json())
        .then(data => {
            if (data.status === 'erreur') {
                window.location.href = '../html/signin.html';
            }
            else {
               recupDonneephp();
            }

        })
        .catch(error => {
            console.error('prb : non identifié pou pas admin', error);
        });
});