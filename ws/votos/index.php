<?php
header('Content-Type: application/json');//hace que retorne un verdadero json
/*vaciar utf enconde o decode al array para que no marque error por los caracteres*/
include ("../../core/award.class.php");
class Votos extends Awards{

    function leerVoto($id_voto=null){
        $sqlpart = "";
        $parametros = array();
        if (!is_null($id_voto)) {
            $sqlpart="where id_voto= :id_voto";
            $parametros[":id_voto"]=$id_voto;
        }
        $sql = "select * from voto ".$sqlpart;
        
        $datos = $this->queryArray($sql, $parametros);
        return $datos;

    }

	
	function sumarVoto($id_concurso){
		$cadena=file_get_contents("php://input");
		$cadena = json_decode($cadena);
		
		if ($this->validarUsuarioVotos($cadena[0]->id_usuario, $cadena[0]->id_concurso)) {
                    echo '<div class="alert alert-danger" role="alert"> ¡Ya has votado en este concurso! </div>';
        }else{
			try{
                        $this->conexion();	
                        $this->db->beginTransaction();
                        $sql="insert into voto (id_fotografia, id_usuario) values (:id_fotografia, :id_usuario)";
                        $statment = $this->db->prepare($sql);
                        $statment->bindParam(":id_fotografia",$cadena[0]->id_foto);
                        $statment->bindParam(":id_usuario",$cadena[0]->id_usuario);
                        $fila= $statment->execute();
                       if ($fila == 0) {
                        $this->db->rollback();
                        echo '<div class="alert alert-danger" role="alert"> ¡Error al insertar voto! </div>';
                        $datos = array();
						$datos['estatus']="ERROR";
						$datos['mensaje']="no se pudo";
                       }

                        $sql="update fotografia set num_votos = (select num_votos+1 where id_fotografia=:id_fotografia) where id_fotografia=:id_fotografia";
                        $statment = $this->db->prepare($sql);
                        $statment->bindParam(":id_fotografia",$cadena[0]->id_foto);
                        $fila=$statment->execute();   
                        if ($fila == 0) {
                        $this->db->rollback();
                        echo '<div class="alert alert-success" role="alert"> ¡Error al contar el voto! </div>';
                        $datos = array();
							$datos['estatus']="ERROR";
							$datos['mensaje']="no se pudo";
                            
                        }             

                        $this->db->commit();
                        $datos = array();
						$datos['estatus']="OK";
						$datos['mensaje']="";
						$datos['concurso'] = $cadena[0]->id_concurso;
                        echo '<div class="alert alert-success" role="alert"> ¡Gracias x participar! </div>';
                    }catch(Exception $e){
                         $this->db->rollback();
                         $datos = array();
							$datos['estatus']="ERROR fatal";
							$datos['mensaje']="no se pudo";
                         echo "Fatal Error :) ".$e->getMessage();
                    }
                }
		return $datos;
	}

    function eliminarVoto($id_voto, $id_foto){
        $cadena=file_get_contents("php://input");
        $cadena = json_decode($cadena);
            $this->conexion();
            $consulta = "delete from voto where id_voto = :id_voto";
            $statment = $this->db->prepare($consulta);
            $statment -> bindParam(":id_voto",$id_voto, PDO::PARAM_INT);
            $statment->execute();
            //echo '<div class="alert alert-success" role="alert"> ¡Voto eliminado! </div>';
            if ($statment -> rowCount()>0) {
                $datos['estatus_']="OK";
                $datos['mensaje_']="Voto eliminado";
            }else{
                $datos['estatus_']="Error DELETE";
                $datos['mensaje_']="No se encontro voto";
            }
            $sql="update fotografia set num_votos = (select num_votos-1 where id_fotografia=:id_fotografia) where id_fotografia=:id_fotografia";
            $statment = $this->db->prepare($sql);
            $statment->bindParam(":id_fotografia",$id_foto);
            $statment->execute();  

            //echo '<div class="alert alert-success" role="alert"> ¡Voto descontando! </div>';
            if ($statment -> rowCount()>0) {
                $datos['estatus']="OK";
                $datos['mensaje']="Voto descontado";
            }else{
                $datos['estatus']="Error DELETE";
                $datos['mensaje']="No se encontro voto";
            }

            return $datos;          
    }
}

	$votos = new Votos();
	$metodo = $_SERVER['REQUEST_METHOD'];

	switch ($metodo) {
        case 'DELETE':
            $id_voto = (isset($_GET['id_voto']))?  $_GET['id_voto']:null;
            $id_foto = (isset($_GET['id_foto']))?  $_GET['id_foto']:null;
            $datos = $votos->eliminarVoto($id_voto, $id_foto);
            break;

		case 'PUT':
			$id_concurso = (isset($_GET['id_concurso']))?  $_GET['id_concurso']:null;
			$datos = $votos->sumarVoto($id_concurso);
			break;

        case 'GET':
        default:
            $id_voto = (isset($_GET['id_voto']))?  $_GET['id_voto']:null;
            $datos = $votos->leerVoto($id_voto);
            break;
	}
	$cadena = json_encode($datos);
	echo $cadena;
?>