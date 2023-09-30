<?php

use function Laravel\Prompts\alert;

    session_start();

   

    $key = $_SESSION['key'];
    $_SESSION['enviado'] = true;

    if (count($_SESSION['cart']) == 0) {
      $_SESSION['error2'] = 'Hubo un error en su pedido, no tiene artículos. Último pedido: ' . $_SESSION['ultimoPedido'];
      header("Location: ./");

    

    exit;
  }


    foreach ($_SESSION['cart'] as $item) {

        $newItem = [
            'file' => $item['file'],
            'codigo' => $item['codigo'],
            'cantidad' => $item['cantidad'],
            'comentario' => $item['comentario'],
        ];

        $jsonData[] = $newItem;
        
      } 
    

    $DataJson = file_get_contents('Pedidos.json');

    $Data = json_decode($DataJson, true);
    if ($Data == null || count($Data) == 0) {
      die('Error al cargar los datos desde el archivo JSON.');
    }

    $Data[] = ["key"=>$key, "data"=> $jsonData  ];


   


    $pedidos = array_keys($Data);
    $ultimoPedido = end($pedidos);
   
    $_SESSION['pedido'] = $ultimoPedido;

    


    $host = $_SERVER['HTTP_HOST'];
    $dir = dirname($_SERVER['REQUEST_URI']);

    $whatsappMessage = "Este es mi pedido No. $ultimoPedido \n Puedes acceder aqui --> http://".$host.$dir."pedidos.php?p=$ultimoPedido&key=$key \n Mi nombre es: ";
    $whatsappLink = 'https://wa.me/18098892235/?text=' . urlencode($whatsappMessage);

    $_SESSION['whatsapp_link_reenviar'] = $whatsappLink;



    file_put_contents('Pedidos.json', json_encode($Data));

    if($_SESSION['ultimoPedido'] !=  $ultimoPedido){
      $_SESSION['error'] = 'Huvo un error en su pedido, favor envíalo otra vez'.$_SESSION['ultimoPedido'].'---'.$ultimoPedido;
    }

   
  
      

    header("Location: ./");

    

    exit;
 


