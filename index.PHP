<?php
    //importo il file db
    require 'db.php';

    //salvo in una variabile $result, i risultati della query
    $result = mysqli_query($conn, "SELECT * FROM contatti"); // query per prendermi tutta la tabella contatti
?>


<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecommerce</title>

    <!-- INCLUSIONE BOOTSTRAP 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- LINK CSS PERSONALIZZATO -->
    <link rel="stylesheet" href="style.css?v=<?= time() ?>">
</head>
<body class="bg-light">

    <!-- NAVBAR MODERNA // NUOVO -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">📒 Rubrica E-commerce</a>
            <div>
                <a href="aggiungi_contatto.php" class="btn btn-light btn-sm">➕ Aggiungi contatto</a>
            </div>
        </div>
    </nav>

    <!-- CARD CENTRALE MIGLIORATA // NUOVO -->
    <div class="container my-5">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-4">

                <h1 class="mb-4 text-primary">Rubrica contatti</h1>

                <div class="table-responsive">
                    <table class="table align-middle table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th>Nome</th>
                                <th>Telefono</th>
                                <th>Email</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <!--Ciclo WHILE FINTANTO CHE HO RESULT, MOSTRAMELI IN ROW DEDICATE--->
                            <?php  while($row = mysqli_fetch_assoc($result)) : ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['nome']) ?></td> <!--mostra nome-->
                                    <td><?= htmlspecialchars($row['telefono']) ?></td> <!--mostra telefono-->
                                    <td><?= htmlspecialchars($row['email']) ?></td> <!--mostra email-->

                                    <td>
                                        <!-- Modifica: aggiunto passaggio dell'id del contatto tramite GET -->
                                        <a href="modifica_contatto.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">🖊️</a>

                                        <!-- Elimina: aggiunto passaggio dell'id del contatto tramite GET -->
                                        <a href="elimina_contatto.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm">🗑️</a>

                                        <!-- Ordini: aggiunto passaggio dell'id del contatto tramite GET -->
                                        <a href="ordini.php?id=<?= $row['id'] ?>" class="btn btn-info btn-sm">📦</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>    
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
