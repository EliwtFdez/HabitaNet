-- Crear base de datos
CREATE DATABASE IF NOT EXISTS residencias;
USE residencias;

-- Tabla de usuarios
--LISTO CONTROLLER Y AGREGADO A LA API
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    rol ENUM('inquilino', 'comite') NOT NULL,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de casas
CREATE TABLE casas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    numero_casa VARCHAR(10) NOT NULL UNIQUE,
    id_inquilino INT,
    FOREIGN KEY (id_inquilino) REFERENCES usuarios(id)
);

-- Tabla de cuotas 
CREATE TABLE cuotas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    monto DECIMAL(10,2) NOT NULL DEFAULT 650.00,
    recargo DECIMAL(10,2) NOT NULL DEFAULT 50.00,
    mes TINYINT NOT NULL CHECK (mes BETWEEN 1 AND 12),
    anio INT NOT NULL CHECK (anio >= 2020)
);

-- Tabla de pagos
CREATE TABLE pagos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    id_casa INT NOT NULL,
    fecha_pago DATE NOT NULL,
    monto DECIMAL(10,2) NOT NULL,
    recargo_aplicado BOOLEAN NOT NULL DEFAULT FALSE,
    concepto VARCHAR(255) NOT NULL,
    comprobante_pago VARCHAR(255),
    confirmado_por INT,
    fecha_confirmacion DATETIME,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id),
    FOREIGN KEY (id_casa) REFERENCES casas(id),
    FOREIGN KEY (confirmado_por) REFERENCES usuarios(id)
);

-- Tabla de egresos
CREATE TABLE egresos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fecha DATE NOT NULL,
    monto DECIMAL(10,2) NOT NULL,
    motivo TEXT,
    pagado_a VARCHAR(100),
    registrado_por INT,
    FOREIGN KEY (registrado_por) REFERENCES usuarios(id)
);

-- Tabla de solicitudes de servicios
CREATE TABLE solicitudes_servicios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    tipo ENUM('alberca', 'palapa', 'mantenimiento') NOT NULL,
    fecha_solicitud DATE NOT NULL,
    comentario TEXT,
    estatus ENUM('pendiente', 'atendido', 'rechazado') DEFAULT 'pendiente',
    respuesta TEXT,
    fecha_respuesta DATE,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
);

-- Tabla de mensajes del foro
CREATE TABLE mensajes_foro (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    mensaje TEXT NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    visible BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
);
