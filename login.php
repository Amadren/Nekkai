<?php require('config/config.php'); ?>
<html lang="fr">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" href="style.css">
        <link rel="icon" href="favicon.ico" type="image/x-icon"/>
        <title>Connexion</title>
    </head>
    <body>
        <?php
        include("includes/header.php");
        ?>
        <form method="post">
        <?php
        if(isset($_SESSION['username']))
        {
            unset($_SESSION['username'], $_SESSION['userid']);
            ?>
            <div class="message">You have successfuly been loged out.<br />
            <a href="http://nekkai.net">Home</a></div>
            <?php
        }
        else
        {
            if(isset($_POST['username'], $_POST['password']))
            {
                $username = $_POST['username'];
                $password = $_POST['password'];
 
                $req = $connect->prepare("SELECT * FROM users WHERE username = :user");
                $req->execute(array("user" => $username));
                $dn = $req->fetchAll(PDO::FETCH_ASSOC);

                if(count($dn) > 0 AND $dn[0]['password'] == $password)
                {
                    $form = false;
 
                    $_SESSION['username'] = $_POST['username'];
                    $_SESSION['userid'] = $dn [0]['id'];
                    ?>
                    <div class="message">You have successfuly been logged. You can access to your member area.<br />
                    <a href="http://nekkai.net">Home</a></div>
                    <!-- <meta http-equiv="refresh" content="secondes;URL=adresse-de-redirection"> -->
                    <?php
                }
                else
                {
                ?>
                    <div class="message">The username or password is incorrect.</div>
                <?php
                }
            }
        }
        ?>
        <div class="content">
            Please type your IDs to log in:<br />
            <div class="center">
                <label for="username">Username</label><input type="text" name="username" id="username" /><br />
                <label for="password">Password</label><input type="password" name="password" id="password" /><br />
                <input type="submit" value="Log in" />
            </div>
        </div>
        </form>
        <?php
        include("includes/footer.php");
        ?>
    </body>
</html>