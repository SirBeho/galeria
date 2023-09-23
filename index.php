<?php include("header.php"); ?>
      <!-- Page Heading -->
      <h1 class="my-4">GALERIA PRINCIPAL
        <small>Articulos</small>
      </h1>
      <div style="display:flex ;gap: 1rem; flex-wrap: wrap; justify-content: space-around;" >
		<?php
				$files= scandir("fotos"); 
				foreach ($files as $file) {
				$ruta="fotos/{$file}";
				  if (is_file($ruta)){
					echo "
							<a style='max-width: 20rem; display:flex; max-height: 14rem;position: relative;	' href='detalle.php?f={$file}'>
								<img style='height: 100%; object-fit: cover;  width: 100%;' class='img-responsive' src='{$ruta}' alt=''>
								<img   
								style='width: 7rem; position: absolute;
								bottom: 0;
								right: 0' src='logo.png'>
						</a>
						
					";
				 }
			}
		?>
		</div>
      <!-- /.row -->
    <?php include("footer.php");?>


