<?php 
include 'variables.php';
$mysqli = new mysqli($server, $account, $password, $database, $port);
$pageTitle = 'ReSoC - Mur';
include 'header.php';
if(isset($_POST['message'])) {
    
    $content = $_POST['message'];
    $lInstructionSql = "INSERT INTO posts (id, user_id, content, created, parent_id)
                        VALUES (NULL, {$_SESSION['connected_id']},'$content', NOW(), NULL);";
    // Etape 5 : execution
    $ok = $mysqli->query($lInstructionSql);
    if ( ! $ok)
    {
        echo "Impossible d'ajouter le message: " . $mysqli->error;
    } else
    {
        // echo "Message posté en tant que :" . $_SESSION['connected_id'];
    }
}

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
            $userId =intval($_GET['user_id']); 
            ?>
            <?php
            /**
             * Etape 2: se connecter à la base de donnée
             */
                //
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
                    <p>Sur cette page vous trouverez tous les message de l'utilisatrice : <a href="tags.php?tag_id=<?php echo $user['id'] ?>"><?php echo $user['alias'] ?></a>
                        (n° <?php echo $userId ?>)
                    </p>
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
                    ?>

                    <form action= <?= $_SERVER['REQUEST_URI'] ?> method="post" name="message-form" >
                        <article>    
                            <h2>Poster un message</h2>
                            <dl>
                                <dt><label for='auteur'>Auteur :</label> <?= $_SESSION['connected_id'] ?></dt>
                                <dt><label for='message'>Message</label></dt>
                                <dd><textarea name='message'></textarea></dd>
                            </dl>
                            <input type='submit' value="post" >
                        </article>
                    </form>


                    <?php

                    include 'printPosts.php';
                    ?>
            </main>
        </div>
    </body>
</html>
