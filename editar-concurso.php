<?php
include("core/award.class.php");
include("header.php");
$instancia->validarRol(array("Login"));

if (isset($_GET['id_concurso'])) {
	$id_concurso = $_GET['id_concurso'];
	if (is_numeric($id_concurso)) {

		if (isset($_POST['enviar'])) {
			if (isset($_POST['enviar'])) {

				$foto_tmp=$_FILES['portada']['tmp_name'];
	            
	            $concurso=$_POST['concurso'];
	            $descripcion = $_POST['descripcion'];
	            $descripcion_breve = $_POST['descripcion_breve'];
	            $fecha_inicio = $_POST['fecha_inicio'];
	            $fecha_cierre = $_POST['fecha_cierre'];
	            


				if ($instancia ->validarArchivo($_FILES['portada'])) {
	                $bytesImagen = file_get_contents($foto_tmp);
					$consulta = "update concurso set concurso=:concurso, 
	                        descripcion=:descripcion,descripcion_breve=:descripcion_breve,fecha_inicio=:fecha_inicio, fecha_cierre=:fecha_cierre,portada=:portada
	                        where id_concurso = $id_concurso";
						$statment = $instancia->db->prepare($consulta);

	                    $statment->bindParam(":concurso",$concurso);
	                    $statment->bindParam(":descripcion",$descripcion);
	                    $statment->bindParam(":descripcion_breve",$descripcion_breve);
	                    $statment->bindParam(":fecha_inicio",$fecha_inicio);
	                    $statment->bindParam(":fecha_cierre",$fecha_cierre);
	                    $statment->bindParam(":portada",$bytesImagen);
	                    $statment->execute();
						echo '<div class="alert alert-success" role="alert"> ¡Concurso actualzado! </div>';
				}else{
					$consulta = "update concurso set concurso=:concurso, 
	                        descripcion=:descripcion,descripcion_breve=:descripcion_breve,fecha_inicio=:fecha_inicio, fecha_cierre=:fecha_cierre
	                        where id_concurso = $id_concurso";
					$statment = $instancia->db->prepare($consulta);
	                
	                $statment->bindParam(":concurso",$concurso);
	                $statment->bindParam(":descripcion",$descripcion);
	                $statment->bindParam(":descripcion_breve",$descripcion_breve);
	                $statment->bindParam(":fecha_inicio",$fecha_inicio);
	                $statment->bindParam(":fecha_cierre",$fecha_cierre);

					$statment->execute();

					echo '<div class="alert alert-success" role="alert"> ¡Concurso actualizado! </div>';
				}
			}
		}
	
		$sql="select * from concurso where id_concurso = $id_concurso";
		$datos = $instancia->queryArray($sql);
	}
}


?>
	<link rel="stylesheet" href="css/editar-perfil.css">
   
    <form class="form-signin" action="editar-concurso.php?id_concurso=<?php echo $id_concurso?>" method="POST" enctype="multipart/form-data">
      <h1 class="h3 mb-3 font-weight-normal">Actualiza información de tu concurso</h1>
       <label>Foto de portada</label>
      <img class="img-fluid" src="data:image; base64, <?php echo base64_encode( $datos[0]['portada']) ; ?>" alt=" imagen_concurso">
       <input type="file" name="portada">
      <input type="text" class="form-control" placeholder="Nombre del concurso" name="concurso" value="<?php echo $datos[0]['concurso']?>" required>
      <label>Fecha inicio</label>
      <input type="date" class="form-control" value="<?php echo $datos[0]['fecha_inicio']?>" required name="fecha_inicio">
      <label>Fecha limite</label>
      <input type="date" class="form-control" value="<?php echo $datos[0]['fecha_cierre']?>" required name="fecha_cierre">
      <textarea class="form-control" rows="5" placeholder="Descripción general del concurso." name="descripcion" required><?php echo $datos[0]['descripcion']?></textarea>
      <textarea class="form-control" rows="5" placeholder="Descripción breve del concurso." name="descripcion_breve" required><?php echo $datos[0]['descripcion_breve']?></textarea>

      <button class="btn btn-lg btn-red btn-block" type="submit" name="enviar">Guardar</button>
    </form>
<?php include("footer.php");?>