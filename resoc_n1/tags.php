<?php 
$pageTitle = 'ReSoC - Les message par mot-clé';
include 'header.php';
?>
        <div id="wrapper">
            
            <?php
            // Etape 1: Le mur concerne un mot-clé en particulier
            $tagId = intval($_GET['tag_id']);
            // Etape 2: se connecter à la base de données
            include 'variables.php';
            $mysqli = new mysqli($server, $account, $password, $database, $port);
            ?>

            <aside>

                <?php
                // Etape 3: récupérer le nom du mot-clé
                $laQuestionEnSql = "SELECT * FROM tags WHERE id= '$tagId' ";
                $lesInformations = $mysqli->query($laQuestionEnSql);
                $tag = $lesInformations->fetch_assoc();
                //@todo: afficher le résultat de la ligne ci dessous, remplacer XXX par le label et effacer la ligne ci-dessous
                echo "<pre>" . print_r($tag, 1) . "</pre>";
                ?>
                <img src="user.jpg" alt="Portrait de l'utilisatrice"/>
                <section>
                    <h3>Présentation</h3>
                    <p>Sur cette page vous trouverez les derniers messages comportant
                        le #<a href="tags.php?tag_id=<?= $tagId ?>"><?= $tag['label'] ?></a> 
                        (n° <?= $tagId ?>)
                    </p>

                </section>
            </aside>
            <main>
                <?php
                // Etape 3: récupérer tous les messages avec un mot clé donné
                $laQuestionEnSql = "SELECT posts.content,
                                        posts.created,
                                        users.alias as author_name,  
                                        count(likes.id) as like_number,  
                                        GROUP_CONCAT(DISTINCT tags.label, tags.id) AS taglist 
                                    FROM posts_tags as filter 
                                    JOIN posts ON posts.id=filter.post_id
                                    JOIN users ON users.id=posts.user_id
                                    LEFT JOIN posts_tags ON posts.id = posts_tags.post_id  
                                    LEFT JOIN tags       ON posts_tags.tag_id  = tags.id 
                                    LEFT JOIN likes      ON likes.post_id  = posts.id 
                                    WHERE filter.tag_id = '$tagId' 
                                    GROUP BY posts.id
                                    ORDER BY posts.created DESC";
                
                // afficher les messages
                include 'printPosts.php';
                ?>


            </main>
        </div>
    </body>
</html>