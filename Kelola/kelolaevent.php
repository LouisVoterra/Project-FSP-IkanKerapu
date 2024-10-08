<?php
    require_once("../Class/eventclass.php");    
?>
<html>
    <head>
        <title>Kelola Game</title>
    </head>
    <link rel="stylesheet" href="../style.css">
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
        <h1>Kelola Event</h1>
        <div id="kanan">
            <a href="../Event/insertevent.php">Tambah Event</a><br><br>
            <form method="get" action="kelolaevent.php">
                <label for="judul">Masukkan Judul:</label>
                <input type="text" id="name" name="name"
                       value="<?php echo @$_GET["name"]; ?>" >
                <input type="submit" value="Submit" name="btnSubmit">
                <a href="kelolaevent.php">Reset</a>
            </form>

    <?php 
        $movie = new Event();
        $totaldata = 0;
        $perhalaman = 5;       
        $currenthalaman = 1;

        if(isset($_GET['offset'])) { 
            $offset = $_GET['offset']; 
            $currenthalaman = $_GET['offset']/$perhalaman + 1;  // Baca offset dan kalkulasi halaman saat ini
        } else { $offset = 0; }
        
        if(isset($_GET["name"])) {
            $res = $movie->getEvent($_GET["name"], $offset, $perhalaman);
            $totaldata = $movie->getTotalData($_GET["name"]);
        } else {
            $res = $movie->getEvent("", $offset, $perhalaman);
            $totaldata = $movie->getTotalData("");
        }       

        $jumlahhalaman = ceil($totaldata/$perhalaman);

        echo "<br><table border='1'>
            <tr>
                <th>ID Event</th>
                <th>Nama Team</th>
                <th>Nama Event</th>
                <th>Deskripsi</th>
                <th>Tanggal</th>
                <th></th>
                <th></th>
            </tr>";

            while($row = $res->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($row["event_id"]) . "</td>
                        <td>" . htmlspecialchars($row["team_name"]) . "</td>
                        <td>" . htmlspecialchars($row["event_name"]) . "</td>
                        <td>" . htmlspecialchars($row["event_description"]) . "</td>
                        <td>" . htmlspecialchars($row["event_date"]) . "</td>
                        <td><a href='../Event/updateevent.php?idevent=" . $row["event_id"] . "'>Edit</a></td>
                        <td><a href='../Event/deleteevent.php?idevent=" . $row["event_id"] . "'>Delete</a></td>
                    </tr>";
            }
            echo "</table>";

        // paging
        echo "<div>Total Data: ".$totaldata."</div>";
        echo "<a href='kelolaevent.php?offset=0'>First</a>";
        
        for($i = 1; $i <= $jumlahhalaman; $i++) {
            $off = ($i-1) * $perhalaman;
            if($currenthalaman == $i) {                
                echo "<a href='kelolaevent.php?offset=".$off."'>
                      <strong style='color:red'>$i</strong></a> ";
            } else {
                echo "<a href='kelolaevent.php?offset=".$off."'>".$i."</a> ";
            }
        }
        $lastoffset = ($jumlahhalaman-1)*$perhalaman;
        echo "<a href='kelolaevent.php?offset=".$lastoffset."'>Last</a>";
        ?>
        </div>    
    </body>
</html>