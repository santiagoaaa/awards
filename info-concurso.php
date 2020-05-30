<?php 
        include('core/award.class.php');
        include ('header.php');
        $instancia->validarRol2(array("Login"));
        

        if(isset($_GET['id_concurso'])){

            $id_concurso=$_GET['id_concurso'];

            $email = $_SESSION['email'];
            $sql="SELECT id_usuario from usuario
                     where email = '$email'";
            $datos = $instancia->queryArray($sql);

            $id_usuario = $datos[0]['id_usuario'];

            if(is_numeric($id_concurso)){

              if (isset($_POST['enviar'])) {
                if ($instancia->validarUsuarioConcurso($id_usuario, $id_concurso)) {
                    echo '<div class="alert alert-danger" role="alert"> ¡Ya estas registrado! </div>';
                }
                else{
                    try{
                        $instancia->db->beginTransaction();

                        $fotografia = $_POST['fotografia'];
                        $foto=$_FILES['foto']['tmp_name'];

                        if ($instancia ->validarArchivo($_FILES['foto'])) {
                             $bytesImagen = file_get_contents($foto);
                             
                            $sql="insert into fotografia (fotografia, foto, id_usuario, id_estatus, id_concurso, num_votos)
                                values (:fotografia, :foto, :id_usuario, 4, :id_concurso, 0)";
                            $statment = $instancia->db->prepare($sql);

                            $statment->bindParam(":fotografia",$fotografia);
                            $statment->bindParam(":foto",$bytesImagen);
                            $statment->bindParam(":id_usuario",$id_usuario);
                            $statment->bindParam(":id_concurso",$id_concurso);
                            $fila= $statment->execute();
                             if ($fila == 0) {
                                $instancia->db->rollback();
                                echo '<div class="alert alert-danger" role="alert"> ¡Error al registrar fotografia! </div>';
                                    die();
                            }

                    
                            $instancia->db->commit();
                            echo '<div class="alert alert-success" role="alert"> ¡Inscrito correctamente! </div>';
                        }else{
                            echo '<div class="alert alert-danger" role="alert"> ¡Debes elegir una fotografia! </div>';
                        }
                    }catch(Exception $e){
                        $instancia->db->rollback();
                        echo "Fatal Error :( ".$e->getMessage();
                    }
                }
               

              }
              
              if (isset($_POST['votar'])) {  
                
                $id_foto=$_GET['id_foto'];
                
                if ($instancia->validarUsuarioVotos($id_usuario, $id_concurso)) {
                    echo '<div class="alert alert-danger" role="alert"> ¡Ya has votado en este concurso! </div>';
                }else{
                    try{
                        $instancia->db->beginTransaction();
                        $sql="insert into voto (id_fotografia, id_usuario) values (:id_fotografia, :id_usuario)";
                        $statment = $instancia->db->prepare($sql);
                        $statment->bindParam(":id_fotografia",$id_foto);
                        $statment->bindParam(":id_usuario",$id_usuario);
                        $fila= $statment->execute();
                       if ($fila == 0) {
                        $instancia->db->rollback();
                        echo '<div class="alert alert-danger" role="alert"> ¡Error al insertar voto! </div>';
                            die();
                        }

                        $sql="update fotografia set num_votos = (select num_votos+1 where id_fotografia=:id_fotografia) where id_fotografia=:id_fotografia";
                        
                        $statment = $instancia->db->prepare($sql);
                        $statment->bindParam(":id_fotografia",$id_foto);
                        $fila=$statment->execute();   
                        if ($fila == 0) {
                        $instancia->db->rollback();
                        echo '<div class="alert alert-danger" role="alert"> ¡Error al sumar voto! Comuniquese con el administrador.</div>';
                            die();
                        }

/*
                        $sql="select id_voto from voto order by id_voto desc limit 1";
                        $statment = $instancia->db->prepare($sql);
                        $fila= $statment->execute();
                        if ($fila == 0) {
                            $instancia->db->rollback();
                            echo '<div class="alert alert-danger" role="alert"> ¡Error al insertar el voto! </div>';
                            die();
                        }
                    */ 
                        $instancia->db->commit();
                        $sql="select id_voto from voto order by id_voto desc limit 1";
                        $datos_voto = $instancia->queryArray($sql);
                        $id_voto = $datos_voto[0]['id_voto']; 
                        //echo '<div class="alert alert-success" role="alert"> ¡Gracias x participar! </div>';
                        header("Location: ticket.php?id_voto=$id_voto");
                    }catch(Exception $e){
                         $instancia->db->rollback();
                         echo "Fatal Error :) ".$e->getMessage();
                    }
                }
              }

              $parametros[':id_concurso']=$id_concurso;
              $sql="select * from concurso c join estatus e on c.id_estatus=e.id_estatus  
                    where c.id_concurso=:id_concurso";
              $concurso = $instancia->queryArray($sql,$parametros);

              $sql ="select * from concurso c join fotografia f on c.id_concurso = f.id_concurso
                        where c.id_concurso=$id_concurso order by num_votos desc";
              $concursantes = $instancia->queryArray($sql,$parametros);
              //print_r($concurso);


            }

           
        }
?>

<link rel="stylesheet" href="css/info-concurso.css">

    
    <section class="index-intro">
        <div class="jumbotron">
            <div class="container text-center my-auto">
                <img class="img-fluid" src="data:image; base64, <?php echo base64_encode( $concurso[0]['portada']) ; ?>" alt=" imagen_concurso">
              <?php echo '<h1 class="mb-1">'.$concurso[0]['concurso'].'</h1>'?>
              <h3 class="mb-5">
                        <em><?php echo $concurso[0]['descripcion_breve']?></em>
                </h3>
                <a class="btn btn-red btn-xl" href="#info">Saber más</a>
            </div>
        </div>
    </section>

    <section class="content-section" id="info">
        <div class="container">
            <div class="content-section-heading text-center">
                <h2 class="mb-5">¿De que se trata?</h2>
            </div>
            <div class="row no-gutters">
                <div class="col-lg-6">
                    <a class="portfolio-item" href="#">

                        <img class="img-fluid" src="data:image; base64, <?php echo base64_encode( $concurso[0]['portada']) ; ?>" alt="Card image cap">
                    </a>
                </div>

                <div class="col-lg-6">
                    <div class="caption">
                        <div class="caption-content">
                            <?php echo '<h2 class="text-center">'.$concurso[0]['concurso'].'</h2> <hr>'?>
                            <p class="mb-0">
                                <strong>Descripción</strong> <br /><?php echo $concurso[0]['descripcion']?>
                            </p>
                             <br />
                             <p class="mb-0">
                                <strong>Estatus</strong> <br /><?php echo $concurso[0]['estatus']?>
                            </p>
                            <br />
                            <p class="mb-0">
                                <strong>Fecha de inicio</strong> <br /><?php echo $concurso[0]['fecha_inicio']?>
                            </p>
                             <br />
                            <p class="mb-0">
                                <strong>Fecha de cierre</strong> <br /><?php echo $concurso[0]['fecha_cierre']?>
                            </p>
                             <br />

                        </div>

                    </div>
                </div>
                <br />

                <?php 
                    if ($concurso[0]['estatus']=="Activo") {
                ?>
                    <a class="btn btn-red btn-xl " href="#ventana1" data-toggle="modal">¡Quiero participar!</a>

                    <div class="modal fade" id="ventana1">
                      <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title text-center">
                                    Registro
                                </h1>
                                <button tyle="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                
                            </div>

                            <div class="modal-body"> 
                                <form class="form-signin" action="info-concurso.php?id_concurso=<?php echo $id_concurso?>" method="POST" enctype="multipart/form-data">

                                    <h3>Aqui subiras la foto con la que participaras</h3>
                                    <p>
                                        Todas las fotos seran publicas y deben ser libres de derechos de autor o de lo contrario seran descalificadas.
                                    </p>
                                    <label><em>Elege tu foto favorita paps</em></label>
                                    <input type="file" name="foto">
                                    <br />
                                    <label>Titulo de tu foto</label>
                                    <input type="text" name="fotografia" required>
                                    <br />
                                    <button class="btn btn-lg btn-red btn-block" type="submit" name="enviar">Subir</button>
                                </form>
                            </div>
                        </div>
                      </div>
                    </div>

                <?php    
                    }else{
                ?>
                    <a class="btn btn-red btn-xl js-scroll-trigger" href="lista-concursos.php">Ver más concursos</a>
                <?php
                    }
                ?>
                

            </div>
        </div>

        <div class="container">
            <div class="content-section-heading text-center">
                <hr>
                <h2 class="mb-5">Fotografias inscritas</h2>
            </div>
            <div class="album py-5 bg-light">
                <div class="container">
                    <div class="row">
                        <?php for ($i=0; $i <count($concursantes) ; $i++):?>
                            <div class="col-md-4">
                                <div class="card mb-4 shadow-sm">
                                    <img class="card-img-top" src="data:image; base64, <?php echo base64_encode( $concursantes[$i]['foto']) ; ?>" alt="Card image cap">
                                    <div class="card-body">
                                       <?php echo '<p class="card-text">'.$concursantes[$i]['fotografia'].'</p>'?>
                                        <div class="d-flex justify-content-between align-items-center">

                                            <small class="text-muted"></small>
                                            <label><?php echo $concursantes[$i]['num_votos']?> votos recibidos</label>


                                                <div class="btn-group">
                                                    <form class="form-signin" action="info-concurso.php?id_concurso=<?php echo $id_concurso?>&id_foto=<?php echo $concursantes[$i]['id_fotografia']?>" method="POST" enctype="multipart/form-data">

                                                       <button class="btn btn-red btn-block" type="submit" name="votar">Votar</button>
                                                   </form>
                                                </div>

                                    
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                       <?php endfor;?>
                    </div>
                </div>
            </div>
        </div>

    </section>
<?php include('footer.php')?>