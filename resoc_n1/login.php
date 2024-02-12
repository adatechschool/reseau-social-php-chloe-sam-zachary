<?php

$pageTitle = "ReSoC - Connexion";
include 'header.php';

?>

        <div id="wrapper">

            <aside>
                <h2>Présentation</h2>
                <p>Bienvenu sur notre réseau social.</p>
            </aside>
            <main>
                <article>
                    <h2>Connexion</h2>
                    <?php
                    // TRAITEMENT DU FORMULAIRE
                    $enCoursDeTraitement = isset($_POST['email']);
                    if ($enCoursDeTraitement) {
                        // Etape 2: récupérer ce qu'il y a dans le formulaire
                        $emailAVerifier = $_POST['email'];
                        $passwdAVerifier = $_POST['motpasse'];

                        // Etape 3 : Ouvrir une connexion avec la base de données.
                        include 'variables.php';
                        $mysqli = new mysqli($server, $account, $password, $database2, $port);
                        // Etape 4 : Petite sécurité
                        // pour éviter les injection sql : https://www.w3schools.com/sql/sql_injection.asp
                        $emailAVerifier = $mysqli->real_escape_string($emailAVerifier);
                        $passwdAVerifier = $mysqli->real_escape_string($passwdAVerifier);
                        // on hash le mot de passe
                        $passwdAVerifier = md5($passwdAVerifier);
                        // Etape 5 : construction de la requete
                        $lInstructionSql = "SELECT *
                                            FROM users
                                            WHERE email LIKE '$emailAVerifier'";
                        // Etape 6: Vérification de l'utilisateur
                        $res = $mysqli->query($lInstructionSql);
                        $user = $res->fetch_assoc();
                        if (!$user OR $user["password"] != $passwdAVerifier) {
                            echo "La connexion a échouée. ";
                        } else {
                            echo "Votre connexion est un succès : " . $user['alias'] . ".";
                            // Etape 7 : Se souvenir que l'utilisateur s'est connecté pour la suite
                            // documentation: https://www.php.net/manual/fr/session.examples.basic.php
                            $_SESSION['connected_id']=$user['id'];
                        }
                    }
                    
                    // si on n'a pas de session connectée, alors on affiche le formulaire :
                    if (isset($_POST['logout'])){ 
                        ?>
                        <p>Vous avez bien été déconnecté-e. </p>
                        <?php
                    }
                    if(empty($_SESSION)) {
                        ?>
                        <form action="login.php" method="post">
                            <dl>
                                <dt><label for='email'>E-Mail</label></dt>
                                <dd><input type='email'name='email'></dd>
                                <dt><label for='motpasse'>Mot de passe</label></dt>
                                <dd><input type='password'name='motpasse'></dd>
                            </dl>
                            <input type='submit'>
                        </form>
                        <p>
                            Pas de compte?
                            <a href='registration.php'>Inscrivez-vous.</a>
                        </p>
                    <?php } else { ?>
                        <p>Bonjour ! Vous êtes connectée.</p>
                    <?php } ?>

                </article>
            </main>
        </div>
    </body>
</html>
