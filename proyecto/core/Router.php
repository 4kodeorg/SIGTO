<?php

class Router
{
    private $request;
    private $action;

    public function __construct($request, $action)
    {
        $this->request = trim($request, '/') ?: '/';
        $this->action = $action;
    }

    public function route()
    {
        $routes = [
            'echo' => 'renderPage',
            'registro' => 'formRegistration',
            'product' => 'renderProduct',
            'cuenta' => 'formAccount',
            'perfil' => 'renderProfile',
            'carrito' => 'renderPage',
            'admin' => 'renderBackOffice',
            'admin/main' => 'renderBackOffice',
            'admin/estadisticas' => 'renderBackOffice',
            'admin/empresa' => 'renderBackOffice',
            'admin/productos' => 'formProductAdmin',
            'admin/perfil' => 'renderBackOffice',
            'logout' => 'logout',
            'home' => 'searchForm',
            '/' => 'redirectHome'
        ];

        if (preg_match('/^product\/(\d+)$/', $this->request, $matches)) {
            $productId = $matches[1];
            $this->renderProduct($productId);
        } elseif (preg_match('/^perfil\/(\d+)$/', $this->request, $matches)) {
            $userId = intval($matches[1]);
           
            if ($this->checkUserMiddleware($userId)) {
                if (isset($_GET['action']) && $_GET['action'] === 'actualizar_info') {
                    $this->updateInfo($userId);
                }
                elseif (isset($_GET['action']) && $_GET['action'] === 'actualizar_direccion') {
                    $this->updateDirecciones($userId);
                } else {
                    $this->renderProfile($userId);
                }
            } else {
                $message = "Acceso no autorizado";
                $this->renderPage('error', ['message' => $message]);
            }
        } elseif (isset($routes[$this->request])) {
            $this->assignPage($routes[$this->request], $this->request);
        } else {
            $this->renderPage('error');
        }
    }
    private function redirectHome()
    {
        header('Location: /home');
        exit();
    }
    private function checkUserMiddleware($userId)
    {
        if (isset($_SESSION["id_username"])) {
            $loggedUser = $_SESSION["id_username"];

            if ($loggedUser == $userId) {
                return true;
            } else {
                return false;
            }
        } else {
            throw new Exception("Iniciar sesion");
        }
    }

    private function assignPage($method, $route)
    {
        $backOfficeRoutes = ['admin', 'admin/main', 'admin/estadisticas', 'admin/empresa', 'admin/perfil'];
        if (in_array($route, $backOfficeRoutes)) {
            call_user_func([$this, $method], 'general');
        } elseif ($method === 'renderPage') {
            call_user_func([$this, $method], $route);
        } else {
            call_user_func([$this, $method]);
        }
    }

    private function renderPage($page, $data = [])
    {

        $file = $_SERVER['DOCUMENT_ROOT'] . "/vista/{$page}.php";
        if (file_exists($file)) {
            extract($data);
            include($file);
        } else {
            http_response_code(404);
            print_r(__DIR__);
            echo "404 - Page not found";
        }
    }

    private function renderBackOffice($page, $data = [])
    {

        $file = $_SERVER['DOCUMENT_ROOT'] . "/vista/administracion/{$page}.php";
        if (file_exists($file)) {
            extract($data);
            include($file);
        } else {
            http_response_code(404);
            echo "404 - Page not found";
        }
    }
    private function updateDirecciones($userId)
    {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/controlador/UsuarioController.php';
        $response = ['success' => false, 'message' => ''];
        $direccionEnvio = htmlspecialchars($_POST['direccion']) ?? '';
        $segDireccion = htmlspecialchars($_POST['seg_direccion']) ?? '';
        if (!empty(trim($direccionEnvio)) && !empty(trim($segDireccion))) {
            $userController = new UsuarioController();
            $userUpdatedOk = $userController->updateUserDireccion($userId, $direccionEnvio, $segDireccion);
            if ($userUpdatedOk) {
                $response['success'] = true;
                $response['message'] = "Direcciones actualizadas con éxito.";
            }
        } else {
            $response['message'] = "Ambos campos son requeridos";
        }
        header('Content-type: application/json');
        echo (json_encode($response));
        exit();
    }
    private function updateInfo($userId) {
        require_once $_SERVER['DOCUMENT_ROOT'].'/controlador/UsuarioController.php';

        $response = ['success' => false, 'message' => ''];
        $username = htmlspecialchars($_POST['new_user']) ?? '';
        $email = htmlspecialchars($_POST['new_correo']) ?? '';
        $phone = htmlspecialchars($_POST['new_telefono']) ?? '';
        if (!empty(trim($username)) && !empty(trim($email)) && !empty(trim($phone))) {
            $userController = new UsuarioController();
            $userInfoUpdatedOk = $userController->updateUserData($userId, $email, $phone, $username);
            if ($userInfoUpdatedOk) {
                $response['success'] = true;
                $response['message'] = "Información actualizada con éxito";
            }
        } else {
            $response['message'] = "Todos los campos son requeridos";
        }
        header('Content-type: application/json');
        echo (json_encode($response));
        exit();
    }

    private function formRegistration()
    {
        if ($this->action === 'registrarse' && $_SERVER['REQUEST_METHOD'] == 'POST') {
            require_once $_SERVER['DOCUMENT_ROOT'] . '/modelo/Usuario.php';
            require_once $_SERVER['DOCUMENT_ROOT'] . '/controlador/UsuarioController.php';
            $response = ['success' => false, 'id' => 0, 'message' => '', 'username' => '', 'url' => ''];

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
                                        $sessIdfragment = date('Ymd_His') . "-" . $newUser['id'];
                                        $response['success'] = true;
                                        $response['id'] = $newUser['id'];
                                        $response['username'] = $newUser['username'];
                                        $response['message'] = "Registro exitoso, redireccionando..";
                                        $response['url'] = "/home";
                                        $_SESSION['uri_fragment'] = $sessIdfragment;
                                        $_SESSION['username'] = $newUser['username'];
                                        $_SESSION['id_username'] = $newUser['id'];
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
                } else {
                    array_push($errors, "El email es inválido");
                    $response['message'] = "El email es inválido";
                }
            }
            header('Content-Type: application/json');
            echo (json_encode($response));
            exit();
        }
        $this->renderPage('register');
    }

    private function formAccount()
    {
        if ($this->action === '1' && $_SERVER['REQUEST_METHOD'] == 'POST') {
            require_once $_SERVER['DOCUMENT_ROOT'] . '/modelo/Usuario.php';
            require_once $_SERVER['DOCUMENT_ROOT'] . '/controlador/UsuarioController.php';

            $res = ['success' => false, 'mssg' => '', 'id' => 0, 'url' => ''];
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
                        $sessIdfragment = date('Ymd_His') . "-" . $usuario['id'];
                        $_SESSION['id_username'] = $usuario['id'];
                        $_SESSION['uri_fragment'] = $sessIdfragment;
                        $_SESSION['username'] = $usuario['username'];
                        $res['url'] = '/home';
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
        $this->renderPage('account');
    }
    private function renderProfile($userId)
    {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/controlador/UsuarioController.php';
        $userController = new UsuarioController();
        $usuario = $userController->getUserbyId($userId);
        if ($usuario) {
            $this->renderPage('perfil', ['usuario' => $usuario]);
        } else {
            http_response_code(404);
            $this->renderPage('error');
        }
    }
    private function searchForm()
    {
        if (isset($_GET['buscar'])) {
            $searchParam = htmlspecialchars($_GET['buscar']);
            if (!empty(trim($searchParam))) {
                require_once $_SERVER['DOCUMENT_ROOT'] . '/controlador/ProductController.php';
                $productos = new ProductController();
                $resultados = $productos->searchProductsByTitleOrDescripcion($searchParam);
                if ($resultados) {
                    $this->renderPage('home', ['data' => $resultados]);
                    return;
                } else {
                    $message = "No se encontraron resultados";
                    $this->renderPage('home', ['message' => $message]);
                    return;
                }
            } else {
                $message = "Ingresa algún producto para buscar";
                $this->renderPage('home', ['message' => $message]);
                return;
            }
        }
        $this->renderPage('home');
    }

    private function formProductAdmin()
    {
        if ($this->action === 'agregar_producto' && $_SERVER['REQUEST_METHOD'] == 'POST') {
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
                    $resp['mssg'] = 'No se pudo agregar el producto, todos los campos son requeridos';
                }
            }

            header('Content-Type: application/json');
            echo (json_encode($resp));
            exit();
        }
        $this->renderBackOffice('productos');
    }
    private function renderProduct($productId)
    {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/controlador/ProductController.php';
        $productController = new ProductController();
        $product = $productController->getProductById($productId);

        if ($product) {
            $this->renderPage('product', ['product' => $product]);
        } else {
            http_response_code(404);
            $this->renderPage('error');
        }
    }

    private function formCarrito()
    {
        if ($this->action === 'add_to_cart' && $_SERVER['REQUEST_METHOD'] == 'POST') {
            $response = ['success' => false, 'message' => ''];
            if (!isset($_SESSION['id'])) {
            } else {
            }
        }
        $this->renderPage('home');
    }

    private function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_unset();
        session_destroy();

        if (ini_get("session.use_cookies")) {
            setcookie(session_name(), '', time() - 42000, '/');
        }

        header('Location: /');
        exit();
    }
}
