<?php
// Incluye la conexión a la base de datos
require 'app/config.php';

// Verifica si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoge los datos del formulario
    $nombre_semilla = $_POST['nombre_semilla'];
    $tiempo_germinacion = $_POST['tiempo_germinacion'];
    $region = $_POST['region'];
    $temperatura_optima = $_POST['temperatura_optima'];
    $estado_semilla = $_POST['estado_semilla'];

    // Prepara la consulta SQL para insertar datos
    $sql = "INSERT INTO semilla (nombre, tiempo_germinacion, region, temperatura_optima, estado) 
            VALUES (:nombre, :tiempo_germinacion, :region, :temperatura_optima, :estado)";

    try {
        // Prepara y ejecuta la consulta
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nombre', $nombre_semilla);
        $stmt->bindParam(':tiempo_germinacion', $tiempo_germinacion);
        $stmt->bindParam(':region', $region);
        $stmt->bindParam(':temperatura_optima', $temperatura_optima);
        $stmt->bindParam(':estado', $estado_semilla);

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
  <title>Formulario de Donación de Semillas</title>
  <link rel="stylesheet" href="css/diseño_formulario_donacion.css">
  <!-- Incluye SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
  <header>
    <div class="logo">
      <img src="imagenes/logouae.ico" alt="Logo">
      <h4>Donación de semillas</h4>
    </div>
    <nav>
      <ul>
        <li><a href="#">Inicio</a></li>
        <li><a href="#">Donar</a></li>
        <li><a href="contact.html">Contacto</a></li>
      </ul>
    </nav>
  </header>
  <button type="button" onclick="window.history.back()" class="input-group">Volver</button>

  <section class="form-section">
    <h2>Formulario de donación de semillas</h2>
    <form action="procesar_donacion_semillas.php" method="POST">
      <fieldset>
        <div class="input-group">
          <label for="nombre_semilla">Nombre de la semilla:</label>
          <input type="text" name="nombre_semilla" id="nombre_semilla" required>
        </div>
        <div class="input-group">
          <label for="tiempo_germinacion">Tiempo de germinación (días):</label>
          <input type="number" name="tiempo_germinacion" id="tiempo_germinacion" required>
        </div>
        <div class="input-group">
          <label for="region">Región de origen:</label>
          <select name="region" id="region" required>
            <option value="costa">Costa</option>
            <option value="sierra">Sierra</option>
            <option value="oriente">Oriente</option>
            <option value="galapagos">Galápagos</option>
          </select>
        </div>
        <div class="input-group">
          <label for="temperatura_optima">Temperatura óptima (°C):</label>
          <input type="number" name="temperatura_optima" id="temperatura_optima" step="0.1" required>
        </div>
        <div class="input-group">
          <label for="estado_semilla">Estado de la semilla:</label>
          <select name="estado_semilla" id="estado_semilla" required>
            <option value="sana">Sana</option>
            <option value="enferma">Enferma</option>
            <option value="con_plaga">Con plaga</option>
          </select>
        </div>
        <div class="input-group">
          <button type="submit">Donar semillas</button>
          <button type="button" onclick="window.location.href='consultar_donacion.php'">Consultar</button>
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
      window.location.href = 'procesar_donacion_semillas.php'; // Recarga la página
    });
  </script>
  <?php endif; ?>
</body>
</html>
