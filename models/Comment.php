<?php
class Comment {
    private $id;
    private $texto;
    private $post_id;
    private $user_id;
    private $fecha_creacion;
    private $username;

    public function __construct($id, $texto, $post_id, $user_id, $fecha_creacion, $username = null) {
        $this->id = $id;
        $this->texto = $texto;
        $this->post_id = $post_id;
        $this->user_id = $user_id;
        $this->fecha_creacion = $fecha_creacion;
        $this->username = $username;
    }

    public function getId() {
        return $this->id;
    }

    public function getTexto() {
        return $this->texto;
    }

    public function getPostId() {
        return $this->post_id;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function getFechaCreacion() {
        return $this->fecha_creacion;
    }

    public function getUsername() {
        return $this->username;
    }
}
?>
