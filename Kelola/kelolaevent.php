<?php


$search_keyword = "";
if (isset($_GET['search'])) {
    $search_keyword = $_GET['search'];
}

$limit = 5; 
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; 
$offset = ($page - 1) * $limit; 

$sql_count = "SELECT COUNT(*) AS total FROM event WHERE name LIKE ? OR description LIKE ?";
$stmt_count = $conn->prepare($sql_count);
$search_param = "%" . $search_keyword . "%";
$stmt_count->bind_param("ss", $search_param, $search_param);
$stmt_count->execute();
$result_count = $stmt_count->get_result();
$total_rows = $result_count->fetch_assoc()['total'];
$total_pages = ceil($total_rows / $limit);

$sql = "SELECT * FROM event WHERE name LIKE ? OR description LIKE ? LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssii", $search_param, $search_param, $limit, $offset);
$stmt->execute();
$result = $stmt->get_result();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event</title>
    <link rel = "stylesheet" href="style.css">
</head>
<body>
    <div class="position">
        <nav class="navigation">
            <ul>
                <li><a href="kelolateam.php">Kelola Team</a></li>
                <li><a href="kelolagame.php">Kelola Game</a></li>
                <li><a href="kelolaachievment.php">Kelola Achievement</a></li>
                <li><a href="kelolaevent.php">Kelola Event</a></li>
            </ul>
        </nav>
    </div>


    <h1>Event</h1>

    <form action="" method="GET">
        <input type="text" name="search" placeholder="Search event..." value="<?php echo htmlspecialchars($search_keyword); ?>">
        <input type="submit" value="Search">
    </form>

<?php
if ($result->num_rows > 0) {
    echo "<br><table border='1'>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Deskripsi</th>
                <th>Date</th>
                <th></th>
                <th></th>
            </tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row["idevent"]) . "</td>
                <td>" . htmlspecialchars($row["name"]) . "</td>
                <td>" . htmlspecialchars($row["description"]) . "</td> 
                <td>" . htmlspecialchars($row["date"]) . "</td>   
                <td><a href='updateevent.php?idevent=" . $row["idevent"] . "'>Edit</a></td>
                <td><a href='deleteevent.php?idevent=" . $row["idevent"] . "'>Delete</a></td>
            </tr>";
    }
    echo "</table>";
} else {
    echo "Tidak ada event yang ditemukan.";
}

if ($total_pages > 1) {
    echo "<div style='margin-top: 20px;'>";
    for ($i = 1; $i <= $total_pages; $i++) {
        echo "<a href='?search=" . urlencode($search_keyword) . "&page=$i' style='margin-right: 10px;'>$i</a>";
    }
    echo "</div>";
}
echo "<a href='insertevent.php'><button style='margin: 10px;'>INSERT</button></a>";
echo "<a href='home.php'><button style='margin: 10px;'>HOME</button></a>";

$conn->close();
?>

</body>
</html>