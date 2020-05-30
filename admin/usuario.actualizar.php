<?php
        include('../core/award.class.php');
        $instancia->validarRol(array("Administrador"));
        $instancia->validarPermiso(array("CRUD"));
        include("header.php");
        if(isset($_GET['id_usuario'])){
        $id_usuario = $_GET['id_usuario'];
        if(is_numeric($id_usuario)){
            if(isset($_POST['enviar'])){
                
                $nombre = $_POST['nombre'];
                $apaterno = $_POST['apaterno'];
                $amaterno = $_POST['amaterno'];
                $correo = $_POST['correo'];
                $clave = $_POST['clave'];
                $descripcion = $_POST['descripcion'];
                
                $consulta = "update usuario set 
                nombre=:nombre,
                apaterno=:apaterno,
                amaterno=:amaterno,
                correo=:correo,
                clave=:clave,
                descripcion=:descripcion
                where id_usuario = $id_usuario";
                
                $statment = $instancia->db->prepare($consulta);
                
                $statment->bindParam(":nombre",$nombre);
                $statment->bindParam(":apaterno",$apaterno);
                $statment->bindParam(":amaterno",$amaterno);
                $statment->bindParam(":correo",$correo);
                $statment->bindParam(":clave",$clave);
                $statment->bindParam(":descripcion",$descripcion);
                
                $statment->execute();
                
                echo '<div class="alert alert-success" role="alert"> ¡Usuario editado! </div>';
            }
            $parametros[':id_usuario'] = $id_usuario;
            $sql="select * from usuario where id_usuario=:id_usuario";
            $usuarioSQL = $instancia->queryArray($sql, $parametros);
            //print_r($usuarioSQL);
            //die();
        }
    }
?>

<h1>Editar usuario</h1>
<div class="container">
    <form action="usuario.actualizar.php?id_usuario=<?php echo $id_usuario?>" method="post" class="form-group">
        <div class="form-group">
            <label>Nombre</label>
            <input class="form-control" type="text" name="nombre" maxlength="30" value="<?php echo $usuarioSQL[0]['nombre']?>" required>
        </div>
        
        <div class="form-group">
            <label>Apellido Paterno</label>
            <input class="form-control" type="text" name="apaterno" maxlength="30" value="<?php echo $usuarioSQL[0]['apaterno']?>">
        </div>
        
        <div class="form-group">
            <label>Apellido Materno</label>
            <input class="form-control" type="text" name="amaterno" maxlength="30" value="<?php echo $usuarioSQL[0]['amaterno']?>">
        </div>
        
        <div class="form-group">
            <label>Correo</label>
            <input class="form-control" type="email" name="correo" maxlength="40" required value="<?php echo $usuarioSQL[0]['correo']?>">
        </div>
        
        <div class="form-group">
            <label>Clave</label>
            <input class="form-control" type="password" name="clave" maxlength="8" required value="<?php echo $usuarioSQL[0]['clave']?>">
        </div>
        <div class="form-group">
            <label>Descripción</label>
            <input class="form-control" type="text" name="descripcion" maxlength="500" value="<?php echo $usuarioSQL[0]['descripcion']?>">
        </div>
        
        
        <div class="form-group">
            <input class="btn btn-primary" type="submit" name="enviar" value="Guardar">
        </div>
    </form>
</div>

<?php include("footer.php");?>