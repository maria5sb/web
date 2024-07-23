<?php
// Incluye la conexión a la base de datos
require 'app/config.php';

// Verifica si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoge los datos del formulario
    $nombre_fertilizante = $_POST['nombre_fertilizante'];
    $fecha_caducidad = $_POST['fecha_caducidad'];
    $cantidad = $_POST['cantidad'];
    $estado_fertilizante = $_POST['estado_fertilizante'];

    // Prepara la consulta SQL para insertar datos
    $sql = "INSERT INTO fertilizante (nombre, fecha_caducidad, cantidad, estado) 
            VALUES (:nombre, :fecha_caducidad, :cantidad, :estado)";

    try {
        // Prepara y ejecuta la consulta
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nombre', $nombre_fertilizante);
        $stmt->bindParam(':fecha_caducidad', $fecha_caducidad);
        $stmt->bindParam(':cantidad', $cantidad);
        $stmt->bindParam(':estado', $estado_fertilizante);
        
        if ($stmt->execute()) {
            $message = "Donación registrada exitosamente.";
            $alertType = "success";
        } else {
            $message = "Error al registrar la donación.";
            $alertType = "error";
        }
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
        $alertType = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulario de Donación de Fertilizantes</title>
  <link rel="stylesheet" href="css/diseño_formulario_donacion.css">
  <!-- Incluye SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
  <header>
    <div class="logo">
      <img src="imagenes/logouae.ico" alt="Logo">
      <h4>Donación de Fertilizantes</h4>
    </div>
    <nav>
      <ul>
        <li><a href="index_dona.html">Inicio</a></li>
        <li><a href="#">Donar</a></li>
        <li><a href="contact.html">Contacto</a></li>
      </ul>
    </nav>
  </header>
  <button type="button" onclick="window.history.back()" class="back-button">Volver</button>

  <section class="form-section">
    <h2>Formulario de Donación de Fertilizantes</h2>
    <form action="procesar_donacion_fertilizantes.php" method="POST">
      <fieldset>
        <div class="input-group">
          <label for="nombre_fertilizante">Nombre del fertilizante:</label>
          <input type="text" name="nombre_fertilizante" id="nombre_fertilizante" required>
        </div>
        <div class="input-group">
          <label for="fecha_caducidad">Fecha de caducidad:</label>
          <input type="date" name="fecha_caducidad" id="fecha_caducidad" required>
        </div>
        <div class="input-group">
          <label for="cantidad">Cantidad:</label>
          <input type="number" name="cantidad" id="cantidad" required>
        </div>
        <div class="input-group">
          <label for="estado_fertilizante">Estado del fertilizante:</label>
          <select name="estado_fertilizante" id="estado_fertilizante" required>
            <option value="nuevo">Nuevo</option>
            <option value="usado">Usado</option>
            <option value="caducado">Caducado</option>
          </select>
        </div>
        <div class="input-group">
          <button type="submit">Donar Fertilizantes</button>
          <button type="button" onclick="window.location.href='consultar_fertilizante.php'">Consultar</button>
        </div>
      </fieldset>
    </form>
  </section>

  <footer>
    <div class="footer-nombre">
      <a href="#">Nombre del Proyecto</a>
    </div>
    <div class="social-media">
      <a href="#">Facebook</a>
      <a href="#">Twitter</a>
    </div>
    <div class="contact">
      <a href="#">Contacto</a>
    </div>
  </footer>

  <?php if (isset($message)): ?>
  <script>
    Swal.fire({
      icon: '<?php echo $alertType; ?>',
      title: '<?php echo $message; ?>',
      timer: 2000,
      showConfirmButton: false
    }).then(() => {
      window.location.href = 'procesar_donacion_fertilizantes.php'; // Recarga la página
    });
  </script>
  <?php endif; ?>
</body>
</html>
