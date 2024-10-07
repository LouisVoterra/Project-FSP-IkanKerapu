<?php
require_once 'db.php';

if (isset($_GET['idevent'])) {
    $idgame = $_GET['idevent'];

    $sql = "SELECT * FROM event WHERE idevent = ?";
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
            <title>Update Event</title>
        </head>
        <body>

        <h2>Update Data Event</h2>

        <form action="updateevent_proses.php" method="POST">
            <input type="hidden" name="idevent" value="<?php echo $row['idevent']; ?>">

            <label for="name">Nama Event:</label><br>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" required><br><br>

            <label for="name">Tanggal Evemt:</label><br>
            <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($row['date']); ?>" required><br><br>

            <label for="description">Deskripsi Event:</label><br>
            <textarea id="description" name="description" required><?php echo htmlspecialchars($row['description']); ?></textarea><br><br>

            <input type="submit" value="Update">
        </form>

        </body>
        </html>
        <?php
    } else {
        echo "Evemt tidak ditemukan.";
    }

    $stmt->close();
} else {
    echo "ID event tidak ditemukan.";
}

$conn->close();
?>