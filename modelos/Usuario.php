<?php
    require_once "librerias/Conexion.php" ;

class Usuario {
    public int $ID;
    public string $nombre;
    public string $apellidos;
    public string $email;
    public string $password;
    public string $pais;
    public string $profesion;
    public string $CodEmpresa;  // Se añadió el signo de interrogación para permitir valores nulos.
    public string $nombreEmpresa;
    public function __construct() {
        
    }
    public function getNombreEmpresa(): string {
        return $this->nombreEmpresa;
    }

    // Setter para nombreEmpresa
    public function setNombreEmpresa(string $nombreEmpresa): void {
        $this->nombreEmpresa = $nombreEmpresa;
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

    // Puedes seguir el mismo patrón para los demás atributos...

    // Getter para CodEmpresa
    public function getCodEmpresa(): ?string {
        return $this->CodEmpresa;
    }

    // Setter para CodEmpresa
    public function setCodEmpresa(string $CodEmpresa): void {
        $this->CodEmpresa = $CodEmpresa;
    }
    public static function getUsuario(int $id) {

        return Conexion::getConnection()
                ->query("SELECT * FROM usuarios WHERE ID={$id} ;")
                ->getRow("Usuario") ;   
    }

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
public static function loginUsuario(string $email, string $password) {

        $pass = md5($password) ;

        return Conexion::getConnection()
                ->query("SELECT * FROM usuarios 
                         WHERE email='{$email}' AND password='{$pass}' ;") 
                ->getRow("Usuario");   
    }
    
    


    public static function registroUsuario(string $nombre, string $apellidos, string $email, string $password, string $pais, string $profesion, int $CodEmpresa): void {
        $pass = md5($password);
    
        $conexion = Conexion::getConnection();
        $sql = "INSERT INTO usuarios (nombre, apellidos, email, password, pais, profesion, CodEmpresa) VALUES ('$nombre', '$apellidos', '$email', '$pass', '$pais', '$profesion', $CodEmpresa)";
    
        // Ejecutar la consulta
        $conexion->query($sql);
    }

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