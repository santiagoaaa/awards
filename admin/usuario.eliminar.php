<?php
 include('../core/award.class.php');
        $instancia->validarRol(array("Administrador"));
        $instancia->validarPermiso(array("CRUD"));
    include('header.php');

    if (isset($_GET['id_usuario'])) {
        
        $id_usuario = $_GET['id_usuario'];
        
        if(is_numeric($id_usuario)){
            $consulta = "delete from usuario where id_usuario = :id_usuario";

            $statment = $instancia->db->prepare($consulta);

            $statment -> bindParam(":id_usuario",$id_usuario, PDO::PARAM_INT);

            $statment->execute();
            echo '<div class="alert alert-success" role="alert"> ¡Usuario eliminado! </div>';
        }
    }

    include("footer.php");
?>