<?php
    require_once("../Class/teamclass.php");    
?>
<html>
    <head>
        <title>Kelola Team Informatics Club</title>
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
                <li><a href="../Portal/logout.php">Logout</a></li>
            </ul>
        </nav>
    </div>
        <h1>Kelola Team</h1>
        <div id="kanan">
            <a href="../Team/insertteam.php">Tambah Team</a><br><br>
            <form method="get" action="kelolateam.php">
                <label for="judul">Masukkan Judul:</label>
                <input type="text" id="name" name="name"
                       value="<?php echo @$_GET["name"]; ?>" >
                <input type="submit" value="Submit" name="btnSubmit">
                <a href="kelolateam.php">Reset</a>
            </form>

    <?php 
        $movie = new Team();
        $totaldata = 0;
        $perhalaman = 5;       
        $currenthalaman = 1;

        if(isset($_GET['offset'])) { 
            $offset = $_GET['offset']; 
            $currenthalaman = $_GET['offset']/$perhalaman + 1;  
        } else { $offset = 0; }
        
        if(isset($_GET["name"])) {
            $res = $movie->getTeam($_GET["name"], $offset, $perhalaman);
            $totaldata = $movie->getTotalData($_GET["name"]);
        } else {
            $res = $movie->getTeam("", $offset, $perhalaman);
            $totaldata = $movie->getTotalData("");
        }       

        $jumlahhalaman = ceil($totaldata/$perhalaman);

        echo "<br><table border='1'>
            <tr>
                <th>ID</th>
                <th>Nama Team</th>
                <th>Nama Game</th>
                <th></th>
                <th></th>
            </tr>";

           

            // <td>" . htmlspecialchars($row["idteam"]) . "</td>
            while($row = $res->fetch_assoc()) {

                $namaposter = "../images/" . $row["idteam"] . ".jpg";
        
        // Cek jika gambar tidak ditemukan, cari dengan ekstensi lain (misalnya .png), atau gunakan gambar default
        if (!file_exists($namaposter)) {
            $namaposter = "../images/" . $row["idteam"] . ".png";
            if (!file_exists($namaposter)) {
                $namaposter = "../images/blank.jpg"; // Gambar default jika tidak ditemukan
            }
        }

                echo "<tr>
                        <td><img class='poster' src='../images/".$namaposter."' width='100'/><br>".htmlspecialchars($row["idteam"])."</td>
                       
                        <td>" . htmlspecialchars($row["team_name"]) . "</td>
                        <td>" . htmlspecialchars($row["game_name"]) . "</td>
                        <td><a href='../Team/updateteam.php?idteam=" . $row["idteam"] . "'>Edit</a></td>
                        <td><a href='../Team/deleteteam.php?idteam=" . $row["idteam"] . "'>Delete</a></td>
                    </tr>";
            }
            echo "</table>";

        
        echo "<div>Total Data: ".$totaldata."</div>";
        echo "<a href='kelolateam.php?offset=0'>First</a>";
        
        for($i = 1; $i <= $jumlahhalaman; $i++) {
            $off = ($i-1) * $perhalaman;
            if($currenthalaman == $i) {                
                echo "<a href='kelolateam.php?offset=".$off."'>
                      <strong style='color:red'>$i</strong></a> ";
            } else {
                echo "<a href='kelolateam.php?offset=".$off."'>".$i."</a> ";
            }
        }
        $lastoffset = ($jumlahhalaman-1)*$perhalaman;
        echo "<a href='kelolateam.php?offset=".$lastoffset."'>Last</a>";
        ?>
        </div>    
    </body>
</html>