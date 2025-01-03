<?php
// Conectar a la base de datos
$conn = new mysqli('localhost', 'root', '', '4VGym');

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Eliminar actividad
if (isset($_GET['delete_tipo']) && isset($_GET['delete_monitor']) && isset($_GET['delete_fecha']) && isset($_GET['delete_aula'])) {
    $delete_tipo = $_GET['delete_tipo'];
    $delete_monitor = $_GET['delete_monitor'];
    $delete_fecha = $_GET['delete_fecha'];
    $delete_aula = $_GET['delete_aula'];
    
    $stmt = $conn->prepare("DELETE FROM actividades WHERE tipo = ? AND monitor = ? AND fecha = ? AND aula = ?");
    $stmt->bind_param("ssss", $delete_tipo, $delete_monitor, $delete_fecha, $delete_aula);
    $stmt->execute();
    $stmt->close();
}

// Editar actividad
if (isset($_GET['edit_tipo']) && isset($_GET['edit_monitor']) && isset($_GET['edit_fecha']) && isset($_GET['edit_aula'])) {
    $edit_tipo = $_GET['edit_tipo'];
    $edit_monitor = $_GET['edit_monitor'];
    $edit_fecha = $_GET['edit_fecha'];
    $edit_aula = $_GET['edit_aula'];
    
    $stmt = $conn->prepare("SELECT * FROM actividades WHERE tipo = ? AND monitor = ? AND fecha = ? AND aula = ?");
    $stmt->bind_param("ssss", $edit_tipo, $edit_monitor, $edit_fecha, $edit_aula);
    $stmt->execute();
    $result_edit = $stmt->get_result();
    $activity = $result_edit->fetch_assoc();

    // Si el formulario de edición se ha enviado
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $tipo = $_POST['tipo'];
        $monitor = $_POST['monitor'];
        $fecha = $_POST['fecha'];
        $aula = $_POST['aula'];

        // Actualizar la actividad
        $stmt_update = $conn->prepare("UPDATE actividades SET tipo = ?, monitor = ?, fecha = ?, aula = ? WHERE tipo = ? AND monitor = ? AND fecha = ? AND aula = ?");
        $stmt_update->bind_param("ssssssss", $tipo, $monitor, $fecha, $aula, $edit_tipo, $edit_monitor, $edit_fecha, $edit_aula);
        $stmt_update->execute();
        $stmt_update->close();

        // Redirigir después de actualizar
        header("Location: index.php");
        exit;
    }
}

// Obtener todas las actividades para mostrar
$sql = "SELECT * FROM actividades";
$result = $conn->query($sql);

// Agregar nueva actividad
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_GET['edit_tipo']) && !isset($_GET['edit_monitor']) && !isset($_GET['edit_fecha']) && !isset($_GET['edit_aula'])) {
    $tipo = $_POST['tipo'];
    $monitor = $_POST['monitor'];
    $fecha = $_POST['fecha'];
    $aula = $_POST['aula'];

    // Insertar nueva actividad
    $stmt = $conn->prepare("INSERT INTO actividades (tipo, monitor, fecha, aula) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $tipo, $monitor, $fecha, $aula);
    $stmt->execute();
    $stmt->close();

    // Redirigir después de agregar
    header("Location: index.php");
    exit;
}

// Función para obtener la imagen según el tipo de actividad
function getActivityImage($tipo) {
    switch ($tipo) {
        case 'Spinning':
            return 'assets/img/spinning2.png';
        case 'BodyPump':
            return 'assets/img/bodypump.png';
        case 'Pilates':
            return 'assets/img/pilates.png';
        default:
            return 'assets/img/default.png'; // Imagen por defecto si no coincide
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>4VGym</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <!-- Barra de navegación -->
    <nav class="navbar navbar-light bg-light fixed-top navbar-expand-md mx-3">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <img src="assets/img/logo.png" alt="Logo" class="rounded img-fluid" width="40">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="insert.html">Nuevas Actividades</a>
                    </li>
                </ul>
                <form class="d-flex">
                    <input class="form-control me-2" type="date" placeholder="Buscar por fecha">
                    <button class="btn btn-dark" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Contenido de la página -->
    <div class="container-fluid p-3 mt-5">

        <!-- Mostrar actividades -->
        <h2 class="text-center mb-4">Actividades Programadas</h2>
        <div class="row g-3">
            <?php while ($activity = $result->fetch_assoc()): ?>
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="card">
                        <!-- Imagen según el tipo de actividad -->
                        <img class="card-img-top img-fluid mx-auto d-block w-50" src="<?= getActivityImage($activity['tipo']) ?>" alt="<?= $activity['tipo'] ?>">
                        <div class="card-body">
                            <h2 class="h4"><?= $activity['tipo'] ?></h2>
                            <p class="fw-bold">Monitor: <?= $activity['monitor'] ?></p>
                            <p class="fw-bold">Aula: <?= $activity['aula'] ?></p>
                            <p class="text-muted"><?= date('d F Y H:i', strtotime($activity['fecha'])) ?></p>
                        </div>
                        <div class="card-footer d-flex justify-content-around">
                            <a href="?edit_tipo=<?= $activity['tipo'] ?>&edit_monitor=<?= $activity['monitor'] ?>&edit_fecha=<?= $activity['fecha'] ?>&edit_aula=<?= $activity['aula'] ?>" class="btn btn-primary">Editar</a>
                            <a href="?delete_tipo=<?= $activity['tipo'] ?>&delete_monitor=<?= $activity['monitor'] ?>&delete_fecha=<?= $activity['fecha'] ?>&delete_aula=<?= $activity['aula'] ?>" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que quieres eliminar esta actividad?')">Borrar</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
// Cerrar la conexión
$conn->close();
?>
