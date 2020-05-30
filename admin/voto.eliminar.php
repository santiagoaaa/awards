<?php
 include('../core/award.class.php');
        $instancia->validarRol(array("Administrador"));
        $instancia->validarPermiso(array("CRUD"));
    include('header.php');

    if (isset($_GET['id_voto'])) {
        
        $id_voto = $_GET['id_voto'];
        $id_foto = $_GET['id_foto'];
        
        if(is_numeric($id_voto)){
            
            $consulta = "delete from voto where id_voto = :id_voto";
            $statment = $instancia->db->prepare($consulta);
            $statment -> bindParam(":id_voto",$id_voto, PDO::PARAM_INT);
            $statment->execute();
            echo '<div class="alert alert-success" role="alert"> ¡Voto eliminado! </div>';

            $sql="update fotografia set num_votos = (select num_votos-1 where id_fotografia=:id_fotografia) where id_fotografia=:id_fotografia";
            $statment = $instancia->db->prepare($sql);
            $statment->bindParam(":id_fotografia",$id_foto);
            $statment->execute();  

            echo '<div class="alert alert-success" role="alert"> ¡Voto descontando! </div>';
        }
    }

include("footer.php");
?>