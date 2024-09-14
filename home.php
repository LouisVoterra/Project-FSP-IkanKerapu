<?php
include 'db.php';


// Query untuk mendapatkan data dari tabel team dan game
$sql = "SELECT t.idteam, t.name AS team_name, g.name AS game_name
        FROM team t
        JOIN game g ON t.idgame = g.idgame";
$result = $conn->query($sql);


// Cek apakah ada hasil
if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Nama Team</th>
                <th>Nama Game</th>
                <th></th>
                <th></th>
            </tr>";

    // Menampilkan data baris per baris
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["idteam"] . "</td>
                <td>" . htmlspecialchars($row["team_name"]) . "</td>
                <td>" . htmlspecialchars($row["game_name"]) . "</td>
                <td><a href='updateteam.php?idteam=" . $row["idteam"] . "'>Edit</a></td>
                <td><a href='deleteteam.php?idteam=" . $row["idteam"] . "'>Delete</a></td>
              </tr>";
    }

    echo "</table>";
} 


echo "<br><a href='insertteam.php'><button style='margin-bottom: 20px;'>INSERT</button></a>";

$sql = "SELECT * FROM game";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<br><table border='1'>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Deskripsi</th>
                <th></th>
                <th></th>
            </tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["idgame"] . "</td>
                <td>" . $row["name"] . "</td>
                <td>" . $row["description"] . "</td>    
                <td><a href='updategame.php?idgame=" . $row["idgame"] . "'>Edit</a></td>
                <td><a href='deletegame.php?idgame=" . $row["idgame"] . "'>Delete</a></td>
              </tr>";
    }
    echo "</table>";
} 


echo "<br><a href='insertgame.php'><button style='margin-bottom: 20px;'>INSERT</button></a>";



$sql = "SELECT * FROM event";
$result = $conn->query($sql);

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
                <td>" . $row["idevent"] . "</td>
                <td>" . $row["name"] . "</td>
                <td>" . $row["description"] . "</td> 
                <td>" . $row["date"] . "</td>   
                <td><a href='updateevent.php?idevent=" . $row["idevent"] . "'>Edit</a></td>
                <td><a href='deleteevent.php?idevent=" . $row["idevent"] . "'>Delete</a></td>
              </tr>";
    }
    echo "</table>";
} 

echo "<br><a href='insertevent.php'><button style='margin-bottom: 20px;'>INSERT</button></a>";

$sql = " SELECT t.name AS team_name, a.idachievement, a.name AS achievement_name, a.date ,a.description
		FROM team t
        JOIN achievement a ON t.idteam = a.idteam";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<br><table border='1'>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Date</th>
                <th>Description</th>
                <th></th>
                <th></th>
            </tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["team_name"] . "</td>
                <td>" . htmlspecialchars($row["achievement_name"]) . "</td>
                <td>" . htmlspecialchars($row["date"]) . "</td> 
                <td>" . $row["description"] . "</td>   
                <td><a href='updateachievement.php?idachievement=" . $row["idachievement"] . "'>Edit</a></td>
                <td><a href='deleteachievement.php?idachievement=" . $row["idachievement"] . "'>Delete</a></td>
              </tr>";
    }
    echo "</table>";
} 

echo "<br><a href='insertachievement.php'><button style='margin-bottom: 20px;'>INSERT</button></a>";

$conn->close();



?>




