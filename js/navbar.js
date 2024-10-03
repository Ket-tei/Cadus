
/*
* Injecte la navbar dans le body
* 
*/
function injectNavbar() {
    const id = 'id="actual-page"'

    // Récupère le nom de la page actuelle
    const actualPath = window.location.pathname.split('/').pop().split('.')[0];

    // Définit l'id de la page actuelle
    let id1 = "", id2 = "", id3 = "", id4 = "";
    switch (actualPath) {
        case "contact":
            break;
        case "quisommenous":
            id2 = id;
            break;
        case "action":
            id3 = id;
            break;
        case "aide":
            id4 = id;
            break;
        default:
            id1 = id;
            break;
    }

    const navbarHTML = `
    <header>
        <nav>
            <ul class="menu">
                <a href="./index.html"><img src="./assets/Logo_Cadus.png" alt="logo du site" /></a>
                <li ${id1}>
                    <a href="./index.html">Acceuil</a>
                </li>
                <li ${id2}>
                    <a href="./quisommenous.html">Qui somme-nous ?</a>
                </li>
                <li ${id3}>
                    <a href="./action.html">Nos actions</a>
                </li>
                <li ${id4}>
                    <a href="./aide.html">Nous aider</a>
                </li>
            </ul>
            <ul class="contact-button">
                <li>
                    <a href="./contact.html">
                        <img src="./assets/arrow-circle.png" alt="arrow image">
                        <p>Contacter</p>
                    </a>
                </li>
            </ul>
        </nav>
    </header>
    `;

    document.body.insertAdjacentHTML('afterbegin', navbarHTML);
}

// Inject la navbar dans le body
injectNavbar();