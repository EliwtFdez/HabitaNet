<?php
namespace Api\Models;

class MensajeForo {
    private $id;
    private $id_usuario;
    private $mensaje;
    private $fecha;
    private $visible;

    public function __construct(
        $id = null,
        $id_usuario = null,
        $mensaje = null,
        $fecha = null,
        $visible = true
    ) {
        $this->id = $id;
        $this->id_usuario = $id_usuario;
        $this->mensaje = $mensaje;
        $this->fecha = $fecha;
        $this->visible = $visible;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getIdUsuario() {
        return $this->id_usuario;
    }

    public function getMensaje() {
        return $this->mensaje;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function getVisible() {
        return $this->visible;
    }

    // Setters
    public function setIdUsuario($id_usuario) {
        $this->id_usuario = $id_usuario;
    }

    public function setMensaje($mensaje) {
        $this->mensaje = $mensaje;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    public function setVisible($visible) {
        $this->visible = $visible;
    }
} 