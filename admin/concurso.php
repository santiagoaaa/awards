<?php 
 include('../core/award.class.php');
        $instancia->validarRol(array("Administrador"));
        $instancia->validarPermiso(array("CRUD"));
    include("header.php");
    $sql="select c.id_concurso, c.concurso, c.descripcion, c.fecha_inicio, c.fecha_cierre, c.portada, u.nombre, e.estatus from concurso c join usuario u on c.id_usuario=u.id_usuario
                                     join estatus e on e.id_estatus = c.id_estatus
                                     order by c.fecha_cierre desc";
    $concurso = $instancia->queryArray($sql);
?>
<h1>Concursos Registrados</h1>
<a href="concurso.insertar.php" class="btn btn-success">Nuevo concurso</a>
<table class="table table-light">
    <tr>
        <th>ID</th>
        <th>Concurso</th>
        <th>Descripcion</th>
        <th>Fecha inicio</th>
        <th>Fecha cierra</th>
        <th>Portada</th>
        <th>Usuario Creador</th>
        <th>Estatus concurso</th>
        <th></th>    
        <th></th>
    </tr>
    <?php
        for($i=0; $i < count($concurso); $i++):
    ?>
    <tr>
        <td>
            <?php echo $concurso[$i]['id_concurso'];?>
        </td>
        <td>
            <?php echo $concurso[$i]['concurso'];?>
        </td>
        <td>
            <?php echo $concurso[$i]['descripcion'];?>
        </td>
        <td>
            <?php echo $concurso[$i]['fecha_inicio'];?>
        </td>
        <td>
            <?php echo $concurso[$i]['fecha_cierre'];?>
        </td>
        <td>
           
           <img class="img-fluid" src="data:image; base64, <?php echo base64_encode( $concurso[$i]['portada']) ; ?>" alt=" imagen_concurso">
        </td>
        <td>
            <?php echo $concurso[$i]['nombre'];?>
        </td>
        <td>
            <?php echo $concurso[$i]['estatus'];?>
        </td>
        <td>    
            <a href="concurso.actualizar.php?id_concurso=<?php echo $concurso[$i]['id_concurso']?>" class="btn btn-success">Actualizar</a>
        </td>
        <td>
            <a href="concurso.eliminar.php?id_concurso=<?php echo $concurso[$i]['id_concurso']?>" class="btn btn-danger">Eliminar</a>
        </td>
    </tr>
    <?php endfor; ?>
</table>
<?php include("footer.php");?>