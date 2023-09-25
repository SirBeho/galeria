<?php
include("header.php");
?>

<!-- Page Heading -->
<h1 class="my-4">GALERIA PRINCIPAL

    <small>Articulos</small>
</h1>
<div style="display:flex ;gap: 1rem; flex-wrap: wrap; justify-content: space-around;">
    <?php

    $files = scandir("fotos");
    array_shift($files);
    array_shift($files);

    foreach ($files as $file) {
        $ruta = "fotos/{$file}";

        if (!isset($Articulos[$file])) {
            $Articulos[$file] = [
                'codigo' => '--',
            ];
        }

        
       
?>
        <!-- Agrega un enlace que abra el modal al hacer clic en la imagen -->
        <div style='max-width: 20rem; cursor: pointer; box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.5); display: flex; max-height: 15rem; position: relative;' onclick='openModal(<?php echo json_encode($Articulos[$file]); ?>,"<?=$file ?>")'>
            <img style='height: 100%; object-fit: cover; width: 100%;' class='img-responsive' src='<?php echo $ruta; ?>' alt=''>
            <img style='width: 7rem; position: absolute; bottom: 0; right: 0' src='logo.png'>
            <span style='position: absolute; top: 10px; left: 16px; color: black; background: white; border-radius: 8px; padding-inline: 5px;'> <?php echo $Articulos[$file]["codigo"]; ?> </span>
        </div>
    <?php }
    ?>
</div>


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Detalle del Artículo</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">


      <div style=" position:relative; border-radius: 0.5rem; overflow: hidden;">
        <img id="modal-image" src="" class="img-fluid" alt="Imagen del artículo">
        <img style='width: 45%; position: absolute; bottom: 0; right: 0' src='logo.png'>
        <span id="modal-codigo" style='position: absolute; top: 10px; left: 16px;color: black;background: white;border-radius: 8px; padding-inline: 5px;'></span>

    </div>



    <!-- modificar  codigo
          <form method="POST" action="add.php">

            <fieldset>
                <legend>Datos del Producto</legend>
                <input id="modal-file" type="hidden" name="file" >
                <div>
                Código:
                
                <button type="submit">Guardar</button>
                </div>

            </fieldset>

        </form>  -->


        <form id="add_form" method="POST" action="./add.php" style="display: flex;gap:1rem; margin-top: 1rem; border: solid black; border-radius: 1rem; padding: 1rem;">
           
             <input type="hidden" id="scrollPosition"  name="scrollPosition">

            <div class="form-group">
                <input type="hidden" name="add_to_cart" value="1">
                <input type="hidden" name="file" id="form-file">
                <input type="hidden" name="codigo" id="form-codigo">
                <label for="cantidad" style="width: 100%;">
                    Cantidad:
                    <input type="number" class="form-control" id="cantidad" name="cantidad" required>
                </label>
                <label for="comentario" style="width: 100%;">
                    Comentario:
                    <textarea class="form-control" id="comentario" name="comentario" rows="4"></textarea>
                </label>
            </div>
            <button type="submit" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" height="3em" fill="white" viewBox="0 0 640 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M64 32C28.7 32 0 60.7 0 96V304v80 16c0 44.2 35.8 80 80 80c26.2 0 49.4-12.6 64-32c14.6 19.4 37.8 32 64 32c44.2 0 80-35.8 80-80c0-5.5-.6-10.8-1.6-16H416h33.6c-1 5.2-1.6 10.5-1.6 16c0 44.2 35.8 80 80 80s80-35.8 80-80c0-5.5-.6-10.8-1.6-16H608c17.7 0 32-14.3 32-32V288 272 261.7c0-9.2-3.2-18.2-9-25.3l-58.8-71.8c-10.6-13-26.5-20.5-43.3-20.5H480V96c0-35.3-28.7-64-64-64H64zM585 256H480V192h48.8c2.4 0 4.7 1.1 6.2 2.9L585 256zM528 368a32 32 0 1 1 0 64 32 32 0 1 1 0-64zM176 400a32 32 0 1 1 64 0 32 32 0 1 1 -64 0zM80 368a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"/></svg> </br>
                <i class="fas fa-shopping-cart"></i> Agregar
            </button>
        </form>



        

      </div>
      <div class="modal-footer" style="justify-content: center;">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>



<script>
 function openModal(articuloData,file) {
 $('#myModal').modal('show');
 $('#modal-image').attr('src', "fotos/"+file);
 $('#modal-codigo').text(articuloData.codigo);

 $('#form-file').val(file);
 $('#form-codigo').val(articuloData.codigo);
}
</script>


</div>



<!-- /.row -->
<?php include("footer.php"); ?>