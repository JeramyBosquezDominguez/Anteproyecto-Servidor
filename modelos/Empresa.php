<?php

class Empresa {
    public int $CodEmpresa;
    public string $nombre;
    public string $Localidad;

    public function __construct() {
        // Constructor vacío por ahora.
    }

    // Getter para CodEmpresa
    public function getCodEmpresa(): int {
        return $this->CodEmpresa;
    }

    // Getter para nombre
    public function getNombre(): string {
        return $this->nombre;
    }

    // Setter para nombre
    public function setNombre(string $nombre): void {
        $this->nombre = $nombre;
    }

    // Getter para Localidad
    public function getLocalidad(): string {
        return $this->Localidad;
    }

    // Setter para Localidad
    public function setLocalidad(string $Localidad): void {
        $this->Localidad = $Localidad;
    }
}

?>
