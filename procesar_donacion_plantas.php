<?php
// Incluye la conexión a la base de datos
require 'app/config.php';

// Verifica si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoge los datos del formulario
    $nombre_planta = $_POST['nombre_planta'];
    $edad = $_POST['edad'];
    $region = $_POST['region'];
    $temperatura_optima = $_POST['temperatura_optima'];
    $estado_planta = $_POST['estado_planta'];
    $ubicacion = $_POST['ubicacion'];

    // Prepara la consulta SQL para insertar datos
    $sql = "INSERT INTO planta (nombre, edad, region, temperatura, estado, ubicacion_actual) 
            VALUES (:nombre, :edad, :region, :temperatura, :estado, :ubicacion)";

    try {
        // Prepara y ejecuta la consulta
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nombre', $nombre_planta);
        $stmt->bindParam(':edad', $edad);
        $stmt->bindParam(':region', $region);
        $stmt->bindParam(':temperatura', $temperatura_optima);
        $stmt->bindParam(':estado', $estado_planta);
        $stmt->bindParam(':ubicacion', $ubicacion);

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
  <title>Formulario de Donación de Plantas</title>
  <link rel="stylesheet" href="css/diseño_formulario_donacion.css">
  <!-- Incluye SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
  <header>
    <div class="logo">
      <img src="imagenes/logouae.ico" alt="Logo">
      <h4>Donación de plantas</h4>
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
    <h2>Formulario de donación de plantas</h2>
    <form action="procesar_donacion_plantas.php" method="POST">
      <fieldset>
        <div class="input-group">
          <label for="nombre_planta">Nombre de la planta:</label>
          <input type="text" name="nombre_planta" id="nombre_planta" required>
        </div>
        <div class="input-group">
          <label for="edad">Edad (días):</label>
          <input type="number" name="edad" id="edad" required>
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
          <label for="estado_planta">Estado de la planta:</label>
          <select name="estado_planta" id="estado_planta" required>
            <option value="sana">Sana</option>
            <option value="enferma">Enferma</option>
            <option value="con_plaga">Con plaga</option>
          </select>
        </div>
        <div class="input-group">
          <label for="ubicacion">Ubicación:</label>
          <input type="text" name="ubicacion" id="ubicacion" required>
        </div>
        <div class="input-group">
          <button type="submit">Donar Planta</button>
          <button type="button" onclick="window.location.href='consultar_donacion_plantas.php'">Consultar</button>
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
      window.location.href = 'procesar_donacion_plantas.php'; // Recarga la página
    });
  </script>
  <?php endif; ?>
</body>
</html>
