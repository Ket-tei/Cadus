    async function fetchMessages() {
    try {
    const response = await fetch('../php/app/getMessage.php');
    const data = await response.json();

    const container = document.getElementById('messages-container');
    container.innerHTML = '';

    if (data.error) {
    container.innerHTML = `<p class="error">${data.error}</p>`;
    return;
}

    if (data.length === 0) {
    container.innerHTML = '<p>Aucun message trouvé.</p>';
    return;
}

    data.forEach((msg) => {
    const messageDiv = document.createElement('div');
    messageDiv.classList.add('message-item');
    messageDiv.innerHTML = `
          <p><strong>${msg.nom} ${msg.prenom}</strong> (${msg.date_submission}):</p>
          <p>${msg.message}</p>
        `;
    container.appendChild(messageDiv);
});
} catch (error) {
    console.error('Erreur lors de la récupération des messages :', error);
}
}

    window.onload = fetchMessages;
