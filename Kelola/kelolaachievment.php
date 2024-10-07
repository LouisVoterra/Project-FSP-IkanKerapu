<?php
    require_once("movieclass.php");
    require_once("pemainclass.php");
?>
<html>
    <head>
        <title>Movie</title>
        <style>
            .text_merah {
                color: red;
            }

            .poster {
                width: 50px;
                height: 100px;
                object-fit: cover;
            }

            #kiri {
                display: inline-block;
                width: 200px;
            }

            #kanan {
                display: inline-block;
                min-width: 800px;
            }

            body {
                margin-left:auto;
                margin-right:auto;
                width: 1200px;
            }
        </style>
    </head>
    <body>
        <h1>My Movie</h1>
        <div id="kiri">
            <ul>
                <li><a href="#">Daftar Movie</a></li>
                <li><a href="#">Daftar Pemain</a></li>
                <li><a href="#">Daftar Genre</a></li>
            </ul>
        </div>
        <div id="kanan">
            <h2>Daftar Movie</h2>
            <a href="insertmovie.php">Tambah Movie</a><br><br>
            <form method="get" action="movie.php">
                <label for="judul">Masukkan Judul:</label>
                <input type="text" id="judul" name="judul"
                       value="<?php echo @$_GET["judul"]; ?>" >
                <input type="submit" value="Submit" name="btnSubmit">
                <a href="movie.php">Reset</a>
            </form>

    <?php 
        $movie = new Movie();
        $totaldata = 0;
        $perhalaman = 5;       
        $currenthalaman = 1;

        if(isset($_GET['offset'])) { 
            $offset = $_GET['offset']; 
            $currenthalaman = $_GET['offset']/$perhalaman + 1;  // Baca offset dan kalkulasi halaman saat ini
        } else { $offset = 0; }
        
        if(isset($_GET["judul"])) {
            $res = $movie->getMovie($_GET["judul"], $offset, $perhalaman);
            $totaldata = $movie->getTotalData($_GET["judul"]);
        } else {
            $res = $movie->getMovie("", $offset, $perhalaman);
            $totaldata = $movie->getTotalData("");
        }       

        $jumlahhalaman = ceil($totaldata/$perhalaman);

        echo "<table border='1'>";
        echo "<tr>
                <th>Judul</th>
                <th>Tgl. Rilis</th> 
                <th>Skor</th>
                <th>Pemain</th>
                <th>Sinopsis</th>
                <th>Serial</th>
                <th>Genre</th>
                <th>Aksi</th>
            </tr>";

        while($row = $res->fetch_assoc()) {
            $formatrilis = strftime("%d %B %Y", strtotime($row['rilis']));
            $formatserial = "";
            if($row['serial']) { 
                $formatserial="Ya";
            } else { 
                $formatserial="Tidak";
            }
            $textmerah = '';
            if($row['skor'] < 5) {
                $textmerah = "class='text_merah'";
            }

            $namaposter = $row["idmovie"].".".$row["extention"];
            if(!file_exists("images/".$namaposter)) {
                $namaposter = "blank.jpg";
            }            

            //query pemain
            $pemain = new Pemain();
            $resPemain = $pemain->getPemain($row['idmovie']);           

            $pemain = "";
            while($rowPemain = $resPemain->fetch_assoc()) {
                $pemain.= $rowPemain['nama'].", ";
            }

            echo "<tr $textmerah>
                    <td><img class='poster' src='images/".$namaposter."'/><br>".$row['idmovie']."<br>".$row['judul']."</td>
                    <td>".$formatrilis."</td>
                    <td>".$row['skor']."</td>
                    <td>".$pemain."</td>
                    <td>".$row['sinopsis']."</td>
                    <td>".$formatserial."</td>
                    <td>".$row['genre']."</td>
                    <td>
                        <a href='editmovie.php?idmovie=".$row['idmovie']."'>Ubah Data</a> 
                        <a href='hapusmovie.php?idmovie=".$row['idmovie']."'>Hapus Data</a>
                    </td>
                </tr>";
        }

        echo "</table>";

        // paging
        echo "<div>Total Data: ".$totaldata."</div>";
        echo "<a href='movie.php?offset=0'>First</a>";
        
        for($i = 1; $i <= $jumlahhalaman; $i++) {
            $off = ($i-1) * $perhalaman;
            if($currenthalaman == $i) {                
                echo "<a href='movie.php?offset=".$off."'>
                      <strong style='color:red'>$i</strong></a> ";
            } else {
                echo "<a href='movie.php?offset=".$off."'>".$i."</a> ";
            }
        }
        $lastoffset = ($jumlahhalaman-1)*$perhalaman;
        echo "<a href='movie.php?offset=".$lastoffset."'>Last</a>";
        ?>
        </div>    
    </body>
</html>