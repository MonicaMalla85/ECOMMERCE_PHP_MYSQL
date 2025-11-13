<?php
require 'db.php';

// Controllo che l'id del contatto sia stato passato
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$contatto_id = $_GET['id'];

// Recupero i dati del contatto per mostrare il nome nella pagina
$contatto_result = mysqli_query($conn, "SELECT * FROM contatti WHERE id = $contatto_id");
$contatto = mysqli_fetch_assoc($contatto_result);

if (!$contatto) {
    header("Location: index.php");
    exit;
}

// Recupero tutti gli ordini di questo contatto
$ordini_result = mysqli_query($conn, "SELECT * FROM ordini WHERE contatto_id = $contatto_id ORDER BY data_di_ordine DESC");
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ordini di <?= htmlspecialchars($contatto['nome']) ?></title>

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
            <div>
                <a href="index.php" class="btn btn-light btn-sm">⬅️ Torna alla lista</a>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-4">
                
                <h1 class="mb-4 text-info">Ordini di <?= htmlspecialchars($contatto['nome']) ?></h1>

                <!-- LINK A PAGINA DI AGGIUNTA ORDINE // NUOVO -->
                <a href="aggiungi_ordine.php?contatto_id=<?= $contatto_id ?>" class="btn btn-success mb-4">➕ Aggiungi nuovo ordine</a>

                <!-- TABELLA ORDINI -->
                <div class="table-responsive">
                    <table class="table align-middle table-hover">
                        <thead class="table-info">
                            <tr>
                                <th>Prodotto</th>
                                <th>Quantità</th>
                                <th>Data ordine</th>
                                <th>Azioni</th> <!-- NUOVO -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($ordini_result) > 0): ?>
                                <?php while ($ordine = mysqli_fetch_assoc($ordini_result)) : ?>
                                    <tr>
                                        <td><?= htmlspecialchars($ordine['prodotto']) ?></td>
                                        <td><?= htmlspecialchars($ordine['quantita']) ?></td>
                                        <td><?= htmlspecialchars($ordine['data_di_ordine']) ?></td>
                                        <td>
                                            <!-- NUOVO: link a modifica ed elimina -->
                                            <a href="modifica_ordine.php?id=<?= $ordine['id'] ?>" class="btn btn-warning btn-sm me-1">🖊️</a>
                                            <!-- Button trigger modale eliminazione // NUOVO -->
                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#eliminaModal<?= $ordine['id'] ?>">
                                                🗑️
                                            </button>

                                            <!-- Modal // NUOVO -->
                                            <div class="modal fade" id="eliminaModal<?= $ordine['id'] ?>" tabindex="-1" aria-labelledby="eliminaModalLabel<?= $ordine['id'] ?>" aria-hidden="true">
                                              <div class="modal-dialog">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <h5 class="modal-title" id="eliminaModalLabel<?= $ordine['id'] ?>">Conferma eliminazione</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                  </div>
                                                  <div class="modal-body">
                                                    Sei sicuro di voler eliminare l’ordine per <strong><?= htmlspecialchars($ordine['prodotto']) ?></strong> (Quantità: <?= htmlspecialchars($ordine['quantita']) ?>)?
                                                  </div>
                                                  <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                                                    <a href="elimina_ordine.php?id=<?= $ordine['id'] ?>" class="btn btn-danger">Elimina</a> <!-- NUOVO -->
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Nessun ordine trovato per questo contatto.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <!-- BOOTSTRAP JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
