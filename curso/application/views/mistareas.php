<section id="main-content">
  <section class="wrapper">
    <div class="row">
      
    <?php
    foreach ($tareas as $t) {
    ?>
      <div class="col-md-4 tarea"><!--columnas-->
        <div class="row"><!--filas-->
         <strong><?=$t->nombre?></strong> 
        </div>
        <div class="row"><!--filas-->
          <?=$t->descripcion?>
        </div>
        <div class="row"><!--filas-->
          <?= date('d-m-Y',strtotime($t->fecha_inicial))?>
        </div>
        
        <div class="row"><!--filas-->
          <?php
          if($t->archivo!=""){
        ?>
          <a href="<?= base_url().'uploads/'.$t->archivo?>" download> Descargar </a>
          <?php
         }else{
          echo "Sin archivo";
         }
        ?>
        </div>
        
      </div>
    <?php
    }
    ?>
    </div>
  </section>
  
</section>

