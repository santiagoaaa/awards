<?php 
     include('core/award.class.php');
    include('header.php');
    use PHPMailer\PHPMailer\PHPMailer;
    require '../vendor/autoload.php';

     if(isset($_POST['enviar'])){
        $nombre = $_POST['nombre'];
        $apaterno = $_POST['apaterno'];
        $amaterno = $_POST['amaterno'];
        $correo = $_POST['correo'];
        $comentario = $_POST['comentario'];

        
        $consulta ="insert into comentario (comentario,nombre, apaterno, amaterno, correo)
                    values (:comentario,:nombre, :apaterno, :amaterno, :correo)";
        $statment =$instancia -> db -> prepare($consulta);
        
        $statment->bindParam(":nombre",$nombre);
        $statment->bindParam(":apaterno",$apaterno);
        $statment->bindParam(":amaterno",$amaterno);
        $statment->bindParam(":correo",$correo);
        $statment->bindParam(":comentario",$comentario);
        $statment->execute();

        $sql = "select id_comentario from comentario order by id_comentario desc";
        $com=$instancia->queryArray($sql);
        $id_comentario=$com[0]['id_comentario'];

        $sql = "select * from comentario where id_comentario=$id_comentario";
        $datos_comentario=$instancia->queryArray($sql);



            $mail = new PHPMailer;
            $mail->isSMTP();
            //$mail->SMTPDebug = 2;
            $mail->setLanguage('es', '../vendor/PHPMailer/PHPMailer/language/phpmailer.lang-es.php
      ');
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 587;
            $mail->SMTPSecure = 'tls';
            $mail->SMTPAuth = true;
            $mail->Username = "15030129@itcelaya.edu.mx";
            $mail->Password = "santiagoarturo97";
            $mail->setFrom('15030129@itcelaya.edu.mx', 'Comentario');
            $mail->addAddress('15030129@itcelaya.edu.mx', 'Usuarios');
            $mail->Subject = 'Comentario';
            $mensaje ="El usuario ".$datos_comentario[0]['correo']." escribio el siguiente comentario <br />".$datos_comentario[0]['comentario'];
            $mail->msgHTML($mensaje);
            $mail->AltBody = 'This is a plain-text message body';
            if (!$mail->send()) {
                $msg= '<div class="alert alert-danger" role="alert">
                            Algo salio mal 
                         </div>';
                echo $msg;
                //echo "Mailer Error: " . $mail->ErrorInfo;
            } else {
                $msg= '<div class="alert alert-success" role="alert">
                            ¡Correo enviado!
                       </div>';
                 echo $msg;
            }
        
        echo '<div class="alert alert-success" role="alert"> ¡Tu mensaje a sido enviado! No te preocupes, nostros te llamamos. </div>';
    }
?>
<link rel="stylesheet" href="css/contacto.css">
    <section>
        <header class="masthead d-flex">
            <div class="container text-center my-auto">
                <h2 class="mb-1">Tu opinion es importante</h2>
            </div>
        </header>
    </section>

    <form class="form-signin" action="contacto.php" method="post">
        <h1 class="h3 mb-3 font-weight-normal">Comentanos lo que quieras</h1>
        <em>No somos como tu ex... nosotros si te hacemos caso</em>
        <hr />
        <input type="text" class="form-control" name="nombre" placeholder="Nombre" required>
        <input type="text" class="form-control" name="apaterno" placeholder="Apellido paterno">
        <input type="text" class="form-control" name="amaterno" placeholder="Apellido materno">
        <input type="email" id="inputEmail" class="form-control" name="correo" placeholder="Correo electronico" required >
        <textarea class="form-control" name="comentario" rows="5" placeholder="Escribe aquí lo que nos quieras decir."></textarea>
        <hr />
        <button class="btn btn-lg btn-red btn-block" type="submit" name="enviar">Enviar opinion</button>
    </form>
<?php include('footer.php');?>