<?php
require 'db.php';

// Controllo che sia passato l'id del contatto // NUOVO
if (!isset($_GET['contatto_id'])) {
    header("Location: index.php");
    exit;
}

$contatto_id = $_GET['contatto_id'];

// Recupero i dati del contatto per mostrare il nome
$contatto_result = mysqli_query($conn, "SELECT * FROM contatti WHERE id = $contatto_id");
$contatto = mysqli_fetch_assoc($contatto_result);

if (!$contatto) {
    header("Location: index.php");
    exit;
}

// Se il form è stato inviato tramite POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $prodotto = $_POST['prodotto'];
    $quantita = $_POST['quantita'];
    $data_di_ordine = $_POST['data_di_ordine'];

    // Query per inserire il nuovo ordine collegato al contatto
    $sql = "INSERT INTO ordini (prodotto, quantita, data_di_ordine, contatto_id)
            VALUES ('$prodotto', '$quantita', '$data_di_ordine', '$contatto_id')";
    mysqli_query($conn, $sql);

    // Reindirizzamento alla lista ordini del contatto
    header("Location: ordini.php?id=$contatto_id");
    exit;
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aggiungi Ordine</title>

    <!-- BOOTSTRAP 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- CSS personalizzato -->
    <link rel="stylesheet" href="style.css?v=<?= time() ?>">
</head>
<body class="bg-light">

    <!-- NAVBAR // NUOVO -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">📒 Rubrica E-commerce</a>
        </div>
    </nav>

    <!-- FORM AGGIUNTA ORDINE -->
    <div class="container my-5 p-4 bg-white rounded-4 shadow-lg">
        <h1 class="mb-4 text-success">Aggiungi ordine per <?= htmlspecialchars($contatto['nome']) ?></h1>

        <form action="" method="POST" class="row g-3">
            <div class="col-md-4">
                <label class="form-label fw-semibold">Prodotto</label>
                <input type="text" name="prodotto" class="form-control shadow-sm" placeholder="Es. Laptop" required>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Quantità</label>
                <input type="number" name="quantita" class="form-control shadow-sm" min="1" required>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Data ordine</label>
                <input type="date" name="data_di_ordine" class="form-control shadow-sm" required>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-success px-4">💾 Salva ordine</button>
                <a href="ordini.php?id=<?= $contatto_id ?>" class="btn btn-secondary px-4">⬅️ Torna agli ordini</a>
            </div>
        </form>
    </div>

    <!-- BOOTSTRAP JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
