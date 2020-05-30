<?php 
include("core/award.class.php");
include("header.php");
$email = $_SESSION['email'];
 $sql="SELECT * from usuario u join concurso c on u.id_usuario = c.id_usuario
         where u.email = '$email' order by c.fecha_inicio desc ";
    $datos = $instancia->queryArray($sql);
?>

<link rel="stylesheet" href="css/info-concurso.css">

    <section class="jumbotron text-center">
        <div class="container">
            <h1 class="jumbotron-heading">Concursos creados por ti</h1>
            <p class="lead text-muted">Aqui encontraras los concursos que tu hayas creado</p>
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
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <button onclick="location.href='info-concurso.php?id_concurso=<?php echo $datos[$i]['id_concurso']?>'" type="button" class="btn btn-sm btn-outline-secondary">Ver</button>
                                        <button onclick="location.href='editar-concurso.php?id_concurso=<?php echo $datos[$i]['id_concurso']?>'" type="button" class="btn btn-sm btn-outline-secondary">Editar</button>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endfor;?>
            </div>
        </div>
    </div>

    <footer class="footer text-center">
        <div class="container">
            <ul class="list-inline mb-5">
                <li class="list-inline-item">
                    <a class="social-link rounded-circle text-white mr-3" href="#">
                        <i class="icon-social-facebook"></i>
                    </a>
                </li>
                <li class="list-inline-item">
                    <a class="social-link rounded-circle text-white mr-3" href="#">
                        <i class="icon-social-twitter"></i>
                    </a>
                </li>
                <li class="list-inline-item">
                    <a class="social-link rounded-circle text-white" href="#">
                        <i class="icon-social-youtube"></i>
                    </a>
                </li>
            </ul>
            <p class="text-muted small mb-0">Copyright &copy; awards.xyz 2018</p>
        </div>
    </footer>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>

</html>
