<?php
namespace Api\Models;

class Casa {
    private $id;
    private $numero_casa;
    private $id_inquilino;

    public function __construct($id = null, $numero_casa = null, $id_inquilino = null) {
        $this->id = $id;
        $this->numero_casa = $numero_casa;
        $this->id_inquilino = $id_inquilino;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getNumeroCasa() {
        return $this->numero_casa;
    }

    public function getIdInquilino() {
        return $this->id_inquilino;
    }

    // Setters
    public function setNumeroCasa($numero_casa) {
        $this->numero_casa = $numero_casa;
    }

    public function setIdInquilino($id_inquilino) {
        $this->id_inquilino = $id_inquilino;
    }
} 