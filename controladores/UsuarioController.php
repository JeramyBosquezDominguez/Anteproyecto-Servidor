<?php

    require_once "Controller.php" ;
    require_once "modelos/Usuario.php" ;
    require_once "modelos/Arte.php" ;
    require_once "librerias/libreria.php" ;

    class UsuarioController extends Controller {

        /**
         * Muestra el formulario de login
         * @return
         */
        public function showLogin() {

            // Generamos el token para protección CSRF
            $token = md5(uniqid(mt_rand())) ;         
            
            // Guardamos el token en la sesión
            $_SESSION["_csrf"] = $token ;
            
            // Cargamos la vista de login y le pasamos el token
            $this->render("usuario/login.php.twig", ["token" => $token]) ;
        }

        /** 
         * Logueamos al usuario si existe en la base de datos
         * @return
         */
        public function login() {

            //  comprobar el token
            if ($_POST["_csrf"] != $_SESSION["_csrf"]) redireccion("error.php") ;

            //
            if ((empty($_POST["email"])) || (empty($_POST["pass"]))):
                // Hacemos una redirección al formulario de login indicando
                // que hay un error.

                // TODO
                redireccion("error.php") ;  

            endif ;
            
            // Solicitamos al MODELO que comprueba si existe algún
            // usuario coincidente en el email y la contraseña que
            // se nos proporciona a través del formulario.
            $usuario = Usuario::loginUsuario($_POST["email"], $_POST["pass"]) ;

            if (is_null($usuario)):
                // Hacemos una redirección al formulario de login indicando
                // que hay un error.
                //TODO              
                redireccion("error.php") ; 
            endif ;

            // El usuario existe, por lo tanto lo redirigimos a la página
            // principal de la aplicación.
            $_SESSION["id_usuario"] = $usuario->getID() ;
            $_SESSION["inicio"]  = time() ;

            //
            redireccion("paginaPrincipal.php") ;

        }
        public function ShowRegistro() {

            $this->render("usuario/registro.php.twig") ;
        }
        
        public function registro() {
    
            if (empty($_POST["nombre"]) || empty($_POST["apellidos"]) || empty($_POST["email"]) || empty($_POST["pass"]) || empty($_POST["pais"]) || empty($_POST["profesion"]) || empty($_POST["empresa"])) {
                // Mostrar un mensaje de error y redirigir si algún campo está vacío.
                redireccion("error.php");
            }
        
            // Otros controles de validación podrían agregarse aquí.
        
            // Intentar registrar al usuario.
            $registroExitoso = Usuario::registroUsuario($_POST["nombre"], $_POST["apellidos"], $_POST["email"], $_POST["pass"], $_POST["pais"], $_POST["profesion"], $_POST["empresa"]);
        
            if (is_null($registroExitoso)) {
                // Mostrar mensaje de éxito y redirigir a otra página si es necesario.
                redireccion("index.php?registro=exito");
            } else {
                // Mostrar mensaje de error y redirigir si el registro falla.
                redireccion("index.php?registro=false");
            }
        }

        public function actualizar() {
           
            if (empty($_POST["nombre"]) || empty($_POST["apellidos"]) || empty($_POST["email"]) || empty($_POST["pais"]) || empty($_POST["profesion"]) || empty($_POST["empresa"])) {
                // Mostrar un mensaje de error y redirigir si algún campo está vacío.
                $this->render("control/camposVacios.php.twig");
            }else{
        
            // Otros controles de validación podrían agregarse aquí.
        
            // Intentar registrar al usuario.
            $actExitoso = Usuario::actualizarUsuario($_POST["id_usuario"],$_POST["nombre"], $_POST["apellidos"], $_POST["email"],$_POST["pais"], $_POST["profesion"], $_POST["empresa"]);
        
            if (is_null($actExitoso)) {
                // Mostrar mensaje de éxito y redirigir a otra página si es necesario.
                $this->render("control/exito.php.twig");
            } else {
                // Mostrar mensaje de error y redirigir si el registro falla.
                $this->render("control/error.php.twig");
            }
        }
    }

        public function perfil($idUsuario){
            $datosUsuario = Usuario::getInfoUsuario($idUsuario);
            $datosArtes = Arte::getObrasDeUsuario($idUsuario);
            $this->render("usuario/perfil.php.twig", ["datosUsuario" => $datosUsuario,"datosArtes" => $datosArtes]);
        }
        public function showUsuarioEditar($idUsuario) {
            $datosUsuario = Usuario::getInfoUsuario($idUsuario);
            $this->render("usuario/editarUsuario.php.twig", ["datosUsuario" => $datosUsuario]);
        }
        
    }