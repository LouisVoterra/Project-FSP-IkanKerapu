<?php
require_once 'db.php';

if (isset($_GET['idgame'])) {
    $idgame = $_GET['idgame'];

    $sql = "SELECT * FROM game WHERE idgame = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idgame);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Update Game</title>
        </head>
        <body>

        <h2>Update Data Game</h2>

        <form action="updategame_proses.php" method="POST">
            <input type="hidden" name="idgame" value="<?php echo $row['idgame']; ?>">

            <label for="name">Nama Game:</label><br>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" required><br><br>

            <label for="description">Deskripsi Game:</label><br>
            <textarea id="description" name="description" required><?php echo htmlspecialchars($row['description']); ?></textarea><br><br>

            <input type="submit" value="Update">
        </form>

        </body>
        </html>
        <?php
    } else {
        echo "Game tidak ditemukan.";
    }

    $stmt->close();
} else {
    echo "ID game tidak ditemukan.";
}

$conn->close();
?>