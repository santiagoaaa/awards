<?php 
 include('../core/award.class.php');
        $instancia->validarRol(array("Administrador"));
        $instancia->validarPermiso(array("CRUD"));
    include('header.php');
    if(isset($_POST['enviar'])){
        
        $foto_tmp=$_FILES['portada']['tmp_name'];
        
        $concurso=$_POST['concurso'];
        $descripcion = $_POST['descripcion'];
        $descripcion_breve = $_POST['descripcion_breve'];
        $fecha_inicio = $_POST['fecha_inicio'];
        $fecha_cierre = $_POST['fecha_cierre'];

        $id_usuario = $_POST['id_usuario'];
        $id_estatus = $_POST['id_estatus'];
        
        if ($instancia ->validarArchivo($_FILES['portada'])) {
           $bytesImagen = file_get_contents($foto_tmp);
                $consulta="insert into concurso (concurso, descripcion,descripcion_breve, fecha_inicio, fecha_cierre, portada, id_usuario, id_estatus) values (:concurso,:descripcion,:descripcion_breve,:fecha_inicio, :fecha_cierre, :portada, :id_usuario, :id_estatus)";

                $statment = $instancia->db->prepare($consulta);

                $statment->bindParam(":concurso",$concurso);
                $statment->bindParam(":descripcion",$descripcion);
                $statment->bindParam(":descripcion_breve",$descripcion_breve);
                $statment->bindParam(":fecha_inicio",$fecha_inicio);
                $statment->bindParam(":fecha_cierre",$fecha_cierre);
                $statment->bindParam(":portada",$bytesImagen);
                $statment->bindParam(":id_usuario",$id_usuario);
                $statment->bindParam(":id_estatus",$id_estatus);

                $statment->execute();

                echo '<div class="alert alert-success" role="alert"> ¡Nueva concurso agregada! </div>';
           
	   } else{
                echo "Error desconocido";
            }

    }
?>
<h1>Nuevo concurso</h1>
<div class="container">
    <form action="concurso.insertar.php" method="post" class="form-group" enctype="multipart/form-data">
        <div class="form-group">
            <label>Concurso</label>
            <input class="form-control" type="text" name="concurso" maxlength="100" required>
        </div>
        
        <div class="form-group">
            <label>Descripcion</label>
            <input class="form-control" type="text" name="descripcion" maxlength="500">
        </div>

         <div class="form-group">
            <label>Descripcion breve</label>
            <input class="form-control" type="text" name="descripcion_breve" maxlength="50">
        </div>


        <div class="form-group">
            <label>Fecha Inicio</label>
            <input class="form-control" type="date" name="fecha_inicio" required>
        </div>

        <div class="form-group">
            <label>Fecha Cierre</label>
            <input class="form-control" type="date" name="fecha_cierre" required>
        </div>

        <div class="form-group">
            <label>Imagen de portada</label>
            <input type="file" name="portada" required>
        </div>
        
        <div class="form-group">
            <label>Creado por</label>
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