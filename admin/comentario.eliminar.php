<?php
    include('../core/award.class.php');
    $instancia->validarRol(array("Administrador"));
    $instancia->validarPermiso(array("CRUD"));
    include('header.php');
    if (isset($_GET['id_comentario'])) {
        
        $id_comentario = $_GET['id_comentario'];
        
        if(is_numeric($id_comentario)){
            $consulta = "delete from comentario where id_comentario = :id_comentario";

            $statment = $instancia->db->prepare($consulta);

            $statment -> bindParam(":id_comentario",$id_comentario, PDO::PARAM_INT);

            $statment->execute();
            echo '<div class="alert alert-success" role="alert"> ¡Usuario eliminado! </div>';
        }
    }

    include("footer.php");
?>