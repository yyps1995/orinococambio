<?php
session_start();
require_once 'class.user.php';
$user = new USER();

if($user->is_logged_in()!="")
{
	$user->redirect('home.php');
}

if(isset($_POST['btn-submit']))
{
	$email = $_POST['txtemail'];
	
	$stmt = $user->runQuery("SELECT userID FROM tbl_users WHERE user_email=:email LIMIT 1");
	$stmt->execute(array(":email"=>$email));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);	
	if($stmt->rowCount() == 1)
	{
		$id = base64_encode($row['userID']);
		$code = md5(uniqid(rand()));
		
		$stmt = $user->runQuery("UPDATE tbl_users SET tokenCode=:token WHERE user_email=:email");
		$stmt->execute(array(":token"=>$code,"email"=>$email));
		
		$message= "
				   Hola, $email
				   <br /><br />
				   Recibimos un pedido para cambiar tu contraseña, si ha sido usted haga click en el siguiente link, si no, solo ignore este email,
				   <br /><br />
				   <a href='http://orinococambio.com/resetpass.php?id=$id&code=$code'>Presiones aqui para cambiar su contraseña</a>
				   <br /><br />
				   Gracias!
				   ";
		$subject = "Cambiar contraseña";
		
		$user->send_mail($email,$message,$subject);
		
		$msg = "<div class='alert alert-success'>
					<button class='close' data-dismiss='alert'>&times;</button>
					Hemos enviado un email a $email.
                    Porfavor has click en el link enviado a su email para generar su nueva contraseña. 
			  	</div>";
	}
	else
	{
		$msg = "<div class='alert alert-danger'>
					<button class='close' data-dismiss='alert'>&times;</button>
					<strong>Lo sentimos!</strong> Este email no existe. 
			    </div>";
	}
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Orinoco</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/styles.css">
    <link href="assets/styles.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" href="css/animate.min.css">
  </head>

  <body>

<nav class="navbar navbar-toggleable-md navbar-light bg-faded">
  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
    <ul class="navbar-nav">
      <li class="nav-item">
          <a href="index.php"><button style="margin: 5px;" type="button" class="btn btn-large botoniniciar">Atras</button></a>
      </li>
    </ul>
  </div>
</nav>

  	<center>
		<div class="animated fadeInDown fpass">
		      <form class="form-signin" method="post">
		        <h2 class="form-signin-heading">Cambiar contraseña</h2><hr />
		        
		        	<?php
					if(isset($msg))
					{
						echo $msg;
					}
					else
					{
						?>
		              	<div class='alert alert-info'>
						Porfavor ingrese su email. Recibira un email para crear su nueva contraseña.!
						</div>  
		                <?php
					}
					?>
		        
		        <input type="email" class="input-block-level" placeholder="Email address" name="txtemail" required />
		     	<hr />
		        <button class="btn btn-danger btn-primary" type="submit" name="btn-submit">Generar nueva contraseña</button>
		      </form>
		  </div>
  	</center>
    <!-- jQuery first, then Tether, then Bootstrap JS. -->
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
    <script type="text/javascript" src="assets/particles.min.js"></script>
    <script type="text/javascript" src="assets/app.js"></script> 
  </body>
</html>