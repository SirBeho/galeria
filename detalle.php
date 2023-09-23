<?php
$tmp = $_GET['f'];

$foto = "fotos/{$tmp}";

$tmp = str_replace('.jpg', '.txt', $tmp);
$dato = "datos/{$tmp}";

if (file_exists($dato)) {
    $dato = unserialize(file_get_contents($dato));
} else {
    $defaultData = [
        'Nombre' => "No data",
        'Telefono' => "No data",
        'Comentario' => "No data",
    ];
    // Use the default data
    $dato = $defaultData;
}

include("header.php");

?>

<h3>VISUALIZADOR DE IMAGENES</h3>
<fieldset>
  <legend>Datos</legend>
  <div>
    Nombre: <?php echo $dato['Nombre']; ?>
  </div>
  <div>
    Telefono: <?php echo $dato['Telefono']; ?>
  </div>
  <div>
    Comentario: <?php echo $dato['Comentario']; ?>
  </div>
</fieldset>
<div style="width: 50rem">

  <img style="width: 100%" src="<?php echo $foto; ?>" class="image-responsive" />
</div>

<?php include("footer.php"); ?>