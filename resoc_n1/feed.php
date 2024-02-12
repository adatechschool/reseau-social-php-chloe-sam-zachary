<?php 
$pageTitle = 'ReSoC - Flux';
include 'header.php';
?>

        <div id="wrapper">
            
            <?php
            // Etape 1: Le mur concerne un utilisateur en particulier
            $userId = intval($_GET['user_id']);
            // Empêcher les accès non-autorisés
            if (!isset($_SESSION['connected_id']) || ($userId != $_SESSION['connected_id'])) { ?>
                <aside> Vous n'avez pas accès à cette page. <a href='login.php'>Merci de vous connecter.</a></aside>
                <?php
                exit();
            }

            // Etape 2: se connecter à la base de données
            include 'variables.php';
            $mysqli = new mysqli($server, $account, $password, $database, $port);
            ?>

            <aside>
                <?php
                // Etape 3: récupérer le nom de l'utilisateur
                $laQuestionEnSql = "SELECT * FROM `users` WHERE id= '$userId' ";
                $lesInformations = $mysqli->query($laQuestionEnSql);
                $user = $lesInformations->fetch_assoc();
                ?>
                <img src="user.jpg" alt="Portrait de l'utilisatrice"/>
                <section>
                    <h3>Présentation</h3>
                    <p>Sur cette page vous trouverez tous les message des utilisatrices
                        auxquel est abonnée l'utilisatrice <?= $user['alias'] ?>
                        (n° <?php echo $userId ?>)
                    </p>

                </section>
            </aside>
            <main>

                <?php
                // Etape 3: récupérer tous les messages des abonnements
                $laQuestionEnSql = "SELECT posts.content,
                                        posts.created,
                                        users.alias as author_name,
                                        posts.user_id,
                                        count(likes.id) as like_number,  
                                        GROUP_CONCAT(DISTINCT tags.label, tags.id) AS taglist 
                                    FROM followers
                                    JOIN users ON users.id=followers.followed_user_id
                                    JOIN posts ON posts.user_id=users.id
                                    LEFT JOIN posts_tags ON posts.id = posts_tags.post_id  
                                    LEFT JOIN tags       ON posts_tags.tag_id  = tags.id 
                                    LEFT JOIN likes      ON likes.post_id  = posts.id 
                                    WHERE followers.following_user_id='$userId' 
                                    GROUP BY posts.id
                                    ORDER BY posts.created DESC";
                $lesInformations = $mysqli->query($laQuestionEnSql);
                if (!$lesInformations) {
                    echo("Échec de la requete : " . $mysqli->error);
                }

                // Etape 4: afficher les messages
                include 'printposts.php'; ?>

            </main>
        </div>
    </body>
</html>
