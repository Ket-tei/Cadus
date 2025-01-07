import sqlite3
import random
import hashlib

connexion = sqlite3.connect('../identifier.sqlite')
curseur = connexion.cursor()

def creer_utilisateur(index_utilisateur):
    email = f"user{index_utilisateur}@test.com"
    mot_de_passe = hashlib.md5("1234".encode()).hexdigest()
    role = "user"
    sondage_effectue = 1

    curseur.execute(
        "INSERT INTO utilisateurs (email, mot_de_passe, role, sondage_effectue) VALUES (?, ?, ?, ?)",
        (email, mot_de_passe, role, sondage_effectue)
    )

def creer_session():
    curseur.execute("INSERT INTO sessions DEFAULT VALUES")
    return curseur.lastrowid

def generer_reponses_pour_session(id_session, index_utilisateur):
    curseur.execute("SELECT id FROM questions")
    liste_questions = curseur.fetchall()

    for i, question in enumerate(liste_questions, start=1):
        id_question = question[0]

        if id_question == 1:
            age = random.randint(18, 99)
            texte_reponse = str(age)
        else:
            curseur.execute("SELECT id, texte FROM choix WHERE id_question = ?", (id_question,))
            liste_choix = curseur.fetchall()

            if not liste_choix:
                print(f"Aucun choix disponible pour la question ID {id_question}. Réponse ignorée.")
                continue

            choix = random.choice(liste_choix)
            texte_reponse = choix[1]

        curseur.execute(
            "INSERT INTO reponses (id_question, id_sessions, reponse) VALUES (?, ?, ?)",
            (id_question, id_session, texte_reponse)
        )

def generer_utilisateurs_et_reponses(nombre_utilisateurs):
    for index_utilisateur in range(1, nombre_utilisateurs + 1):
        creer_utilisateur(index_utilisateur)

        id_session = creer_session()

        generer_reponses_pour_session(id_session, index_utilisateur)

generer_utilisateurs_et_reponses(100)

connexion.commit()

connexion.close()

print("Utilisateurs, sessions et réponses générés avec succès !")
