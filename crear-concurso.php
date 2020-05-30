<?php
include('core/award.class.php');
include('header.php');
    $instancia->validarRol(array("Login"));
    $email = $_SESSION['email'];

    $sql="SELECT id_usuario from usuario where email = '$email'";
    $datos = $instancia->queryArray($sql);

    $id_usuario = $datos[0]['id_usuario'];

    if(isset($_POST['enviar'])){
        $foto_tmp=$_FILES['foto']['tmp_name'];
        $concurso=$_POST['concurso'];
        $descripcion = $_POST['descripcion'];
        $descripcion_breve = $_POST['descripcion_breve'];
        $fecha_inicio = $_POST['fecha_inicio'];
        $fecha_cierre = $_POST['fecha_cierre'];
        
        if ($instancia ->validarArchivo($_FILES['foto'])) {
           $bytesImagen = file_get_contents($foto_tmp);
                $consulta="insert into concurso (concurso, descripcion,descripcion_breve, fecha_inicio, fecha_cierre, portada, id_usuario, id_estatus) values (:concurso,:descripcion,:descripcion_breve,:fecha_inicio, :fecha_cierre, :portada, :id_usuario, 3)";

                $statment = $instancia->db->prepare($consulta);

                $statment->bindParam(":concurso",$concurso);
                $statment->bindParam(":descripcion",$descripcion);
                $statment->bindParam(":descripcion_breve",$descripcion_breve);
                $statment->bindParam(":fecha_inicio",$fecha_inicio);
                $statment->bindParam(":fecha_cierre",$fecha_cierre);
                $statment->bindParam(":portada",$bytesImagen);
                $statment->bindParam(":id_usuario",$id_usuario);
                $statment->execute();

                echo '<div class="alert alert-success" role="alert"> ¡Nuevo concurso agregada! </div>';
                echo '<div class="alert alert-alert" role="alert"> El administrador se pondra en contacto contigo para autorizar tu concurso </div>';
            
     }else{
                echo '<div class="alert alert-danger" role="alert"> ¡No olvides la portada! </div>';
      }

    }
?>
  <link rel="stylesheet" href="css/editar-perfil.css">
   
    <form class="form-signin" action="crear-concurso.php" method="POST" enctype="multipart/form-data">
      <h1 class="h3 mb-3 font-weight-normal">Ingresa la información de tu concurso</h1>
       <label>Foto de portada</label>
       <input type="file" name="foto">
      <input type="text" class="form-control" placeholder="Nombre del concurso" name="concurso" required>
      <label>Fecha inicio</label>
      <input type="date" class="form-control" required name="fecha_inicio">
      <label>Fecha limite</label>
      <input type="date" class="form-control" required name="fecha_cierre">
      <textarea class="form-control" rows="5" placeholder="Descripción general del concurso." name="descripcion" required></textarea>
      <textarea class="form-control" rows="5" placeholder="Descripción breve del concurso." name="descripcion_breve" required></textarea>
      <button class="btn btn-lg btn-red btn-block" type="submit" name="enviar">Crear</button>
      
    </form>

<?php include("footer.php");?>