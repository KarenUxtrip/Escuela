<section id="main-content">
  <section class="wrapper">

<div class="row">
  <button id="btnmensaje" class="btn btn-success btn-md" data-toggle="modal" data-target="#myModal">Enviar mensaje</button>
  
</div>

<br><br>
<!--tabla-->
   <table id="example" class="display" style="width: 100%">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Fecha</th>
            <th>Leer</th>
        </tr>
    </thead>
    <tbody>
       <?php
        foreach ($mensajes as $m) {
          $nombreyapellidos=$this->Site_model->getNombre($m->id_from);
          $nombre=$nombreyapellidos[0]->nombre;
          $apellidos=$nombreyapellidos[0]->apellidos;
          if ($m->is_read==1) {
              $class="isreadclass";
          }else{
              $class="noreadclass";
          }
       ?>
          <tr id="">
            <td><?=$nombre?></td>
            <td><?=$apellidos?></td>
            <td><?=date('d-m H:i',strtotime($m->created_at))?></td>
            <td id="verMensaje-<?=$m->id?>" class="<?= $class?>" onclick="verMensaje(<?= $m->id?>,'<?=$nombre?>',this.id)">Ver</td>
          </tr>
       <?php
          }
       ?>
    </tbody>
</table>


<!--modal-->
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Enviar mensaje</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!--formulario-->
        <div class="col-md-6 col-md-offset-3">
        <form action="" method="post">
    
    <div class="form-group">
      <label class="col-sm-2 col-sm-2 control-label">
        Destinatario
      </label><br>
      <div class="col-sm-10">
        <select name="id_to">
          <option class="form-control" value="0" disabled>
            Selecciona un usuario
          </option>
          <?php
            foreach ($usuarios as $c) {
              echo "<option id='user-'".$c->id."' value='".$c->token_mensaje."'>".$c->nombre." ".$c->apellidos."</option>";
            }
          ?>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-2 col-sm-2 control-label">
        Mensaje
      </label><br>
      <div class="col-sm-10">
        <textarea class="form-control" name="mensaje" cols=6></textarea>
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-2 col-sm-2 control-label">
      </label><br><br>
      <div class="col-sm-10">
        <input class="form-control" type="submit" name="" value="Enviar">
      </div>
    </div>

  </form> 
</div>
        <!--//formulario-->
      </div>
      <div class="modal-footer" style="margin-top: 25px">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modalMensaje" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalMensaje">Mensaje de </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer" style="margin-top: 25px">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!--77modal-->
  </section>
  
</section>

<script>

  function verMensaje(id,nombre,idver){
    //console.log(nombre);

   $.post("<?=base_url()?>Dashboard/getMensaje",{idmensaje: id}));
  }
  
 
</script>

