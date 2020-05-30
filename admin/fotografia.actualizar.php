<?php 
 include('../core/award.class.php');
        $instancia->validarRol(array("Administrador"));
        $instancia->validarPermiso(array("CRUD"));
include('header.php');
if (isset($_GET['id_fotografia'])) {
	$id_fotografia=$_GET['id_fotografia'];
	if (is_numeric($id_fotografia)) {
		if (isset($_POST['enviar'])) {
            $foto_tmp=$_FILES['fotografia']['tmp_name'];

            $num_votos=$_POST['num_votos'];
            $id_usuario = $_POST['id_usuario'];
            $id_estatus = $_POST['id_estatus'];


			if ($instancia ->validarArchivo($_FILES['fotografia'])) {
                $bytesImagen = file_get_contents($foto_tmp);
				$consulta = "update fotografia set fotografia=:fotografia, 
                        num_votos=:num_votos, 
                        id_estatus=:id_estatus
                        where id_fotografia = $id_fotografia";

				

					$statment = $instancia->db->prepare($consulta);

                    $statment->bindParam(":fotografia",$bytesImagen);
                    $statment->bindParam(":num_votos",$num_votos);
                    $statment->bindParam(":id_estatus",$id_estatus);
                    
					$statment->execute();

					echo '<div class="alert alert-success" role="alert"> ¡Fotografia actualzada! </div>';
				
			}else{
				$consulta = "update fotografia set
                        num_votos=:num_votos, 
                        id_estatus=:id_estatus
                        where id_fotografia = $id_fotografia";
				$statment = $instancia->db->prepare($consulta);
                
                $statment->bindParam(":num_votos",$num_votos);
                $statment->bindParam(":id_estatus",$id_estatus);

				$statment->execute();

				echo '<div class="alert alert-success" role="alert"> ¡Fotografia actualzada! </div>';
			}
		}
		$parametros[':id_foto']=$id_fotografia;
		$sql="select * from fotografia where id_fotografia=:id_foto";
		$fotos = $instancia->queryArray($sql,$parametros);
        
	}

}
?>
<h1>Editar fotografia</h1>
<div class="container">
    <form action="fotografia.actualizar.php?id_fotografia=<?php echo $id_fotografia?>" method="post" class="form-group" enctype="multipart/form-data">
        <div class="form-group">
            <label>Fotografia actual</label>
            <br />
            <img class="img-fluid" src="data:image; base64, <?php echo base64_encode( $fotos[0]['foto']) ; ?>" alt=" imagen_concurso">
            <br />
            <label>Nueva foto</label>
            <input type="file" name="fotografia" class="form-control">
        </div>
        
        <div class="form-group">
            <label>Numero de votos</label>
            <input class="form-control" type="number" name="num_votos" maxlength="30" value="<?php echo $fotos[0]['num_votos']?>">
        </div>
        
        <div class="form-group">
            <label>Subido por</label>
            <select class="form-control" name="id_usuario" id="usuario">
				<?php
					$tipo = $instancia->queryArray("select * from usuario");
					for($i=0;$i < count($tipo);$i++){
                        $seleccionado="";
                        if ($fotos[0]['id_usuario']==$tipo[$i]['id_usuario']) {
                            $seleccionado="selected";
                        }
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
                        $seleccionado ="";
                        if ($fotos[0]['id_estatus']==$tipo[$i]['id_estatus']) {
                            $seleccionado="selected";
                        }
                        echo "<option $seleccionado  value='".$tipo[$i]['id_estatus']."'>".$tipo[$i]['estatus']."</option>";
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