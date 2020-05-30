<?php
include("core/award.class.php");
include ("header.php");
$email = $_SESSION['email'];
$instancia->validarRol(array("Login"));
if (isset($_POST['enviar'])) {
  $foto_tmp=$_FILES['foto']['tmp_name'];
  //extraemos los bytes del archivo
  if ($instancia ->validarArchivo($_FILES['foto'])) {
     $bytesImagen = file_get_contents($foto_tmp);
       $nombre = $_POST['nombre'];
                $apaterno = $_POST['apaterno'];
                $amaterno = $_POST['amaterno'];
                $email = $_POST['email'];
                $descripcion = $_POST['descripcion'];
                
                $consulta = "update usuario set 
                nombre=:nombre,
                apaterno=:apaterno,
                amaterno=:amaterno,
                email=:email,
                descripcion=:descripcion,
                foto_perfil=:imagen
                where email = '$email'";
                
                $statment = $instancia->db->prepare($consulta);
                
                $statment->bindParam(":nombre",$nombre);
                $statment->bindParam(":apaterno",$apaterno);
                $statment->bindParam(":amaterno",$amaterno);
                $statment->bindParam(":email",$email);
                $statment->bindParam(":descripcion",$descripcion);
                $statment->bindParam(":imagen",$bytesImagen);
                $statment->execute();
                
                echo '<div class="alert alert-success" role="alert"> ¡Información actualizada! </div>';
                header("Location: perfil.php");


      echo '<div class="alert alert-success" role="alert"> ¡Nueva imagen agregada! </div>';

  }else{
    echo '<div class="alert alert-danger" role="alert"> ¡No se cambio foto de perfil! </div>';
     $nombre = $_POST['nombre'];
     $apaterno = $_POST['apaterno'];
     $amaterno = $_POST['amaterno'];
     $email = $_POST['email'];
     $descripcion = $_POST['descripcion'];
                
     $consulta = "update usuario set 
     nombre=:nombre,
     apaterno=:apaterno,
     amaterno=:amaterno,
     email=:email,
     descripcion=:descripcion
     where email = '$email'";
     
     $statment = $instancia->db->prepare($consulta);
                
     $statment->bindParam(":nombre",$nombre);
     $statment->bindParam(":apaterno",$apaterno);
     $statment->bindParam(":amaterno",$amaterno);
     $statment->bindParam(":email",$email);
     $statment->bindParam(":descripcion",$descripcion);
                
     $statment->execute();
                
     echo '<div class="alert alert-success" role="alert"> ¡Información actualizada! </div>';
     header("Location: perfil.php");
  }
               
}   
$sql="select * from usuario where email='$email'";
$datos = $instancia->queryArray($sql);
?>

<link rel="stylesheet" href="css/editar-perfil.css">
   
    <form class="form-signin" method="POST" action="editar-perfil.php" enctype="multipart/form-data">
      <h1 class="h3 mb-3 font-weight-normal">Actualiza tu información</h1>
       <img id="imagen-perfil" class="img-fluid" src="data:image; base64, <?php echo base64_encode( $datos[0]['foto_perfil']) ;?>" alt="imagen_perfil">
       <label>Actualizar foto de perfil</label>
      <input type="file" name="foto">
      <input type="text" class="form-control" placeholder="Nombre" required name="nombre" value="<?php echo $datos[0]['nombre']?>">
      <input type="text" class="form-control" placeholder="Apellido paterno" name="apaterno" value="<?php echo $datos[0]['apaterno']?>">
      <input type="text" class="form-control" placeholder="Apellido materno" name="amaterno" value="<?php echo $datos[0]['amaterno']?>">
      <input type="email" id="inputEmail" class="form-control" placeholder="Correo electronico" required name="email" value="<?php echo $datos[0]['email']?>">
      <textarea class="form-control" rows="5" name="descripcion" placeholder="Esta descripción aparecera en tu perfil."><?php echo $datos[0]['descripcion']?></textarea>

      <button class="btn btn-lg btn-red btn-block" type="submit" name="enviar">Guardar</button>
    </form>

<?php include("footer.php");?>