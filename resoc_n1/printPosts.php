<?php

$lesInformations = $mysqli->query($laQuestionEnSql);
// Vérification
if (!$lesInformations) {
    echo "<article>";
    echo("Échec de la requete : " . $mysqli->error);
    echo("<p>Indice: Vérifiez la requete  SQL suivante dans phpmyadmin<code>$laQuestionEnSql</code></p>");
    exit();
}

// Etape 3: Parcourir ces données et les ranger bien comme il faut dans du html
// NB: à chaque tour du while, la variable post ci dessous reçois les informations du post suivant.
while ($post = $lesInformations->fetch_assoc()) {
    ?>
    <article>
        <h3>
            <time><?php echo $post['created'] ?></time>
        </h3>
        <address>par : <a href="wall.php?user_id=<?= $post['user_id'] ?>"><?php echo $post['author_name'] ?></a></address>
        <div>
            <p><?php echo $post['content'] ?></p>
        </div>
        <footer>
            <small>♥ <?php echo $post['like_number'] ?> </small>
            <?php
            $tagsArray = explode(",", $post['taglist']);
            foreach ($tagsArray as $tag) {
            ?> 
                <a href="tags.php?tag_id=<?php echo substr($tag, -1) ?>">#<?php echo substr($tag, 0, -1) ?></a>
            <?php
            }
            ?>
        </footer>
    </article>
    <?php
    // avec le <?php ci-dessus on retourne en mode php 
}// cette accolade ferme et termine la boucle while ouverte avant.
?>