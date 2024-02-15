<?php 
if (isset ($_SESSION['connected_id'])) {
    $enCoursDeTraitement = isset($_POST['following_user_id']);
    if ($enCoursDeTraitement) {
        // Etape 2: récupérer ce qu'il y a dans le formulaire
        $followed_user_id = $_POST['followed_user_id'];
        $following_user_id = $_POST['following_user_id'];

        //Etape 3 : Ouvrir une connexion avec la base de données.
        include 'variables.php';
        $mysqli = new mysqli($server, $account, $password, $database2, $port);
        // Etape 4 : éviter les injections sql
        $following_user_id = $mysqli->real_escape_string($following_user_id);
        $followed_user_id = $mysqli->real_escape_string($followed_user_id);
        // Etape 5 : construction de la requete
        $lInstructionSql = "INSERT INTO followers (id, followed_user_id, following_user_id)
                            VALUES (NULL, '$followed_user_id','$following_user_id');";
        // Etape 6: exécution de la requete
        $ok = $mysqli->query($lInstructionSql);
    }
    if (isset($_SESSION['connected_id']) && ($userId != $_SESSION['connected_id'])) { 
    ?>
        <form id="myForm" action=<?= $_SERVER['REQUEST_URI']?> method="post">
            <dl>
                <dd><input type="hidden" name="following_user_id" value="<?php echo $userId; ?>"></dd>
                <dd><input type="hidden" name="followed_user_id" value="<?php echo $_SESSION["connected_id"]; ?>"></dd>
            </dl>
            <button type="submit">follow</button>
        </form>
    <?php
    }
}                    
?>