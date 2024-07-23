<?php
// Incluye la conexión a la base de datos
require 'app/config.php';

// Inicializa las variables para el mensaje y el tipo de alerta
$message = "";
$alertType = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoge los datos del formulario
    $nombre_insecticida = $_POST['nombre_insecticida'];
    $cantidad = $_POST['cantidad'];
    $fecha_caducidad = $_POST['fecha_caducidad'];
    $estado_insecticida = $_POST['estado_insecticida'];

    // Prepara la consulta SQL para insertar datos
    $sql = "INSERT INTO insecticida (nombre, fecha_caducidad, cantidad, estado) 
            VALUES (:nombre, :fecha_caducidad, :cantidad, :estado)";

    try {
        // Prepara y ejecuta la consulta
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nombre', $nombre_insecticida);
        $stmt->bindParam(':cantidad', $cantidad);
        $stmt->bindParam(':fecha_caducidad', $fecha_caducidad);
        $stmt->bindParam(':estado', $estado_insecticida);

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
  <title>Formulario de Donación de Insecticidas</title>
  <link rel="stylesheet" href="css/diseño_formulario_donacion.css">
  <!-- Incluye SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
  <header>
    <div class="logo">
      <img src="imagenes/logouae.ico" alt="Logo">
      <h4>Donación de Insecticidas</h4>
    </div>
    <nav>
      <ul>
        <li><a href="#">Inicio</a></li>
        <li><a href="#">Donar</a></li>
        <li><a href="contact.html">Contacto</a></li>
      </ul>
    </nav>
  </header>
  <button type="button" onclick="window.history.back()" class="back-button">Volver</button>

  <section class="form-section">
    <h2>Formulario de Donación de Insecticidas</h2>
    <form action="procesar_donacion_insecticidas.php" method="POST">
      <fieldset>
        <div class="input-group">
          <label for="nombre_insecticida">Nombre del insecticida:</label>
          <input type="text" name="nombre_insecticida" id="nombre_insecticida" required>
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
          <label for="estado_insecticida">Estado del insecticida:</label>
          <select name="estado_insecticida" id="estado_insecticida" required>
            <option value="nuevo">Nuevo</option>
            <option value="usado">Usado</option>
            <option value="caducado">Caducado</option>
          </select>
        </div>
        <div class="input-group">
          <button type="submit">Donar Insecticidas</button>
          <button type="button" onclick="window.location.href='consultar_insecticida.php'">Consultar</button>
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

  <?php if ($message): ?>
  <script>
    Swal.fire({
      icon: '<?php echo $alertType; ?>',
      title: '<?php echo $message; ?>',
      timer: 2000,
      showConfirmButton: false
    }).then(() => {
      window.location.href = 'procesar_donacion_insecticidas.php'; // Redirige a la página principal o la página deseada
    });
  </script>
  <?php endif; ?>
</body>
</html>
