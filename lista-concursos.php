<?php 
    include('core/award.class.php');
    include('header.php');
    $activos = $instancia ->obtenerConcursosActivos();
    $terminados =$instancia ->obtenerConcursosTerminados();
?>
    <link rel="stylesheet" href="css/lista-concursos.css">
    <section>
        <header class="masthead d-flex">
            <div class="container text-center my-auto">
                <h1 class="mb-1">Awards</h1>
                <h3 class="mb-5">
                    <em>Te presenta la mas extensa lista de concursos fotograficos jamas creados</em>
                </h3>
            </div>
        </header>
    </section>

    <section class="content-section" id="concursos">
        <div class="container">
            <div class="content-section-heading text-center">
                <h2 class="mb-5">Concursos Activos</h2>
            </div>
            <div class="row no-gutters">
                <?php for ($i=0; $i < count($activos); $i++):?>
                    <div class="col-lg-6">
                        <a class="portfolio-item" href="info-concurso.php?id_concurso=<?php echo $activos[$i]['id_concurso']?>">
                            <div class="caption">
                                <div class="caption-content">
                                    <?php echo "<h2>".$activos[$i]['concurso']."</h2>"?>
                                    <?php echo '<p class="mb-0">'.$activos[$i]['descripcion'].'</p>'?>
                                </div>
                            </div>
                            <img class="img-fluid" src="data:image; base64, <?php echo base64_encode($activos[$i]['portada']); ?>" alt="imagen concurso">
                        </a>
                    </div>
                <?php endfor;?>
            </div>
        </div>
    </section>
  <div class="container">
         <hr />
  </div>
    <section class="content-section" id="portfolio">
        <div class="container">
            <div class="content-section-heading text-center">
                <h2 class="mb-5">Concursos que ya cerraron convocatoria</h2>
            </div>
            <div class="row no-gutters">
                <?php for ($i=0; $i < count($terminados); $i++):?>
                    <div class="col-lg-6">
                        <a class="portfolio-item" href="info-concurso.php?id_concurso=<?php echo $terminados[$i]['id_concurso']?>">
                            <div class="caption">
                                <div class="caption-content">
                                    <?php echo "<h2>".$terminados[$i]['concurso']."</h2>"?>
                                    <?php echo '<p class="mb-0">'.$terminados[$i]['descripcion'].'</p>'?>
                                </div>
                            </div>
                            <img class="img-fluid" src="data:image; base64, <?php echo base64_encode( $terminados[$i]['portada']) ; ?>" alt="imagen concurso">
                        </a>
                    </div>
                <?php endfor;?>
            </div>
        </div>
    </section>
    
    
<?php include('footer.php');?>