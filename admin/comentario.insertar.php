<?php 
        include('../core/award.class.php');
        $instancia->validarRol(array("Administrador"));
        $instancia->validarPermiso(array("CRUD"));
        include('header.php');
    if(isset($_POST['enviar'])){
        $nombre = $_POST['nombre'];
        $apaterno = $_POST['apaterno'];
        $amaterno = $_POST['amaterno'];
        $correo = $_POST['correo'];
        $comentario = $_POST['comentario'];

        
        $consulta ="insert into comentario (comentario,nombre, apaterno, amaterno, correo)
                    values (:comentario,:nombre, :apaterno, :amaterno, :correo)";
        $statment =$instancia -> db -> prepare($consulta);
        
        $statment->bindParam(":nombre",$nombre);
        $statment->bindParam(":apaterno",$apaterno);
        $statment->bindParam(":amaterno",$amaterno);
        $statment->bindParam(":correo",$correo);
        $statment->bindParam(":comentario",$comentario);
        
        $statment->execute();
        
        echo '<div class="alert alert-success" role="alert"> ¡Nuevo comentario agregado! </div>';
        
    }
?>
<h1>Crear nuevo comentario</h1>
<div class="container">
    <form action="comentario.insertar.php" method="post" class="form-group">
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
            <label>comentario</label>
            <input class="form-control" type="text" name="comentario" maxlength="500" required>
        </div>

        
        <div class="form-group">
            <input class="btn btn-primary" type="submit" name="enviar" value="Guardar">
        </div>
    </form>
</div>
<?php include("footer.php");?>