<?php
// Incluye la conexión a la base de datos
require 'app/config.php';
include('layout/sesion.php');
include('layout/parte1.php');

// Consulta para obtener los registros de plantas
$sql = "SELECT * FROM planta";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$plantas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Consultar Donaciones de Plantas</title>
  <!-- Incluye los estilos de DataTables -->
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0">Listado de Donaciones de Plantas</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-outline card-primary">
              <div class="card-header">
                <h3 class="card-title">Donaciones Registradas</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
              </div>

              <div class="card-body" style="display: block;">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th><center>ID</center></th>
                      <th><center>Nombre</center></th>
                      <th><center>Edad (días)</center></th>
                      <th><center>Región</center></th>
                      <th><center>Temperatura Óptima (°C)</center></th>
                      <th><center>Estado</center></th>
                      <th><center>Ubicación Actual</center></th>
                      <!--<th><center>ID Fertilizante</center></th>
                      <th><center>ID Insecticida</center></th>
                      <th><center>ID Semilla</center></th>
                      <th><center>ID Sustrato</center></th>-->
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($plantas as $planta): ?>
                      <tr>
                        <td><center><?php echo htmlspecialchars($planta['id_planta']); ?></center></td>
                        <td><?php echo htmlspecialchars($planta['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($planta['edad']); ?> días</td>
                        <td><?php echo htmlspecialchars($planta['region']); ?></td>
                        <td><?php echo htmlspecialchars($planta['temperatura']); ?> °C</td>
                        <td><?php echo htmlspecialchars($planta['estado']); ?></td>
                        <td><?php echo htmlspecialchars($planta['ubicacion_actual']); ?></td>
                        
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th><center>ID</center></th>
                      <th><center>Nombre</center></th>
                      <th><center>Edad (días)</center></th>
                      <th><center>Región</center></th>
                      <th><center>Temperatura Óptima (°C)</center></th>
                      <th><center>Estado</center></th>
                      <th><center>Ubicación Actual</center></th>
                      <!--<th><center>ID Fertilizante</center></th>
                      <th><center>ID Insecticida</center></th>
                      <th><center>ID Semilla</center></th>
                      <th><center>ID Sustrato</center></th>-->
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </div><!-- /.content -->
  </div><!-- /.content-wrapper -->

  <?php include('layout/mensajes.php'); ?>
  <?php include('layout/parte2.php'); ?>

  <script>
    $(function () {
      $("#example1").DataTable({
        "pageLength": 5,
        "language": {
          "emptyTable": "No hay información",
          "info": "Mostrando _START_ a _END_ de _TOTAL_ Donaciones",
          "infoEmpty": "Mostrando 0 a 0 de 0 Donaciones",
          "infoFiltered": "(Filtrado de _MAX_ total Donaciones)",
          "infoPostFix": "",
          "thousands": ",",
          "lengthMenu": "Mostrar _MENU_ Donaciones",
          "loadingRecords": "Cargando...",
          "processing": "Procesando...",
          "search": "Buscador:",
          "zeroRecords": "Sin resultados encontrados",
          "paginate": {
            "first": "Primero",
            "last": "Último",
            "next": "Siguiente",
            "previous": "Anterior"
          }
        },
        "responsive": true,
        "lengthChange": true,
        "autoWidth": false,
        buttons: [
          {
            extend: 'collection',
            text: 'Reportes',
            orientation: 'landscape',
            buttons: [
              'copy', 'csv', 'excel', 'pdf', 'print'
            ]
          },
          {
            extend: 'colvis',
            text: 'Visor de columnas',
            collectionLayout: 'fixed three-column'
          }
        ],
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
  </script>
</body>
</html>
