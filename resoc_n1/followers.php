<?php 
$pageTitle = 'ReSoC - Mes abonnés';
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
            }
            ?>

            <aside>
                <img src = "user.jpg" alt = "Portrait de l'utilisatrice"/>
                <section>
                    <h3>Présentation</h3>
                    <p>Sur cette page vous trouverez la liste des personnes qui
                        suivent les messages de l'utilisatrice
                        n° <?= $userId ?></p>

                </section>
            </aside>

            <main class='contacts'>

                <?php
                // Etape 2: se connecter à la base de donnée
                include 'variables.php';
                $mysqli = new mysqli($server, $account, $password, $database, $port);
                // Etape 3: récupérer le nom de l'utilisateur
                $laQuestionEnSql = "SELECT users.*
                                    FROM followers
                                    LEFT JOIN users ON users.id=followers.following_user_id
                                    WHERE followers.followed_user_id='$userId'
                                    GROUP BY users.id;";
                $lesInformations = $mysqli->query($laQuestionEnSql);
                // Etape 4: à vous de jouer
                //@todo: faire la boucle while de parcours des abonnés et mettre les bonnes valeurs ci dessous 
                ?>
                <?php

                while ($user = $lesInformations->fetch_assoc()) { ?>

                    <article><a href="wall.php?user_id=<?= $user['id'] ?>">
                        <img src="user.jpg" alt="blason"/>
                        <h3><?= $user['alias'] ?></h3>
                        <p>id : <?= $user['id'] ?></p>                    
                        </a></article>
                <?php } ?>

            </main>
        </div>
    </body>
</html>
