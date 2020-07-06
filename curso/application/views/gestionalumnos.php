<section id="main-content">
  <section class="wrapper">

    <?php
    //print_r($alumnos);
    ?>

    <table id="alumnos" class="display" style="width: 100%">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Usuario</th>
            <th>Curso</th>
            <th>Editar</th>
        </tr>
    </thead>
    <tbody>
       <?php
        foreach ($alumnos as $a) {
       ?>
          <tr id="rowalumno<?=$a->id ?>">
            <td><?= $a->nombre?></td>
            <td><?= $a->apellidos?></td>
            <td><?= $a->username?></td>
            <td><?= $a->curso?></td>
            <td><i class="eliminar fa fa-trash-o" style="cursor: pointer;" id="alumno-<?= $a->id ?>"></i></td>
          </tr>
       <?php
          }
       ?>
    </tbody>
</table>

  </section>
  
</section>

<script type="text/javascript">

  $(".eliminar").click(function(){

    var idalumno=this.id;
    var res=idalumno.split("-");
    var id=res[1];//dondeesta el numerito
    //console.log(id);
    $.post("<?=base_url()?>Dashboard/eliminarAlumno",{idalumno: id}).done(function(data){
       console.log('Eliminado');
       $("#rowalumno"+id).fadeOut();
   });

  });
   
</script>

<script>
  
  $(document).ready( function () {
    $('#alumnos').DataTable({
      columnDefs:[{
        targets:[0],
        orderData[0,1]
      },{
        targets:[1],
        orderData[1,0]
      },{
        targets:[4],
        orderData[4,0]
      }]

    });
} );
</script>
