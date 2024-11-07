CREATE DATABASE IF NOT EXISTS SIGTO CHARSET utf8mb4;
USE SIGTO;

-- CREAR TABLAS

CREATE TABLE administrador (
    email VARCHAR(50) PRIMARY KEY,
    nombre VARCHAR(30) NOT NULL,
    password VARCHAR(255) NOT NULL,
    fecha_registro DATE NOT NULL,
    fecha_ini_ses DATETIME,
    fecha_fin_ses DATETIME,
    CONSTRAINT chk_admin_email_format CHECK (email LIKE '%_@__%.__%')
);

CREATE TABLE usuario_admin (
	id_usu_admin INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(50),
    FOREIGN KEY (email) REFERENCES administrador(email)
);

CREATE TABLE cliente (
    email VARCHAR(50) PRIMARY KEY,
    username VARCHAR(30) NOT NULL,
    password VARCHAR(255) NOT NULL,
    fecha_registro DATE NOT NULL,
    fecha_nac DATE NOT NULL,
    pais VARCHAR(30),
    CONSTRAINT chk_cliente_email_format CHECK (email LIKE '%_@__%.__%')
);

CREATE TABLE comprador (
    email VARCHAR(50) PRIMARY KEY,
    nombre1 VARCHAR(30),
    nombre2 VARCHAR(30),
    apellido1 VARCHAR(30),
    apellido2 VARCHAR(30),
    FOREIGN KEY (email) REFERENCES cliente(email)
);

CREATE TABLE comprador_direccion (
    id_direccion INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(50)  NOT NULL,
    calle_pri VARCHAR(50) NOT NULL,
    calle_sec VARCHAR(50) NOT NULL,
    num_puerta VARCHAR(10) NOT NULL,
    num_apartamento VARCHAR(5) NOT NULL,
    ciudad VARCHAR(30) NOT NULL,
    tipo_dir VARCHAR(11) NOT NULL,
    CONSTRAINT chk_tipo_direccion CHECK (tipo_dir IN ('Facturacion','Envio')),
    FOREIGN KEY (email) REFERENCES comprador(email)
);


CREATE TABLE comprador_telefono (
    email VARCHAR(50) PRIMARY KEY,
    telefono VARCHAR(18) NOT NULL,
    FOREIGN KEY (email) REFERENCES comprador(email),
    CONSTRAINT chk_comprador_telefono_format CHECK (telefono REGEXP '^[0-9]{7,15}$')
);

CREATE TABLE comprador_metodos_pago (
    id_tarjeta INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(50) NOT NULL,   
    nom_titular VARCHAR(50) NOT NULL,
    numero VARCHAR(20) NOT NULL,
    fecha_ven DATE NOT NULL,
    codigo_seg CHAR(4) NOT NULL,
    FOREIGN KEY (email) REFERENCES comprador(email)
);

CREATE TABLE vendedor (
    email VARCHAR(50) PRIMARY KEY,
    razon_social VARCHAR(50) NOT NULL,
    password VARCHAR (255) NOT NULL,
    fecha_registro DATETIME NOT NULL, 
    nombre VARCHAR(30) NOT NULL,
    apellido VARCHAR(30) NOT NULL,
    fecha_nac DATE NOT NULL, 
    CONSTRAINT chk_vendedor_email_format CHECK (email LIKE '%_@__%.__%')
);

CREATE TABLE usuario_ven (
	id_usu_ven INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(50),
    FOREIGN KEY (email) REFERENCES vendedor(email)
);

CREATE TABLE usuario_comprador (
    id_usu_com INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(50),
    FOREIGN KEY (email) REFERENCES comprador(email)
) AUTO_INCREMENT=1000;


CREATE TABLE productos (
    sku INT AUTO_INCREMENT PRIMARY KEY,
    id_usu_ven INT,
    nombre VARCHAR(100) NOT NULL,
    precio DECIMAL(10, 2) CHECK (precio > 0),
    origen ENUM('Nacional', 'Internacional'),
    stock int not null check (stock > 0),
    descripcion TEXT,
    estado ENUM('Nuevo', 'Usado'),
    oferta ENUM('Si', 'No'),
    activo TINYINT(1) DEFAULT 1 CHECK (activo IN (0, 1)),
    id_cat INT,
    id_subcat INT,
    FOREIGN KEY (id_cat) REFERENCES categorias(id_categoria) ON DELETE SET NULL,
    FOREIGN KEY (id_subcat) REFERENCES subcategorias(id) ON DELETE SET NULL,
    FOREIGN KEY (id_usu_ven) REFERENCES usuario_ven(id_usu_ven)
) AUTO_INCREMENT=4500;



CREATE TABLE categorias (
    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50),
    descripcion TEXT
);

CREATE TABLE subcategorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL UNIQUE,
    id_categoria INT,
    FOREIGN KEY (id_categoria) REFERENCES categorias(id_categoria) ON DELETE CASCADE
);

CREATE TABLE producto_imagenes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    producto_sku INT,
    imagen_url VARCHAR(1000) NOT NULL,
    FOREIGN KEY (producto_sku) REFERENCES productos(sku) ON DELETE CASCADE
);

CREATE TABLE favoritos (
    sku int,
    id_usuario INT, 
    PRIMARY KEY (sku, id_usuario),
    FOREIGN KEY (sku) REFERENCES productos(sku),
    FOREIGN KEY (id_usuario) REFERENCES usuario_comprador(id_usu_com)
);

CREATE TABLE vendedorSesion (
    id_session_vendedor INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(50),
    fecha_ini_ses DATETIME NOT NULL,
    FOREIGN KEY (email) REFERENCES vendedor(email)
);

CREATE TABLE sesionCliente (
    id_session INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(50),
    fecha_ini_ses DATETIME NOT NULL,
    FOREIGN KEY (email) REFERENCES cliente(email)
);

CREATE TABLE carrito (
    id_carrito INT AUTO_INCREMENT PRIMARY KEY,
    fecha_gen DATETIME NOT NULL,
    sku_prod int,
    id_usu_com int,
    id_usu_ven int,
    cantidad INT NOT NULL CHECK (cantidad > 0),
    titulo VARCHAR (100),
    precio_prod DECIMAL(10, 2) CHECK (precio_prod > 0),
    FOREIGN KEY (id_usu_ven) REFERENCES usuario_ven(id_usu_ven),
    FOREIGN KEY (sku_prod) REFERENCES productos(sku),
    FOREIGN KEY (id_usu_com) REFERENCES usuario_comprador(id_usu_com)
)AUTO_INCREMENT = 7000;

ALTER TABLE carrito 
ADD COLUMN is_deleted BOOLEAN DEFAULT FALSE;

CREATE TABLE vendedor_telefono (
    email VARCHAR(50),
    telefono VARCHAR(18),
    PRIMARY KEY (email,telefono),
    FOREIGN KEY (email) REFERENCES vendedor(email),
    CONSTRAINT chk_vendedor_telefono_format CHECK (telefono REGEXP '^[0-9]{7,15}$')
);

CREATE TABLE vendedor_direccion (
    id_direccion INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(50) NOT NULL,
    calle_pri VARCHAR(50),
    calle_sec VARCHAR(50),
    num_puerta VARCHAR(5),
    ciudad VARCHAR(30),
    pais VARCHAR(30),
    FOREIGN KEY (email) REFERENCES vendedor(email)
);

CREATE TABLE ofertas_especiales (
    id_oferta INT AUTO_INCREMENT PRIMARY KEY,
    descuento DECIMAL(5, 2) CHECK (descuento BETWEEN 0 AND 100),
    nombre_evento VARCHAR(100),
    descripcion TEXT,
    fecha_inicio DATE,
    fecha_fin DATE,
    CONSTRAINT chk_ofertas_fechas CHECK (fecha_inicio < fecha_fin)
);

CREATE TABLE medio_pago (
    id_pago INT AUTO_INCREMENT PRIMARY KEY,
    monto_total DECIMAL(10, 2) CHECK (monto_total > 0),
    estado ENUM('Pendiente', 'Completado', 'Cancelado') DEFAULT 'Pendiente',
    tipo_pago VARCHAR(30),
    nombre_met_pago VARCHAR(30)
);

CREATE TABLE confirmar_compra (
    id_usu_com INT,
    id_usu_ven INT,
    id_pago INT,
    fecha_confirmacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    estado_confirmacion ENUM('Pendiente', 'Confirmado', 'Cancelado'),
    cupon_desc VARCHAR(50),
    PRIMARY KEY (id_usu_com, id_usu_ven, id_pago),
    FOREIGN KEY (id_usu_com) REFERENCES carrito(id_usu_com),
    FOREIGN KEY (id_usu_ven) REFERENCES carrito(id_usu_ven),
    FOREIGN KEY (id_pago) REFERENCES medio_pago(id_pago)
);

-- DONE HASTA ACÁ



CREATE TABLE pertenece (
    sku VARCHAR(50),
    id_categoria INT,
    PRIMARY KEY (sku,id_categoria),
    FOREIGN KEY (sku) REFERENCES producto(sku),
    FOREIGN KEY (id_categoria) REFERENCES categoria(id_categoria)
);

CREATE TABLE asigna_item_stock (
    id_pago INT,
    sku VARCHAR(50),
    codigo VARCHAR(100),
    PRIMARY KEY (id_pago,sku,codigo),
    FOREIGN KEY (sku) REFERENCES producto(sku),
    FOREIGN KEY (id_pago) REFERENCES medio_pago(id_pago)
);

CREATE TABLE comenta (
    id_comentario INT AUTO_INCREMENT PRIMARY KEY,
    sku VARCHAR(50),
    texto TEXT,
    fecha DATETIME,
    puntuacion INT CHECK (puntuacion BETWEEN 0 AND 5),
    id_usu_com INT,
    estado VARCHAR(50),
    FOREIGN KEY (sku) REFERENCES producto(sku),
    FOREIGN KEY (id_usu_com) REFERENCES usuario_comprador(id_usu_com)
);

CREATE TABLE ofrece (
    id_usu_ven INT,
    id_oferta INT,
    PRIMARY KEY(id_usu_ven,id_oferta),
    FOREIGN KEY (id_usu_ven) REFERENCES usuario_ven(id_usu_ven),
    FOREIGN KEY (id_oferta) REFERENCES ofertas_especiales(id_oferta)
);

CREATE TABLE factura (
    num_factura INT AUTO_INCREMENT PRIMARY KEY,
    id_usu_com INT,
    FOREIGN KEY (id_usu_com) REFERENCES usuario_comprador(id_usu_com)
);

CREATE TABLE detalle_factura (
    num_factura INT,
    renglon INT,
    id_pago INT,
    sku VARCHAR(50),
    cantidad INT NOT NULL CHECK (cantidad > 0),
    UNIQUE (num_factura, sku),
    PRIMARY KEY (num_factura,renglon),
    FOREIGN KEY (sku) REFERENCES producto(sku),
    FOREIGN KEY (num_factura) REFERENCES factura(num_factura),
    FOREIGN KEY (id_pago) REFERENCES medio_pago(id_pago)
);

CREATE TABLE entrega (
    id_pickup INT AUTO_INCREMENT PRIMARY KEY,
    id_pago INT,
    FOREIGN KEY (id_pago) REFERENCES medio_pago(id_pago)
);
CREATE TABLE vehiculo (
    id_vehiculo INT AUTO_INCREMENT PRIMARY KEY,
    tipo VARCHAR(30),
    modelo VARCHAR(30),
    marca VARCHAR(30),
    huella_carbono DECIMAL(10, 2),
    tipo_combustible VARCHAR(50),
    capacidad INT,
    estado VARCHAR(50)
);

CREATE TABLE retiro (
    id_pickup INT,
    direccion VARCHAR(255) NOT NULL,
    telefono VARCHAR(15) NOT NULL,
    fecha DATE NOT NULL,
    hora TIME NOT NULL,
	PRIMARY KEY (id_pickup),
    FOREIGN KEY (id_pickup) REFERENCES pickup_center(id_pickup)
);

CREATE TABLE envio (
    id_envio INT AUTO_INCREMENT PRIMARY KEY,
    id_pickup INT,
    id_vehiculo INT,
    fecha_entrega DATE,
    fecha_salida DATE,
    distancia DECIMAL(10, 2),
    estado_envio ENUM('Ingresado','En Transito','Entregado','Rechazado','No Entregado - No Atienden')NOT NULL,
    FOREIGN KEY (id_pickup) REFERENCES pickup_center(id_pickup)
);

CREATE TABLE transporta (
    id_envio INT,
    id_vehiculo INT,
    PRIMARY KEY (id_envio,id_vehiculo),
    FOREIGN KEY (id_envio) REFERENCES envio(id_envio),
    FOREIGN KEY (id_vehiculo) REFERENCES vehiculo(id_vehiculo)
);

CREATE TABLE visitado (
    id_vehiculo INT,
    id_usu_com INT,
    fecha DATE,
    hora TIME,
    estado ENUM('Ingresado','En Transito','Entregado','Rechazado','No Entregado - No Atienden'),
    latitud DECIMAL(9, 6),
    longitud DECIMAL(9, 6),
	PRIMARY KEY (id_vehiculo,id_usu_com),
    FOREIGN KEY (id_vehiculo) REFERENCES vehiculo(id_vehiculo),
    FOREIGN KEY (id_usu_com) REFERENCES usuario_comprador(id_usu_com)
);

















-- 

CREATE TABLE genera (
    id_usu_com INT,
    sku VARCHAR(50),
    id_carrito INT,
    PRIMARY KEY (id_usu_com,sku,id_carrito),
    FOREIGN KEY (id_carrito) REFERENCES carrito(id_carrito),
    FOREIGN KEY (sku) REFERENCES producto(sku),
    FOREIGN KEY (id_usu_com) REFERENCES usuario_comprador(id_usu_com)
);

-- 