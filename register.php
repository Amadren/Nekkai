<?php
include('config/config.php');
?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" href="style.css">
		<link rel="icon" href="favicon.ico" type="image/x-icon"/>
        <title>Sign up</title>
    </head>
    <body>
	<?php include("includes/header.php") ?>
<?php
//We check if the form has been sent
if(isset($_POST['username'], $_POST['password'], $_POST['passverif'], $_POST['email'], $_POST['avatar']) and $_POST['username']!='')
{
        //We remove slashes depending on the configuration
        if(get_magic_quotes_gpc())
        {
                $_POST['username'] = stripslashes($_POST['username']);
                $_POST['password'] = stripslashes($_POST['password']);
                $_POST['passverif'] = stripslashes($_POST['passverif']);
                $_POST['email'] = stripslashes($_POST['email']);
                $_POST['avatar'] = stripslashes($_POST['avatar']);
        }
        //We check if the two passwords are identical
        if($_POST['password']==$_POST['passverif'])
        {
                //We check if the password has 6 or more characters
                if(strlen($_POST['password'])>=6)
                {
                        //We check if the email form is valid
                        if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
                        {
                                //Protection of variables
								$username = $_POST['username'];
								$password = $_POST['password'];
								$email = $_POST['email'];
								$avatar = "";
								$avatar = $_POST['avatar'];
                                //Check if there is no other user using the same username
								$req = $connect->prepare('SELECT id FROM users WHERE username = :user');
								$req->execute(array(":user" => $username));
                                $dn = $req->fetchAll();
                                if(count($dn) == 0)
                                {

                                        //Save the informations to the databse
										$req = $connect->prepare('INSERT INTO users(username, password, email, avatar, signup_date) VALUES (:username, :password, :email, :avatar, :timer)');
										$req->execute(array("username" => $username, "password" => $password, "email" => $email, "avatar" => $avatar, "timer" => time()));
										if($req)
                                        {
                                                $form = false;
?>
<div class="message">You have successfuly been signed up. You can log in.<br />
<a href="login.php">Log in</a></div>
<?php
                                        }
                                        else
                                        {
                                                //Otherwise, we say that an error occured
                                                $form = true;
                                                $message = 'An error occurred while signing up.';
                                        }
                                }
                                else
                                {
                                        //Otherwise, we say the username is not available
                                        $form = true;
                                        $message = 'The username you want to use is not available, please choose another one.';
                                }
                        }
                        else
                        {
                                //Otherwise, we say the email is not valid
                                $form = true;
                                $message = 'The email you entered is not valid.';
                        }
                }
                else
                {
                        //Otherwise, we say the password is too short
                        $form = true;
                        $message = 'Your password must contain at least 6 characters.';
                }
        }
        else
        {
                //Otherwise, we say the passwords are not identical
                $form = true;
                $message = 'The passwords you entered are not identical.';
        }
}
else
{
        $form = true;
}
if($form)
{
        //We display a message if necessary
        if(isset($message))
        {
                echo '<div class="message">'.$message.'</div>';
        }
        //We display the form
?>
<div class="content">
    <form action="register.php" method="post">
        Please fill the following form to sign up:<br />
        <div class="center">
            <label for="username">Username</label><input type="text" name="username" value="<?php if(isset($_POST['username'])){echo htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8');} ?>" /><br />
            <label for="password">Password<span class="small">(6 characters min.)</span></label><input type="password" name="password" /><br />
            <label for="passverif">Password<span class="small">(verification)</span></label><input type="password" name="passverif" /><br />
            <label for="email">Email</label><input type="text" name="email" value="<?php if(isset($_POST['email'])){echo htmlentities($_POST['email'], ENT_QUOTES, 'UTF-8');} ?>" /><br />
            <label for="avatar">Avatar<span class="small">(optional)</span></label><input type="text" name="avatar" value="<?php if(isset($_POST['avatar'])){echo htmlentities($_POST['avatar'], ENT_QUOTES, 'UTF-8');} ?>" /><br />
            <input type="submit" value="Sign up" />
                </div>
    </form>
</div>
<?php
}
?>
	<?php include("includes/footer.php") ?>
        </body>
</html>