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
            'admin' => 'redirectMain',
            'admin/main' => 'renderBackOffice',
            'admin/estadisticas' => 'renderBackOffice',
            'admin/empresa' => 'renderBackOffice',
            'admin/productos' => 'pageProductsAdmin',
            'admin/perfil' => 'renderBackOffice',
            'logout' => 'logout',
            'home' => 'searchForm',
            '/' => 'redirectHome'
        ];
        if (preg_match('/^admin\/productos\/(\d+)$/', $this->request, $matches)) {
            $productId = intval($matches[1]);
            $this->renderProductData($productId);
            return;
        } elseif (preg_match('/^product\/(\d+)$/', $this->request, $matches)) {
            $productId = $matches[1];
            $this->renderProduct($productId);
        } elseif (preg_match('/^finalizar_compra\/(\d+)$/', $this->request, $matches)) {
            $idUserCarrito = $matches[1];
            $this->renderCheckoutPage($idUserCarrito);
        }
        elseif (preg_match('/^perfil\/(\d+)$/', $this->request, $matches)) {
            $userId = intval($matches[1]);

            if ($this->checkUserMiddleware($userId)) {
                if (isset($this->action) && $this->action === 'actualizar_info') {
                    $this->updateInfo($userId);
                } elseif (isset($this->action) && $this->action === 'actualizar_direccion') {
                    $this->updateDirecciones($userId);
                } else {
                    $this->renderProfile($userId);
                }
            } else {
                $message = "Acceso no autorizado";
                $this->renderPage('error', ['message' => $message]);
            }
        } elseif ($this->request === 'home') {
            $this->homeActions();
            return;
        } elseif ($this->request === 'admin/productos') {
            $this->adminActions();
            return;
        } elseif (isset($routes[$this->request])) {
            $this->assignPage($routes[$this->request], $this->request);
        } else {
            $message = "Acceso no autorizado";
            $this->renderPage('error', ['message' => $message]);
        }
    }
    private function redirectMain()
    {
        header('Location: /admin/main');
        exit();
    }

    private function redirectHome()
    {
        header('Location: /home');
        exit();
    }
    private function homeActions()
    {
        switch ($this->action) {
            case 'add_to_fav':
                $this->addToFavoritos();
                break;
            case 'remove_fav':
                $this->removeFromFavoritos();
                break;
            case 'add_to_cart':
                $this->formCarrito();
                break;
            case 'remove_product_cart':
                $this->removeProductFromCartById();
                break;
            case 'get_cart':
                $this->getCurrentCart();
                break;
            default:
                $this->searchForm();
                break;
        }
    }
    private function adminActions()
    {
        switch ($this->action) {
            case 'agregar_producto':
                $this->formProductAdmin();
                break;
            case 'dis_producto':
                $this->disableProductAdmin();
                break;
            case 'edit_producto':
                $this->editProductAdmin();
                break;
            case 'get_productos':
                $this->getMoreProducts();
                break;
            case 'get_disabled_products':
                $this->getDisabledProds();
                break;
            case 'activate_product':
                $this->activateProductAdmin();
                break;
            default:
                $this->pageProductsAdmin();
                break;
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
    private function getDisabledProds()
    {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/controlador/ProductController.php';
        $response = ['success' => false, 'message' => '', 'disabledprods' => []];
        header('Content-type: application/json');
        $productController = new ProductController();
        $disabledProducts = $productController->getDisabledProducts();
        if (count($disabledProducts) > 0) {
            $response['success'] = true;
            $response['message'] = "Productos desactivados";
            $response['disabledprods'] = $disabledProducts;
        } else {
            $response['message'] = "No tienes productos desactivados";
        }
        echo json_encode($response);
        exit();
        return;
    }

    private function activateProductAdmin()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            require_once $_SERVER['DOCUMENT_ROOT'] . '/controlador/ProductController.php';
            header('Content-type: application/json');
            $productController = new ProductController();
            parse_str(file_get_contents("php://input"), $disabledProduct);
            $res = ['status' => false, 'message' => ''];
            $idProduct = $disabledProduct['id_product'] ?? null;

            if ($idProduct) {
                try {
                    $result = $productController->activateProduct($idProduct);
                    if ($result) {
                        $res['status'] = true;
                        $res['message'] = "El producto fue activado con exito";
                    } else {
                        $res['message'] = "No se pudo activar el producto";
                    }
                } catch (Exception $er) {
                    $res['message'] = $er->getMessage();
                }
            } else {
                $res['message'] = "No se pudo procesar la solicitud";
                $res['status'] = "error";
            }
            echo json_encode($res);
            exit();
        }
    }

    private function disableProductAdmin()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            header('Content-type: application/json');
            require_once $_SERVER['DOCUMENT_ROOT'] . '/controlador/ProductController.php';
            $productController = new ProductController();
            parse_str(file_get_contents("php://input"), $disableProduct);
            $res = ['status' => '', 'message' => ''];
            $idProduct = $disableProduct['id_product'] ?? null;

            if ($idProduct) {
                try {
                    $result = $productController->disableProductById($idProduct);
                    if ($result) {
                        $res['status'] = "success";
                        $res['message'] = "El producto ha sido desactivado";
                    } else {
                        $res['status'] = "error";
                        $res['message'] = "No se pudo desactivar el producto";
                    }
                } catch (Exception $er) {
                    $res['message'] = $er->getMessage();
                    $res['status'] = "error";
                }
            } else {
                $res['message'] = "No se pudo procesar la solicitud";
                $res['status'] = "error";
            }
            echo json_encode($res);
            exit();
        }
    }

    private function editProductAdmin()
    {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/controlador/ProductController.php';

        $response = ['success' => false, 'message' => ''];
        $data = [
            'product_id' => htmlspecialchars($_POST['id_producto']),
            'new_titulo' => htmlspecialchars($_POST['new_titulo']),
            'new_descripcion' => htmlspecialchars($_POST['new_descripcion']),
            'new_origen' => htmlspecialchars($_POST['new_origen']),
            'new_cantidad' =>  htmlspecialchars($_POST['new_cantidad']),
            'new_precio' => htmlspecialchars($_POST['new_precio'])

        ];
        $emptyFields = false;
        foreach ($data as $clave => $valor) {
            if (empty(trim($valor))) {
                $emptyFields = true;
                $response['message'] = 'El campo' . $clave . 'es requerido';
            }
        }
        if (!$emptyFields) {
            $productController = new ProductController();
            $result = $productController->updateProductData($data);
            if ($result) {
                $response['success'] = true;
                $response['message'] = "Producto actualizado con exito";
            } else {
                $response['message'] = "No se pudo actualizar el producto";
            }
        } else {
            $response['message'] = "Todos los campos son requeridos";
        }
        header('Content-type: application/json');
        echo (json_encode($response));
        exit();
    }
    // USUARIO

    private function removeFromFavoritos()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            require_once $_SERVER['DOCUMENT_ROOT'] . '/controlador/UsuarioController.php';
            $usuarioController = new UsuarioController();
            parse_str(file_get_contents("php://input"), $favData);

            $idUser = $favData['id_user'] ?? null;
            $idProduct = $favData['id_product'] ?? null;
            if ($idUser && $idProduct) {
                try {
                    $res = $usuarioController->deleteFromFavorites($idUser, $idProduct);
                    if ($res) {
                        echo json_encode(['status' => 'success']);
                    } else {
                        echo json_encode(['status' => 'error', 'message' => 'No se pudo eliminar de favoritos']);
                    }
                } catch (Exception $e) {
                    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Parametros invalidos']);
            }
        }
    }

    private function addToFavoritos()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idUser = $_POST['id_user'];
            $idProduct = $_POST['id_product'];
            require_once $_SERVER['DOCUMENT_ROOT'] . '/controlador/UsuarioController.php';

            $userController = new UsuarioController();

            $result = $userController->addToFav($idUser, $idProduct);

            if ($result) {
                echo json_encode(['status' => 'success', 'message' => 'Producto añadido a favoritos']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'No se pudo añadir a favoritos']);
            }
            exit();
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Solicitud inválida']);
            exit();
        }
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
    private function updateInfo($userId)
    {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/controlador/UsuarioController.php';

        $response = ['success' => false, 'message' => ''];
        $username = htmlspecialchars($_POST['new_user']) ?? '';
        $email = htmlspecialchars($_POST['new_correo']) ?? '';
        $phone = htmlspecialchars($_POST['new_telefono']) ?? '';
        if (!empty(trim($username)) && !empty(trim($email)) && !empty(trim($phone))) {
            $userController = new UsuarioController();
            $userInfoUpdatedOk = $userController->updateUserData($userId, $email, $phone, $username);
            if ($userInfoUpdatedOk) {
                $_SESSION['username'] = $username;
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
                                        $_SESSION['carrito'] = [];
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
        require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
        require_once $_SERVER['DOCUMENT_ROOT'] . '/controlador/UsuarioController.php';
        require_once $_SERVER['DOCUMENT_ROOT'] . '/controlador/CartController.php';
        $userController = new UsuarioController();
        $cartController = new CartController();
        if ($this->action === '1' && $_SERVER['REQUEST_METHOD'] == 'POST') {


            $res = ['success' => false, 'mssg' => '', 'id' => 0, 'url' => '', 'carrito' => []];
            $errors = array();
            if (isset($_POST['submit'])) {
                $username = htmlspecialchars(trim($_POST['username']));
                $password = trim($_POST['passwd']);

                if (empty($username) || empty($password)) {
                    array_push($errors, "Credenciales inválidas");
                }
                if (count($errors) == 0) {

                    $usuario = $userController->validateUser($username, $password);
                    if ($usuario) {
                        $res['success'] = true;
                        $sessIdfragment = date('Ymd_His') . "-" . $usuario['id'];
                        $carrito = $cartController->getUserCarrito($usuario['id']);
                        $_SESSION['carrito'] = $carrito;

                        $_SESSION['id_username'] = $usuario['id'];
                        $_SESSION['uri_fragment'] = $sessIdfragment;
                        $_SESSION['username'] = $usuario['username'];
                        $res['carrito'] = $carrito;
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
        require_once $_SERVER['DOCUMENT_ROOT'] . '/cfg.php';
        $clientID = GOOGLE_CLIENT_ID;
        $clientSecret = GOOGLE_CLIENT_SECRET;
        $redirectUri = 'http://localhost/cuenta';

        $client = new Google\Client();
        $client->setClientId($clientID);
        $client->setClientSecret($clientSecret);
        $client->setRedirectUri($redirectUri);
        $client->addScope("email");
        $client->addScope("profile");

        if (isset($_GET['code'])) {
            $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
            $client->setAccessToken($token['access_token']);

            $google_oauth = new Google\Service\Oauth2($client);
            $google_account_info = $google_oauth->userinfo->get();
            $email =  $google_account_info->email;
            $name =  $google_account_info->name;
            // CREAR TABLE CUENTAS_GOOGLE PARA REGISTRAR LOS INICIOS CON GOOGLE API
            // if ($googleAccountExists = $userController->checkGoogleUser($email)) {
            //     $_SESSION['email_google'] = $googleAccountExists['email'];
            //     $_SESSION['username'] = $googleAccountExists['fullname'];
            //     $_SESSION['id_username'] = md5($googleAccountExists['email']);
            //     header('Location: /');
            //     exit();
            // }
            // else {
            // $googleUser = $userController->createGoogleUser($email, $name);
            // if ($googleUser) {
            $_SESSION['username'] = $name;
            $_SESSION['email_google'] = $email;
            $_SESSION['id_username'] = md5($email);
            $_SESSION['info'] = $google_account_info;
            header('Location: /');
            exit();
            // }
            // }
        }
        $this->renderPage('account', ['client' => $client]);
    }
    private function renderProfile($userId)
    {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/controlador/UsuarioController.php';
        $userController = new UsuarioController();
        $favoritos = $userController->getUserProductFavs($userId) ?? '';
        $usuario = $userController->getUserbyId($userId);
        if ($usuario) {
            $this->renderPage('perfil', ['usuario' => $usuario, 'favoritos' => $favoritos]);
        } else {
            http_response_code(404);
            $this->renderPage('error');
        }
    }

    private function searchForm()
    {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/controlador/ProductController.php';
        require_once $_SERVER['DOCUMENT_ROOT'] . '/controlador/UsuarioController.php';

        $product = new ProductController();
        $userController = new UsuarioController();

        $response = ['success' => false, 'message' => '', 'results' => []];

        if (isset($_SESSION['id_username'])) {
            $userId = $_SESSION['id_username'];
            $favoritos = $userController->getUserFavorites($userId);
        } else {
            $favoritos = [];
        }

        if (isset($_GET['buscar'])) {
            $searchParam = htmlspecialchars($_GET['buscar']);
            $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
            $offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;

            if (!empty(trim($searchParam))) {
                $resultados = $product->searchProductsByTitleOrDescripcion($searchParam);

                if ($resultados) {
                    $this->renderPage('home', [
                        'resultados' => $resultados,
                        'favoritos' => $favoritos
                    ]);
                    return;
                } else {
                    $message = "No se encontraron resultados";
                    $this->renderPage('home', ['message' => $message]);
                    return;
                }
            } else {
                $message = "Ingresa algún producto para buscar";
                $this->renderPage('home', ['message' => $message, 'favoritos' => $favoritos]);
                return;
            }
        }
        if (!isset($_GET['buscar']) && isset($_GET['limit']) && isset($_GET['offset'])) {
            $limit = $_GET['limit'];
            $offset = $_GET['offset'];
            $moreProducts = $product->getProductsByLimit($offset, $limit);
            header('Content-type: application/json');
            echo json_encode([
                'productos' => $moreProducts,
                'favoritos' => $favoritos
            ]);
            return;
        }

        $dataProductos = $product->getProductsByLimit(0, 15);
        $this->renderPage('home', ['productos' => $dataProductos, 'favoritos' => $favoritos]);
    }
    private function getMoreProducts()
    {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/controlador/ProductController.php';

        if (isset($_SESSION['username']) && !empty(trim($_SESSION['username']))) {
            $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
            $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 15;

            $productController = new ProductController();
            $productos = $productController->getProductsByLimit($offset, $limit);

            if (!empty($productos)) {
                echo json_encode($productos);
            } else {
                echo json_encode([]);
            }
        } else {
            echo json_encode(["message" => "Debes iniciar sesión"]);
        }
    }

    private function pageProductsAdmin()
    {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/controlador/ProductController.php';

        if (isset($_SESSION['username']) && !empty(trim($_SESSION['username']))) {

            $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 15;
            $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;

            $productController = new ProductController();
            $productos = $productController->getProductsByLimit($offset, $limit);
            $categorias = $productController->getCategories();
            if (count($productos) > 0) {
                $this->renderBackOffice('productos', ['productos' => $productos, 'categorias' => $categorias]);
            } else {
                $this->renderBackOffice('productos', ['message' => "No hay productos para mostrar"]);
            }
        } else {
            $message = "Debes iniciar sesion";
            $this->renderPage('error', ['message' => $message]);
        }
    }

    private function formProductAdmin()
    {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/controlador/ProductController.php';
        $resp = ['success' => false, 'mssg' => ''];
        $productController = new ProductController();

        if (isset($_POST['submit'])) {
            $imagesPaths = [];
            $errors = array();

            if (!empty($_FILES['images'])) {
            }
            $data = [
                'titulo' => $_POST['titulo'],
                'descripcion' => $_POST['descripcion'],
                'origen' => $_POST['origen'],
                'cantidad' => $_POST['cantidad'],
                'categoria' => $_POST['acategory'],
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

            header('Content-Type: application/json');
            echo (json_encode($resp));
            exit();
        }
        $this->renderBackOffice('productos');
    }
    private function renderProductData($productId)
    {
        header('Content-type: application/json');
        $res = ['success' => false, 'message' => '', 'product' => []];
        require_once $_SERVER['DOCUMENT_ROOT'] . '/controlador/ProductController.php';
        $productController = new ProductController();
        $product = $productController->getProductById($productId);
        if ($product) {
            $res['product'] = $product;
            $res['success'] = true;
        } else {
            $res['message'] = "No se encontró el producto";
        }
        echo json_encode($res);
        exit();
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
    ### CARRITO ###

    private function renderCheckoutPage($userId) {
        require_once $_SERVER['DOCUMENT_ROOT'].'/controlador/CartController.php';
        require_once $_SERVER['DOCUMENT_ROOT'].'/controlador/UsuarioController.php';

        if ($this->checkUserMiddleware($userId)) {
            $cartController = new CartController();
            $userController = new UsuarioController();
            $userCarrito = $cartController->getUserCarrito($userId);
            $usuario = $userController->getUserbyId($userId);
            if (!empty($userCarrito) && !empty($usuario)) {
                $this->renderPage('checkout', ['carrito' => $userCarrito , 'usuario' => $usuario]);
            } else {
                $this->renderPage('error' ,['message' => "No has añadido nada a tu carrito"]);
            }
        } else {
            $this->renderPage('error',[ 'message' => "Acceso no autorizado" ]);
        }
    }

    private function getCurrentCart()
    {

        require_once $_SERVER['DOCUMENT_ROOT'] . '/controlador/CartController.php';

        $response = ['success' => false, 'message' => '', 'carrito' => [], 'prevCarrito' => []];
        if (isset($_GET['id']) && $_GET['id'] != 0) {
            $userId = $_GET['id'];
            $cartController = new CartController();
            $userCart = $cartController->getUserCarrito($userId);
            if (count($userCart) === 0) {
                $response['success'] = true;
                $response['message'] = "Tu carrito está vacio";
            } else {
                $response['prevCarrito'] = $_SESSION['carrito'];
                $_SESSION['carrito'] = [];
                $_SESSION['carrito'] = $userCart;
                $response['success'] = true;
                $response['carrito'] = $userCart;
            }
        } else {
            $response['message'] = "Solicitud inválida";
        }
        echo json_encode($response);
        exit();
    }

    private function removeProductFromCartById()
    {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/controlador/CartController.php';
        $response = ['success' => false, 'message' => ''];
        if ($_SERVER['REQUEST_METHOD'] === 'PUT' && isset($_GET['idUs'])) {
            parse_str(file_get_contents("php://input"), $itemData);

            $idProduct = htmlspecialchars($itemData['id_prod']) ?? null;
            $idUser = htmlspecialchars($itemData['id_usuario']) ?? null;
            if ($idProduct && $idUser) {
                $cartController = new CartController();
                $removedProd = $cartController->removeProductFromCart($idProduct, $idUser);
                if ($removedProd) {
                    $response['success'] = true;
                    $response['message'] = 'Producto eliminado';

                    $_SESSION['carrito'] = [];
                    $_SESSION['carrito'] = $cartController->getUserCarrito($idUser);
                } else {
                    $response['message'] = 'Error en la solicitud';
                }
            } else {
                $response['message'] = 'Solicitud invalida';
            }
        }
        echo json_encode($response);
        exit();
    }
    private function formCarrito()
    {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/controlador/CartController.php';
        require_once $_SERVER['DOCUMENT_ROOT'] . '/modelo/Carrito.php';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $response = ['success' => false, 'message' => '', 'carrito' => []];
            if (!isset($_SESSION['username'])) {
                $response['message'] = "Tienes que iniciar sesion";
            } else {
                $cartController = new CartController();

                $productId = htmlspecialchars($_POST['id_product']);
                $userId = htmlspecialchars($_POST['id_user']);
                $productTitulo = htmlspecialchars($_POST['titulo']);
                $quantity = htmlspecialchars($_POST['quantity']);
                $priceProduct = htmlspecialchars($_POST['price']);


                $itemData = [
                    'id_prod' => $productId,
                    'id_usuario' => $userId,
                    'titulo' => $productTitulo,
                    'cantidad' => (int) $quantity,
                    'price_product' => (int) $priceProduct
                ];
                if ($itemData['cantidad'] < 1) {
                    $response['message'] = "Tu solicitud no pudo ser procesada";
                    return;
                }

                $cartCreated = $cartController->updateCart($itemData);

                $lateCart = $cartController->getUserCarrito($userId);

                if ($cartCreated) {
                    $itemExistsInSession = false;
                    
                        if (!empty($_SESSION['carrito'])) {
                            foreach ($_SESSION['carrito'] as &$sessionItem) {
                                if (
                                    $sessionItem['id_prod'] == $productId
                                    && $sessionItem['id_usuario'] == $userId
                                ) {
                                    $itemExistsInSession = true;
                                    $sessionItem['cantidad'] += $itemData['cantidad'];
                                    $response['message'] = 'Cantidad del producto actualizada';
                                }
                            }
                            if (!$itemExistsInSession) {
                                $_SESSION['carrito'] = $lateCart;
                                $response['message'] = 'Producto añadido al carrito';
                            }
                        }
                     else {
                        $_SESSION['carrito'] = $itemData;
                        $response['message'] = 'Producto añadido al carrito';
                    }
                    $response['success'] = true;
                    $response['carrito'] = $lateCart;
                } else {
                    $response['message'] = 'Ocurrió un error inesperado';
                }
            }
            header('Content-type: application/json');
            echo (json_encode($response));
            exit();
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
