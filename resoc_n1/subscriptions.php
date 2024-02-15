<?php 
$pageTitle = 'ReSoC - Mes abonnements';
include 'header.php';
?>

        <div id="wrapper">

            <?php
            // Etape 1: récupérer l'id de l'utilisateur
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
                    <p>Sur cette page vous trouverez la liste des personnes dont
                        l'utilisatrice
                        n° <?= $userId ?>
                        suit les messages
                    </p>

                </section>
            </aside>
            <main class='contacts'>
                <?php
                // Etape 2: se connecter à la base de donnée
                include 'variables.php';
                $mysqli = new mysqli($server, $account, $password, $database, $port);
                // Etape 3: récupérer le nom de l'utilisateur
                $laQuestionEnSql = "SELECT users.alias, users.id 
                                    FROM followers 
                                    LEFT JOIN users ON users.id=followers.followed_user_id 
                                    WHERE followers.following_user_id='$userId'
                                    GROUP BY users.id;";
                $lesInformations = $mysqli->query($laQuestionEnSql);
                
                // Etape 4: afficher les abonnés
                while ($user = $lesInformations->fetch_assoc()) { ?>
                    <article>
                        <img src="user.jpg" alt="blason"/>
                        <h3>
                            <a href="wall.php?user_id=<?= $user['id'] ?>"><?= $user['alias'] ?></a>
                        </h3>
                        <p>id : <?= $user['id'] ?></p>
                    </article>
                <?php } ?>
                
            </main>
        </div>
    </body>
</html>
