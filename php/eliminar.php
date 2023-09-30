<?php
session_start();

if (isset($_POST['index'])) {
    $index = $_POST['index'];
    
    if (isset($_SESSION['cart'][$index])) {
        // Eliminamos el elemento correspondiente del arreglo de sesión
        unset($_SESSION['cart'][$index]);
        echo "OK"; // Enviamos una respuesta de éxito al cliente
    } else {
        echo "Error: El índice no existe en el arreglo de sesión.";
    }
} else {
    echo "Error: No se proporcionó un índice válido.";
}
?>