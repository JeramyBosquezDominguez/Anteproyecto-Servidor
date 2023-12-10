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

        /* Muestra el login */
         public function showLogin() {
            // Si se nos manda un get de registro con x valor se presenta un mensaje de control
            if (isset($_GET['registro'])) {
                $mensajeRegistro = $_GET['registro'] == 'exito' ? 'Registro exitoso.' : 'Error al registrar.';
                echo '<script>alert("' . $mensajeRegistro . '");</script>';
            }
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
            if ($_POST["_csrf"] != $_SESSION["_csrf"]) redireccion("index.php?registro=error") ;

            if ((empty($_POST["email"])) || (empty($_POST["pass"]))):
              
                $this->render("control/camposVacios.php.twig");

            endif ;
            
            // Solicitamos al MODELO que comprueba si existe algun usuario con este email y pass
            $usuario = Usuario::loginUsuario($_POST["email"], $_POST["pass"]) ;

            if (is_null($usuario)):
                //error en el login             
                redireccion("index.php?registro=error") ; 
            endif ;
            
            //Si existe guardamos su id en la sesion
            $_SESSION["id_usuario"] = $usuario->getID() ;
            $_SESSION["inicio"]  = time() ;

            //
            redireccion("paginaPrincipal.php") ;

        }
        /* Muestra el registro  , si hay algun error se nos muestra un mensaje con el get de registro*/
        public function ShowRegistro() {
            if (isset($_GET['registro'])) {
                $mensajeRegistro = $_GET['registro'] == 'exito' ? 'Registro exitoso.' : 'Error al registrar.';
                echo '<script>alert("' . $mensajeRegistro . '");</script>';
            }
            $this->render("usuario/registro.php.twig") ;
        }
 
        /* Realiza el registro y comprueba si está bien rellenado el formulario */
        public function registro() {
    
            if (empty($_POST["nombre"]) || empty($_POST["apellidos"]) || empty($_POST["email"]) || empty($_POST["pass"]) || empty($_POST["pais"]) || empty($_POST["profesion"]) || empty($_POST["empresa"])) {
                // Mostrar un mensaje de error y redirigir si algún campo está vacío.
                redireccion("index.php?m=usuario&f=ShowRegistro&registro=error") ;
            }
        
            // Otros controles de validación podrían agregarse aquí.
        
            // Intentar registrar al usuario.
            $registroExitoso = Usuario::registroUsuario($_POST["nombre"], $_POST["apellidos"], $_POST["email"], $_POST["pass"], $_POST["pais"], $_POST["profesion"], $_POST["empresa"]);
        
            if (is_null($registroExitoso)) {
                // Mostrar mensaje de éxito y redirigir a otra página si es necesario.
                redireccion("index.php?registro=exito") ;
            } else {
                // Mostrar mensaje de error y redirigir si el registro falla.
                redireccion("index.php?m=usuario&f=ShowRegistro&registro=error") ;
            }
        }

        /* Actualiza la informacion del usuario */
        public function actualizar() {
           
            if (empty($_POST["nombre"]) || empty($_POST["apellidos"]) || empty($_POST["email"]) || empty($_POST["pais"]) || empty($_POST["profesion"]) || empty($_POST["empresa"])) {
                // Mostrar un mensaje de error y redirigir si algún campo está vacío.
                $this->render("control/camposVacios.php.twig");
            }else{
                
            // Intentar registrar al usuario.
            $actExitoso = Usuario::actualizarUsuario($_POST["id_usuario"],$_POST["nombre"], $_POST["apellidos"], $_POST["email"],$_POST["pais"], $_POST["profesion"], $_POST["empresa"]);
        
            if (is_null($actExitoso)) {
                // Mostrar mensaje de éxito
                $this->render("control/exito.php.twig");
            } else {
                // Mostrar mensaje de error
                $this->render("control/error.php.twig");
            }
        }
    }

    /* Muestra el perfil con la informacion del usuario recogiendo su info y la de sus obras , renderiza con los datos */
        public function perfil($idUsuario){
            $datosUsuario = Usuario::getInfoUsuario($idUsuario);
            $datosArtes = Arte::getObrasDeUsuario($idUsuario);
            $this->render("usuario/perfil.php.twig", ["datosUsuario" => $datosUsuario,"datosArtes" => $datosArtes]);
        }
        /* Muestra la pagina para editar el usuario con sus datos en los values */
        public function showUsuarioEditar($idUsuario) {
            $datosUsuario = Usuario::getInfoUsuario($idUsuario);
            $this->render("usuario/editarUsuario.php.twig", ["datosUsuario" => $datosUsuario]);
        }
        
    }