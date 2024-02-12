<?php 
$pageTitle = 'ReSoC - Mes Administration';
include 'header.php';
?>
        <?php
        // Etape 1: Ouvrir une connexion avec la base de donnée.
        include 'variables.php';
        $mysqli = new mysqli($server, $account, $password, $database, $port);
        if ($mysqli->connect_errno) {
            echo("Échec de la connexion : " . $mysqli->connect_error);
            exit();
        } ?>
        
        <div id="wrapper" class='admin'>
            <aside>
                <h2>Mots-clés</h2>

                <?php
                // Etape 2 : trouver tous les mots clés
                $laQuestionEnSql = "SELECT * FROM `tags` LIMIT 50";
                $lesInformations = $mysqli->query($laQuestionEnSql);
                if (!$lesInformations) {
                    echo("Échec de la requete : " . $mysqli->error);
                    exit();
                }

                // Etape 3 : afficher les mots clés
                while ($tag = $lesInformations->fetch_assoc()){
                    $id = print_r($tag['id'], 1);
                    ?>
                    <article>
                        <h3>#<?= $tag['label']?></h3>
                        <p>id : <?=$tag['id']?></p>
                        <nav>
                            <a href="tags.php?tag_id=<?=$id?>"> Messages</a>
                        </nav>
                    </article>
                <?php } ?>

            </aside>
            <main>
                <h2>Utilisatrices</h2>
                <?php
                // Etape 4 : trouver tous users
                $laQuestionEnSql = "SELECT * FROM `users` LIMIT 50";
                $lesInformations = $mysqli->query($laQuestionEnSql);
                // Vérification
                if (!$lesInformations) {
                    echo("Échec de la requete : " . $mysqli->error);
                    exit();
                }

                // Etape 5 : @todo : Afficher les utilisatrices en s'inspirant de ce qui a été fait dans news.php
                while ($user = $lesInformations->fetch_assoc()) {
                    ?>
                    <article>
                        <h3><?php echo $user['alias'] ?></h3>
                        <p>id : <?php echo $user['id'] ?></p>
                        <nav>
                            <a href="wall.php?user_id=<?= $user['id'] ?>">Mur</a>
                            | <a href="feed.php?user_id=<?= $user['id'] ?>">Flux</a>
                            | <a href="settings.php?user_id=<?= $user['id'] ?>">Paramètres</a>
                            | <a href="followers.php?user_id=<?= $user['id'] ?>">Suiveurs</a>
                            | <a href="subscriptions.php?user_id=<?= $user['id'] ?>">Abonnements</a>
                        </nav>
                    </article>
                <?php } ?>
            </main>
        </div>
    </body>
</html>
