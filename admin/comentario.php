<?php 
     include('../core/award.class.php');
        $instancia->validarRol(array("Administrador"));
        $instancia->validarPermiso(array("CRUD"));
    include("header.php");
    $sql="select * from comentario";
    $comentario = $instancia->queryArray($sql);
?>

<h1>comentario</h1>
<a href="comentario.insertar.php" class="btn btn-success">Nuevo comentario</a>
<table class="table table-light">
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Apellido paterno</th>
        <th>Apellido materno</th>
        <th>Correo</th>
        <th>Comentario</th>
        <th></th>
        <th></th>
    </tr>
    <?php
        for($i=0; $i < count($comentario); $i++):
    ?>
    <tr>
        <td>
            <?php echo $comentario[$i]['id_comentario'];?>
        </td>
        <td>
            <?php echo $comentario[$i]['nombre'];?>
        </td>
        <td>
            <?php echo $comentario[$i]['apaterno'];?>
        </td>
        <td>
            <?php echo $comentario[$i]['amaterno'];?>
        </td>
        <td>
            <?php echo $comentario[$i]['correo'];?>
        </td>
        <td>
            <?php echo $comentario[$i]['comentario'];?>
        </td>
        <td>
            <a href="comentario.actualizar.php?id_comentario=<?php echo $comentario[$i]['id_comentario']?>" class="btn btn-success">Actualizar</a>
        </td>
        <td>
            <a href="comentario.eliminar.php?id_comentario=<?php echo $comentario[$i]['id_comentario']?>" class="btn btn-danger">Eliminar</a>
        </td>
    </tr>
    <?php endfor; ?>
</table>
<?php include("footer.php");?>
