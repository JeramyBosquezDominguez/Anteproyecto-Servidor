<?php
    session_start();
    // Tenemos que indicarle al controlador frontal (index.php)
    // qué queremos hacer (f) y con qué controlador/modelo (m).
    // Indicamos esto a través de la URL.
    // index.php?m=serie&f=main
    //
    // URLS AMIGABLES
    // series --> index
    // series/info.php?id=2   --> series/info/2
    //RECOGEN LOS DATOS DE GET O DE POST, DE SI VIENEN DE UN FORMULARIO CON POST O DIRECTAMENTE LA URL.
    $idUsuario = $_SESSION["usuario_id"] ?? null;
    $idArte = $_GET["idArte"] ?? null;
    $quien = $_GET["m"]??$_POST["m"]??"usuario";   // Serie, Usuario, Genero, Pelicula, etc...
    $que   = $_GET["f"]??$_POST["f"]??"ShowLogin";   // Función a realizar con el controlador|modelo
   
    // "Construimos" el nombre del controlador con el que vamos
    // a trabajar.
    $nombreControlador = "{$quien}Controller";

    // Ruta hasta el controlador
    $ruta = "controladores/{$nombreControlador}.php";

    // Comprobamos si existe el archivo controlador
    if (!file_exists($ruta))  die("** Error de acceso al controlador.");

    // Importamos el controlador
    require_once $ruta;

    // Instanciamos el controlador
    $controlador = new $nombreControlador;

    // Invocamos la función que se nos indicaba en la URL
    if (method_exists($controlador, $que)) {
        if ($idArte !== null) {
            // Si hay un idArte, pasa el parámetro
            $controlador->$que($idArte);
        } else if ($idUsuario !== null) {
            // Si no hay idArte pero hay idUsuario, pasa el parámetro de idUsuario
            $controlador->$que($idUsuario);
        } else {
             $controlador->$que();
        }
    } else {
        die("** Error en el controlador.");
    }


