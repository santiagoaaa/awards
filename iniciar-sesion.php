<?php
include("core/award.class.php");
include("header.php");
$msg="";
$email=(isset($_POST['email']))?$_POST['email']:null;
$contrasena=(isset($_POST['contrasena']))?$_POST['contrasena']:null;

if(!is_null($email) && !is_null($contrasena)){
  if ($instancia->login($email,$contrasena)) {
    $_SESSION['valido']="true";
    $_SESSION['email']=$email;
    $_SESSION['roles']=$instancia->obtenerRoles($email);
    $_SESSION['permisos']=$instancia->obtenerPermisos($email);
    $datos = $instancia->obtenerRoles($email);    
    if ($datos[0]=="Administrador") {
      header("Location: indexadmin.php");
      echo "Administrador";
    } else if($datos[0]=="Login") {
      header("Location: perfil.php");
      echo "Usuario";
    }

  }else{

    $instancia->logout();
    $msg= '<div class="alert alert-danger" role="alert">
            Login incorrecto usuario/contraseña inválidos
         </div>';
  }
}else{
  $instancia->logout();
  //$msg= '<div class="alert alert-primary" role="alert">
      //      Has salido del sistema
      // </div>';
}
?>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="css/iniciar-sesion.css">
  </head>
<body>
   
    <form class="form-signin" method="POST" action="iniciar-sesion.php">
      <?php echo $msg; ?>
      <img class="mb-4" src="imagenes/logo.png" alt="logo" width="72" height="72">
      <h1 class="h3 mb-3 font-weight-normal">Ingresa tus datos</h1>
      <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Correo electronico" required autofocus>
      <input type="password" id="inputPassword" name="contrasena" class="form-control" placeholder="Contraseña" required>
     <div class="checkbox mb-3">
        <label>
          <a href="recuperar.php">
            ¿Olvidaste tu contraseña?
          </a>
        </label>
      </div>
      <button class="btn btn-lg btn-primary btn-block" type="submit">Entrar</button>
    </form>
</body>
 <footer class="footer text-center">
        <div class="container">
            <ul class="list-inline mb-5">
                <li class="list-inline-item">
                    <a class="social-link rounded-circle text-white mr-3" href="#">
                        <i class="icon-social-facebook"></i>
                    </a>
                </li>
                <li class="list-inline-item">
                    <a class="social-link rounded-circle text-white mr-3" href="#">
                        <i class="icon-social-twitter"></i>
                    </a>
                </li>
                <li class="list-inline-item">
                    <a class="social-link rounded-circle text-white" href="#">
                        <i class="icon-social-youtube"></i>
                    </a>
                </li>
            </ul>
            <p class="text-muted small mb-0">Copyright &copy; awards.xyz 2018</p>
        </div>
    </footer>
</html>