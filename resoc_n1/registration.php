<?php 
$pageTitle = 'ReSoC - Inscription';
include 'header.php';
?>
        <div id="wrapper" >

            <aside>
                <h2>Présentation</h2>
                <p>Bienvenu sur notre réseau social.</p>
            </aside>
            <main>
                <article>
                    <h2>Inscription</h2>
                    <?php
                    // TRAITEMENT DU FORMULAIRE
                    $enCoursDeTraitement = isset($_POST['email']);
                    if ($enCoursDeTraitement) {
                        // Etape 2: récupérer ce qu'il y a dans le formulaire
                        $new_email = $_POST['email'];
                        $new_alias = $_POST['pseudo'];
                        $new_passwd = $_POST['motpasse'];

                        //Etape 3 : Ouvrir une connexion avec la base de données.
                        include 'variables.php';
                        $mysqli = new mysqli($server, $account, $password, $database2, $port);
                        // Etape 4 : éviter les injections sql
                        $new_email = $mysqli->real_escape_string($new_email);
                        $new_alias = $mysqli->real_escape_string($new_alias);
                        $new_passwd = $mysqli->real_escape_string($new_passwd);
                        // on hash le mot de passe
                        $new_passwd = md5($new_passwd);
                        // Etape 5 : construction de la requete
                        $lInstructionSql = "INSERT INTO users (id, email, password, alias)
                                            VALUES (NULL, '$new_email','$new_passwd','$new_alias');";
                        // Etape 6: exécution de la requete
                        $ok = $mysqli->query($lInstructionSql);
                        if (!$ok) {
                            echo "L'inscription a échouée : " . $mysqli->error;
                        } else {
                            echo "Votre inscription est un succès : " . $new_alias;
                            echo " <a href='login.php'>Connectez-vous.</a>";
                        }
                    }
                    ?>                     
                    <form action="registration.php" method="post">
                        <dl>
                            <dt><label for='pseudo'>Pseudo</label></dt>
                            <dd><input type='text'name='pseudo'></dd>
                            <dt><label for='email'>E-Mail</label></dt>
                            <dd><input type='email'name='email'></dd>
                            <dt><label for='motpasse'>Mot de passe</label></dt>
                            <dd><input type='password'name='motpasse'></dd>
                        </dl>
                        <input type='submit'>
                    </form>
                </article>
            </main>
        </div>
    </body>
</html>
