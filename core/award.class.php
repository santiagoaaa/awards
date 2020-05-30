<?php
    /*
    *31 octubre 2018
    */
    session_start();
    class Awards{
        var $db;

        function _construct(){

        }
        
        function conexion(){
            $db_host="localhost";
            $db_user="santi";
            $db_pass="admin";
            $db_name="awards";

            $this->db = new PDO("mysql:host=$db_host;dbname=$db_name",$db_user,$db_pass);
        }
        function queryArray($query,$parametros=array()){
            $this->conexion();
            $datos = array();
            $statment=$this->db->prepare($query);
            if (count($parametros)>0) {
                $etiquetas=array_keys($parametros);
                for($i=0;$i<count($etiquetas);$i++){
                    $statment->bindParam($etiquetas[$i], $parametros[$etiquetas[$i]]);
                }
            }
            $resultado= $statment->execute();
                    /* obtener array asociativo */
            while ($fila = $statment->fetch(PDO::FETCH_ASSOC)) {
                array_push($datos, $fila);
            }
            return $datos;
        }

        function queryArray2($conexion,$query,$parametros=array()){
        $datos = array();
        $statment=$conexion->db->prepare($query);
        if (count($parametros)>0) {
            $etiquetas=array_keys($parametros);
            for($i=0;$i<count($etiquetas);$i++){
                $statment->bindParam($etiquetas[$i], $parametros[$etiquetas[$i]]);
            }
        }
        $resultado= $statment->execute();
                /* obtener array asociativo */
        while ($fila = $statment->fetch(PDO::FETCH_ASSOC)) {
            array_push($datos, $fila);
        }
        return $datos;
    }
        
        function validarArchivo($archivo){
            switch ($archivo['error']) {
                case 0:
                    $tipos = array("image/jpeg", "image/png");//valores que acepta
                        if (in_array($archivo['type'], $tipos)) {//tipo
                            if ($archivo['size']<520000) {//tamaño del archivo
                                return true;
                            }else{
                                return false;
                            }
                        }else{
                            return false;
                        }
                    break;

                default:
                    return false;
                    break;
            }
        }

        function obtenerConcursos(){
            $this->conexion();
            $query="select * from concurso order by fecha_inicio desc limit 4";
            $datos=array();
            $statment=$this->db->prepare($query);

            $resultado= $statment->execute();
                /* obtener array asociativo */
            while ($fila = $statment->fetch(PDO::FETCH_ASSOC)) {
                    array_push($datos, $fila);
                }
            return $datos;
        }
        function obtenerConcursosActivos(){
            $this->conexion();
            $query="select * from concurso c join estatus e on e.id_estatus=c.id_estatus where e.estatus='Activo' order by c.fecha_inicio";
            $datos=array();
            $statment=$this->db->prepare($query);

            $resultado= $statment->execute();
                /* obtener array asociativo */
            while ($fila = $statment->fetch(PDO::FETCH_ASSOC)) {
                    array_push($datos, $fila);
                }
            return $datos;
        }

        function obtenerConcursosTerminados(){
            $this->conexion();
            $query="select * from concurso c join estatus e on e.id_estatus=c.id_estatus where e.estatus='Terminado' order by c.fecha_inicio";
            $datos=array();
            $statment=$this->db->prepare($query);

            $resultado= $statment->execute();
                /* obtener array asociativo */
            while ($fila = $statment->fetch(PDO::FETCH_ASSOC)) {
                    array_push($datos, $fila);
                }
            return $datos;
        }

        function obtenerPermisos($email){
        $this->conexion();
        //echo $email;
        $query="select p.permiso from usuario u join rol_usuario ru on u.id_usuario = ru.id_usuario
                        join rol_permiso rp on rp.id_rol = ru.id_rol
                        join permiso p on rp.id_permiso = p.id_permiso where u.email =:email";
        $datos=array();
        $statment=$this->db->prepare($query);
        $statment -> bindParam(":email",$email);
        $resultado= $statment->execute();
                /* obtener array asociativo */
            while ($fila = $statment->fetch(PDO::FETCH_ASSOC)) {
                    array_push($datos, $fila['permiso']);
                }
        return $datos;
    }

    function obtenerRoles($email){
        $this->conexion();
        $query="select r.rol from usuario u join rol_usuario ru on u.id_usuario = ru.id_usuario
                        join rol_permiso rp on rp.id_rol = ru.id_rol
                        join rol r on r.id_rol = rp.id_rol where u.email = :email ";
        $datos=array();
        $statment=$this->db->prepare($query);
        $statment -> bindParam(":email",$email);
        $resultado= $statment->execute();
                /* obtener array asociativo */
            while ($fila = $statment->fetch(PDO::FETCH_ASSOC)) {
                    array_push($datos, $fila['rol']);
                }
        return $datos;
    }

   public function login($email,$contrasena){
        $contrasena=md5($contrasena);
        

        $this->conexion();
        $sql = "select * from usuario where email=:email and contrasena=:contrasena";
        $statment=$this->db->prepare($sql);
        $statment->bindParam(":email",$email);
        $statment->bindParam(":contrasena",$contrasena);
        $resultado=$statment->execute();

        if ($statment->fetch(PDO::FETCH_ASSOC)) {
            return true;
        }else{
            return false;
        }

    }

    public function validarRol($roles_permitidos){
        $roles=$this->obtenerRoles($this->obtenerUsuario());
        $valido = false;
        foreach ($roles as $key => $value)
            if (in_array($value, $roles_permitidos)) 
                $valido=true;

        if (!$valido) {
            header("Location: ../iniciar-sesion.php");
        }
        
    }

    public function validarPermiso($permisos_permitidos){
        $roles=$this->obtenerPermisos($this->obtenerUsuario());
        $valido = false;
        foreach ($roles as $key => $value)
            if (in_array($value, $permisos_permitidos)) 
                $valido=true;

        if (!$valido) {
            header("Location: ../iniciar-sesion.php");
        }
        
    }

    public function validarRol2($roles_permitidos){
        $roles=$this->obtenerRoles($this->obtenerUsuario());
        $valido = false;
        foreach ($roles as $key => $value)
            if (in_array($value, $roles_permitidos)) 
                $valido=true;

        if (!$valido) {
            header("Location: iniciar-sesion.php");
        }
        
    }

    public function validarPermiso2($permisos_permitidos){
        $roles=$this->obtenerPermisos($this->obtenerUsuario());
        $valido = false;
        foreach ($roles as $key => $value)
            if (in_array($value, $permisos_permitidos)) 
                $valido=true;

        if (!$valido) {
            header("Location: iniciar-sesion.php");
        }
        
    }

    public function validarUsuarioConcurso($id_usuario, $id_concurso){
        $this->conexion();
        $sql="SELECT f.id_usuario from usuario u join fotografia f on u.id_usuario = f.id_usuario
         where f.id_usuario = $id_usuario and f.id_concurso=$id_concurso";
        $respuesta = $this->queryArray($sql);
        if (count($respuesta)>0) {
            return true;
        }else{
            return false;
        }

    }

    public function validarUsuarioVotos($id_usuario, $id_concurso){
       $this->conexion();
       // $sql="SELECT id_usuario from voto where id_usuario=$id_usuario and id_fotografia=$id_fotografia";
       $sql="SELECT v.id_usuario from voto v join fotografia f on v.id_fotografia = f.id_fotografia
                                            join concurso c on c.id_concurso=f.id_concurso
                         where v.id_usuario=$id_usuario and  f.id_concurso=$id_concurso";
        $respuesta = $this->queryArray($sql);
        if (count($respuesta)>0) {
            return true;
        }else{
            return false;
        }

    }

    public function obtenerUsuario(){
        return $_SESSION['email'];
    }

    public function logout(){
        session_destroy();
    }

        
}

$instancia = new Awards();
$instancia -> conexion();
?>
