<?php

    require_once "Controller.php" ;
    require_once "modelos/Arte.php" ;
    require_once "librerias/libreria.php" ;

    class ArteController extends Controller {

        /**
         * Muestra el formulario de login
         * @return
         */
        
         /* Muestro la informacion de un arte obteniendo sus datos y pasandolos a un twig */
    public function infoArte($CodArte) {
            $datosArtes = Arte::getArte($CodArte);
            $this->render("arte/infoArte.php.twig",["datosArte"=>$datosArtes]) ;
    }

        /* Muestra la plantilla para agregar arte y fecha de crecion en ese formato*/
    public function showAgregarArte(){
        $datos = [
            'fechaDeCreacion' => date('Y-m-d'),
        ];
            $this->render('arte/agregarArte.php.twig', $datos);
    }
    /* Metodo que controla  el registro de un arte , si algun campo está vacio me manda a un twig que me muestra un mensaje.*/
    public function registroArte() {

        if (empty($_POST["titulo"]) || empty($_POST["descripcion"]) || empty($_POST["tipoDeArte"]) || empty($_POST["foto"]) || empty($_POST["fechaDeCreacion"]) || empty($_POST["ID"])) {
            // Mostrar un mensaje de error y redirigir si algún campo está vacío.
            $this->render("control/camposVacios.php.twig");
        } else{
    
        $registroExitoso = Arte::subirArte($_POST["titulo"],$_POST["tipoDeArte"] , $_POST["descripcion"], $_POST["foto"], $_POST["fechaDeCreacion"], $_POST["ID"]);
    
        if (is_null($registroExitoso)){
            // Mostrar mensaje de error y redirigir si el registro funciona.
            $this->render("control/exito.php.twig");
        } else {
            // Mostrar mensaje de error y redirigir si el registro falla.
            $this->render("control/error.php.twig");
        }
    }
}
    /* Borra un arte y me manda directamente a mi perfil */
    public function borrarArte($CodArte) {
        $borradoExitoso = Arte::borrarArte($CodArte);
        if ($borradoExitoso) {
            // Redirigir o mostrar un mensaje de éxito
            redireccion("index.php?m=Usuario&f=perfil");
            exit();
        } else {
            // Mostrar un mensaje de error o redirigir a otra página de error
            die("Error al intentar borrar el arte.");
        }
    
    }
}