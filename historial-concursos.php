<?php
include("core/award.class.php");
include("header.php");
$email = $_SESSION['email'];
if (isset($_GET['id_usuario'])) {
    $id_usuario=$_GET['id_usuario'];
    if (is_numeric($id_usuario)) {
        $sql="SELECT * from usuario u join fotografia f on u.id_usuario = f.id_usuario
                        join concurso c on f.id_concurso = c.id_concurso
         where f.id_usuario = $id_usuario order by c.fecha_inicio desc";
        $datos = $instancia->queryArray($sql);
        //print_r($datos);
    }
}

?>
<link rel="stylesheet" href="css/info-concurso.css">


        <section class="jumbotron text-center">
            <div class="container">
                <h1 class="jumbotron-heading">Historial de tus concursos</h1>
                <p class="lead text-muted">Aqui te mostramos los concursos en los que has participado.</p>
                <p>
                    <a href="crear-concurso.php" class="btn btn-primary my-2">Crear un concurso</a>
                    <a href="lista-concursos.php" class="btn btn-secondary my-2">Ver mas cocursos</a>
                </p>
            </div>
        </section>

        <div class="album py-5 bg-light">
            <div class="container">
                <div class="row">
                    <?php for ($i=0; $i < count($datos); $i++):?>
                        
                        <div class="col-md-4">
                            <div class="card mb-4 shadow-sm">
                                <img class="card-img-top" src="data:image; base64, <?php echo base64_encode( $datos[$i]['portada']) ; ?>" alt="Card image cap">
                                <div class="card-body">
                                    <?php echo '<p class="card-text">'.$datos[$i]['concurso'].'</p>'?>
                                    <?php echo '<p class="card-text">'.$datos[$i]['descripcion'].'</p>'?>
                                     <div class="d-flex justify-content-between align-items-center">
                                         <label class="text-center">Fotografia subida</label>
                                         <img class="card-img-top" src="data:image; base64, <?php echo base64_encode( $datos[$i]['foto']); ?>" alt="Card image cap">
                                    </div>
                                </div>
                            </div>
                        </div>
                   <?php endfor;?>
                </div>
            </div>
        </div>


<?php include("footer.php");?>