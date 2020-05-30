<?php 
 include('../core/award.class.php');
        $instancia->validarRol(array("Administrador"));
        $instancia->validarPermiso(array("CRUD"));
    include("header.php");
    $sql="select * from estatus";
    $estatus = $instancia->queryArray($sql);
?>

<h1>Estatus</h1>
<a href="estatus.insertar.php" class="btn btn-success">Nuevo Estatus</a>
<table class="table table-light">
    <tr>
        <th>ID</th>
        <th>Estatus</th>
        <th></th>
        <th></th>
    </tr>
    <?php
        for($i=0; $i < count($estatus); $i++):
    ?>
    <tr>
        <td><?php echo $estatus[$i]['id_estatus'];?></td>
		<td><?php echo $estatus[$i]['estatus'];?></td>
		<td>
			<a href="estatus.actualizar.php?id_estatus=<?php echo $estatus[$i]['id_estatus']?>" class="btn btn-success">Actualizar</a>
		</td>
		<td>
			<a href="estatus.eliminar.php?id_estatus=<?php echo $estatus[$i]['id_estatus']?>" class="btn btn-danger">Eliminar</a>
		</td>
	</tr>
<?php endfor; ?>
</table>
<?php include("footer.php")?>