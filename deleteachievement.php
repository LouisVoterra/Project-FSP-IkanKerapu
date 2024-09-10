<?php
include 'db.php';

if (isset($_GET['idachievement'])) {
    $idachievement = $_GET['idachievement'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $sql = "DELETE FROM achievement WHERE idachievement = ?";
        

        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }

        $stmt->bind_param("i", $idachievement);

        if ($stmt->execute()) {
            echo "Data berhasil dihapus.";
            echo "<br><a href='home.php'>Kembali ke daftar game</a>";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    } else {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Hapus Game</title>
        </head>
        <body>

        <h2>Konfirmasi Penghapusan</h2>
        <p>Apakah Anda yakin ingin menghapus game dengan ID <?php echo htmlspecialchars($idachievement); ?>?</p>

        <form action="deleteachievement.php?idgame=<?php echo htmlspecialchars($idachievement); ?>" method="POST">
            <input type="submit" value="Hapus">
            <a href="home.php">Batal</a>
        </form>

        </body>
        </html>
        <?php
    }
} else {
    echo "ID achievement tidak ditemukan.";
}
?>