<?php
namespace Api\Models;

class Cuota {
    private $id;
    private $monto;
    private $recargo;
    private $mes;
    private $anio;

    public function __construct($id = null, $monto = null, $recargo = null, $mes = null, $anio = null) {
        $this->id = $id;
        $this->monto = $monto;
        $this->recargo = $recargo;
        $this->mes = $mes;
        $this->anio = $anio;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getMonto() {
        return $this->monto;
    }

    public function getRecargo() {
        return $this->recargo;
    }

    public function getMes() {
        return $this->mes;
    }

    public function getAnio() {
        return $this->anio;
    }

    // Setters
    public function setMonto($monto) {
        $this->monto = $monto;
    }

    public function setRecargo($recargo) {
        $this->recargo = $recargo;
    }

    public function setMes($mes) {
        $this->mes = $mes;
    }

    public function setAnio($anio) {
        $this->anio = $anio;
    }
} 