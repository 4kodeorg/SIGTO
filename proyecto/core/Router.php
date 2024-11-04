<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use PaypalServerSDKLib\Authentication\ClientCredentialsAuthCredentialsBuilder;
use PaypalServerSDKLib\Environment;
use PaypalServerSDKLib\PaypalServerSDKClientBuilder;
use PaypalServerSDKLib\Models\Builders\MoneyBuilder;
use PaypalServerSDKLib\Models\Builders\OrderRequestBuilder;
use PaypalServerSDKLib\Models\Builders\PurchaseUnitRequestBuilder;
use PaypalServerSDKLib\Models\Builders\AmountWithBreakdownBuilder;
use PaypalServerSDKLib\Models\Builders\ShippingDetailsBuilder;
use PaypalServerSDKLib\Models\Builders\ShippingOptionBuilder;
use PaypalServerSDKLib\Models\ShippingType;


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
            'admin-sys' => 'renderSysAdmin',
            'registro' => 'formRegistration',
            'product' => 'renderProduct',
            'cuenta' => 'formAccount',
            'perfil' => 'renderProfile',
            'carrito' => 'renderPage',
            'empresa' => 'formRegistroEmpresa',
            'faq' => 'renderPage',
            'sustentabilidad' => 'renderPage',
            'compra-protegida' => 'renderPage',
            'devolucion-de-productos' => 'renderPage',
            'terminos-y-condiciones' => 'renderPage',
            'admin_cuenta' => 'formAccountEmpresa',
            'admin' => 'redirectMain',
            'admin/main' => 'renderBackOffice',
            'admin/estadisticas' => 'renderBackOffice',
            'admin/empresa' => 'renderBackOffice',
            'admin/productos' => 'pageProductsAdmin',
            'admin/perfil' => 'renderAdminPerfil',
            'logout' => 'logout',
            'home' => 'searchForm',
            '/' => 'redirectHome'
        ];
        if (preg_match('/^admin\/productos\/(\w+)$/', $this->request, $matches)) {
            $productId = intval($matches[1]);
            $this->renderProductData($productId);
            return;
        } elseif (preg_match('/^admin\/perfil\/([a-fA-F0-9]+)$/', $this->request, $matches)) {
            $vendedorId = $matches[1];
            if ($this->checkVendedorMiddleware($vendedorId)) {
                $vendedorEmail = pack("H*", $vendedorId);
                $this->vendedorActions($vendedorEmail);
            }
        } elseif (preg_match('/^product\/(\w+)$/', $this->request, $matches)) {
            $productId = $matches[1];
            $this->renderProduct($productId);
        } elseif (preg_match('/^finalizar_compra\/(\d+)$/', $this->request, $matches)) {
            $idUserCarrito = $matches[1];
            $this->renderCheckoutPage($idUserCarrito);
        } elseif (preg_match('/^finalizar_compra\/paypal\/(\w+)$/', $this->request, $matches)) {
            $userId = $matches[1];
            if ($this->checkUserMiddleware(($userId))) {
                $this->processPaymentPayPal($userId);
            } else {
                $this->renderPage('error', ['message' => 'Ocurrió un error inesperado']);
            }
        } elseif (preg_match('/^perfil\/([a-fA-F0-9]+)$/', $this->request, $matches)) {
            $userId = $matches[1];
            if ($this->checkUserMiddleware($userId)) {
                $userEmail = pack("H*", $userId);
                $this->profileActions($userEmail);
            } else {
                $message = "Acceso no autorizado";
                $this->renderPage('error', ['message' => $message]);
            }

        } elseif ($this->request === 'home') {
            $this->homeActions();
            return;
        } elseif ($this->request === 'admin/productos') {
            $idVendedor = $_SESSION['id_producto'] ?? 0;
            $this->adminActions($idVendedor);
            return;
        } elseif (isset($routes[$this->request])) {
            $this->assignPage($routes[$this->request], $this->request);
        } else {
            $message = "Acceso no autorizado";
            $this->renderPage('error', ['message' => $message]);
        }
    }
    private function vendedorActions($vendedorEmail)
    {
        switch ($this->action) {
            case 'add_phone':
                break;
            case 'add_direccion':
                break;
            case 'update_info':
                break;
            case 'update_direccion':
                break;
            default:
                $this->renderAdminPerfil($vendedorEmail);
                break;
        }
    }
    private function renderAdminSite($page, $data = [])
    {

        $file = $_SERVER['DOCUMENT_ROOT'] . "/vista/admin-site/{$page}.php";
        if (file_exists($file)) {
            extract($data);
            include($file);
        } else {
            http_response_code(404);
            echo "404 - Page not found";
        }
    }
    private function renderSysAdmin () {
        if (isset($_SESSION['sys-admin-email'])) {
            $this->renderAdminSite('admin-site');
        } else {
            $this->renderAdminSite('admin-loggin');
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
            print_r($_SERVER['DOCUMENT_ROOT'] . "/vista/{$page}.php");
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
    private function profileActions($userId)
    {
        switch ($this->action) {
            case 'actualizar_info':
                $this->updateInfo();
                break;
            case 'agregar_direccion':
                $this->addDirecciones();
                break;
            case 'actualizar_direccion':
                $this->updateDirecciones();
                break;
            case 'get_favorites':
                $this->getUserFavorites();
                break;
            case 'get_compras':
                $this->getUserCompras();
                break;
            case 'add_phone':
                $this->addUserPhone();
                break;
            case 'update_phone':
                $this->updateTelefono();
                break;
            case 'agregar_card':
                $this->updatePayment();
                break;
            default:
                $this->renderProfile($userId);
                break;
        }
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
            case 'init_sess':
                $this->initSessionHome();
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
    private function adminActions($idVendedor)
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
                $this->getMoreProducts($idVendedor);
                break;
            case 'get_disabled_products':
                $this->getDisabledProds($idVendedor);
                break;
            case 'activate_product':
                $this->activateProductAdmin();
                break;
            default:
                $this->pageProductsAdmin($idVendedor);
                break;
        }
    }
    private function getDisabledProds($idVendedor)
    {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/controlador/ProductController.php';
        $response = ['success' => false, 'message' => '', 'disabledprods' => []];
        header('Content-type: application/json');
        $productController = new ProductController();
        $disabledProducts = $productController->getDisabledProducts($idVendedor);
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
    private function updateTelefono()
    {
        $response = ['success' => false, 'message' => ''];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            require_once $_SERVER['DOCUMENT_ROOT'] . '/controlador/UsuarioController.php';
            $userController = new UsuarioController();
            $userEmail = htmlspecialchars($_POST['id_username']) ?? '';
            $userPhone = htmlspecialchars($_POST['phone']) ?? '';
            if ($userController->updateUserPhone(pack("H*", $userEmail), $userPhone)) {
                $response['success'] = true;
                $response['message'] = 'Información actualizada con exito';
            } else {
                $response['message'] = "No se pudieron actualizar los datos, intente nuevamente";
            }
        } else {
            $response['message'] = "Solicitud invalida";
        }
        header('Content-type: application/json');
        echo (json_encode($response));
        exit();
    }
   
    private function addUserPhone()
    {
        $response = ['success' => false, 'message' => ''];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            require_once $_SERVER['DOCUMENT_ROOT'] . '/controlador/UsuarioController.php';
            $userController = new UsuarioController();
            $userEmail = htmlspecialchars($_POST['id_username']) ?? '';
            $userPhone = htmlspecialchars($_POST['phone']) ?? '';
            if ($userController->createUserPhones(pack("H*", $userEmail), $userPhone)) {
                $response['success'] = true;
                $response['message'] = 'Número vinculado a tu cuenta con exito';
            } else {
                $response['message'] = "No se pudieron actualizar los datos, intente nuevamente";
            }
        } else {
            $response['message'] = "Solicitud invalida";
        }
        header('Content-type: application/json');
        echo (json_encode($response));
        exit();
    }
    private function updatePayment() {}
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
    private function initSessionHome()
    {
        if ($this->action === 'init_sess' && $_SERVER['REQUEST_METHOD'] == 'POST') {
            $res = ['success' => false, 'mssg' => '', 'url' => '', 'carrito' => []];

            require_once $_SERVER['DOCUMENT_ROOT'] . '/controlador/UsuarioController.php';
            require_once $_SERVER['DOCUMENT_ROOT'] . '/controlador/CartController.php';
            $cartController = new CartController();
            $userController = new UsuarioController();
            $username = htmlspecialchars(trim($_POST['username']));
            $password = trim($_POST['passwd']);

            $usuario = $userController->validateUser($username, $password);
            if ($usuario) {
                $res['success'] = true;
                $sessIdfragment = date('Ymd_His') . "-" . md5($usuario['email']);
                $carrito = $cartController->getUserCarrito($usuario['email']);
                $_SESSION['carrito'] = $carrito;
                $_SESSION['id_username'] = md5($usuario['email']);
                $_SESSION['uri_fragment'] = $sessIdfragment;
                $_SESSION['username'] = $usuario['username'];
            } else {
                $res['mssg'] = 'Credenciales inválidas.';
            }
            header('Content-type: application/json');
            echo (json_encode($res));
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
            'product_sku' => htmlspecialchars($_POST['id_producto']),
            'nombre' => htmlspecialchars($_POST['new_titulo']),
            'descripcion' => htmlspecialchars($_POST['new_descripcion']),
            'origen' => htmlspecialchars($_POST['new_origen']),
            'stock' =>  htmlspecialchars($_POST['new_cantidad']),
            'precio' => htmlspecialchars($_POST['new_precio'])

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

            $idProduct = $favData['id_product'] ?? null;
            if ($idProduct) {
                $userId = $_SESSION['id_comprador'];
                try {
                    $res = $usuarioController->deleteFromFavorites($userId, $idProduct);
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
            $idProduct = $_POST['id_product'];
            require_once $_SERVER['DOCUMENT_ROOT'] . '/controlador/UsuarioController.php';

            $userController = new UsuarioController();
            $userId = $_SESSION['id_comprador'];
            $result = $userController->addToFav($userId, $idProduct);

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
    private function checkVendedorMiddleware($vendedorId)
    {
        if (isset($_SESSION['vendedor_id'])) {
            $loggedVendedor = $_SESSION['vendedor_id'];
            if ($loggedVendedor == $vendedorId) {
                return true;
            } else {
                return false;
            }
        } else {
            $this->renderPage('error', ['message' => "Acceso no autorizado"]);
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
            $this->renderPage('error', ['message' => 'Debes iniciar sesión']);
        }
    }
    private function getUserDirecciones()
    {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/controlador/UsuarioController.php';
        header('Content-type: application/json');
        $response = ['success' => false, 'message' => '', 'userdirecciones' => []];

        $usuarioController = new UsuarioController();
        $direcciones = $usuarioController->getCompradorDirecciones($email);
    }
    private function updateDirecciones()
    {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/controlador/UsuarioController.php';
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            parse_str(file_get_contents('php://input'), $data);
            $response = ['success' => false, 'message' => ''];
            $userData = [
                'id_direccion' => $data['id_direccion'],
                'email' => pack("H*" ,$data['id_username']),
                'calle_prim' => $data['calle_prim'],
                'calle_seg' => $data['calle_seg'],
                'num_puerta' => $data['num_puerta'],
                'num_apartamento' => $data['num_apartamento'],
                'ciudad' => $data['ciudad'],
                'tipo_dir' => $data['tipo_dir']
            ];

            $emptyFields = false;
            foreach ($data as $key => $val) {
                if (empty(trim($val)) || $val == 0) {
                    $emptyFields = true;
                    $response['message'] = "El campo " . $key . "es requerido";
                }
            }
            if (!$emptyFields) {
                $userController = new UsuarioController();
                if ($userController->updateUserDirecciones($userData)) {
                    $response['success'] = true;
                    $response['message'] = 'Direcciones actualizadas con exito';
                } else {
                    $response['message'] = "Ocurrió un error inesperado";
                }
            }
            echo json_encode($response);
            exit();
        }
    }

    private function addDirecciones()
    {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/controlador/UsuarioController.php';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        }
        $response = ['success' => false, 'message' => ''];
        $data = [
            'email' => htmlspecialchars($_POST['id_username']) ?? '',
            'calle_pri' => htmlspecialchars($_POST['calle_prim']) ?? '',
            'calle_seg' => htmlspecialchars($_POST['calle_seg']) ?? '',
            'num_puerta' => htmlspecialchars($_POST['num_puerta']) ?? '',
            'num_apartamento' => htmlspecialchars($_POST['num_apartamento']) ?? '',
            'ciudad' => htmlspecialchars($_POST['ciudad']) ?? '',
            'tipo_dir' =>  htmlspecialchars($_POST['tipo_dir']) ?? ''
        ];
        $emptyFields = false;
        foreach ($data as $key => $val) {
            if (empty(trim($val)) || $val == 0) {
                $emptyFields = true;
                $response['message'] = 'El campo ' . $key . 'es requerido';
            }
        }
        if (!$emptyFields) {
            $userController = new UsuarioController();
            $userAddDirections = $userController->addUserDirecciones($data);
            if ($userAddDirections) {
                $response['success'] = true;
                $response['message'] = "Información agregada con éxito.";
            }
        }
        header('Content-type: application/json');
        echo (json_encode($response));
        exit();
    }

    private function updateInfo()
    {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/controlador/UsuarioController.php';

        $response = ['success' => false, 'message' => ''];
        $email = htmlspecialchars($_POST['id_username']) ?? '';
        $nombre1 = htmlspecialchars($_POST['nombre1']) ?? '';
        $nombre2 = htmlspecialchars($_POST['nombre2']) ?? '';
        $apellido1 = htmlspecialchars($_POST['apellido1']) ?? '';
        $apellido2 = htmlspecialchars($_POST['apellido2']) ?? '';
        if (
            !empty(trim($nombre1)) && !empty(trim($nombre2))
            && !empty(trim($apellido1)) && !empty(trim($apellido2))
        ) {
            $userController = new UsuarioController();
            $userInfoUpdatedOk = $userController->updateUserData($nombre1, $nombre2, $apellido1, $apellido2, pack("H*", $email));

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
    private function formAccountEmpresa()
    {
        if ($this->action === 'login_adm' && $_SERVER['REQUEST_METHOD'] == 'POST') {
            require_once $_SERVER['DOCUMENT_ROOT'] . '/controlador/VendController.php';
            require_once $_SERVER['DOCUMENT_ROOT'] . '/controlador/SessionController.php';

            $response = ['success' => false, 'id' => 0, 'message' => '', 'username' => '', 'url' => ''];
            if (isset($_POST['submit'])) {
                $errors = array();
                $username = htmlspecialchars(trim($_POST['username']));
                $password = trim($_POST['password']);

                if (empty($username) || empty($password)) {
                    array_push($errors, "Credenciales inválidas");
                }
                if (count($errors) == 0) {
                    $vendController = new VendController();
                    $sessionController = new SessionController();
                    $vendedor = $vendController->validateUser($username, $password);
                    $vendedorId = $vendController->getUserVendId($username);
                    if ($vendedor && $vendedorId) {
                        if ($sessionController->createSesionVend($username)) {
                            $response['success'] = true;
                            $_SESSION = [];
                            $response['url'] = '/admin';
                            $response['id'] = bin2hex($username);
                            $_SESSION['id_producto'] = $vendedorId;
                            $_SESSION['vendedor_id'] = bin2hex($username);
                            $_SESSION['backoffice_username'] = $username;
                        }
                    }
                } else {
                    $response['message'] = 'Credenciales inválidas';
                }
            }
            echo (json_encode($response));
            exit();
        }
        $this->renderPage('account_admin');
    }
    private function formRegistroEmpresa()
    {
        if ($this->action === 'registrar_emp' && $_SERVER['REQUEST_METHOD'] == 'POST') {
            require_once $_SERVER['DOCUMENT_ROOT'] . '/controlador/VendController.php';
            require_once $_SERVER['DOCUMENT_ROOT'] . '/controlador/SessionController.php';

            $response = ['success' => false, 'id' => 0, 'message' => '', 'username' => '', 'url' => ''];
            if (isset($_POST['submit'])) {
                $errors = array();
                $mailPattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
                if (preg_match($mailPattern, $_POST['email'])) {
                    $data = [
                        'email' => $_POST['email'],
                        'razon_social' => $_POST['razon_social'],
                        'password' => $_POST['password'],
                        'confirm_pwd' => $_POST['confirm_pwd'],
                        'nombre' => $_POST['nombre'],
                        'apellido' => $_POST['apellido'],
                        'fecha_nac' => $_POST['fecha_nac'],
                        'terminos' => isset($_POST['terminos']) ? $_POST['terminos'] : 0
                    ];

                    $emptyFields = false;
                    foreach ($data as $clave => $valor) {
                        if (empty(trim($valor)) || $valor == 0) {
                            $emptyFields = true;
                            $response['message'] = 'El campo' . $clave . 'es requerido';
                        }
                    }
                    $fechaNacUser = new DateTime($data['fecha_nac']);
                    $fechaNacYear = $fechaNacUser->format('Y');
                    if (intval((date('Y') - $fechaNacYear)) > 18) {
                        if (!$emptyFields) {
                            if (strlen($data['password']) < 5) {
                                array_push($errors, "La contraseña debe tener al menos 5 caracteres");
                                $response['message'] = "La contraseña debe tener al menos 5 caracteres";
                            } else {
                                if ($data['confirm_pwd'] === $data['password']) {
                                    $data['confirm_pwd'] = password_hash($data['confirm_pwd'], PASSWORD_BCRYPT);
                                    $vendedor = new VendController();
                                    $sessionController = new SessionController();
                                    $vendedorData = $vendedor->create($data);
                                    $vendedorCreateId = $vendedor->insertUserVendId($data['email']);
                                    $vendedorId = $vendedor->getUserVendId($data['email']);
                                    if ($vendedorData && $vendedorCreateId) {
                                        if ($sessionController->createSesionVend($vendedorData['email'])) {
                                            $response['success'] = true;
                                            $_SESSION = [];
                                            $response['id'] = bin2hex($vendedorData['email']);
                                            $_SESSION['vendedor_id'] = bin2hex($vendedorData['email']);
                                            $_SESSION['id_producto'] = $vendedorId;
                                            $_SESSION['backoffice_username'] = $vendedorData['email'];
                                            $response['url'] = 'admin/perfil/' . bin2hex($vendedorData['email']);
                                        } else {
                                            $response['success'] = true;
                                            $response['message'] = "Error al iniciar sesión";
                                        }
                                    } else {
                                        $response['message'] = 'Error al crear usuario';
                                    }
                                } else {
                                    $response['message'] = 'Las contraseñas no coinciden';
                                }
                            }
                        }
                    } else {
                        $response['message'] = "Debes ser mayor de 18 años para registrarte";
                    }
                } else {
                    $response['message'] = 'El email no es válido';
                }
            }

            echo (json_encode($response));
            exit();
        }
        $this->renderPage('sellerregister');
    }
    private function formRegistration()
    {
        if ($this->action === 'registrarse' && $_SERVER['REQUEST_METHOD'] == 'POST') {
            require_once $_SERVER['DOCUMENT_ROOT'] . '/controlador/UsuarioController.php';
            require_once $_SERVER['DOCUMENT_ROOT'] . '/controlador/SessionController.php';
            $response = ['success' => false, 'id' => 0, 'message' => '', 'username' => '', 'url' => ''];

            if (isset($_POST['submit'])) {
                $errors = array();

                $mailPattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
                if (preg_match($mailPattern, $_POST['email'])) {
                    $data = [
                        'username' => $_POST['username'],
                        'email' => $_POST['email'],
                        'password' => $_POST['password'],
                        'confirm_pwd' => $_POST['confirm_pwd'],
                        'fecha_nac' => $_POST['fecha_nac'],
                        'pais' => $_POST['pais'],
                        'terminos' => isset($_POST['terminos']) ? $_POST['terminos'] : 0
                    ];

                    $emptyFields = false;
                    foreach ($data as $clave => $valor) {
                        if (empty(trim($valor)) || $valor == 0) {
                            $emptyFields = true;
                            array_push($errors, "Campo faltante: " . $valor);
                            $response['message'] = 'El campo' . $clave . 'es requerido';
                        }
                    }
                    $fechaNacUser = new DateTime($data['fecha_nac']);
                    $fechaNacYear = $fechaNacUser->format('Y');
                    if (intval((date('Y') - $fechaNacYear)) > 18) {
                        if (!$emptyFields) {
                            if (strlen($data['password']) < 5) {
                                array_push($errors, "La contraseña debe tener al menos 5 caracteres");
                                $response['message'] = "La contraseña debe tener al menos 5 caracteres";
                            } else {
                                if ($data['confirm_pwd'] === $data['password']) {
                                    $data['confirm_pwd'] = password_hash($data['confirm_pwd'], PASSWORD_BCRYPT);
                                    if (count($errors) === 0) {
                                        $userController = new UsuarioController();
                                        $sessionController = new SessionController();
                                        $newUser = $userController->create($data);
                                        $createCompradorId = $userController->createIdComprador($data['email']);
    
                                        if ($newUser && $createCompradorId) {
                                            $compradorId = $userController->getIdForComprador($newUser['email']);
                                            if ($sessionController->createSesion($newUser['email'])) {
                                                $sessIdfragment = date('Y:m:d_H:i:s') . "-" . bin2hex($newUser['email']);
                                                $response['success'] = true;
                                                $_SESSION = [];
                                                $response['id'] = bin2hex($newUser['email']);
                                                $response['username'] = $newUser['username'];
                                                $response['message'] = "Registro exitoso, redireccionando..";
                                                $response['url'] = "/perfil/" . bin2hex($newUser['email']);
                                                $_SESSION['carrito'] = [];
                                                $_SESSION['uri_fragment'] = $sessIdfragment;
                                                $_SESSION['id_comprador'] = $compradorId['id_usu_com'];
                                                $_SESSION['username'] = $newUser['username'];
                                                $_SESSION['id_username'] = bin2hex($newUser['email']);
                                            } else {
                                                $response['message'] = "Ocurrió un error al iniciar la sesión";
                                                $response['success'] = true;
                                                $response['url'] = '/cuenta';
                                            }
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
                        $response['message'] = "Debes ser mayor de 18 años para registrarte";
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
        require_once $_SERVER['DOCUMENT_ROOT'] . '/controlador/UsuarioController.php';
        require_once $_SERVER['DOCUMENT_ROOT'] . '/controlador/CartController.php';
        require_once $_SERVER['DOCUMENT_ROOT'] . '/controlador/SessionController.php';

        $userController = new UsuarioController();
        $cartController = new CartController();
        $sessionController = new SessionController();
        if ($this->action === '1' && $_SERVER['REQUEST_METHOD'] == 'POST') {


            $res = ['success' => false, 'mssg' => '', 'id' => 0, 'url' => '', 'carrito' => []];
            $errors = array();
            if (isset($_POST['submit'])) {
                $username = htmlspecialchars(trim($_POST['username']));
                $password = trim($_POST['password']);

                if (empty($username) || empty($password)) {
                    array_push($errors, "Credenciales inválidas");
                }
                if (count($errors) == 0) {

                    $usuario = $userController->validateUser($username, $password);
                    if ($usuario) {
                        $compradorId = $userController->getIdForComprador($usuario['email']);
                        if ($sessionController->createSesion($username)) {
                            $res['success'] = true;
                            $_SESSION = [];
                            $sessIdfragment = date('Ymd_His') . "-" . bin2hex($usuario['email']);
                            $carrito = $cartController->getUserCarrito($compradorId['id_usu_com']);
                            $_SESSION['carrito'] = $carrito;
                            $_SESSION['id_comprador'] = $compradorId['id_usu_com'];
                            $_SESSION['id_username'] = bin2hex($usuario['email']);
                            $_SESSION['uri_fragment'] = $sessIdfragment;
                            $_SESSION['username'] = $usuario['username'];
                            $res['carrito'] = $carrito;
                            $res['url'] = '/home';
                        } else {
                            $res['mssg'] = 'Ocurrió un error al iniciar la sesión';
                        }
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
            $_SESSION['id_username'] = bin2hex($email);
            $_SESSION['info'] = $google_account_info;
            header('Location: /');
            exit();
            // }
            // }
        }
        $this->renderPage('account', ['client' => $client]);
    }
    private function renderAdminPerfil($vendedorId)
    {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/controlador/VendController.php';
        $vendedorController = new VendController();
        $vendedor = $vendedorController->getUserById($vendedorId);
        $vendedorIdProducts = $vendedorController->getUserVendId($vendedorId);
        $productosVendedor = $vendedorController->getUserProducts($vendedorIdProducts['id_usu_ven']);
        if ($vendedor) {
            $this->renderBackOffice('profile', ['vendedor' => $vendedor, 'productos' => $productosVendedor]);
        } else {
            $this->renderPage('error', ['message' => 'No autorizado']);
        }
    }
    private function getUserCompras() {}
    private function getUserFavorites()
    {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/controlador/UsuarioController.php';
        $userController = new UsuarioController();
        $response = ['success' => false, 'message' => '','favoritos' => []];
        if (isset($_GET['id_user']) && $_GET['id_user'] != 0) {
            $idUsername = $_GET['id_user'];
            $usernameEmail = pack("H*", $idUsername);
            $favProducts = $userController->getUserProductFavs($usernameEmail);
            if (count($favProducts) > 0) {
               $response['success'] = true;
               $response['favoritos'] = $favProducts;

            } else {
                $response['success'] = true;
                $response['message'] = 'Aún no tienes productos agregados a favoritos';
            }
            echo(json_encode($response));
            exit();
        } else {
            $this->renderPage('error', ['message' => 'No autorizado']);
        }
    }
    private function renderProfile($userId)
    {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/controlador/UsuarioController.php';
        $userController = new UsuarioController();
        $favoritos = $userController->getUserProductFavs($userId) ?? '';
        $usuario = $userController->getUserbyId($userId);
        $datosComprador = $userController->getUserComprador($userId);
        $metodosPago = $userController->getUserCards($userId);
        $telComprador = $userController->getUserPhones($userId);
        $direccionesComprador = $userController->getCompradorDirecciones($userId);
        if ($usuario) {
            $this->renderPage('perfil', [
                'usuario' => $usuario,
                'userphone' => $telComprador,
                'favoritos' => $favoritos,
                'comprador' => $datosComprador,
                'tarjetas' => $metodosPago,
                'direcciones' => $direccionesComprador
            ]);
        } else {
            http_response_code(404);
            $this->renderPage('error', ['message' => 'No autorizado']);
        }
    }

    private function searchForm()
    {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/controlador/ProductController.php';
        require_once $_SERVER['DOCUMENT_ROOT'] . '/controlador/UsuarioController.php';

        $product = new ProductController();
        $userController = new UsuarioController();

        $response = ['success' => false, 'message' => '', 'results' => []];

        $categorias = $product->getCategories();
        if (isset($_SESSION['id_comprador'])) {
            $userId = $_SESSION['id_comprador'];
            $favoritos = $userController->getUserFavorites($userId);
        } else {
            $favoritos = [];
        }

        if (isset($_GET['buscar'])) {
            $searchParam = htmlspecialchars($_GET['buscar']);
            $idCat = isset($_GET['acategory']) ? (int)$_GET['acategory'] : 0;
            $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
            $offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;

            if (!empty(trim($searchParam))) {
                $resultados = $product->searchProductsByTitleOrDescripcion($searchParam, $idCat);

                if ($resultados) {
                    $this->renderPage('home', [
                        'resultados' => $resultados,
                        'categorias' => $categorias,
                        'favoritos' => $favoritos
                    ]);
                    return;
                } else {
                    $message = "No se encontraron resultados";
                    $this->renderPage('home', ['message' => $message, 'categorias' => $categorias]);
                    return;
                }
            } else {
                $message = "Ingresa algún producto para buscar";
                $this->renderPage('home', ['message' => $message, 'categorias' => $categorias, 'favoritos' => $favoritos]);
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
        $this->renderPage('home', ['productos' => $dataProductos, 'favoritos' => $favoritos, 'categorias' => $categorias]);
    }
    private function getMoreProducts($idVendedor)
    {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/controlador/ProductController.php';

        if (isset($_SESSION['backoffice_username']) && !empty(trim($_SESSION['backoffice_username']))) {
            $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
            $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 15;

            $productController = new ProductController();
            $productos = $productController->getProductsByLimitVend($idVendedor['id_usu_ven'], $offset, $limit);

            if (!empty($productos)) {
                echo json_encode($productos);
            } else {
                echo json_encode([]);
            }
        } else {
            echo json_encode(["message" => "Debes iniciar sesión"]);
        }
    }

    private function pageProductsAdmin($idVendedor)
    {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/controlador/ProductController.php';
        require_once $_SERVER['DOCUMENT_ROOT'] . '/controlador/VendController.php';


        $productController = new ProductController();
        $vendController = new VendController();

        if (isset($_SESSION['backoffice_username']) && !empty(trim($_SESSION['backoffice_username']))) {

            if ($this->action === 'get_subcategories' && $_SERVER['REQUEST_METHOD'] == 'GET') {

                $idCategory = $_GET['id_cat'] ?? '';
                if (!empty($idCategory)) {
                    header('Content-type: application/json');
                    $response = ['success' => false, 'subcategories' => []];
                    $response['success'] = true;
                    $response['subcategories'] = $productController->getSubCategories($idCategory);
                    echo json_encode($response);
                    exit();
                }
            }

            $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 15;
            $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;

            $productos = $productController->getProductsByLimitVend($idVendedor['id_usu_ven'], $offset, $limit );

            $categorias = $productController->getCategories();
            if (count($productos) > 0 || count($categorias) > 0) {
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
        $resp = ['success' => false, 'mssg' => '', 'message_descuento' => ''];
        $productController = new ProductController();

        if (isset($_POST['submit'])) {
            $imagesPaths = [];
            $errors = array();

            if (!empty($_FILES['images']['name'][0])) {
                $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/imagenes/productos/';

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                foreach ($_FILES['images']['name'] as $key => $imageName) {
                    $imageTmpPath = $_FILES['images']['tmp_name'][$key];
                    $imageType = $_FILES['images']['type'][$key];

                    if (in_array($imageType, ['image/jpeg', 'image/png', 'image/gif']) && $_FILES['images']['size'][$key] <= 5000000) {
                        $newImageName = uniqid() . '_' . basename($imageName);
                        $imagePath = $uploadDir . $newImageName;

                        if (move_uploaded_file($imageTmpPath, $imagePath)) {
                            $imagesPaths[] = '/imagenes/productos/' . $newImageName;
                        } else {
                            array_push($errors, "Error al subir la imagen: $imageName");
                        }
                    } else {
                        array_push($errors, "Tipo o tamaño de archivo no válido para la imagen: $imageName");
                    }
                }
            }
            $data = [
                'id_usu_ven' => $_POST['id_usu_ven'],
                'descripcion' => $_POST['descripcion'],
                'origen' => $_POST['origen'],
                'nombre' => $_POST['nombre'],
                'stock' => $_POST['stock'],
                'oferta' => $_POST['ofertas_esp'],
                'estado' => $_POST['estado'],
                'precio' => $_POST['precio'],
                'id_cat' => $_POST['category'],
                'id_subcat' => $_POST['subcategory']
            ];

            $emptyFields = false;
            foreach ($data as $clave => $valor) {
                if (empty(trim($valor))) {
                    $emptyFields = true;
                    array_push($errors, "El campo $clave es requerido");
                }
            }
            if (!$emptyFields && count($errors) === 0) {

                $productCreated = $productController->create($data);
                if ($productCreated) {
                    $productSku = $productController->getLastInsertedSku();

                    foreach ($imagesPaths as $path) {
                        $productController->insertProductImage($productSku, $path);
                    }
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
        $idCat = $product['id_cat'] ?? null;
        $relatedProducts = $productController->getRelatedProducts($idCat);
        if ($product) {
            $this->renderPage('product', ['product' => $product ,'related_products' => $relatedProducts]);
        } else {
            http_response_code(404);
            $this->renderPage('error');
        }
    }
    ### CARRITO ###

    private function processPaymentPayPal($userId)
    {

        require_once $_SERVER['DOCUMENT_ROOT'] . '/cfg.php';
        require_once $_SERVER['DOCUMENT_ROOT'] . '/controlador/CartController.php';
        $cartController = new CartController();
        $userCart = $cartController->getUserCarrito($userId);
        $cartTotal = 0;
        foreach ($userCart as $item) {
            $cartTotal += $item['cantidad'] * $item['price_product'];
        }

        $paypal_client_id = PAYPAL_CLIENT_ID;
        $paypal_client_secret = PAYPAL_CLIENT_SECRET;
        global $client;
        $client = PaypalServerSDKClientBuilder::init()
            ->clientCredentialsAuthCredentials(
                ClientCredentialsAuthCredentialsBuilder::init(
                    $paypal_client_id,
                    $paypal_client_secret
                )
            )
            ->environment(Environment::SANDBOX)
            ->build();
        function handleResponse($response)
        {
            $jsonResponse = json_decode($response->getBody(), true);
            return [
                "jsonResponse" => $jsonResponse,
                "httpStatusCode" => $response->getStatusCode(),
            ];
        }
        /**
         * Create an order to start the transaction.
         * @see https://developer.paypal.com/docs/api/orders/v2/#orders_create
         */
        function createOrder($cart)
        {
            $cartTotal = 0;
            if (!is_array($cart)) {
                throw new Exception("Error en el formato de dato.");
            }
            foreach ($cart as $item) {
                $cartTotal += $item['cantidad'] * $item['price_product'];
            }
            $cartTotal = $cartTotal / 40;
            global $client;
            $orderBody = [
                "body" => OrderRequestBuilder::init("CAPTURE", [
                    PurchaseUnitRequestBuilder::init(
                        AmountWithBreakdownBuilder::init("USD", $cartTotal)->build()
                    )->build(),
                ])->build(),
            ];
            $apiResponse = $client->getOrdersController()->ordersCreate($orderBody);
            return handleResponse($apiResponse);
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
            $cart = $data['cart'];
            try {
                $orderResponse = createOrder($cart);
                if (!$orderResponse) {
                    throw new Exception("Failed to create PayPal order.");
                }
                echo json_encode($orderResponse["jsonResponse"]);
            } catch (Exception $e) {
                echo json_encode(["error" => $e->getMessage()]);
                http_response_code(500);
            }
        }
        /**
         * Capture payment for the created order to complete the transaction.
         * @see https://developer.paypal.com/docs/api/orders/v2/#orders_capture
         */
        function captureOrder($orderID)
        {
            global $client;

            $captureBody = [
                "id" => $orderID,
            ];
            $apiResponse = $client->getOrdersController()->ordersCapture($captureBody);
            return handleResponse($apiResponse);
        }
        if (isset($this->action) && $this->action === 'capture') {
            $orderID = $_GET['pyid'];

            try {
                $captureResponse = captureOrder($orderID);
                echo json_encode($captureResponse["jsonResponse"]);
            } catch (Exception $e) {
                echo json_encode(["error" => $e->getMessage()]);
                http_response_code(500);
            }
        }
    }

    private function renderCheckoutPage($userId)
    {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/controlador/CartController.php';
        require_once $_SERVER['DOCUMENT_ROOT'] . '/controlador/UsuarioController.php';
        $usuario = new UsuarioController();
        $usuarioEmail = $_SESSION['id_username'];

        if ($this->checkUserMiddleware($usuarioEmail)) {
            $email = pack("H*", $_SESSION['id_username']);
            $cartController = new CartController();
            $userController = new UsuarioController();
            $userCarrito = $cartController->getUserCarrito($userId);
            $datosComprador = $userController->getUserComprador($email);
            $phoneComprador = $userController->getUserPhones($email);
            $compradorDirecciones = $userController->getCompradorDirecciones($email);
            $pagoComprador = $userController->getUserCards($email);
            if (!empty($userCarrito) && !empty($usuario)) {
                $this->renderPage('checkout', [
                                    'carrito' => $userCarrito, 
                                    'usuario' => $datosComprador,
                                    'usuario_telefono' => $phoneComprador,
                                    'comp_direcciones' => $compradorDirecciones,
                                    'pago_comp' => $pagoComprador]);
            } else {
                $this->renderPage('error', ['message' => "No has añadido nada a tu carrito"]);
            }
        } else {
            $this->renderPage('error', ['message' => "Acceso no autorizado"]);
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
                $vendedorId = htmlspecialchars($_POST['id_vendedor']);
                $productTitulo = htmlspecialchars($_POST['titulo']);
                $quantity = htmlspecialchars($_POST['quantity']);
                $priceProduct = htmlspecialchars($_POST['price']);


                $itemData = [
                    'sku' => $productId,
                    'id_vendedor' => $vendedorId,
                    'id_comprador' => $userId,
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
                            if ($sessionItem['sku_prod'] == $productId
                                && $sessionItem['id_usu_com'] == $userId
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
                    } else {
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
