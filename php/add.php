<?php
session_start();

 extract($_POST);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_codigo'])) {
      $DataJson = file_get_contents('../json/Articulos.json');
    $Data = json_decode($DataJson, true);
    if ($Data == null || count($Data) == 0) {
      die('Error al cargar los datos desde el archivo JSON.');
    }

      $Data[$file]['codigo'] = $codigo;
     
      file_put_contents('../json/Articulos.json', json_encode($Data));
} 


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {


  $cart_item = [
    'file' => $file,
    'codigo' => $codigo,
    'cantidad' => $cantidad,
    'comentario' => $comentario,
  ];


  $buscar = buscarElementoPorCodigo($file);
  

   if($buscar>=0){
    $_SESSION['cart'][$buscar] = $cart_item;
    $msj = 'Producto Modificado correctamente';
    
  }else{
    $_SESSION['cart'][] = $cart_item;
    $msj = 'Producto agregado correctamente';
  }


  $response = [
    'success' => true,
    'message' =>  $msj,
    'scrollPosition' => isset($_POST['scrollPosition']) ? (int)$_POST['scrollPosition'] : 0,
    ];

    header('Content-Type: application/json');
    echo json_encode($response);  
}
/* 
$scrollPosition = isset($_POST['scrollPosition']) ? (int)$_POST['scrollPosition'] : 0;
header("Location: ./#$scrollPosition");
 */


function buscarElementoPorCodigo($codigo_buscar) {
  foreach ( $_SESSION['cart'] as $posicion => $item) {
      if ($item['file'] == $codigo_buscar) {
          return  $posicion;
      }
  }
  return -1; 
}
?>