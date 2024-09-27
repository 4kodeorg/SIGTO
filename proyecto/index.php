<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$request = trim($_SERVER['REQUEST_URI'], '/');
$request = strtok($request, '?');
$action = $_GET['action'] ?? null;

function renderPage($page)
{
    $file = __DIR__ . "/vista/{$page}.php";
    if (file_exists($file)) {
        include($file);
    } else {
        http_response_code(404);
        echo "404 - Page not found";
    }
}
function renderBackOffice($page, $data = [])
{
    extract($data);
    $file = __DIR__ . "/vista/administracion/{$page}.php";
    if (file_exists($file)) {
        // if (isset($_SESSION['username'])) {
        include($file);
        // }
        // else {
        // header('Location: /cuenta');
        // exit();
        // }
    } else {
        http_response_code(404);
        echo "404 - Page not found";
    }
}

switch ($request) {
    case 'registro':

        if ($action === 'registrarse' & $_SERVER['REQUEST_METHOD'] == 'POST') {
            require_once $_SERVER['DOCUMENT_ROOT'] . '/modelo/Usuario.php';
            require_once $_SERVER['DOCUMENT_ROOT'] . '/controlador/UsuarioController.php';
            $response = ['success' => false, 'id' => 0, 'message' => '', 'username' => ''];

            if (isset($_POST['submit'])) {
                $errors = array();
                
                $mailPattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
                if (preg_match($mailPattern, $_POST['email'])) {
                $data = [
                    'name' => $_POST['name'],
                    'lastname' => $_POST['apellido'],
                    'username' => $_POST['username'],
                    'email' => $_POST['email'],
                    'password' => $_POST['psw'],
                    'confirm_passwd' => $_POST['confirm_passwd'],
                    'direccion' => $_POST['direccion'],
                    'phone' => $_POST['phone'],
                    'fecha_nac' => $_POST['fecha_nac'],
                    'terminos' => isset($_POST['terminos']) ? $_POST['terminos'] : 0
                ];
            
                $emptyFields = false;
                foreach ($data as $clave => $valor) {
                    if (empty(trim($valor))) {
                        $emptyFields = true;
                        $response['message'] = 'El campo' . $clave . 'es requerido';
                    }
                }
                if (!$emptyFields) {
                    if (strlen($data['password']) < 5) {
                        array_push($errors, "La contraseña debe tener al menos 5 caracteres");
                        $response['message'] = "La contraseña debe tener al menos 5 caracteres";
                    } else {
                        if ($data['confirm_passwd'] === $data['password']) {
                            $data['confirm_passwd'] = password_hash($data['confirm_passwd'], PASSWORD_BCRYPT);
                            if (count($errors) === 0) {
                                $userController = new UsuarioController();
                                $newUser = $userController->create($data);

                                if ($newUser) {
                                    $response['success'] = true;
                                    session_start();
                                    $response['id'] = $newUser['id'];
                                    $response['username'] = $newUser['username'];
                                    $response['message'] = "Registro exitoso, redireccionando..";

                                    $_SESSION['username'] = $newUser['username'];
                                    $_SESSION['id'] = $newUser['id'];
                                } else {
                                    $response['message'] = "Error al crear el usuario, intente nuevamente";
                                }
                            } else {
                                $response['message'] = "Error al crear el usuario, intente nuevamente";
                            }
                            
                        } else {
                            $response['message'] = "Las contraseñas no coinciden";
                        }
                    }
                } else {
                    $response['message'] = "Todos los campos son requeridos";
                } 
            }
                else {
                    array_push($errors, "El email es inválido");
                    $response['message'] = "El email es inválido";
                }
            }
            header('Content-Type: application/json');
            echo (json_encode($response));
            exit();
        }
        renderPage('register');
        break;
    case 'product':
        renderPage('product');
        break;
    case 'cuenta':
        
        if ($action === '1' & $_SERVER['REQUEST_METHOD'] == 'POST') {

            require_once $_SERVER['DOCUMENT_ROOT'] . '/modelo/Usuario.php';
            require_once $_SERVER['DOCUMENT_ROOT'] . '/controlador/UsuarioController.php';
            $res = ['success' => false, 'mssg' => '', 'id' => 0];
            $errors = array();
            if (isset($_POST['submit'])) {
                $username = htmlspecialchars(trim($_POST['username']));
                $password = trim($_POST['passwd']);

                if (empty($username) || empty($password)) {
                    array_push($errors, "Credenciales inválidas");
                }
                if (count($errors) == 0) {
                    $userController = new UsuarioController();
                    $usuario = $userController->validateUser($username, $password);

                    if ($usuario) {
                        $res['success'] = true;
                        session_start();
                        $_SESSION['id'] = $usuario['id'];
                        $_SESSION['username'] = $usuario['username'];
                        $res['id'] = $_SESSION['id'];
                    } else {
                        $res['mssg'] = 'Credenciales inválidas.';
                    }
                } else {
                    $res['mssg'] = 'Credenciales inválidas.';
                }
            }
            header('Content-Type: application/json');
            echo (json_encode($res));
            exit();
        }
        renderPage('account');
        break;
    case 'perfil':
        renderPage('perfil');
        break;
    case 'carrito':
        renderPage('cart');
        break;
    case 'admin':
    case 'admin/main':
        renderBackOffice('general');
        break;
    case 'admin/estadisticas':
        renderBackOffice('estadisticas');
        break;
    case 'admin/empresa':
        renderBackOffice('company');
        break;
    case 'admin/productos':
        if ($action === 'agregar_producto' && $_SERVER['REQUEST_METHOD'] == 'POST') {

            require_once $_SERVER['DOCUMENT_ROOT'] . '/modelo/Producto.php';
            require_once $_SERVER['DOCUMENT_ROOT'] . '/controlador/ProductController.php';

            $resp = ['success' => false, 'mssg' => ''];
            if (isset($_POST['submit'])) {
                $errors = array();
                $data = [
                    'titulo' => $_POST['titulo'],
                    'descripcion' => $_POST['descripcion'],
                    'origen' => $_POST['origen'],
                    'cantidad' => $_POST['cantidad'],
                    'precio' => $_POST['precio']
                ];

                $emptyFields = false;
                foreach ($data as $clave => $valor) {
                    if (empty(trim($valor))) {
                        $emptyFields = true;
                        array_push($errors, "El campo $clave es requerido");
                    }
                }
                if (!$emptyFields && count($errors) === 0) {
                    $productController = new ProductController();
                    $productId = $productController->create($data);
                    if ($productId) {
                        $resp['success'] = true;
                        $resp['mssg'] = 'Producto agregado exitosamente';
                    } else {
                        $resp['mssg'] = 'Ocurrió un error, no se pudo agregar el producto';
                    }
                } else {
                    $resp['mssg'] = 'Ocurrió un error, no se pudo agregar el producto';
                }
            }

            header('Content-Type: application/json');
            echo (json_encode($resp));
            exit();
        }
        renderBackOffice('productos');
        break;
    case 'admin/perfil':
        renderBackOffice('profile');
        break;
    case 'logout':
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_unset();
        session_destroy();

        if (ini_get("session.use_cookies")) {
            setcookie(session_name(), '', time() - 42000, '/');
        }
        // session_regenerate_id(true);

        header('Location: /');
        exit();
        break;
    case '':
    case 'home':
    case '/':
        renderPage('home');
        break;
    default:
        renderPage('home');
        break;
}
