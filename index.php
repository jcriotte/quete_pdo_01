<?php

require_once '_connec.php';

$pdo = new \PDO(DSN, USER, PASS);

$firstNameErr = $lastNameErr = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["firstname"])) {
      $firstNameErr = "First Name is required<br>";
    } else {
        $firstname = trim($_POST['firstname']); // get the data from a form
    }
  
    if (empty($_POST["lastname"])) {
      $lastNameErr = "Last Name is required<br>";
    } else {
      $lastname = trim($_POST['lastname']); // get the data from a form
    }
  
    $query = 'INSERT INTO friend (firstname, lastname) VALUES (:firstname, :lastname)';
    $statement = $pdo->prepare($query);
    
    $statement->bindValue(':firstname', $firstname, \PDO::PARAM_STR);
    $statement->bindValue(':lastname', $lastname, \PDO::PARAM_STR);
    
    $statement->execute();
   
    $friends = $statement->fetchAll();

//    echo "Nombre d'enregistrement ajouté " . $statement. " <br>";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>FRIEND FAMILLY</title>
        <link rel="stylesheet" type="text/css" href="style.css">

        <?php
        // set the default timezone to use.
        date_default_timezone_set('UTC');
        ?>
</head>

<body>

    <div class="listeFriends">

        <h2>Voici la liste des membres de la Firends Familly</h2>
        
        <ul>
        <?php
            $query = "SELECT * FROM friend";
            $statement = $pdo->query($query);
            $friends = $statement->fetchAll();

            foreach($friends as $friend) {
                ?>
                <li><?php echo $friend['firstname'] . " " . $friend['lastname'] ." <br>";?></li>
            <?php
            }
        ?>
        </ul>
    </div>    

    <div class="ajoutFriend">
        <form action="" method="post">
            <div>
                <label for="name">Nom :</label>
                <input type="text" id="name" name="firstname" required>
/*                <span class="error">* <?php echo $firstNameErr;?></span>*/
            </div>
            <div>
                <label for="prenom">Prénom :</label>
                <input type="text" id="prenom" name="lastname" required>
/*                <span class="error">* <?php echo $lastNameErr;?></span>*/
            </div>
            <div>
                <button type="submit" onclick="alert('Le formulaire est soumit!')">Ajouter une personne</button> </button>
            </div>
        </form>
    </div>

</body>

</html>

