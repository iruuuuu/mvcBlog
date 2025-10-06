<?php
class Post {
    private $id;
    private $title;
    private $created_at;
    private $text;
    private $author;
    private $user_id;

    public function __construct($id, $title, $created_at, $text, $author, $user_id) {
        $this->id = $id;
        $this->title = $title;
        $this->created_at = $created_at;
        $this->text = $text;
        $this->author = $author;
        $this->user_id = $user_id;
    }

    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getCreatedAt() {
        return $this->created_at;
    }

    public function getText() {
        return $this->text;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function getUserId() {
        return $this->user_id;
    }
}
?>
