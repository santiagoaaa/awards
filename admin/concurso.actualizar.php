<?php 
 include('../core/award.class.php');
        $instancia->validarRol(array("Administrador"));
        $instancia->validarPermiso(array("CRUD"));
include('header.php');
if (isset($_GET['id_concurso'])) {
	$id_concurso=$_GET['id_concurso'];
	if (is_numeric($id_concurso)) {
		if (isset($_POST['enviar'])) {

			$foto_tmp=$_FILES['portada']['tmp_name'];
            
            $concurso=$_POST['concurso'];
            $descripcion = $_POST['descripcion'];
            $descripcion_breve = $_POST['descripcion_breve'];
            $fecha_inicio = $_POST['fecha_inicio'];
            $fecha_cierre = $_POST['fecha_cierre'];
            $id_estatus = $_POST['id_estatus'];


			if ($instancia ->validarArchivo($_FILES['portada'])) {
                $bytesImagen = file_get_contents($foto_tmp);
				$consulta = "update concurso set concurso=:concurso, 
                        descripcion=:descripcion,descripcion_breve=:descripcion_breve,fecha_inicio=:fecha_inicio, fecha_cierre=:fecha_cierre,portada=:portada,
                        id_estatus=:id_estatus
                        where id_concurso = $id_concurso";
					$statment = $instancia->db->prepare($consulta);

                    $statment->bindParam(":concurso",$concurso);
                    $statment->bindParam(":descripcion",$descripcion);
                    $statment->bindParam(":descripcion_breve",$descripcion_breve);
                    $statment->bindParam(":fecha_inicio",$fecha_inicio);
                    $statment->bindParam(":fecha_cierre",$fecha_cierre);
                    $statment->bindParam(":portada",$bytesImagen);
                    $statment->bindParam(":id_estatus",$id_estatus);
                    $statment->execute();
					echo '<div class="alert alert-success" role="alert"> ¡Concurso actualzado! </div>';
			}else{
				$consulta = "update concurso set concurso=:concurso, 
                        descripcion=:descripcion,descripcion_breve=:descripcion_breve,fecha_inicio=:fecha_inicio, fecha_cierre=:fecha_cierre,
                        id_estatus=:id_estatus
                        where id_concurso = $id_concurso";
				$statment = $instancia->db->prepare($consulta);
                
                $statment->bindParam(":concurso",$concurso);
                $statment->bindParam(":descripcion",$descripcion);
                $statment->bindParam(":descripcion_breve",$descripcion_breve);
                $statment->bindParam(":fecha_inicio",$fecha_inicio);
                $statment->bindParam(":fecha_cierre",$fecha_cierre);
                $statment->bindParam(":id_estatus",$id_estatus);

				$statment->execute();

				echo '<div class="alert alert-success" role="alert"> ¡Concurso actualizado! </div>';
			}
		}
		$parametros[':id_concurso']=$id_concurso;
		$sql="select * from concurso where id_concurso=:id_concurso";
		$concursos = $instancia->queryArray($sql,$parametros);
	}

}
?>
<h1>Editar concurso</h1>
<div class="container">
    <form action="concurso.actualizar.php?id_concurso=<?php echo $id_concurso?>" method="post" class="form-group" enctype="multipart/form-data">


         <div class="form-group">
            <label>Concurso</label>
            <input class="form-control" type="text" name="concurso" maxlength="100" value="<?php echo $concursos[0]['concurso']?>" required>
        </div>
        
        <div class="form-group">
            <label>Descripcion</label>
            <input class="form-control" type="text" name="descripcion" maxlength="500" value="<?php echo $concursos[0]['descripcion']?>" >
        </div>


        <div class="form-group">
            <label>Descripcion breve</label>
            <input class="form-control" type="text" name="descripcion_breve" maxlength="50" value="<?php echo $concursos[0]['descripcion_breve']?>" >
        </div>


        <div class="form-group">
            <label>Fecha Inicio</label>
            <input class="form-control" type="date" name="fecha_inicio" value="<?php echo $concursos[0]['fecha_inicio']?>"  required>
        </div>

        <div class="form-group">
            <label>Fecha Cierre</label>
            <input class="form-control" type="date" name="fecha_cierre" value="<?php echo $concursos[0]['fecha_cierre']?>" >
        </div>  
        
        <div class="form-group">
            <label>Creador</label>
            <br />
            <label>
				<?php
                    $id=$concursos[0]['id_usuario'];
					$tipo = $instancia->queryArray("select concat(nombre,' ',apaterno,' ',amaterno) as nombre_completo from usuario where id_usuario = $id");
					echo $tipo[0]['nombre_completo'];
				?>
			</label>
        </div>
        
        <div class="form-group">
            <label>Estatus</label>
            <select class="form-control" name="id_estatus" id="estatus">
				<?php
					$tipo = $instancia->queryArray("select * from estatus");
                    for($i=0;$i < count($tipo);$i++){
                        $seleccionado ="";
                        if ($concursos[0]['id_estatus']==$tipo[$i]['id_estatus']) {
                            $seleccionado="selected";
                        }
                        echo "<option $seleccionado  value='".$tipo[$i]['id_estatus']."'>".$tipo[$i]['estatus']."</option>";
                    }
				?>
			</select>
        </div>

        <div class="form-group">
            <label>Portada actual</label>
             <img class="img-fluid" src="data:image; base64, <?php echo base64_encode( $concursos[0]['portada']) ; ?>" alt=" imagen_concurso">
             <br />
            <label>Nueva foto</label>
            <input type="file" name="portada" class="form-control">
        </div>    
        
        <div class="form-group">
            <input class="btn btn-primary" type="submit" name="enviar" value="Guardar">
        </div>
    </form>
</div>
<?php include('footer.php');?>