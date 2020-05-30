<?php 
     include('../core/award.class.php');
        $instancia->validarRol(array("Administrador"));
        $instancia->validarPermiso(array("CRUD"));
    include("header.php");
    $sql="select * from fotografia f join usuario u on f.id_usuario=u.id_usuario
                                     join estatus e on e.id_estatus = f.id_estatus
                                     join concurso c on c.id_concurso = f.id_concurso";
    $fotografia = $instancia->queryArray($sql);
?>
<h1>Fotografias</h1>
<a href="fotografia.insertar.php" class="btn btn-success">Nueva fotografia</a>
<table class="table table-light">
    <tr>
        <th>ID</th>
        <th>Fotografia</th>
        <th>Numero de votos</th>
        <th>Subida por</th>
        <th>Estatus</th>
        <th>Concurso</th>
        <th></th>    
        <th></th>
    </tr>
    <?php
        for($i=0; $i < count($fotografia); $i++):
    ?>
    <tr>
        <td>
            <?php echo $fotografia[$i]['id_fotografia'];?>
        </td>
        <td>
            <?php echo $fotografia[$i]['fotografia'];?>
        </td>
        <td>
            <?php echo $fotografia[$i]['num_votos'];?>
        </td>
        <td>
            <?php echo $fotografia[$i]['nombre'];?>
        </td>
        <td>
            <?php echo $fotografia[$i]['estatus'];?>
        </td>
        <td>
            <?php echo $fotografia[$i]['concurso'];?>
             <img class="img-fluid" src="data:image; base64, <?php echo base64_encode( $fotografia[$i]['foto']) ; ?>" alt=" imagen_concurso">
        </td>
        <td>
            <a href="fotografia.actualizar.php?id_fotografia=<?php echo $fotografia[$i]['id_fotografia']?>" class="btn btn-success">Actualizar</a>
        </td>
        <td>
            <a href="fotografia.eliminar.php?id_fotografia=<?php echo $fotografia[$i]['id_fotografia']?>" class="btn btn-danger">Eliminar</a>
        </td>
    </tr>
    <?php endfor; ?>
</table>
<?php include("footer.php");?>