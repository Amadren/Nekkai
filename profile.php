<?php
include('config/config.php');
?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" href="style.css">
        <link rel="icon" href="favicon.ico" type="image/x-icon"/>
        <title>Profile of an user</title>
    </head>
    <body>
	<?php include("includes/header.php") ?>
        <div class="content">
<?php
//We check if the users ID is defined
if(isset($_GET['id']))
{
        $id = intval($_GET['id']);
        //We check if the user exists
		$req = $connect->prepare("SELECT username, email, avatar, signup_date FROM users WHERE id = :id");
		$req->execute(array(":id" => $id));
		$dn = $req->fetch();

		
        if(count($dn) > 0)
        {
                $dnn = $dn;
?>
This is the profile of "<?php echo htmlentities($dnn['username']); ?>" :
<table style="width:500px;">
        <tr>
        <td><?php
if($dnn['avatar']!='')
{
        echo '<img src="'.htmlentities($dnn['avatar'], ENT_QUOTES, 'UTF-8').'" alt="Avatar" style="max-width:100px;max-height:100px;" />';
}
else
{
        echo 'This user dont have an avatar.';
}
?></td>
        <td class="left"><h1><?php echo htmlentities($dnn['username'], ENT_QUOTES, 'UTF-8'); ?></h1>
        Email: <?php echo htmlentities($dnn['email'], ENT_QUOTES, 'UTF-8'); ?><br />
        This user joined the website on <?php echo date('Y/m/d',$dnn['signup_date']); ?></td>
    </tr>
</table>
<?php
        }
        else
        {
                echo 'This user dont exists.';
        }
}
else
{
        echo 'The user ID is not defined.';
}
?>
                </div>
		<?php
        include("includes/footer.php");
        ?>
        </body>
</html>