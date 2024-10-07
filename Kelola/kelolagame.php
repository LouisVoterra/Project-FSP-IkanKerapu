<?php
    require_once("../Class/gameclass.php");    
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
        <h1>Kelola Game</h1>
        <div id="kanan">
            <a href="../Game/insertgame.php">Tambah Game</a><br><br>
            <form method="get" action="kelolagame.php">
                <label for="judul">Masukkan Judul:</label>
                <input type="text" id="name" name="name"
                       value="<?php echo @$_GET["name"]; ?>" >
                <input type="submit" value="Submit" name="btnSubmit">
                <a href="kelolagame.php">Reset</a>
            </form>

    <?php 
        $movie = new Game();
        $totaldata = 0;
        $perhalaman = 5;       
        $currenthalaman = 1;

        if(isset($_GET['offset'])) { 
            $offset = $_GET['offset']; 
            $currenthalaman = $_GET['offset']/$perhalaman + 1;  // Baca offset dan kalkulasi halaman saat ini
        } else { $offset = 0; }
        
        if(isset($_GET["name"])) {
            $res = $movie->getGame($_GET["name"], $offset, $perhalaman);
            $totaldata = $movie->getTotalData($_GET["name"]);
        } else {
            $res = $movie->getGame("", $offset, $perhalaman);
            $totaldata = $movie->getTotalData("");
        }       

        $jumlahhalaman = ceil($totaldata/$perhalaman);

        echo "<br><table border='1'>
            <tr>
                <th>ID Game</th>
                <th>Nama Game</th>
                <th>Description</th>
                <th></th>
                <th></th>
            </tr>";

            while($row = $res->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($row["idgame"]) . "</td>
                        <td>" . htmlspecialchars($row["name"]) . "</td>
                        <td>" . htmlspecialchars($row["description"]) . "</td>
                        <td><a href='../Game/updategame.php?idgame=" . $row["idgame"] . "'>Edit</a></td>
                        <td><a href='../Game/deletegame.php?idgame=" . $row["idgame"] . "'>Delete</a></td>
                    </tr>";
            }
            echo "</table>";

        // paging
        echo "<div>Total Data: ".$totaldata."</div>";
        echo "<a href='kelolagame.php?offset=0'>First</a>";
        
        for($i = 1; $i <= $jumlahhalaman; $i++) {
            $off = ($i-1) * $perhalaman;
            if($currenthalaman == $i) {                
                echo "<a href='kelolagame.php?offset=".$off."'>
                      <strong style='color:red'>$i</strong></a> ";
            } else {
                echo "<a href='kelolagame.php?offset=".$off."'>".$i."</a> ";
            }
        }
        $lastoffset = ($jumlahhalaman-1)*$perhalaman;
        echo "<a href='kelolagame.php?offset=".$lastoffset."'>Last</a>";
        ?>
        </div>    
    </body>
</html>