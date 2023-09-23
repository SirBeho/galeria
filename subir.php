	
<?php
if ($_POST){
$foto = $_FILES['foto'];
$rnd= rand(0,9999999999);
if($foto['error'] == 0){
  move_uploaded_file($foto['tmp_name'], "fotos/{$rnd}.jpg");

  $datos= $_POST;
  file_put_contents("datos/{$rnd}.txt", serialize($datos));
}
}

 include("header.php"); ?>

<h3>Cargar Imagenes</h3>
<form method="post" action=""  enctype="multipart/form-data">



  <div class="row">
    <div class="col col-sm-6">
      <div class="form-group input-group">
		<span class="input-group-addon">Foto:   </span>
        <input type="file" name="foto" class="form-control"/>
      </div>
	  
      <div class="form-group input-group">
        <span class="input-group-addon">Nombre:   </span>
        <input type="text" name="Nombre" class="form-control"/>
      </div>
	  
      <div class="form-group input-group">
        <span class="input-group-addon">Telefono:   </span>
        <input type="text" name="Telefono" class="form-control"/>
      </div>
	  
      <div class="form-group input-group">
        <span class="input-group-addon">Comentario:   </span>
        <textarea type="text" name="Comentario" class="form-control"/></textarea>
      </div>
	  
	<button type="submit" class="btn btn-primary">Guardar</button>
   
   </div>

  </div>
</form>
<?php include("footer.php"); ?>
