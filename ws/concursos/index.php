<?php
header('Content-Type: application/json');//hace que retorne un verdadero json
/*vaciar utf enconde o decode al array para que no marque error por los caracteres*/
include ("../../core/award.class.php");
class Concurso extends Awards{
	function leerConcursos($id_concurso=null){
		$sqlpart = "";
		$parametros = array();
		if (!is_null($id_concurso)) {
			$sqlpart="where id_concurso= :id_concurso";
			$parametros[":id_concurso"]=$id_concurso;
		}
		$sql = "select id_concurso, concurso, descripcion, fecha_inicio, fecha_cierre, id_usuario from concurso ".$sqlpart;
		
		$datos = $this->queryArray($sql, $parametros);
		return $datos;

	}
	function crearConcursos(){
		$cadena=file_get_contents("php://input");
		$cadena = json_decode($cadena);
		$this->conexion();
		$this->db->beginTransaction();
		$sql ="insert into concurso (concurso, descripcion,descripcion_breve, fecha_inicio, fecha_cierre, id_usuario, id_estatus) values (:concurso,:descripcion,:descripcion_breve,:fecha_inicio, :fecha_cierre,:id_usuario, 3)";

		$statment = $this->db->prepare($sql);
		$statment->bindParam(":concurso",$cadena[0]->concurso);
        $statment->bindParam(":descripcion",$cadena[0]->descripcion);
        $statment->bindParam(":descripcion_breve",$cadena[0]->descripcion_breve);
        $statment->bindParam(":fecha_inicio",$cadena[0]->fecha_inicio);
        $statment->bindParam(":fecha_cierre",$cadena[0]->fecha_cierre);
        $statment->bindParam(":id_usuario",$cadena[0]->id_usuario);
		$statment->execute();

		$datos = array();
		$datos['estatus']="OK";
		$datos['mensaje']="Se inserto concurso sin portada";
		$datos['concurso'] = $cadena[0]->concurso;
		$this->db->commit();
		return $datos;
		//print_r($cadena);
		//die();
	}
	function eliminarConcursos($id_concurso){
		if (is_numeric($id_concurso)) {
			$sql = "delete from concurso where id_concurso = :id_concurso";
			$this->conexion();
			$statment = $this->db->prepare($sql);

			$statment -> bindParam(":id_concurso",$id_concurso);
			$fila = $statment->execute();

			if ($statment -> rowCount()>0) {
				$datos['estatus']="OK";
				$datos['mensaje']="Concurso eliminado";
			}else{
				$datos['estatus']="Error DELETE";
				$datos['mensaje']="No se encontro concurso";
			}
		}else{
			$datos['estatus']="Error DELETE";
			$datos['mensaje']="Se requiere un id numerico";
		}
		
		return $datos;
	}
	function actualizarConcursos($id_concurso){
		$cadena=file_get_contents("php://input");
		$cadena = json_decode($cadena);
		

		$sql ="update concurso set concurso=:concurso, 
	                        descripcion=:descripcion,
	                        descripcion_breve=:descripcion_breve,fecha_inicio=:fecha_inicio,
	                        fecha_cierre=:fecha_cierre
	                        where id_concurso = $id_concurso";

		$statment=$this->db->prepare($sql);
		$statment->bindParam(":concurso",$cadena[0]->concurso);
        $statment->bindParam(":descripcion",$cadena[0]->descripcion);
        $statment->bindParam(":descripcion_breve",$cadena[0]->descripcion_breve);
        $statment->bindParam(":fecha_inicio",$cadena[0]->fecha_inicio);
        $statment->bindParam(":fecha_cierre",$cadena[0]->fecha_cierre);
		$statment->execute();

		$datos = array();
		$datos['estatus']="OK";
		$datos['mensaje']="Se actualizo concurso sin portada";
		$datos['concurso'] = $cadena[0]->concurso;
		
		return $datos;

	}
}

	$concursos = new Concurso();
	$concursos->leerConcursos();

	$metodo = $_SERVER['REQUEST_METHOD'];//obtiene el metodo que usa
	switch ($metodo) {
		case 'POST':
			$datos = $concursos->crearConcursos();
			break;

		case 'PUT':
			$id = (isset($_GET['id']))?  $_GET['id']:null;
			$datos = $concursos->actualizarConcursos($id);
			break;

		case 'DELETE':
			$id = (isset($_GET['id']))?  $_GET['id']:null;
			$datos = $concursos->eliminarConcursos($id);
			break;

		case 'GET':
		default:
			$id = (isset($_GET['id']))?  $_GET['id']:null;
			$datos = $concursos->leerConcursos($id);
			break;
	}
	$cadena = json_encode($datos);
	echo $cadena;

?>