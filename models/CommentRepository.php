<?php
class CommentRepository {

    public static function getCommentsByPostId($post_id) {
        $db = Connection::connect();
        $q = "SELECT c.*, u.username 
            FROM comentarios c 
            INNER JOIN user u ON c.user_id = u.id 
            WHERE c.post_id = " . intval($post_id) . " 
            ORDER BY c.fecha_creacion ASC";
        $result = $db->query($q);
        $comments = array();
        while ($row = $result->fetch_assoc()) {
            $comments[] = new Comment(
                $row['id'], 
                $row['texto'], 
                $row['post_id'], 
                $row['user_id'], 
                $row['fecha_creacion'],
                $row['username']
            );
        }
        return $comments;
    }

    public static function addComment($texto, $post_id, $user_id) {
        $db = Connection::connect();
        $texto = $db->real_escape_string($texto);
        $post_id = intval($post_id);
        $user_id = intval($user_id);
        
        $q = "INSERT INTO comentarios (texto, post_id, user_id) 
            VALUES ('" . $texto . "', " . $post_id . ", " . $user_id . ")";
        
        if ($result = $db->query($q))
            return $db->insert_id;
        else
            return false;
    }

    public static function deleteComment($id, $user_id) {
        $db = Connection::connect();
        $q = 'DELETE FROM comentarios WHERE id=' . intval($id) . ' AND user_id=' . intval($user_id);
        return $db->query($q);
    }

    public static function deleteCommentAdmin($id) {
        $db = Connection::connect();
        $q = 'DELETE FROM comentarios WHERE id=' . intval($id);
        return $db->query($q);
    }
}
?>
