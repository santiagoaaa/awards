<?php 
 include('../core/award.class.php');
        $instancia->validarRol(array("Administrador"));
        $instancia->validarPermiso(array("CRUD"));
include("header.php");
    $sql="select * from usuario";
    $usuario = $instancia->queryArray($sql);
?>

<h1>Usuario</h1>
<a href="usuario.insertar.php" class="btn btn-success">Nuevo usuario</a>
<table class="table table-light">
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Apellido paterno</th>
        <th>Apellido materno</th>
        <th>Correo</th>
        <th>Descripción</th>
        <th></th>
        <th></th>
    </tr>
    <?php
        for($i=0; $i < count($usuario); $i++):
    ?>
    <tr>
        <td>
            <?php echo $usuario[$i]['id_usuario'];?>
        </td>
        <td>
            <?php echo $usuario[$i]['nombre'];?>
        </td>
        <td>
            <?php echo $usuario[$i]['apaterno'];?>
        </td>
        <td>
            <?php echo $usuario[$i]['amaterno'];?>
        </td>
        <td>
            <?php echo $usuario[$i]['email'];?>
        </td>

        <td>
            <?php echo $usuario[$i]['descripcion'];?>
        </td>
        <td>
            <a href="usuario.actualizar.php?id_usuario=<?php echo $usuario[$i]['id_usuario']?>" class="btn btn-success">Actualizar</a>
        </td>
        <td>
            <a href="usuario.eliminar.php?id_usuario=<?php echo $usuario[$i]['id_usuario']?>" class="btn btn-danger">Eliminar</a>
        </td>
    </tr>
    <?php endfor; ?>
</table>
<?php include("footer.php");?>
