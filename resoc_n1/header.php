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
        <!-- <?php echo $_SESSION['connected_id']?> -->
            <a href='admin.php'><img src="resoc.jpg" alt="Logo de notre réseau social"/></a>
            <nav id="menu">
                <a href="news.php">Actualités</a>
                <a href="wall.php?user_id=<?= isset($_SESSION['connected_id']) ? $_SESSION['connected_id'] : "0" ?>">Mur</a>
                <a href="feed.php?user_id=<?= isset($_SESSION['connected_id']) ? $_SESSION['connected_id'] : "0"?>">Flux</a>
                <a href="tags.php?tag_id=1">Mots-clés</a>
            </nav>

            <nav id="user">
                <a href="login.php">Profil</a>
                <ul>
                    <?php
                    if (isset ($_SESSION['connected_id'])) { ?>
                        <li><a href="settings.php?user_id=<?php echo $_SESSION['connected_id']?>">Paramètres</a></li>
                        <li><a href="followers.php?user_id=<?php echo $_SESSION['connected_id']?>">Mes suiveurs</a></li>
                        <li><a href="subscriptions.php?user_id=<?php echo $_SESSION['connected_id']?>">Mes abonnements</a></li>
                        <form action="login.php" method="post">
                        <input type='submit'name='logout' value="Se déconnecter">
                        </form>
                    <?php
                    } ?>
                </ul>

            </nav>
        </header>