<?php
require_once("../include/phpHeader.inc.php");
// Récupère la langue et les textes selon la langue choisie
$currentPage = basename(__FILE__,'.php')."_php";
$fileName = basename(__FILE__,'.php').".php";
?>
<?php
if(isset($_SESSION["connecte"]) && isset($_SESSION["connecte"]) == "true" && isset($_SESSION["user"]) ){
    $sql = "SELECT * FROM admin WHERE idadmin = :idUser";
    $stmt = $bdd->prepare($sql);
    $stmt->bindParam(':idUser', $_SESSION["user"]);;
    $stmt->execute();
    $user = $stmt->fetch();
    if($stmt->rowCount() >= 1){


    }else{
        header("Location: ./index.php");
    }

}else{
    header("Location: ./index.php");
}
?>

<!DOCTYPE html>
<html lang=<?php echo "$lang" ?>>
<!-- Début du head générée par php -->
<head>
    <meta charset="utf-8" />
    <title><?php echo ${$currentPage."_title"}[$lang] ;  ?></title>
    <meta name="description" content=<?php echo ${$currentPage."_desc"}[$lang] ?>>

<!-- Head teamplate -->
<?php include_once("./teamplates/head.php"); ?>

    <body>
        <a id='skip' href="#content"><?php echo "$gotoContent[$lang]" ?></a>
        <div class="bloc"></div>
        <div class="top">
            <div class="container">
                <div class="content">
                    <p><?php echo ${$currentPage."_splashScreen"}[$lang] ?></p>
                </div>
            </div>
        </div>

<?php include_once("./teamplates/nav_bar.php"); ?>



    <article>
        <div class="article-content">
            <h1><?php echo ${$currentPage."_contribsA"}[$lang];?></h1>
            </div>       
    </article>

    <main class="connexion_main" >
<?php
     
if(isset($_POST['login']) && isset($_POST['name']) && isset($_POST['lastname'])){
    $role = $_POST['login'];
    $name = $_POST['name'];
    $lastname = $_POST['lastname'];


    $req = $bdd->prepare("INSERT INTO contributeur (nom, prenom,role) VALUES (:lastname, :name, :role);");
    $req->bindParam(':role', $role);
    $req->bindParam(':name', $name);
    $req->bindParam(':lastname', $lastname);
    $req->execute();
    $idUser = $req->fetch();
    $req->closeCursor();
    echo "<h2> Le contributeur a été ajouté </h2>";
}

if(isset($_POST['contrib'])){
    $name = $_POST['contrib'];
   
    $req = $bdd->prepare("DELETE FROM contributeur WHERE idcontributeur	= :name");
    $req->bindParam(':name', $name);
    
    $req->execute();
    $req->closeCursor();
    echo "<h2> Le contributeur a été supprimé </h2>";

}
?>
    <form action="#" method="post" class="connexion_form">
        <div>
            <label for="name"><?php echo ${$currentPage."_name"}[$lang];?></label>
            <input type="text" id="name" name="name" placeholder="<?php echo ${$currentPage."_name"}[$lang];?>" required>
        </div>
        <div>     
            <label for="lastname"><?php echo ${$currentPage."_lastname"}[$lang];?></label>
            <input type="text" id="lastname" name="lastname" placeholder="<?php echo ${$currentPage."_lastname"}[$lang];?>" required>
        </div>

        <div>
            <label for="login"><?php echo ${$currentPage."_login"}[$lang];?></label>
            <input type="text" id="login" name="login" placeholder="<?php echo ${$currentPage."_login"}[$lang];?>" required>
        </div>
            <input type="submit" value="<?php echo ${$currentPage."_submitA"}[$lang];?>">
    
    </form>

    <article>
        <div class="article-content">
            <h1><?php echo ${$currentPage."_contribsR"}[$lang];?></h1>
            </div>       
    </article>

    <form action="#" method="post" class="connexion_form">


        <div>
        <label for="contrib">Contributeur/Contributor</label>
        <SELECT name="contrib" required>
                <?php
                $contribs = $bdd->query("SELECT * FROM contributeur;");
                print_r($contribs);
                while ($contrib = $contribs->fetch()){
                    echo "<option value='$contrib[0]'>$contrib[1] $contrib[2] - $contrib[3]</option>";
                }
                ?>
			</SELECT><br>
        </div>
        
            <input type="submit" value="<?php echo ${$currentPage."_submitR"}[$lang];?>">
    
    </form>

</main>


<?php include_once("./teamplates/footer.php"); ?>
    </body>