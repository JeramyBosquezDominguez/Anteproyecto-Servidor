<?php 
session_start();

// Si no me he logueado redirijo al índice
if (empty($_SESSION)) {
    header("Location: index.php");
}

// comprobamos si la sesión de tiempo ha expirado
if (time() - $_SESSION["inicio"] >= 300) {
    header("Location: logout.php");
}

// refresco el momento de acceso a la página    
$_SESSION["inicio"] = time();

// importamos las librerías
require_once("librerias/libreria.php");
require_once("librerias/Conexion.php");

// importamos las clases
require_once("modelos/Arte.php");
require_once("modelos/Usuario.php");
require_once("vendor/autoload.php");

// recuperamos información del usuario
$idUsuario = $_SESSION["id_usuario"];

$datosArtes = Arte::getAllArtes();

if (!empty($datosArtes)) {
    // Resto del código que usa $datosUsuario
} else {
    echo "No hay obras de arte.<br>";
}

if ($idUsuario !== null) {
    $datosUsuario = Usuario::getUsuario($idUsuario);
    // Resto del código que usa $datosUsuario
} else {
    // Manejar el caso en que $idUsuario es null
    echo "No se ha iniciado sesión o el ID de usuario es nulo.";
}


// Configuramos la librería Twig indicándole la ruta hasta la carpeta donde tenemos todas las vistas.
$loader = new \Twig\Loader\FilesystemLoader("vistas");

// Instanciamos la librería Twig
$twig = new \Twig\Environment($loader);

// Renderizamos la plantilla
echo $twig->render("main.php.twig", ["datos" => $datosArtes, "datosUsuario" => $datosUsuario, "idUsuario" => $idUsuario]);
?>
