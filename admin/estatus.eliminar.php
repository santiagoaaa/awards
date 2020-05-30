<?php
 include('../core/award.class.php');
        $instancia->validarRol(array("Administrador"));
        $instancia->validarPermiso(array("CRUD"));
    include('header.php');

    if (isset($_GET['id_estatus'])) {
        
        $id_estatus = $_GET['id_estatus'];
        
        if(is_numeric($id_estatus)){
            $consulta = "delete from estatus where id_estatus = :id_estatus";

            $statment = $instancia->db->prepare($consulta);

            $statment -> bindParam(":id_estatus",$id_estatus, PDO::PARAM_INT);

            $statment->execute();
            echo '<div class="alert alert-success" role="alert"> ¡Estatus eliminado! </div>';
        }
    }

include("footer.php");
?>
