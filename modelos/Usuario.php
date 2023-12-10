<?php
    require_once "librerias/Conexion.php" ;

class Usuario {
    private int $ID;
    private string $nombre;
    private string $apellidos;
    private string $email;
    private string $password;
    private string $pais;
    private string $profesion;
    private string $CodEmpresa;
    private string $nombreEmpresa;
    private function __construct() {
        
    }
      // getter para nombreEmpresa
    public function getNombreEmpresa(): string {
        return $this->nombreEmpresa;
    }

    // Setter para nombreEmpresa
    public function setNombreEmpresa(string $nombreEmpresa): void {
        $this->nombreEmpresa = $nombreEmpresa;
    }
    public function getApellidos(): string {
        return $this->apellidos;
    }

    // Setter para nombreEmpresa
    public function setApellidos(string $apellidos): void {
        $this->apellidos = $apellidos;
    }
    // getter para pais
    public function getPais(): string {
        return $this->pais;
    }

    // Setter para pais
    public function setPais(string $pais): void {
        $this->pais = $pais;
    }
    // getter para profesion
    public function getProfesion(): string {
        return $this->profesion;
    }

    // Setter para profesion
    public function setProfesion(string $Profesion): void {
        $this->profesion = $Profesion;
    }

    // Getter para ID
    public function getID(): int {
        return $this->ID;
    }

    // Getter para nombre
    public function getNombre(): string {
        return $this->nombre;
    }

    // Setter para nombre
    public function setNombre(string $nombre): void {
        $this->nombre = $nombre;
    }

    // Getter para CodEmpresa
    public function getCodEmpresa(): ?string {
        return $this->CodEmpresa;
    }

    /* Obtenemos el usuario del id */
    public static function getUsuario(int $id) {

        return Conexion::getConnection()
                ->query("SELECT * FROM usuarios WHERE ID={$id} ;")
                ->getRow("Usuario") ;   
    }

    /* Obtener la info de un usuario */
    public static function  getInfoUsuario(int $id) {

        return Conexion::getConnection()
                ->query("SELECT 
                U.*, 
                E.nombre as nombreEmpresa
            FROM 
                usuarios U
            JOIN 
                empresa E ON U.CodEmpresa = E.CodEmpresa
            WHERE 
                U.ID = {$id};")
                ->getRow("Usuario");   
    }

     /**
     * @return Usuario
     */

     /* Hacemos el log in del usuario */
     public static function loginUsuario(string $email, string $password) {

        $pass = md5($password) ;

        return Conexion::getConnection()
                ->query("SELECT * FROM usuarios 
                         WHERE email='{$email}' AND password='{$pass}' ;") 
                ->getRow("Usuario");   
    }
    
    

    /* Registramos el usuario */
    public static function registroUsuario(string $nombre, string $apellidos, string $email, string $password, string $pais, string $profesion, int $CodEmpresa): void {
        $pass = md5($password);
    
        $conexion = Conexion::getConnection();
        $sql = "INSERT INTO usuarios (nombre, apellidos, email, password, pais, profesion, CodEmpresa) VALUES ('$nombre', '$apellidos', '$email', '$pass', '$pais', '$profesion', $CodEmpresa)";
    
        // Ejecutar la consulta
        $conexion->query($sql);
        
    }

    /* Actualiza los datos de usuario */
    public static function actualizarUsuario(int $ID, string $nombre, string $apellidos, string $email, string $pais, string $profesion, int $CodEmpresa): void {
    $conexion = Conexion::getConnection();
    $sql = "UPDATE usuarios 
            SET nombre = '$nombre', 
                apellidos = '$apellidos', 
                email = '$email', 
                pais = '$pais', 
                profesion = '$profesion', 
                CodEmpresa = $CodEmpresa
            WHERE ID = $ID";

    // Ejecutar la consulta
    $conexion->query($sql);
}
}

?>
