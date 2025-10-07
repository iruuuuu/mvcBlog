<?php

class UserRepository {
    public static function login($username,$password){
        if(isset($_POST['username']) && isset($_POST['password'])){
    // ... Tu lógica de consulta y verificación de credenciales ...
    $q = 'SELECT * FROM user WHERE username="'.$_POST['username'].'" AND password="'.md5($_POST['password']).'"';
            $db = Connection::connect();
    $result = $db->query($q);

    if($row = $result->fetch_assoc()){
        $_SESSION['user'] = new User($row['id'], $row['username']);
        session_write_close();
        header('Location: index.php?c=post&action=create'); // Redirige tras login exitoso
        ob_end_flush();
        exit;
    }
}
    }
public static function register($username, $password, $password2) {
    
    // 1. **Verificación de Contraseñas**
    if ($password !== $password2) {
        // Devuelve false si las contraseñas no coinciden.
        return false;
    }

    // 2. **Seguridad: Hashear la Contraseña**
    // Usa el algoritmo bcrypt por defecto, que es seguro.
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    try {
        // 3. **Conexión a la DB** (Asume que Connection::connect() devuelve un objeto PDO)
        $db = Connection::connect();

        // 4. **Consulta Segura (Sentencia Preparada)**
        // Se usa '?' como placeholders para el username y el password hasheado.
        // Asume que tu tabla de usuarios se llama 'user'.
        $sql = "INSERT INTO user (username, password) VALUES (?, ?)";

        // 5. **Preparar y Ejecutar la Consulta**
        $stmt = $db->prepare($sql);
        // Pasa los valores de forma segura; los placeholders se llenan aquí.
        $result = $stmt->execute([$username, $hashedPassword]);

        // Devuelve el resultado de la ejecución (true en éxito, false en fallo).
        return $result;

    } catch (PDOException $e) {
        // Manejo de errores de base de datos (ej: el usuario ya existe)
        // Puedes loguear el error aquí.
        // error_log("Error de registro: " . $e->getMessage()); 
        return false;
    }
}

}