const showButton = document.querySelector('#show-button');
const footerMention = document.querySelector('footer');

showButton.addEventListener('click', () => {
  console.log('click');
    // Toggle l'affichage du panneau
    footerMention.classList.toggle('show');
    showButton.classList.toggle('show');
});