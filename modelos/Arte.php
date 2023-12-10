<?php
require_once("librerias/Conexion.php");

class Arte {
    private int $CodArte;
    private string $titulo;
    private string $tipoDeArte;
    private string $descripcion;
    private string $foto;
    private int $likes;
    private string $FechaCreacion;
    private int $ID;
    private string $nombre;
    private string $nombreEmpresa;


    public function __construct() {
        // Constructor vacío por ahora.
    }

      // Getter para CodArte
      public function getCodArte(): int {
        return $this->CodArte;
    }

    // Getter para titulo
    public function getTitulo(): string {
        return $this->titulo;
    }

    // Setter para titulo
    public function setTitulo(string $titulo): void {
        $this->titulo = $titulo;
    }

    // Getter para tipoDeArte
    public function getTipoDeArte(): string {
        return $this->tipoDeArte;
    }

    // Setter para tipoDeArte
    public function setTipoDeArte(string $tipoDeArte): void {
        $this->tipoDeArte = $tipoDeArte;
    }

    // Getter para descripcion
    public function getDescripcion(): string {
        return $this->descripcion;
    }

    // Setter para descripcion
    public function setDescripcion(string $descripcion): void {
        $this->descripcion = $descripcion;
    }

    // Getter para foto
    public function getFoto(): string {
        return $this->foto;
    }

    // Setter para foto
    public function setFoto(string $foto): void {
        $this->foto = $foto;
    }

    // Getter para likes
    public function getLikes(): string {
        return $this->likes;
    }

    // Setter para likes
    public function setLikes(int $likes): void {
        $this->likes = $likes;
    }

    // Getter para fechaCreacion
    public function getFechaCreacion(): string {
        // Formatear la fecha como desees, aquí se asume que ya está en formato 'YYYY-MM-DD'
        return (new DateTime($this->FechaCreacion))->format('d/m/Y');
    }

    // Setter para fechaCreacion
    public function setFechaCreacion( string $FechaCreacion): void {
        $this->FechaCreacion = $FechaCreacion;
    }

    // Getter para ID
    public function getID(): string {
        return $this->ID;
    }
    public function getNombre(): string {
        return $this->nombre;
    }

    // Setter para ID
    public function setNombre(string $nombre): void {
        $this->nombre = $nombre;
    }
    public function getNombreEmpresa(): string {
        return $this->nombreEmpresa;
    }

    // Setter para nombreEmpresa
    public function setNombreEmpresa(string $nombreEmpresa): void {
        $this->nombreEmpresa = $nombreEmpresa;
    }

    /* Obtenemos la informacion de una arte */
        public static function getArte(int $CodArte):Arte{            
           
                return Conexion::getConnection()
                            ->query("SELECT 
                            A.CodArte, 
                            A.titulo, 
                            A.tipoDeArte,
                            A.foto, 
                            A.descripcion, 
                            A.likes, 
                            DATE_FORMAT(FechaCreacion, '%d/%m/%Y') as FechaCreacion, 
                            U.ID, 
                            U.nombre, 
                            E.nombre as nombreEmpresa
                        FROM 
                            artes A 
                        JOIN 
                            usuarios U ON A.ID = U.ID
                        JOIN 
                            empresa E ON U.CodEmpresa = E.CodEmpresa
                        WHERE 
                            CodArte = {$CodArte};")
                            ->getRow("Arte") ;            
            }

            /* Obtenemos las obras de un usuario */
            public static function getObrasDeUsuario(int $idUsuario): array {
                $db = Conexion::getConnection();
        
                // Realizar la consulta para obtener las obras de arte del usuario
                $db->query("SELECT 
                                A.CodArte, 
                                A.titulo, 
                                A.tipoDeArte,
                                A.foto, 
                                A.descripcion, 
                                A.likes, 
                                DATE_FORMAT(A.FechaCreacion, '%d/%m/%Y') as FechaCreacion, 
                                U.ID, 
                                U.nombre, 
                                E.nombre as nombreEmpresa
                            FROM 
                                artes A 
                            JOIN 
                                usuarios U ON A.ID = U.ID
                            JOIN 
                                empresa E ON U.CodEmpresa = E.CodEmpresa
                            WHERE 
                                U.ID = {$idUsuario};");
        
                // Devolver las obras de arte en forma de array
                return $db->getAll("Arte");
            }
        
        

        /**
         * Recupera información sobre todas las Artes
         * @return array
         */

         /* Obtenemos todas las artes de la base de datos */
        public static function getAllArtes(): array {
            
            // Recuperamos la instancia de la clase Conexión
            $db = Conexion::getConnection(); 

            // Realizamos la consulta 
            $db->query("SELECT CodArte,titulo,tipoDeArte,descripcion,foto,likes,DATE_FORMAT(FechaCreacion, '%d/%m/%Y') as FechaCreacion,ID   FROM artes");
            
            // Recuperamos los datos y los devolvemos en forma de array
            return $db->getAll("Arte");
         
        }

        /* Subimos el arte a la base de datos */
        public static function subirArte($titulo,$tipoDeArte,$descripcion,$foto,$fechaDeCreacion,$ID):void{
        $conexion = Conexion::getConnection();
        $fechaDeCreacion = date('Y-m-d', strtotime($fechaDeCreacion));

        $sql = "INSERT INTO artes (titulo, tipoDeArte, descripcion, foto,FechaCreacion, ID) VALUES ('$titulo', '$tipoDeArte', '$descripcion', '$foto', '$fechaDeCreacion', $ID)";
        // Ejecutar la consulta
        $conexion->query($sql);
        }

        /* Borramos el arte de la base de datos*/
        public static function borrarArte($CodArte) {
            $conexion = Conexion::getConnection();
            $sql = "DELETE FROM artes WHERE CodArte = $CodArte";
    
            // Ejecutar la consulta
            return $conexion->query($sql);
        }
}

?>
