<?php

$DataJson = file_get_contents('Pedidos.json');
$Data = json_decode($DataJson, true);
if ($Data == null || count($Data) == 0) {
  die('Error al cargar los datos desde el archivo JSON.');
}

$pedido = $_GET['p'];
$key = $_GET['key'];

if (!isset($Data[$pedido]) || $Data[$pedido]["key"] != $key) {
  die("El pedido no existe o no está autorizado");
}

$Data = $Data[$pedido]['data'];
include("header.php");
?>

<h3 class=" mt-5">Pedido No. <?php echo $pedido ?></h3>

<div class="table-responsive">
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Articulo</th>
        <th>Código</th>
        <th>Cantidad</th>
        <th>Comentario</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($Data as $item) : ?>
        <tr>
          <td style="width:12rem; height: 10rem;"  >
            <a href="detalle.php?f=<?php echo $item['file']; ?>">
              <img style="width: 100%;  height: 100%;  object-fit: cover;" src='fotos/<?php echo $item['file']; ?>' alt="" srcset="">
            </a>
          </td>
          <td><?php echo $item['codigo']; ?></td>
          <td><?php echo $item['cantidad']; ?></td>
          <td><?php echo $item['comentario']; ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php include("footer.php"); ?>
