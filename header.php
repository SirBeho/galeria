<?php
session_start();

if (basename($_SERVER['REQUEST_URI']) === "index.php") {
  header("Location: ./");
  exit;
}

$ArticulosJson = file_get_contents('./json/Articulos.json');
$Articulos = json_decode($ArticulosJson, true);
if ($Articulos == null || count($Articulos) == 0) {
  die('Error al cargar los Productos desde el archivo JSON.');
}

$PedidosJson = file_get_contents('./json/Pedidos.json');
$Pedios = json_decode($PedidosJson, true);
if ($Pedios == null || count($Pedios) == 0) {
  die('Error al cargar los Pedidos desde el archivo JSON.');
}

if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = [];
}

if (!isset($_SESSION['key'])) {
  $_SESSION['key'] = bin2hex(random_bytes(10));
}
if (!isset($_SESSION['whatsapp_link_reenviar'])) {

  $_SESSION['whatsapp_link_reenviar'] = "#";
}



$pedidos = array_keys($Pedios);
$ultimoPedido = end($pedidos);
$ultimoPedido = $ultimoPedido + 1;

$_SESSION['ultimoPedido'] =   $ultimoPedido;
$key = $_SESSION['key'];

$host = $_SERVER['HTTP_HOST'];
$directory = $_SERVER['REQUEST_URI'];
$dir = dirname($_SERVER['REQUEST_URI']) . "/";

$whatsappMessage = "Este es mi pedido No. $ultimoPedido \n Puedes acceder aqui --> http://" . $host . $dir . "pedidos.php?p=$ultimoPedido&key=$key \n Mi nombre es: ";
$whatsappLink = 'https://wa.me/18296394721/?text=' . urlencode($whatsappMessage);

$_SESSION['whatsapp_link'] = $whatsappLink;

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Galeria de Fotos </title>
  <script src="./script.js" defer></script>
  <link rel="stylesheet" href="./css/style.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>






<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="./">Mundo del Cumpleaños</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="./">Home <span class="sr-only">(current)</span></a>
                </li>
                <!-- Puedes agregar más elementos de navegación aquí -->
            </ul>
        </div>

        <div class="btn btn-primary" id="openModalButton" style="display:flex;color:black;gap:4px" data-toggle="modal" data-target="#cartModal">
            <img src="./carrito.svg" alt="">
            <span id="cart-count" style="background: white;border-radius: 50%; width: 41px;text-align: center;">
                <?= count($_SESSION['cart']); ?>
            </span>
        </div>
    </div>
</nav>

 <!-- Modal de Carrito -->
<div class="modal fade" id="cartModal" tabindex="-1" role="dialog" aria-labelledby="cartModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cartModalLabel">Datos del Carrito</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Cantidad</th>
                            <th>Comentario</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody id="cart-container">
                    <?php
                    $cartData = $_SESSION['cart'];
                    foreach ($cartData as $index => $item) :
                    ?>
                      <tr id="fila<?= $index; ?>">
                        <td><a href="./detalle.php?f=<?= $item['file']; ?>"><?= $item['codigo']; ?></a></td>
                        <td><?= $item['cantidad']; ?></td>
                        <td><?= $item['comentario']; ?></td>
                        <td>
                          <button type="button" class="btn btn-danger" onclick="eliminarFila(<?= $index; ?>)">Eliminar</button>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <form id="formulario" action="./php/send.php" style="display: flex; justify-content: center;margin-top: 2rem;">
                    <a id="asumit" target="_blank" href="<?= $_SESSION['whatsapp_link']; ?>">Enviar</a>
                </form>
            </div>
        </div>
    </div>
</div>



<!-- Modal de Confirmación de Envío -->
<div class="modal fade" id="miModal" tabindex="-1" role="dialog" aria-labelledby="miModalLabel" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="miModalLabel">Confirmación de Envío</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php
                echo isset($_SESSION['error']) ? $_SESSION['error'] : (isset($_SESSION['error2']) ? $_SESSION['error2'] : "¿Se envió su pedido a través de WhatsApp?");
                ?>
            </div>
            <div class="modal-footer justify-content-between">
                <?php
                if (!isset($_SESSION['error']) && !isset($_SESSION['error2'])) {
                ?>
                <form action="./php/limpiar.php" method="post">
                    <button type="submit" name="eliminar" class="btn btn-success">Pedido exitoso</button>
                </form>
                <?php
                }
                ?>
                <form action="./php/limpiar.php" method="post">
                    <button type="submit" name="continuar" class="btn btn-secondary">Seguir añadiendo</button>
                </form>
                <?php
                if (!isset($_SESSION['error2'])) {
                ?>
                <form id="formresumit" action="./php/limpiar.php">
                    <a class="btn btn-primary" id="reenvia" href="<?php echo $_SESSION['whatsapp_link_reenviar'] ?>" target="_blank">Reenviar pedido</a>
                </form>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>



  <div class="bg-dark" onclick="subir()" style="cursor: pointer; position: fixed;right: 2%;bottom: 2%;border-radius: 50%;width: 6vh;height: 6vh;display: flex;align-items: center;justify-content: center;z-index: 20">
    <svg fill="white" style="width: 100%;height: 58%;" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 384 512">
      <path d="M32 448c-17.7 0-32 14.3-32 32s14.3 32 32 32l96 0c53 0 96-43 96-96l0-306.7 73.4 73.4c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3l-128-128c-12.5-12.5-32.8-12.5-45.3 0l-128 128c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 109.3 160 416c0 17.7-14.3 32-32 32l-96 0z" />
    </svg>
  </div>


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
          if (<?php echo isset($_SESSION['enviado']) ? "true" : "false" ?>) {
            $('#miModal').modal('show');
          }
        });
  </script>


  <div name="arriba"  style="margin:2rem;margin-top: 4rem; ">