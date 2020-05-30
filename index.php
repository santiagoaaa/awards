<?php 
    include("core/award.class.php");
    include("header.php");
    $concursos = $instancia->obtenerConcursos();
?>


    <section>
        <header class="masthead d-flex">
            <div class="container text-center my-auto">
                <h1 class="mb-3">Awards</h1>
                <h3 class="mb-5">
                    <em>La mejor alternativa para tus consursos</em>
                </h3>

                <?php
                        if (isset($_SESSION['email'])) {
                    ?>
                        
                        <a class="btn btn-red btn-xl" href="perfil.php">Mi perfil</a>
                    <?php
                            
                        }else{
                    ?>
                        <a class="btn btn-red btn-xl" href="registro.php">Resgistrarme</a>

                    <?php
                            
                        }
                    ?>
                
            </div>
        </header>
    </section>



    <section class="content-section" id="portfolio">
        <div class="container">
            <div class="content-section-heading text-center">
                <h2 class="mb-5">Concursos más recientes</h2>
            </div>
            <div class="row no-gutters">
                <?php for ($i=0; $i < count($concursos); $i++):?>
                    <div class="col-lg-6">
                        <a class="portfolio-item" href="info-concurso.php?id_concurso=<?php echo $concursos[$i]['id_concurso']?>">
                            <div class="caption">
                                <div class="caption-content">
                                    <?php echo "<h2>".$concursos[$i]['concurso']."</h2>"?>
                                    <?php echo '<p class="mb-0">'.$concursos[$i]['descripcion'].'</p>'?>
                                </div>
                            </div>
                            <img class="img-fluid" src="data:image; base64, <?php echo base64_encode( $concursos[$i]['portada']) ; ?>" alt=" imagen_concurso">
                        </a>
                    </div>
                <?php endfor;?>
            </div>
        </div>
    </section>
<?php include("footer.php");?>
