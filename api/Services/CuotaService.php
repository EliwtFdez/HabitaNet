<?php

namespace Api\Services;

use PDO;
require_once __DIR__ . '/../Models/Cuota.php';
require_once __DIR__ . '/../Core/Conexion.php';

class CuotaService {
    private $db;

    public function __construct() {
        $this->db = \Api\Core\Conexion::conectar();
    }

    public function crearCuota($monto, $recargo, $mes, $anio) {
        // Validación básica de tipos y rangos
        if (!is_numeric($mes) || $mes < 1 || $mes > 12 || floor($mes) != $mes) {
            throw new \InvalidArgumentException("El mes debe ser un entero entre 1 y 12.");
        }
        if (!is_numeric($anio) || $anio < 2020 || floor($anio) != $anio) {
            throw new \InvalidArgumentException("El año debe ser un entero mayor o igual a 2020.");
        }
        if (!is_numeric($monto) || $monto < 0) {
             throw new \InvalidArgumentException("El monto debe ser un número positivo.");
        }
         if (!is_numeric($recargo) || $recargo < 0) {
             throw new \InvalidArgumentException("El recargo debe ser un número positivo.");
        }


        $stmt = $this->db->prepare("INSERT INTO cuotas (monto, recargo, mes, anio) VALUES (?, ?, ?, ?)");
        // Asegurarse de que se insertan como enteros
        $stmt->execute([$monto, $recargo, (int)$mes, (int)$anio]);
        return $this->db->lastInsertId();
    }

    public function obtenerCuota($id) {
        $stmt = $this->db->prepare("SELECT * FROM cuotas WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            // Asegúrate que el modelo Cuota y su constructor coinciden con los campos de la BD
            return new \Api\Models\Cuota(
                $result['id'],
                $result['monto'],
                $result['recargo'],
                $result['mes'],
                $result['anio']
            );
        }
        // Si no se encuentra la cuota, devuelve null. El controlador debería manejar esto.
        return null;
    }

    public function actualizarCuota($id, $monto, $recargo, $mes, $anio) {
         // Validación básica de tipos y rangos
        if (!is_numeric($mes) || $mes < 1 || $mes > 12 || floor($mes) != $mes) {
            throw new \InvalidArgumentException("El mes debe ser un entero entre 1 y 12.");
        }
        if (!is_numeric($anio) || $anio < 2020 || floor($anio) != $anio) {
            throw new \InvalidArgumentException("El año debe ser un entero mayor o igual a 2020.");
        }
         if (!is_numeric($monto) || $monto < 0) {
             throw new \InvalidArgumentException("El monto debe ser un número positivo.");
        }
         if (!is_numeric($recargo) || $recargo < 0) {
             throw new \InvalidArgumentException("El recargo debe ser un número positivo.");
        }

        $stmt = $this->db->prepare("UPDATE cuotas SET monto = ?, recargo = ?, mes = ?, anio = ? WHERE id = ?");
        // Asegurarse de que se actualizan como enteros
        return $stmt->execute([$monto, $recargo, (int)$mes, (int)$anio, $id]);
    }

    public function eliminarCuota($id) {
        $stmt = $this->db->prepare("DELETE FROM cuotas WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function obtenerTodasLasCuotas() {
        $stmt = $this->db->query("SELECT * FROM cuotas");
        $cuotas = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $cuotas[] = new \Api\Models\Cuota(
                $row['id'],
                $row['monto'],
                $row['recargo'],
                $row['mes'],
                $row['anio']
            );
        }
        return $cuotas;
    }

    public function obtenerCuotaPorMesAnio($mes, $anio) {
        // Validación básica de tipos y rangos
        if (!is_numeric($mes) || $mes < 1 || $mes > 12 || floor($mes) != $mes) {
            throw new \InvalidArgumentException("El mes debe ser un entero entre 1 y 12.");
        }
        if (!is_numeric($anio) || $anio < 2020 || floor($anio) != $anio) {
            throw new \InvalidArgumentException("El año debe ser un entero mayor o igual a 2020.");
        }

        $stmt = $this->db->prepare("SELECT * FROM cuotas WHERE mes = ? AND anio = ?");
        // Asegurarse de que se usan enteros en la consulta
        $stmt->execute([(int)$mes, (int)$anio]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            return new \Api\Models\Cuota(
                $result['id'],
                $result['monto'],
                $result['recargo'],
                $result['mes'], // Ya viene como entero de la BD
                $result['anio']  // Ya viene como entero de la BD
            );
        }
        return null;
    }
}