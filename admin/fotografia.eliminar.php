<?php 
 include('../core/award.class.php');
        $instancia->validarRol(array("Administrador"));
        $instancia->validarPermiso(array("CRUD"));
include('header.php');
if (isset($_GET['id_fotografia'])) {
	$id_foto=$_GET['id_fotografia'];
	if (is_numeric($id_foto)) {
		$consulta="delete from voto where id_fotografia = :id_foto";
		$statment=$instancia->db->prepare($consulta);
		$statment->bindParam(":id_foto",$id_foto, PDO::PARAM_INT/*verifica que esea un entero*/);
		$statment->execute();		
		
		$consulta="delete from fotografia where id_fotografia = :id_foto";
		$statment=$instancia->db->prepare($consulta);
		$statment->bindParam(":id_foto",$id_foto, PDO::PARAM_INT/*verifica que esea un entero*/);
		$statment->execute();

		
		echo '<div class="alert alert-success" role="alert"> ¡Fotografia borrada! </div>';
	}
}
?>

<?php include('footer.php')?>