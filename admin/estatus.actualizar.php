<?php 
 include('../core/award.class.php');
        $instancia->validarRol(array("Administrador"));
        $instancia->validarPermiso(array("CRUD"));
    include("header.php");
    if(isset($_GET['id_estatus'])){
        $id_estatus = $_GET['id_estatus'];
        if(is_numeric($id_estatus)){
            if(isset($_POST['enviar'])){
                $estatus=$_POST['estatus'];
                
                $consulta = "update estatus set estatus =:estatus where id_estatus = $id_estatus";
                
                $statment = $instancia->db->prepare($consulta);
                
                $statment ->bindParam(":estatus",$estatus);
                
                $statment->execute();
                echo '<div class="alert alert-success" role="alert"> ¡Estatus editado! </div>';
            }
            $parametros[':id_estatus'] = $id_estatus;
            $sql="select * from estatus where id_estatus=:id_estatus";
            $estatusSQL = $instancia->queryArray($sql, $parametros);
            print_r($estatusSQL);
            //die();
        }
    }

?>
<h1>Editar estatus</h1>
<div class="container">
    <form action="estatus.actualizar.php?id_estatus=<?php echo $id_estatus; ?>" method="post" class="form-group" enctype="multipart/form-data">
        <div class="form-group">
            <label>Estatus</label>
            <input class="form-control" type="text" name="estatus" maxlength="20" value="<?php echo $estatusSQL[0]['estatus']?>" required>
        </div>
        
        <div class="form-group">
            <input class="btn btn-primary" type="submit" name="enviar" value="Editar">
        </div>
    </form>
</div>
<?php include("footer.php");?>