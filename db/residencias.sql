CREATE TABLE Casas (
    IdCasa INT AUTO_INCREMENT PRIMARY KEY,
    NumeroCasa VARCHAR(10) NOT NULL
);

CREATE TABLE Residentes (
    IdResidente INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(100) NOT NULL,
    IdCasa INT,
    FOREIGN KEY (IdCasa) REFERENCES Casas(IdCasa)
);

CREATE TABLE Cuotas (
    IdCuota INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(100) NOT NULL,
    Descripcion TEXT,
    Monto DECIMAL(10, 2) NOT NULL
);

CREATE TABLE Pagos (
    IdPago INT AUTO_INCREMENT PRIMARY KEY,
    IdResidente INT,
    IdCuota INT,
    FechaPago DATE,
    MontoPagado DECIMAL(10, 2),
    FOREIGN KEY (IdResidente) REFERENCES Residentes(IdResidente),
    FOREIGN KEY (IdCuota) REFERENCES Cuotas(IdCuota)
);
