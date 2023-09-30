<?php
// Inicializa la sesión (si no lo has hecho ya)
session_start();

// Inicializa una variable para contar los elementos en el carrito
$elementosEnCarrito = 0;
$cartContent = '';

// Verifica si existe la variable de sesión 'cart'
if (isset($_SESSION['cart']) && is_array($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
    // Si hay elementos en el carrito, incrementa la variable de conteo y genera el contenido HTML del carrito
    $elementosEnCarrito = count($_SESSION['cart']);

    // Inicializa una variable para el contenido del carrito
   
    foreach ($_SESSION['cart'] as $index => $item) {
       
        $cartContent .= '<tr id="fila' . $index . '">';
        $cartContent .= "<td  onclick='openModal(".json_encode($item).",'".$item['file'] ."')>". $item['codigo'].  "</td>";
        $cartContent .= '<td>' . $item['cantidad'] . '</td>';
        $cartContent .= '<td>' . $item['comentario'] . '</td>';
        $cartContent .= '<td>';
        $cartContent .= '<button type="button" class="btn btn-danger" onclick="eliminarFila(' . $index . ')">Eliminar</button>';
        $cartContent .= '</td>';
        $cartContent .= '</tr>';
    }
}

// Devuelve una respuesta JSON con el contenido del carrito y la cantidad de elementos en el carrito
 header('Content-Type: application/json'); 
echo json_encode(['cartContent' => $cartContent, 'elementosEnCarrito' => $elementosEnCarrito]); 
?>
