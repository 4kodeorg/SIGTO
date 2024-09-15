<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

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
function renderBackOffice($page)
{
    $file = __DIR__ . "/vista/administracion/{$page}.php";
    if (file_exists($file)) {
        include($file);
    } else {
        http_response_code(404);
        echo "404 - Page not found";
    }
}

switch ($request) {
    case 'info':
        renderPage('info');
        break;
    case 'registro':
        if ($action === 'registrarse' & $_SERVER['REQUEST_METHOD'] == 'POST') {
            require_once $_SERVER['DOCUMENT_ROOT'] . '/modelo/Usuario.php';
            require_once $_SERVER['DOCUMENT_ROOT'] . '/controlador/UsuarioController.php';

            if (isset($_POST['submit'])) {
                $errors = array();
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
                        array_push($errors, "El campo $clave es requerido");
                    }
                }

                if (!$emptyFields) {
                    if ($data['confirm_passwd'] === $data['password']) {
                        $data['confirm_passwd'] = password_hash($data['confirm_passwd'], PASSWORD_BCRYPT);
                        if (count($errors) === 0) {
                            $userController = new UsuarioController();
                            $newUser = $userController->create($data);
                            // echo "<div class='modal-redirect'>
                            // <div>
                            // <a class='close-modal' href=#close> </a>
                            // <p>Cuenta creada con éxito, redirigiendo al inicio..</p> 
                            // </div>
                            // </div>";
                            if ($newUser) {
                                session_start();
                                $_SESSION['username'] = $newUser['username'];
                                $_SESSION['id'] = $newUser['id'];
                                header('Location: /?id=' . $newUser['id']);
                                exit();
                            } else {
                                echo "Error al crear el usuario" . $userId . "\n" . $data;
                            }
                        } else {
                            foreach ($errors as $error) {
                                echo "<p>$error</p>";
                            }
                        }
                    } else {
                        array_push($errors, "Las contraseñas no coinciden");
                    }
                } else {
                    array_push($errors, "Todos los campos son requeridos");
                }
                var_dump($errors);
            }
        } else {
            renderPage('register');
        }
        break;
    case 'product':
        renderPage('product');
        break;
    case 'cuenta':
        if ($action === '1' & $_SERVER['REQUEST_METHOD'] == 'POST') {

            require_once $_SERVER['DOCUMENT_ROOT'] . '/modelo/Usuario.php';
            require_once $_SERVER['DOCUMENT_ROOT'] . '/controlador/UsuarioController.php';

            $errors = array();
            if (isset($_POST['submit'])) {
                if (empty(trim($_POST['username'])) || empty(trim($_POST['passwd']))) {
                    array_push($errors, "Credenciales inválidas");
                }
                $username = htmlspecialchars($_POST['username']);
                $password = $_POST['passwd'];
                if (count($errors) == 0) {
                    $userController = new UsuarioController();
                    $usuario = $userController->validateUser($username, $password);
                    session_start();
                    $_SESSION['id'] = $usuario['id'];
                    $_SESSION['username'] = $usuario['username'];
                    header('Location: /?id=' . $usuario['id']);
                }
            }
        } else {
            renderPage('account');
        }
        break;
    case 'carrito':
        renderPage('cart');
        break;
    case 'admin':
        header('Location: /admin/main');
        break;
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
                        header('refresh: 1; url=/admin/productos');
                    }
                } else {
                    foreach ($errors as $error) {
                        echo "<p>$error</p>";
                    }
                }
            }
        } else {
            renderBackOffice('productos');
            break;
        }
    case 'admin/perfil':
        renderBackOffice('profile');
        break;
    case 'logout':
        session_unset();
        session_destroy();
        session_write_close();
        setcookie(session_name(), '', 0, '/');
        session_regenerate_id(true);
        header('Location: /');
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
