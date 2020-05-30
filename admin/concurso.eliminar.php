<?php 
 include('../core/award.class.php');
        $instancia->validarRol(array("Administrador"));
        $instancia->validarPermiso(array("CRUD"));
include('header.php');
if (isset($_GET['id_concurso'])) {
	$id_concurso=$_GET['id_concurso'];
	if (is_numeric($id_concurso)) {
		$consulta="delete from concurso where id_concurso = :id_concurso";
		$statment=$instancia->db->prepare($consulta);
		$statment->bindParam(":id_concurso",$id_concurso, PDO::PARAM_INT/*verifica que esea un entero*/);
		$statment->execute();
		echo '<div class="alert alert-success" role="alert"> ¡Fotografia borrada! </div>';
	}
}
?>

<?php include('footer.php')?>