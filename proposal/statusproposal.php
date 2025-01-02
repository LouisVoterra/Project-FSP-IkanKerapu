<?php
    require_once("../Class/userclass.php");    
?>
<html>
    <head>
        <title>Daftar Proposal ke Tim</title>
    </head>
    <link rel="stylesheet" href="../style.css">
    <body>
    <div class="position">
        <nav class="navigation">
            <ul>
                <li><a href="../Member/applyteam.php">Apply Team</a></li>
                <li><a href="../proposal/statusproposal.php">Status Proposal</a></li>
            </ul>
        </nav>
    </div>
        <h1>Daftar Proposal</h1>
        <div id="kanan">
            <form method="get" action="daftar_proposal.php">
                <label for="judul">Masukkan Judul:</label>
                <input type="text" id="name" name="name"
                       value="<?php echo @$_GET["name"]; ?>" >
                <input type="submit" value="Submit" name="btnSubmit">
                <a href="daftar_proposal.php">Reset</a>
            </form>

    <?php 
        $movie = new User();
        $totaldata = 0;
        $perhalaman = 5;       
        $currenthalaman = 1;

        if(isset($_GET['offset'])) { 
            $offset = $_GET['offset']; 
            $currenthalaman = $_GET['offset']/$perhalaman + 1; 
        } else { $offset = 0; }
        
        if(isset($_GET["name"])) {
            $res = $movie->status_proposal($_GET["name"], $offset, $perhalaman);
            $totaldata = $movie->getTotalData($_GET["name"]);
        } else {
            $res = $movie->status_proposal("", $offset, $perhalaman);
            $totaldata = $movie->getTotalData("");
        }       

        $jumlahhalaman = ceil($totaldata/$perhalaman);

        echo "<br><table border='1'>
            <tr>
                <th>ID Proposal</th>
                <th>Nama Team</th>
                <th>Deskripsi</th>
                <th>Status</th>
            </tr>";

            while($row = $res->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($row["id"]) . "</td>
                        <td>" . htmlspecialchars($row["team_name"]) . "</td>
                        <td>" . htmlspecialchars($row["description"]) . "</td>
                        <td>" . htmlspecialchars($row["status"]) . "</td>
                    </tr>";
            }
            echo "</table>";

        // paging
        echo "<div>Total Data: ".$totaldata."</div>";
        echo "<a href='status_proposal.php?offset=0'>First</a>";
        
        for($i = 1; $i <= $jumlahhalaman; $i++) {
            $off = ($i-1) * $perhalaman;
            if($currenthalaman == $i) {                
                echo "<a href='daftar_proposal.php?offset=".$off."'>
                      <strong style='color:red'>$i</strong></a> ";
            } else {
                echo "<a href='status_proposal.php?offset=".$off."'>".$i."</a> ";
            }
        }
        $lastoffset = ($jumlahhalaman-1)*$perhalaman;
        echo "<a href='status_proposal.php?offset=".$lastoffset."'>Last</a>";
        ?>
        </div>    
    </body>
</html>