<?php
require 'db.php';

// Controllo che sia stato passato l’id ordine // NUOVO
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];

// Recupero i dati dell’ordine
$result = mysqli_query($conn, "SELECT * FROM ordini WHERE id = $id");
$ordine = mysqli_fetch_assoc($result);

if (!$ordine) {
    header("Location: index.php");
    exit;
}

// Recupero il contatto per eventuale redirect dopo l’eliminazione // NUOVO
$contatto_id = $ordine['contatto_id'];

// Se conferma eliminazione
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Elimino l’ordine
    mysqli_query($conn, "DELETE FROM ordini WHERE id = $id");

    // Redirect alla lista ordini del contatto
    header("Location: ordini.php?id=$contatto_id");
    exit;
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elimina Ordine</title>

    <!-- BOOTSTRAP 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- CSS personalizzato -->
    <link rel="stylesheet" href="style.css?v=<?= time() ?>">
</head>
<body class="bg-light">

    <!-- NAVBAR // NUOVO -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-danger shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">📒 Rubrica E-commerce</a>
        </div>
    </nav>

    <div class="container my-5">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body text-center p-5">
                <h1 class="text-danger mb-4">⚠️ Conferma eliminazione ordine</h1>
                <p class="lead mb-4">
                    Sei sicuro di voler eliminare l’ordine per <strong><?= htmlspecialchars($ordine['prodotto']) ?></strong> (Quantità: <?= htmlspecialchars($ordine['quantita']) ?>)?
                </p>

                <form method="POST" class="d-inline">
                    <button type="submit" class="btn btn-danger px-4">🗑️ Elimina definitivamente</button>
                </form>
                <a href="ordini.php?id=<?= $contatto_id ?>" class="btn btn-secondary px-4">❌ Annulla</a>
            </div>
        </div>
    </div>

    <!-- BOOTSTRAP JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
