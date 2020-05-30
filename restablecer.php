<?php 
include("core/award.class.php");
if(isset($_GET['llave'])){
	$llave = $_GET['llave'];
	$datos=$instancia->queryArray("select * from usuario where llave = :llave", array(':llave'=>$llave));

	if (isset($datos[0])) {
		if (isset($_POST['recuperar'])) {
			print_r($datos);
			$contrasena=md5($_POST['contrasena']);
			$sql="update usuario set contrasena = :contrasena, llave=null where llave=:llave";
			$statment = $instancia->db->prepare($sql);
			$statment->bindParam(":contrasena",$contrasena);
			$statment->bindParam(":llave",$llave);
			$statment->execute();
			header("Location: iniciar-sesion.php");
		}
	}else{
		die("llave expiro");
	}
}else{
	die();
}
?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Restablecer contraseña</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link href="../css/sigin.css" rel="stylesheet">
  </head>

  <body class="text-center">
  	
    <form class="form-signin" action="restablecer.php?llave=<?php echo $llave; ?>" method="POST">
      <h1 class="h3 mb-3 font-weight-normal">Nueva contraseña</h1>

      <label for="inputPassword" class="sr-only">Contraseña</label>
      <input type="password" id="inputPassword" name="contrasena" class="form-control" placeholder="Contraseña" required>
      
      <input class="btn btn-lg btn-primary btn-block" type="submit" name="recuperar">Recuperar</input>
      <p class="mt-5 mb-3 text-muted">&copy; 2017-2018</p>
    </form>
  </body>
</html>