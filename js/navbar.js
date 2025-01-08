
/*
* Injecte la navbar dans le body
* 
*/
function injectDesktopNavbar() {
    const id = 'id="actual-page"'

    // Récupère le nom de la page actuelle
    const actualPath = window.location.pathname.split('/').pop().split('.')[0];

    // Définit l'id de la page actuelle
    let id1 = "", id2 = "", id3 = "", id4 = "", id5 = "";
    switch (actualPath) {
        case "quisommenous":
            id2 = id;
            break;
        case "action":
            id3 = id;
            break;
        case "aide":
            id4 = id;
            break;
        case "contact":
            id5 = id;
            break;
        default:
            id1 = id;
            break;
    }

    const navbarHTML = `
    <header>
        <nav>
            <ul class="menu">
                <a href="../index.html"><img src="../assets/Logo_Cadus.png" alt="logo du site" /></a>
                <li ${id1}>
                    <a href="../index.html">Acceuil</a>
                </li>
                <li ${id2}>
                    <a href="../html/quisommenous.html">Qui somme-nous ?</a>
                </li>
                <li ${id3}>
                    <a href="../html/action.html">Nos actions</a>
                </li>
                <li ${id4}>
                    <a href="../html/aide.html">Nous aider</a>
                </li>
                <li ${id5}>
                    <a href="../html/contact.html">Contacter</a>
                </li>
            </ul>
            <ul class="login-button">
                <li>
                    <a href="../html/signup.html">
                        <img src="../assets/arrow-circle.png" alt="arrow image">
                        <p>S'inscrire</p>
                    </a>
                </li>
                <li>
                    <a href="../html/signin.html">
                        <img src="../assets/arrow-circle.png" alt="arrow image">
                        <p>Se connecter</p>
                    </a>
                </li>
            </ul>
        </nav>
    </header>
    `;

    document.body.insertAdjacentHTML('afterbegin', navbarHTML);
}


/*
* Injecte la navbar dans le body
* 
*/
function injectMobileNavbar() {
    const id = 'id="actual-page"'

    // Récupère le nom de la page actuelle
    const actualPath = window.location.pathname.split('/').pop().split('.')[0];

    // Définit l'id de la page actuelle
    let id1 = "", id2 = "", id3 = "", id4 = "", id5 = "", id6 = "", id7 = "";
    switch (actualPath) {
        case "quisommenous":
            id2 = id;
            break;
        case "action":
            id3 = id;
            break;
        case "aide":
            id4 = id;
            break;
        case "contact":
            id5 = id;
            break;
        case "signup":
            id6 = id;
            break;
        case "signin":
            id7 = id;
            break;
        default:
            id1 = id;
            break;
    }

    const navbarHTML = `
    <header>
    
        <div class="off-screen-menu">
            <ul>
                <li ${id1}>
                    <a href="../index.html">Acceuil</a>
                </li>
                <li ${id2}>
                    <a href="../html/quisommenous.html">Qui somme-nous ?</a>
                </li>
                <li ${id3}>
                    <a href="../html/action.html">Nos actions</a>
                </li>
                <li ${id4}>
                    <a href="../html/aide.html">Nous aider</a>
                </li>
                <li ${id5}>
                    <a href="../html/contact.html">Contacter</a>
                </li>
                <li ${id6}>
                    <a href="../html/signup.html">S'inscrire</a>
                </li>
                <li ${id7}>
                    <a href="../html/signin.html">Se connecter</a>
                </li>
            </ul>
        </div>
        <nav>
            <ul class="ham-menu">
                <span></span>
                <span></span>
                <span></span>
            </ul>

            <ul class="menu">
                <a href="../index.html"><img src="../assets/Logo_Cadus_Mobile.svg" alt="logo du site" /></a>
            </ul>
        </nav>
    </header>
    `;

    document.body.insertAdjacentHTML('afterbegin', navbarHTML);
}



if (window.innerWidth > 800) {
    // Inject la navbar dans le body
    injectDesktopNavbar();
  }
else {
    // Inject la navbar dans le body
    injectMobileNavbar();

    const hamMenu = document.querySelector('.ham-menu');

    const offScreenMenu = document.querySelector('.off-screen-menu');

    hamMenu.addEventListener('click', () => {
        hamMenu.classList.toggle('active');
        offScreenMenu.classList.toggle('active');
    });
}