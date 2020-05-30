<?php 
include('core/award.class.php');
$instancia->validarRol2(array("Login"));
include('header.php');
$email = $_SESSION['email'];
$sql="select * from usuario where email='$email'";
$datos = $instancia->queryArray($sql);
$id_usuario =$datos[0]['id_usuario'];
?>
<link rel="stylesheet" href="css/perfil.css">
    <div class="row no-gutters">
        <div class="col-md-3">
            <div class="col-md-12">
                <img id="imagen-perfil" class="img-fluid" src="data:image; base64, <?php echo base64_encode( $datos[0]['foto_perfil']) ;?>" alt="imagen_perfil">
            </div>
            <div class="col-md-12">
                <p class="text-center">
                    <strong>
                     <?php 
                        
                        $sql="SELECT concat(nombre,' ',apaterno,' ',amaterno) as nombre_completo, descripcion from usuario where email = '$email'";
                        $datos = $instancia->queryArray($sql);
                        echo $datos[0]['nombre_completo'];
                     ?> 
                    </strong>
                </p>
                <p class="text-center"><em>Fotografo</em></p>
            </div>
            <div class="col-md-12">
                <br />
                <ul class="list-group list-primary">
                    <li class="list-group-item">
                        <a href="iniciar-sesion.php" class="list-group-item">Cerrar sesión</a>
                   </li>
                   <li class="list-group-item">
                        <a href="editar-perfil.php" class="list-group-item">Editar perfil</a>
                   </li>
                   <li class="list-group-item">
                       <a href="historial-concursos.php?id_usuario=<?php echo $id_usuario; ?>" class="list-group-item">Historial de concursos</a>
                   </li>
                   <li class="list-group-item">
                       <a href="mis-concursos.php" class="list-group-item">Mis concursos</a>
                   </li>
    
                </ul>
            </div>
        </div>

        <div class="col-md-9 divFondo">
            <div class="col-md-12">
                <h3 class="text-center">
                    Mi perfil
                </h3>
                <div class="row text-center">
                    <div class="col-md-6">

                        <p>Haz votado: 
                            <em>
                                <?php 
                                    $sql ="select COUNT(id_usuario) as votos_dados from voto where id_usuario = $id_usuario;";
                                    $cantidad = $instancia->queryArray($sql);
                                    echo $cantidad[0]['votos_dados'];
                                ?>
                            </em>  
                            veces
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p>Han votado por ti: 
                            <em>
                                <?php 
                                    $sql ="select COUNT(v.id_fotografia) as votos_recibidos from voto v join fotografia f on f.id_fotografia = v.id_fotografia
                                        join concurso c on c.id_concurso = f.id_concurso
                                     where f.id_usuario = $id_usuario";
                                    $cantidad = $instancia->queryArray($sql);
                                    echo $cantidad[0]['votos_recibidos'];
                                ?>
                            </em> 
                             veces
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="col-md-8">
                    <p><strong>Tu poderosa descripción:</strong></p>
                    <p><?php echo $datos[0]['descripcion']?></p>
                </div>
            </div>
        </div>


    </div>

<?php include('footer.php');?>