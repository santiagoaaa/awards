<?php
	include("core/award.class.php");
	use PHPMailer\PHPMailer\PHPMailer;
	//require '../vendor/autoload.php';
	require '../vendor/autoload.php';
	$email=(isset($_POST['email']))?$_POST['email']:null;
	if (!is_null($email)) {
		$sql="select * from usuario where email = :email";
		$parametros [':email']=$email;
		$datos = $instancia->queryArray($sql,$parametros);
		if (isset($datos[0])) {
			$llave =md5($email.rand(1,900000000).crypt("padalustro","otracosa").rand(1,43)).md5(crypt("antimateria","otra").sha1("timulo").soundex("monaschinas").rand(1,2));

			$sql="update usuario set llave = :llave where email = :email";
			$statment=$instancia->db->prepare($sql);
			$statment->bindParam(":llave",$llave);
			$statment->bindParam(":email",$email);
			$statment->execute();


			$mail = new PHPMailer;
			$mail->isSMTP();
			//$mail->SMTPDebug = 2;
			$mail->setLanguage('es', '../vendor/PHPMailer/PHPMailer/language/phpmailer.lang-es.php
      ');
			$mail->Host = 'smtp.gmail.com';
			$mail->Port = 587;
			$mail->SMTPSecure = 'tls';
			$mail->SMTPAuth = true;
			$mail->Username = "15030129@itcelaya.edu.mx";
			$mail->Password = "santiagoarturo97";
			$mail->setFrom('15030129@itcelaya.edu.mx', 'Recuperar');
			$mail->addAddress($email, 'Usuarios Generico');
			$mail->Subject = 'Restaurar contraseña';
			$mensaje ="Estimado usuario a continuación encontrará un vinculo para restablecer su contraseña: <br> <a href='https://localhost/awards/restablecer.php?llave=".$llave."'>Restablecer contraseña</a>";
			$mail->msgHTML($mensaje);
			$mail->AltBody = 'This is a plain-text message body';
			if (!$mail->send()) {
				$msg= '<div class="alert alert-danger" role="alert">
				            Algo salio mal 
				         </div>';
         		echo $msg;
			    //echo "Mailer Error: " . $mail->ErrorInfo;
			} else {
			    $msg= '<div class="alert alert-success" role="alert">
		            		¡Correo enviado!
		        	   </div>';
		         echo $msg;
			}

		}else{
			die("El email no existe");
		}
	}
?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>inicio de sesión</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link href="../css/sigin.css" rel="stylesheet">
  </head>

  <body class="text-center">
  	
    <form class="form-signin" action="recuperar.php" method="POST">
      <h1 class="h3 mb-3 font-weight-normal">Restablecer contraseña</h1>
      <label for="inputEmail" class="sr-only">Correo electronico</label>
      <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Correo electronico" required autofocus>
      <br />
      <button class="btn btn-lg btn-primary btn-block" type="submit">Entrar</button>
      <p class="mt-5 mb-3 text-muted">&copy; 2017-2018</p>
    </form>
  </body>
</html>