<?php 
$pageTitle = 'ReSoC - Actualités';
include 'header.php';
?>
        <div id="wrapper">
            <aside>
                <img src="user.jpg" alt="Portrait de l'utilisatrice"/>
                <section>
                    <h3>Présentation</h3>
                    <p>Sur cette page vous trouverez les derniers messages de
                        tous les utilisatrices du site.</p>
                </section>
            </aside>
            <main>
                <?php

                // Etape 1: Ouvrir une connexion avec la base de données.
                include 'variables.php';
                $mysqli = new mysqli($server, $account, $password, $database, $port);
                if ($mysqli->connect_errno) {
                    echo "<article>";
                    echo("Échec de la connexion : " . $mysqli->connect_error);
                    echo("<p>Indice: Vérifiez les parametres de <code>new mysqli(...</code></p>");
                    echo "</article>";
                    exit();
                }

                // Etape 2: récupérer les posts dans la base de données
                $laQuestionEnSql = "SELECT posts.content,
                                        posts.created,
                                        posts.user_id,
                                        users.alias as author_name,  
                                        count(likes.id) as like_number,  
                                        GROUP_CONCAT(DISTINCT tags.label, tags.id) as taglist
                                    FROM posts
                                    JOIN users ON  users.id=posts.user_id
                                    LEFT JOIN posts_tags ON posts.id = posts_tags.post_id  
                                    LEFT JOIN tags       ON posts_tags.tag_id  = tags.id 
                                    LEFT JOIN likes      ON likes.post_id  = posts.id 
                                    GROUP BY posts.id
                                    ORDER BY posts.created DESC  
                                    LIMIT 5
                                    ";
                // Afficher les posts
                include 'printPosts.php';
                ?>

            </main>
        </div>
    </body>
</html>
