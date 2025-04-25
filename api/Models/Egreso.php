<?php
namespace Api\Models;

class Egreso {
    private $id;
    private $fecha;
    private $monto;
    private $motivo;
    private $pagado_a;
    private $registrado_por;

    public function __construct(
        $id = null,
        $fecha = null,
        $monto = null,
        $motivo = null,
        $pagado_a = null,
        $registrado_por = null
    ) {
        $this->id = $id;
        $this->fecha = $fecha;
        $this->monto = $monto;
        $this->motivo = $motivo;
        $this->pagado_a = $pagado_a;
        $this->registrado_por = $registrado_por;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function getMonto() {
        return $this->monto;
    }

    public function getMotivo() {
        return $this->motivo;
    }

    public function getPagadoA() {
        return $this->pagado_a;
    }

    public function getRegistradoPor() {
        return $this->registrado_por;
    }

    // Setters
    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    public function setMonto($monto) {
        $this->monto = $monto;
    }

    public function setMotivo($motivo) {
        $this->motivo = $motivo;
    }

    public function setPagadoA($pagado_a) {
        $this->pagado_a = $pagado_a;
    }

    public function setRegistradoPor($registrado_por) {
        $this->registrado_por = $registrado_por;
    }
} 