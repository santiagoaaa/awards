<?php
/**
 * Html2Pdf Library - example
 *
 * HTML => PDF converter
 * distributed under the OSL-3.0 License
 *
 * @package   Html2pdf
 * @author    Laurent MINGUET <webmaster@html2pdf.fr>
 * @copyright 2017 Laurent MINGUET
 */
require_once '../vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;
$id_comentario=(isset($_GET['id_comentario']))?$_GET['id_comentario']:null;
include('core/award.class.php');
try {
    ob_start();

    //cuando vote que le diga por quien voto, cual foto es y en que concurso
    $sql="select * from comentario
        where id_comentario=:id_comentario";
    $statement=$instancia->db->prepare($sql);
    $statement->bindparam(":id_comentario",$id_comentario);
    $statement->execute();
    $datos=array();
    while ($fila = $statement->fetch(PDO::FETCH_ASSOC)) {
                    array_push($datos, $fila);
                }
    $content = "
    <page style='text-align: center;'>
        <link rel='stylesheet' href='css/ticket.css'>

        <img src='imagenes/logo-negro.png' style='width: 200px; height: 200px;'>
    	<h2>Constancia de votación</h2><br>
        <label>folio n°</label>
        <h3>".$id_voto."</h3>
        <table style='border: 1px solid black; margin: auto;'>
            <tr  style='border: 1px solid black;'>
                <th  style='border: 1px solid black; padding:10px;'>Votaste por el usuario</th>
                <th  style='border: 1px solid black; padding:10px;'>Titulo de la fotografia</th>
                <th  style='border: 1px solid black; padding:10px;'>Concurso</th>
            </tr>
            <tr  style='border: 1px solid black;'>
                <td  style='border: 1px solid black; padding:10px;'>".$datos[0]['nombre_completo']."</td>
                <td  style='border: 1px solid black; padding:10px;'>".$datos[0]['fotografia']."</td>
                <td  style='border: 1px solid black; padding:10px;'>".$datos[0]['concurso']."</td>
            </tr>
        </table>
    	<p>Gracias por usar nuestra plataforma</p>
        <p>Seguiremos mejorando por ti</p>
	</page>";
	$html2pdf = new Html2Pdf('P', 'A4', 'es');
    $html2pdf->writeHTML($content);
    $html2pdf->output('constancia_votacion.pdf');
} catch (Html2PdfException $e) {
    $html2pdf->clean();

    $formatter = new ExceptionFormatter($e);
    echo $formatter->getHtmlMessage();
}
