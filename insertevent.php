<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Game</title>
</head>
<body>

<h2>Tambah Data Event</h2>

<form action="insertevent_process.php" method="POST">
    <label for="name">Nama Event:</label><br>
    <input type="text" id="name" name="name" required><br><br>

    <label for="description">Tanggal Event:</label><br>
    <input type="date" id="date" name="date"><br><br>

    <label for="description">Deskripsi Event:</label><br>
    <textarea id="description" name="description" required></textarea><br><br>

    <input type="submit" value="Submit">
</form>

</body>
</html>