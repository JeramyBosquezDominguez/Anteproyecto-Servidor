<?php
session_start();

// Destruir todas las variables de sesión
$_SESSION = array();

// Si se desea destruir la sesión completamente, borra también la cookie de la sesión.
// Nota: Esto destruirá la sesión, y no la información de la sesión.

// Finalmente, destruir la sesión.
session_destroy();

// Redirigir a la página de inicio o a donde desees después de cerrar sesión.
header("Location: index.php");
exit();
?>