<?php
namespace Api\Models;

class SolicitudServicio {
    private $id;
    private $id_usuario;
    private $tipo;
    private $fecha_solicitud;
    private $comentario;
    private $estatus;
    private $respuesta;
    private $fecha_respuesta;

    public function __construct(
        $id = null,
        $id_usuario = null,
        $tipo = null,
        $fecha_solicitud = null,
        $comentario = null,
        $estatus = 'pendiente',
        $respuesta = null,
        $fecha_respuesta = null
    ) {
        $this->id = $id;
        $this->id_usuario = $id_usuario;
        $this->tipo = $tipo;
        $this->fecha_solicitud = $fecha_solicitud;
        $this->comentario = $comentario;
        $this->estatus = $estatus;
        $this->respuesta = $respuesta;
        $this->fecha_respuesta = $fecha_respuesta;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getIdUsuario() {
        return $this->id_usuario;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function getFechaSolicitud() {
        return $this->fecha_solicitud;
    }

    public function getComentario() {
        return $this->comentario;
    }

    public function getEstatus() {
        return $this->estatus;
    }

    public function getRespuesta() {
        return $this->respuesta;
    }

    public function getFechaRespuesta() {
        return $this->fecha_respuesta;
    }

    // Setters
    public function setIdUsuario($id_usuario) {
        $this->id_usuario = $id_usuario;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function setFechaSolicitud($fecha_solicitud) {
        $this->fecha_solicitud = $fecha_solicitud;
    }

    public function setComentario($comentario) {
        $this->comentario = $comentario;
    }

    public function setEstatus($estatus) {
        $this->estatus = $estatus;
    }

    public function setRespuesta($respuesta) {
        $this->respuesta = $respuesta;
    }

    public function setFechaRespuesta($fecha_respuesta) {
        $this->fecha_respuesta = $fecha_respuesta;
    }
} 