<?php 
 include('../core/award.class.php');
        $instancia->validarRol(array("Administrador"));
        $instancia->validarPermiso(array("CRUD"));
    include("header.php");
    if(isset($_POST['enviar'])){
        $nombre = $_POST['nombre'];
        $apaterno = $_POST['apaterno'];
        $amaterno = $_POST['amaterno'];
        $correo = $_POST['correo'];
        $clave = $_POST['clave'];
        $descripcion = $_POST['descripcion'];
        
        $consulta ="insert into usuario (nombre, apaterno, amaterno, correo, clave, descripcion)
                    values (:nombre, :apaterno, :amaterno, :correo, :clave, :descripcion)";
        $statment =$instancia -> db -> prepare($consulta);
        
        $statment->bindParam(":nombre",$nombre);
        $statment->bindParam(":apaterno",$apaterno);
        $statment->bindParam(":amaterno",$amaterno);
        $statment->bindParam(":correo",$correo);
        $statment->bindParam(":clave",$clave);
        $statment->bindParam(":descripcion",$descripcion);
        
        $statment->execute();
        
         echo '<div class="alert alert-success" role="alert"> ¡Nuevo usuario agregado! </div>';
        
    }
?>
<h1>Crear nuevo usuario</h1>
<div class="container">
    <form action="usuario.insertar.php" method="post" class="form-group">
        <div class="form-group">
            <label>Nombre</label>
            <input class="form-control" type="text" name="nombre" maxlength="30" required>
        </div>
        
        <div class="form-group">
            <label>Apellido Paterno</label>
            <input class="form-control" type="text" name="apaterno" maxlength="30">
        </div>
        
        <div class="form-group">
            <label>Apellido Materno</label>
            <input class="form-control" type="text" name="amaterno" maxlength="30">
        </div>
        
        <div class="form-group">
            <label>Correo</label>
            <input class="form-control" type="email" name="correo" maxlength="40" required>
        </div>
        
        <div class="form-group">
            <label>Clave</label>
            <input class="form-control" type="password" name="clave" maxlength="8" required>
        </div>
        <div class="form-group">
            <label>Descripción</label>
            <input class="form-control" type="text" name="descripcion" maxlength="500">
        </div>
        
        
        <div class="form-group">
            <input class="btn btn-primary" type="submit" name="enviar" value="Guardar">
        </div>
    </form>
</div>
<?php include("footer.php");?>