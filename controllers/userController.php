<?php
ob_start();

// --- 1. Lógica de Logout ---
if(isset($_GET['logout'])){
    $_SESSION['user'] = false;
    session_destroy();
    header('Location: index.php');
    ob_end_flush();
    exit;
}

// --- 2. Lógica de Login (intento de login) ---
if(isset($_POST['username']) && isset($_POST['password'])){
    // ... Tu lógica de consulta y verificación de credenciales ...
    $q = 'SELECT * FROM user WHERE username="'.$_POST['username'].'" AND password="'.md5($_POST['password']).'"';
    $result = $db->query($q);

    if($row = $result->fetch_assoc()){
        $_SESSION['user'] = new User($row['id'], $row['username']);
        session_write_close();
        header('Location: index.php?c=post&action=create'); // Redirige tras login exitoso
        ob_end_flush();
        exit;
    }
}

// --- 3. Verificación de Sesión Activa (redirige si ya está logueado) ---
if(isset($_SESSION['user']) && is_object($_SESSION['user'])){
    header('Location: index.php?c=post&action=create');
    ob_end_flush();
    exit;
}

// --- 4. Lógica de la Vista Principal ---

/*
 * En este punto, sabemos que:
 * - No se intentó hacer logout.
 * - Si se intentó hacer login, falló.
 * - El usuario NO tiene una sesión activa.
 */

// Si no hay sesión, se muestra la vista de Login.
// Aquí es donde puedes agregar tu lógica si quieres mostrar blogView.phtml
// en lugar de loginView.phtml cuando no hay sesión.

if(!isset($_SESSION['user']) || !is_object($_SESSION['user'])){
    // Si no hay sesión activa, podrías elegir entre mostrar el blog o el formulario de login.
    // Si queremos el blog como vista por defecto para no logueados:
    // require_once('views/blogView.phtml');
    // Si queremos el formulario de login:
    require_once('views/createPost.phtml'); // Tu línea original

    // Si quieres que el código *siempre* muestre el blog si no está logueado, reemplaza el require_once anterior.
    // **OPCIÓN A: Reemplazar el login por el blog (si NO hay sesión)**
    // require_once('views/blogView.phtml');

    // **OPCIÓN B: Mostrar el blog DESPUÉS del login/fallido, pero ANTES del exit final (NO RECOMENDADO si loginView.phtml es el objetivo)**
    // Las líneas originales que querías mantener/incluir:
    /*
    if(!$_SESSION['user'] || !is_object($_SESSION['user'])){
        require_once('views/blogView.phtml');
        exit;
    }
    */
}


// El código original terminaba mostrando la vista de login y terminando.
require_once('views/loginView.phtml'); // Esta línea es de tu código original
ob_end_flush();
exit;

// Las líneas que querías incluir están aquí, fuera del flujo principal, y nunca se ejecutan.
/*
if(!$_SESSION['user'] || !is_object($_SESSION['user'])){
    require_once('views/blogView.phtml');
    exit;
}
*/
?>