<?php 
    include('../core/award.class.php');
    $instancia->validarRol(array("Administrador"));
    $instancia->validarPermiso(array("CRUD"));
    include('header.php');
    if(isset($_POST['enviar'])){
        
        $foto=$_FILES['fotografia']['name'];
        $foto_size=$_FILES['fotografia']['size'];
        $foto_tmp=$_FILES['fotografia']['tmp_name'];
        $foto=substr(md5(rand()), 20).$foto;
        $foto=str_replace(" ", "_", $foto);
        $origen = $foto_tmp;
        $destino = "../imagenes/fotos/".$foto;
        
        $num_votos=$_POST['num_votos'];
        $id_usuario = $_POST['id_usuario'];
        $id_estatus = $_POST['id_estatus'];
        
        if ($instancia ->validarArchivo($_FILES['fotografia'])) {
            if (move_uploaded_file($origen, $destino)) {
                $consulta="insert into fotografia (fotografia, num_votos, id_usuario, id_estatus) values (:fotografia, :num_votos, :id_usuario, :id_estatus)";

                $statment = $instancia->db->prepare($consulta);

                $statment->bindParam(":fotografia",$foto);
                $statment->bindParam(":num_votos",$num_votos);
                $statment->bindParam(":id_usuario",$id_usuario);
                $statment->bindParam(":id_estatus",$id_estatus);

                $statment->execute();

                echo '<div class="alert alert-success" role="alert"> ¡Nueva fotografia agregada! </div>';
            }else{
                echo "Error desconocido";
            }
	   }

    }
?>
<h1>Nueva fotografia</h1>
<div class="container">
    <form action="fotografia.insertar.php" method="post" class="form-group" enctype="multipart/form-data">
        <div class="form-group">
            <label>Fotografia</label>
            <input class="form-control" type="file" name="fotografia" maxlength="30" required>
        </div>
        
        <div class="form-group">
            <label>Numero de votos</label>
            <input class="form-control" type="text" name="num_votos" maxlength="30">
        </div>
        
        <div class="form-group">
            <label>Subido por</label>
            <select class="form-control" name="id_usuario" id="usuario">
				<?php
					$tipo = $instancia->queryArray("select * from usuario");
					for($i=0;$i < count($tipo);$i++){
						echo "<option value='".$tipo[$i]['id_usuario']."'>".$tipo[$i]['nombre']."</option>";
					}
				?>
			</select>
        </div>
        
        <div class="form-group">
            <label>Estatus</label>
            <select class="form-control" name="id_estatus" id="estatus">
				<?php
					$tipo = $instancia->queryArray("select * from estatus");
					for($i=0;$i < count($tipo);$i++){
						echo "<option value='".$tipo[$i]['id_estatus']."'>".$tipo[$i]['estatus']."</option>";
					}
				?>
			</select>
        </div>    
        
        <div class="form-group">
            <input class="btn btn-primary" type="submit" name="enviar" value="Guardar">
        </div>
    </form>
</div>
<?php include('footer.php');?>