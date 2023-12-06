<?php

    require_once "Controller.php" ;
    require_once "modelos/Arte.php" ;
    require_once "librerias/libreria.php" ;

    class ArteController extends Controller {

        /**
         * Muestra el formulario de login
         * @return
         */
       
    public function infoArte($CodArte) {
            $datosArtes = Arte::getArte($CodArte);
            $this->render("arte/infoArte.php.twig",["datosArte"=>$datosArtes]) ;
    }
    public function showArteEditar($idArte) {
        $datosArte = Arte::getArte($idArte);
        $this->render("usuario/editarArte.twig", ["datosArte" => $datosArte]);
    }

    public function showAgregarArte(){
        $datos = [
            'fechaDeCreacion' => date('Y-m-d'),
            // ... otros datos ...
        ];
$this->render('arte/agregarArte.php.twig', $datos);
    }
    public function registroArte() {

        if (empty($_POST["titulo"]) || empty($_POST["descripcion"]) || empty($_POST["tipoDeArte"]) || empty($_POST["foto"]) || empty($_POST["fechaDeCreacion"]) || empty($_POST["ID"])) {
            // Mostrar un mensaje de error y redirigir si algún campo está vacío.
            die("error campos vacios");
        }
    
        // Otros controles de validación podrían agregarse aquí.
        // Intentar registrar al usuario.
        $registroExitoso = Arte::subirArte($_POST["titulo"],$_POST["tipoDeArte"] , $_POST["descripcion"], $_POST["foto"], $_POST["fechaDeCreacion"], $_POST["ID"]);
    
        if (is_null($registroExitoso)) {
            // Mostrar mensaje de éxito y redirigir a otra página si es necesario.
            redireccion("exito.php");
        } else {
            // Mostrar mensaje de error y redirigir si el registro falla.
            redireccion("error2.php");
        }
    }
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