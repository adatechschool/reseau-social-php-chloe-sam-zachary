<?php 
$pageTitle = 'ReSoC - Paramètres';
include 'header.php';
?>

        <div id="wrapper" class='profile'>

            <?php 
            // Etape 1: Les paramètres concernent une utilisatrice en particulier
                // attention : ne concerne que le user connecté
            $userId = intval($_GET['user_id']);
            // Empêcher les accès non-autorisés
            if (!isset($_SESSION['connected_id']) || ($userId != $_SESSION['connected_id'])) { ?>
                <aside> Vous n'avez pas accès à cette page. <a href='login.php'>Merci de vous connecter.</a></aside>
                <?php
                exit();
            } ?>

            <aside>
                <img src="user.jpg" alt="Portrait de l'utilisatrice"/>
                <section>
                    <h3>Présentation</h3>
                    <p>Sur cette page vous trouverez les informations de l'utilisatrice
                        n° <?php echo intval($userId) ?></p>
                </section>
            </aside>

            <main>

                <?php
                // Etape 2: se connecter à la base de données
                include 'variables.php';
                $mysqli = new mysqli($server, $account, $password, $database, $port);
                // Etape 3: récupérer le nom de l'utilisateur
                $laQuestionEnSql = "SELECT users.*, 
                                        count(DISTINCT posts.id) as totalpost, 
                                        count(DISTINCT given.post_id) as totalgiven, 
                                        count(DISTINCT recieved.user_id) as totalrecieved 
                                    FROM users 
                                    LEFT JOIN posts ON posts.user_id=users.id 
                                    LEFT JOIN likes as given ON given.user_id=users.id 
                                    LEFT JOIN likes as recieved ON recieved.post_id=posts.id 
                                    WHERE users.id = '$userId' 
                                    GROUP BY users.id;";
                $lesInformations = $mysqli->query($laQuestionEnSql);
                if (!$lesInformations) {
                    echo("Échec de la requete : " . $mysqli->error);
                }
                $user = $lesInformations->fetch_assoc();
                ?>                

                <!-- Etape 4: afficher les infos du user -->
                <article class='parameters'>
                    <h3>Mes paramètres</h3>
                    <dl>
                        <dt>Pseudo</dt>
                        <dd><?php echo $user['alias'] ?> </dd>
                        <dt>Email</dt>
                        <dd><?php echo $user['email'] ?></dd>
                        <dt>Nombre de message</dt>
                        <dd><?php echo $user['totalpost'] ?></dd>
                        <dt>Nombre de "J'aime" donnés </dt>
                        <dd> <?php echo $user['totalgiven'] ?></dd>
                        <dt>Nombre de "J'aime" reçus</dt>
                        <dd><?php echo $user['totalrecieved'] ?></dd>
                    </dl>
                </article>
            </main>
        </div>
    </body>
</html>
