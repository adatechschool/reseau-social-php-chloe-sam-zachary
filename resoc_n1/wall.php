<?php 
$pageTitle = 'ReSoC - Mur';
include 'header.php';
?>
        <div id="wrapper">
            <?php
            /**
             * Etape 1: Le mur concerne un utilisateur en particulier
             * La première étape est donc de trouver quel est l'id de l'utilisateur
             * Celui ci est indiqué en parametre GET de la page sous la forme user_id=...
             * Documentation : https://www.php.net/manual/fr/reserved.variables.get.php
             * ... mais en résumé c'est une manière de passer des informations à la page en ajoutant des choses dans l'url
             */
                if ($_GET['user_id']) {
                    $userId =intval($_GET['user_id']);
                } else {
                    $userId = $_SESSION['connected_id'];
                }
            ?>
            <?php
            /**
             * Etape 2: se connecter à la base de donnée
             */
            include 'variables.php';
            $mysqli = new mysqli($server, $account, $password, $database, $port);
            ?>
            

            <aside>
                <?php
                /**
                 * Etape 3: récupérer le nom de l'utilisateur
                 */                
                $laQuestionEnSql = "SELECT * FROM users WHERE id= '$userId' ";
                $lesInformations = $mysqli->query($laQuestionEnSql);
                $user = $lesInformations->fetch_assoc();
                //@todo: afficher le résultat de la ligne ci dessous, remplacer XXX par l'alias et effacer la ligne ci-dessous
                echo "<pre>" . print_r($user, 1) . "</pre>";
                ?>
                <img src="user.jpg" alt="Portrait de l'utilisatrice"/>
                <section>
                    <h3>Présentation</h3>
                    <p>Sur cette page vous trouverez tous les message de l'utilisatrice : <?php echo $user['alias'] ?></a>
                        (n° <?php echo $userId ?>)
                    </p>
                    <?php 
                    include 'follow.php';
                    ?>
                </section>
            </aside>
            <main>
                <?php
                /**
                 * Etape 3: récupérer tous les messages de l'utilisatrice
                 */
                $laQuestionEnSql = "SELECT posts.content, 
                                        posts.created,
                                        posts.user_id,
                                        users.alias as author_name, 
                                        COUNT(likes.id) as like_number,
                                        GROUP_CONCAT(DISTINCT tags.label, tags.id) AS taglist 
                                    FROM posts
                                    JOIN users ON  users.id=posts.user_id
                                    LEFT JOIN posts_tags ON posts.id = posts_tags.post_id  
                                    LEFT JOIN tags       ON posts_tags.tag_id  = tags.id 
                                    LEFT JOIN likes      ON likes.post_id  = posts.id 
                                    WHERE posts.user_id='$userId' 
                                    GROUP BY posts.id
                                    ORDER BY posts.created DESC  
                                    ";
                    
                    include 'printPosts.php';
                    ?>


            </main>
        </div>
    </body>
</html>
