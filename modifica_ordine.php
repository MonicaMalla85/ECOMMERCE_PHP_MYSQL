<?php
require 'db.php';

// Controllo che sia stato passato un id ordine // NUOVO
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];

// Recupero i dati dell’ordine
$result = mysqli_query($conn, "SELECT * FROM ordini WHERE id = $id");
$ordine = mysqli_fetch_assoc($result);

// Se non esiste, torno alla home
if (!$ordine) {
    header("Location: index.php");
    exit;
}

// Recupero anche i dati del contatto collegato // NUOVO
$contatto_id = $ordine['contatto_id'];
$contatto_result = mysqli_query($conn, "SELECT * FROM contatti WHERE id = $contatto_id");
$contatto = mysqli_fetch_assoc($contatto_result);

// Se il form è stato inviato tramite POST // NUOVO
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $prodotto = $_POST['prodotto'];
    $quantita = $_POST['quantita'];
    $data_di_ordine = $_POST['data_di_ordine'];

    // Query di aggiornamento ordine
    $sql = "UPDATE ordini 
            SET prodotto='$prodotto', quantita='$quantita', data_di_ordine='$data_di_ordine'
            WHERE id=$id";
    mysqli_query($conn, $sql);

    // Redirect alla pagina ordini del contatto
    header("Location: ordini.php?id=$contatto_id");
    exit;
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica Ordine</title>

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

    <!-- FORM MODIFICA ORDINE -->
    <div class="container my-5 p-4 bg-white rounded-4 shadow-lg">
        <h1 class="mb-4 text-warning">Modifica ordine di <?= htmlspecialchars($contatto['nome']) ?></h1>

        <form action="" method="POST" class="row g-3">
            <div class="col-md-4">
                <label class="form-label fw-semibold">Prodotto</label>
                <input type="text" name="prodotto" class="form-control shadow-sm" value="<?= htmlspecialchars($ordine['prodotto']) ?>" required>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Quantità</label>
                <input type="number" name="quantita" class="form-control shadow-sm" value="<?= htmlspecialchars($ordine['quantita']) ?>" min="1" required>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Data ordine</label>
                <input type="date" name="data_di_ordine" class="form-control shadow-sm" value="<?= htmlspecialchars($ordine['data_di_ordine']) ?>" required>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-warning px-4">💾 Salva modifiche</button>
                <a href="ordini.php?id=<?= $contatto_id ?>" class="btn btn-secondary px-4">⬅️ Torna agli ordini</a>
            </div>
        </form>
    </div>

    <!-- BOOTSTRAP JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
