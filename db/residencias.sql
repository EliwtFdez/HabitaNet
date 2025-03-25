-- Admin table with additional fields for enhanced security and management
CREATE TABLE Admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    last_login DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    is_active BOOLEAN DEFAULT TRUE,
    role ENUM('superadmin', 'admin', 'manager') DEFAULT 'admin'
);

-- Casas (Houses) table with more detailed information
CREATE TABLE Casas (
    IdCasa INT AUTO_INCREMENT PRIMARY KEY,
    NumeroCasa VARCHAR(10) NOT NULL UNIQUE,
    Direccion VARCHAR(255),
    MetrosCuadrados DECIMAL(10, 2),
    AñoConstruccion INT,
    TipoVivienda ENUM('Unifamiliar', 'Departamento', 'Duplex', 'Otro') DEFAULT 'Otro'
);

-- Residentes (Residents) table with expanded personal information
CREATE TABLE Residentes (
    IdResidente INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(100) NOT NULL,
    ApellidoPaterno VARCHAR(50) NOT NULL,
    ApellidoMaterno VARCHAR(50),
    Email VARCHAR(100) UNIQUE,
    Telefono VARCHAR(20),
    FechaNacimiento DATE,
    IdCasa INT,
    FechaIngreso DATE DEFAULT CURRENT_DATE,
    FOREIGN KEY (IdCasa) REFERENCES Casas(IdCasa)
);

-- Cuotas (Fees) table with more comprehensive fee tracking
CREATE TABLE Cuotas (
    IdCuota INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(100) NOT NULL,
    Descripcion TEXT,
    Monto DECIMAL(10, 2) NOT NULL,
    FrecuenciaPago ENUM('Mensual', 'Trimestral', 'Anual', 'Unica') DEFAULT 'Mensual',
    FechaInicio DATE,
    FechaFin DATE,
    Activo BOOLEAN DEFAULT TRUE
);

-- Pagos (Payments) table with enhanced payment tracking
CREATE TABLE Pagos (
    IdPago INT AUTO_INCREMENT PRIMARY KEY,
    IdResidente INT,
    IdCuota INT,
    FechaPago DATE,
    MontoPagado DECIMAL(10, 2),
    MetodoPago ENUM('Efectivo', 'Transferencia', 'Tarjeta', 'Otro') DEFAULT 'Otro',
    Comprobante VARCHAR(255),
    Estado ENUM('Pendiente', 'Pagado', 'Parcial', 'Vencido') DEFAULT 'Pendiente',
    FOREIGN KEY (IdResidente) REFERENCES Residentes(IdResidente),
    FOREIGN KEY (IdCuota) REFERENCES Cuotas(IdCuota)
);

-- Additional index for performance optimization
CREATE INDEX idx_residente_casa ON Residentes(IdCasa);
CREATE INDEX idx_pago_residente ON Pagos(IdResidente);
CREATE INDEX idx_pago_cuota ON Pagos(IdCuota);