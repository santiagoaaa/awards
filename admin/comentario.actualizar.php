<?php
        include('../core/award.class.php');
        $instancia->validarRol(array("Administrador"));
        $instancia->validarPermiso(array("CRUD"));
        include('header.php');
        if(isset($_GET['id_comentario'])){
        $id_comentario = $_GET['id_comentario'];
        if(is_numeric($id_comentario)){
            if(isset($_POST['enviar'])){
                
                $nombre = $_POST['nombre'];
                $apaterno = $_POST['apaterno'];
                $amaterno = $_POST['amaterno'];
                $correo = $_POST['correo'];
                $comentario = $_POST['comentario'];

                $consulta="update comentario set comentario=:comentario,
                            nombre=:nombre,
                            apaterno=:apaterno,
                            amaterno=:amaterno,
                            correo=:correo
                            where id_comentario= $id_comentario";
                $statment =$instancia -> db -> prepare($consulta);
                
                $statment->bindParam(":nombre",$nombre);
                $statment->bindParam(":apaterno",$apaterno);
                $statment->bindParam(":amaterno",$amaterno);
                $statment->bindParam(":correo",$correo);
                $statment->bindParam(":comentario",$comentario);
                
                $statment->execute();
                
                echo '<div class="alert alert-success" role="alert"> ¡Comentario actualizado! </div>';
            }
            $parametros[':id_comentario'] = $id_comentario;
            $sql="select * from comentario where id_comentario=:id_comentario";
            $comentario = $instancia->queryArray($sql, $parametros);
            //print_r($comentario);
            //die();
        }
    }
?>

<h1>Editar comentario</h1>
<div class="container">
    <form action="comentario.actualizar.php?id_comentario=<?php echo $id_comentario?>" method="post" class="form-group">
        <div class="form-group">
            <label>Nombre</label>
            <input class="form-control" type="text" name="nombre" maxlength="30" value="<?php echo $comentario[0]['nombre']?>" required>
        </div>
        
        <div class="form-group">
            <label>Apellido Paterno</label>
            <input class="form-control" type="text" name="apaterno" maxlength="30" value="<?php echo $comentario[0]['apaterno']?>">
        </div>
        
        <div class="form-group">
            <label>Apellido Materno</label>
            <input class="form-control" type="text" name="amaterno" maxlength="30" value="<?php echo $comentario[0]['amaterno']?>">
        </div>
        
        <div class="form-group">
            <label>Correo</label>
            <input class="form-control" type="email" name="correo" maxlength="40" required value="<?php echo $comentario[0]['correo']?>">
        </div>
        
        <div class="form-group">
            <label>Comentario</label>
            <input class="form-control" type="text" name="comentario" maxlength="500"  value="<?php echo $comentario[0]['comentario']?>">
        </div>

        
        <div class="form-group">
            <input class="btn btn-primary" type="submit" name="enviar" value="Guardar">
        </div>
    </form>
</div>

<?php include("footer.php");?>