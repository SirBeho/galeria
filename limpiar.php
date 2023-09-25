<?php
session_start();

if(isset($_POST['eliminar'])){
  unset($_SESSION['cart']);
  unset($_SESSION['whatsapp_link']);
  unset($_SESSION['enviado']);

}else if (isset($_POST['continuar'])){


  unset($_SESSION['whatsapp_link']);
  unset($_SESSION['enviado']);

  



  $pedido = $_SESSION['pedido'];

  $DataJson = file_get_contents('Pedidos.json');

    $Data = json_decode($DataJson, true);
    if ($Data == null || count($Data) == 0) {
      die('Error al cargar los datos desde el archivo JSON.');
    }


    if (isset($Data[$pedido])) {
      unset($Data[$pedido]);
  }

  file_put_contents('Pedidos.json', json_encode($Data));

}

unset($_SESSION['error']);
unset($_SESSION['error2']);

 

   header("Location: ./");
   exit;

?>