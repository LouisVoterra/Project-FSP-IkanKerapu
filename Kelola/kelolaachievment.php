<?php
    require_once("../Class/achievementclass.php");    
?>
<html>
    <head>
        <title>Kelola Achievement</title>
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
                <li><a href="daftar_proposal.php">Daftar Proposal</a></li>
            </ul>
        </nav>
    </div>
        <h1>Kelola Achievement</h1>
        <div id="kanan">
            <a href="../Achievement/insertachievement.php">Tambah Achievement</a><br><br>
            <form method="get" action="kelolaachievment.php">
                <label for="judul">Masukkan Judul:</label>
                <input type="text" id="name" name="name"
                       value="<?php echo @$_GET["name"]; ?>" >
                <input type="submit" value="Submit" name="btnSubmit">
                <a href="kelolaachievment.php">Reset</a>
            </form>

    <?php 
        $movie = new Achievement();
        $totaldata = 0;
        $perhalaman = 5;       
        $currenthalaman = 1;

        if(isset($_GET['offset'])) { 
            $offset = $_GET['offset']; 
            $currenthalaman = $_GET['offset']/$perhalaman + 1;  
        } else { $offset = 0; }
        
        if(isset($_GET["name"])) {
            $res = $movie->getAchievement($_GET["name"], $offset, $perhalaman);
            $totaldata = $movie->getTotalData($_GET["name"]);
        } else {
            $res = $movie->getAchievement("", $offset, $perhalaman);
            $totaldata = $movie->getTotalData("");
        }       

        $jumlahhalaman = ceil($totaldata/$perhalaman);

        echo "<br><table border='1'>
            <tr>
                <th>ID Achievemet</th>
                <th>Nama Team</th>
                <th>Nama Achievement</th>
                <th>Tanggal</th>
                <th>Deskripsi</th>
            </tr>";

            while($row = $res->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($row["idachievement"]) . "</td>
                        <td>" . htmlspecialchars($row["team_name"]) . "</td>
                        <td>" . htmlspecialchars($row["name_achievement"]) . "</td>
                        <td>" . htmlspecialchars($row["date"]) . "</td>
                        <td>" . htmlspecialchars($row["description"]) . "</td>
                        <td><a href='../Achievement/updateachievement.php?idachievement=" . $row["idachievement"] . "'>Edit</a></td>
                        <td><a href='../Achievement/deleteachievement.php?idachievement=" . $row["idachievement"] . "'>Delete</a></td>
                    </tr>";
            }
            echo "</table>";

        
        echo "<div>Total Data: ".$totaldata."</div>";
        echo "<a href='kelolaachievment.php?offset=0'>First</a>";
        
        for($i = 1; $i <= $jumlahhalaman; $i++) {
            $off = ($i-1) * $perhalaman;
            if($currenthalaman == $i) {                
                echo "<a href='kelolaachievment.php?offset=".$off."'>
                      <strong style='color:red'>$i</strong></a> ";
            } else {
                echo "<a href='kelolaachievment.php?offset=".$off."'>".$i."</a> ";
            }
        }
        $lastoffset = ($jumlahhalaman-1)*$perhalaman;
        echo "<a href='kelolaachievment.php?offset=".$lastoffset."'>Last</a>";
        ?>
        </div>    
    </body>
</html>