<?php
namespace Api\Models;

class Pago {
    private $id;
    private $id_usuario;
    private $id_casa;
    private $fecha_pago;
    private $monto;
    private $recargo_aplicado;
    private $concepto;
    private $comprobante_pago;
    private $confirmado_por;
    private $fecha_confirmacion;

    public function __construct(
        $id = null,
        $id_usuario = null,
        $id_casa = null,
        $fecha_pago = null,
        $monto = null,
        $recargo_aplicado = false,
        $concepto = null,
        $comprobante_pago = null,
        $confirmado_por = null,
        $fecha_confirmacion = null
    ) {
        $this->id = $id;
        $this->id_usuario = $id_usuario;
        $this->id_casa = $id_casa;
        $this->fecha_pago = $fecha_pago;
        $this->monto = $monto;
        $this->recargo_aplicado = $recargo_aplicado;
        $this->concepto = $concepto;
        $this->comprobante_pago = $comprobante_pago;
        $this->confirmado_por = $confirmado_por;
        $this->fecha_confirmacion = $fecha_confirmacion;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getIdUsuario() {
        return $this->id_usuario;
    }

    public function getIdCasa() {
        return $this->id_casa;
    }

    public function getFechaPago() {
        return $this->fecha_pago;
    }

    public function getMonto() {
        return $this->monto;
    }

    public function getRecargoAplicado() {
        return $this->recargo_aplicado;
    }

    public function getConcepto() {
        return $this->concepto;
    }

    public function getComprobantePago() {
        return $this->comprobante_pago;
    }

    public function getConfirmadoPor() {
        return $this->confirmado_por;
    }

    public function getFechaConfirmacion() {
        return $this->fecha_confirmacion;
    }

    // Setters
    public function setIdUsuario($id_usuario) {
        $this->id_usuario = $id_usuario;
    }

    public function setIdCasa($id_casa) {
        $this->id_casa = $id_casa;
    }

    public function setFechaPago($fecha_pago) {
        $this->fecha_pago = $fecha_pago;
    }

    public function setMonto($monto) {
        $this->monto = $monto;
    }

    public function setRecargoAplicado($recargo_aplicado) {
        $this->recargo_aplicado = $recargo_aplicado;
    }

    public function setConcepto($concepto) {
        $this->concepto = $concepto;
    }

    public function setComprobantePago($comprobante_pago) {
        $this->comprobante_pago = $comprobante_pago;
    }

    public function setConfirmadoPor($confirmado_por) {
        $this->confirmado_por = $confirmado_por;
    }

    public function setFechaConfirmacion($fecha_confirmacion) {
        $this->fecha_confirmacion = $fecha_confirmacion;
    }
} 