<?php 
include('core/award.class.php');
use PHPMailer\PHPMailer\PHPMailer;
require '../vendor/autoload.php';
    include("header.php");
    if(isset($_POST['enviar'])){
        $nombre = $_POST['nombre'];
        $apaterno = $_POST['apaterno'];
        $amaterno = $_POST['amaterno'];
        $correo = $_POST['email'];
        $email = $_POST['email'];
        $contrasena=$_POST['contrasena'];
        $clave = md5($_POST['contrasena']);
        
        $consulta ="insert into usuario (nombre, apaterno, amaterno, email, contrasena)
                    values (:nombre, :apaterno, :amaterno, :email, :contrasena)";
        $statment =$instancia -> db -> prepare($consulta);
        
        $statment->bindParam(":nombre",$nombre);
        $statment->bindParam(":apaterno",$apaterno);
        $statment->bindParam(":amaterno",$amaterno);
        $statment->bindParam(":email",$correo);
        $statment->bindParam(":contrasena",$clave);
        $statment->execute();

        $datos =$instancia->queryArray("select id_usuario from usuario where email = '$correo'");
        $id_usuario=$datos[0]['id_usuario'];
        $id_rol=2;
        $sql="insert into rol_usuario (id_rol, id_usuario) values (:id_rol, :id_usuario)";
        $statment = $instancia->db->prepare($sql);
        $statment->bindParam(":id_rol",$id_rol);
        $statment->bindParam(":id_usuario",$id_usuario);
        $statment->execute();
        
        echo '<div class="alert alert-success" role="alert"> ¡Registrado correctamente! </div>';
 
        
        if (!is_null($email)) {
          $sql="select * from usuario where email = :email";
          $parametros [':email']=$email;
          $datos = $instancia->queryArray($sql,$parametros);
          if (isset($datos[0])) {
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
            $mail->setFrom('15030129@itcelaya.edu.mx', 'Información');
            $mail->addAddress($email, 'Usuarios Generico');
            $mail->Subject = 'Datos login';
            $mensaje ="La siguiente Información debe ser privada. No debes compartirla con nadie mas: <br />
                  Correo: ".$email."<br /> Contraseña: ".$contrasena;
            $mail->msgHTML($mensaje);
            $mail->AltBody = 'This is a plain-text message body';
            if (!$mail->send()) {
              $contrasena=0;
              $msg= '<div class="alert alert-danger" role="alert">
                          Algo salio mal 
                       </div>';
                  echo $msg;
                //echo "Mailer Error: " . $mail->ErrorInfo;
            } else {
                $contrasena=0;
                $msg= '<div class="alert alert-success" role="alert">
                          ¡Correo enviado!
                       </div>';
                   echo $msg;
            }

          }else{
            die("El email no existe");
          }
        }    
        
    }
?>

    <link rel="stylesheet" href="css/registro.css">
   
    <form class="form-signin" action="registro.php" method="post">
      <img class="mb-4" src="imagenes/logo.png" alt="logo" width="72" height="72">
      <h1 class="h3 mb-3 font-weight-normal">Formulario de registro</h1>

      <input type="text" class="form-control" name="nombre" placeholder="Nombre" required>
      <input type="text" class="form-control" name="apaterno" placeholder="Apellido paterno">
      <input type="text" class="form-control" name="amaterno" placeholder="Apellido materno">

      <input type="email" id="inputEmail" class="form-control" name="email" placeholder="Correo electronico" required>
      <input type="password" id="inputPassword" class="form-control" name="contrasena" placeholder="Contraseña" required>
      <div class="checkbox mb-3">
   
      </div>
      <button class="btn btn-lg btn-red btn-block" type="submit" name="enviar">Registrar</button>
    </form>

<?php include("footer.php")?>