<?php 
include('../core/award.class.php');
        $instancia->validarRol(array("Administrador"));
        $instancia->validarPermiso(array("CRUD"));
    include("header.php");
    $sql="select concat(u.nombre,' ',u.apaterno,' ',u.amaterno) as nombre_completo, f.fotografia, c.concurso, v.id_voto, f.foto, f.id_fotografia
        from voto v 
        join fotografia f on v.id_fotografia = f.id_fotografia
        join usuario u on u.id_usuario = v.id_usuario
        join concurso c on c.id_concurso = f.id_concurso";
    $voto = $instancia->queryArray($sql);
?>
<h1>Votos</h1>
<a href="voto.insertar.php" class="btn btn-success">Nuevo voto</a>
<table class="table table-light">
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Fotografia</th>
        <th>Concurso</th>
        <th></th>
        
    </tr>
    <?php
        for($i=0; $i < count($voto); $i++):
    ?>
    <tr>
        <td>
            <?php echo $voto[$i]['id_voto'];?>
        </td>
        <td>
            <?php echo $voto[$i]['nombre_completo'];?>
        </td>
        <td>
            <?php echo $voto[$i]['fotografia'];?>
        </td>
        <td>
            <?php echo $voto[$i]['concurso'];?>
             <img class="img-fluid" src="data:image; base64, <?php echo base64_encode( $voto[$i]['foto']) ; ?>" alt=" imagen_concurso">
        </td>

        <td>
            <a href="voto.eliminar.php?id_voto=<?php echo $voto[$i]['id_voto']?>&id_foto=<?php echo $voto[$i]['id_fotografia']?>" class="btn btn-danger">Eliminar</a>
        </td>
    </tr>
    <?php endfor; ?>
</table>
<?php include("footer.php");?>