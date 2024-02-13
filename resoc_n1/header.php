<?php
session_start();

// déconnecter le user
if (isset($_POST['logout'])) {
    $_SESSION = array();    
}
?>

<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title><?php echo $pageTitle ?></title> 
        <meta name="author" content="Julien Falconnet">
        <link rel="stylesheet" href="style.css"/>
    </head>
    <body>
        <header>
            <a href='admin.php'><img src="resoc.jpg" alt="Logo de notre réseau social"/></a>
            <nav id="menu">
                <a href="news.php">Actualités</a>
                <a href="wall.php?user_id=5">Mur</a>
                <a href="feed.php?user_id=5">Flux</a>
                <a href="tags.php?tag_id=1">Mots-clés</a>
            
            <?php
            if (isset($_SESSION['connected_id'])){ ?>
                <form action="login.php" method="post">
                    <input type='submit'name='logout' value="Se déconnecter">
                </form>
            <?php } ?>
            </nav>

            <nav id="user">
                <a href="#">Profil</a>
                <ul>
                    <li><a href="settings.php?user_id=5">Paramètres</a></li>
                    <?php
                    if (isset ($_SESSION['connected_id'])) { ?>
                    <li><a href="followers.php?user_id=5">Mes suiveurs</a></li>
                    <li><a href="subscriptions.php?user_id=5">Mes abonnements</a></li>
                    <?php } else { ?>
                    <li><a href="login.php?">login</a></li>
                        <?php
                    } ?>
                </ul>

            </nav>
        </header>