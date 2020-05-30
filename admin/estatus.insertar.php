<?php
 include('../core/award.class.php');
        $instancia->validarRol(array("Administrador"));
        $instancia->validarPermiso(array("CRUD"));
    include('header.php');

    if (isset($_POST['enviar'])) {
        $estatus = $_POST['estatus'];

        $consulta = "insert into estatus (estatus) values (:estatus)";

        $statment = $instancia->db->prepare($consulta);

        $statment -> bindParam(":estatus", $estatus);

        $statment->execute();
        echo '<div class="alert alert-success" role="alert"> ¡Nuevo estatus agregado! </div>';
    }
?>
<h1>Crear nuevo estatus</h1>
<div class="container">
    <form action="estatus.insertar.php" method="post" class="form-group">
        <div class="form-group">
            <label>Estatus</label>
            <input class="form-control" type="text" name="estatus" maxlength="20" required>
        </div>
        
        <div class="form-group">
            <input class="btn btn-primary" type="submit" name="enviar" value="Guardar">
        </div>
    </form>
</div>

<?php
include("footer.php");
?>
