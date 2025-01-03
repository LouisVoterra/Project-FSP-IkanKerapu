<?php
require_once("../Class/gameclass.php");
require_once("../Class/teamclass.php");

session_start();
$nama = $_SESSION['nama'];
$idteam = $_SESSION['id_team'];
$team = new Team();

// Mengambil tim berdasarkan username yang login
$teams = $team->getTeamById($idteam);

$members = [];
$achievements = [];
$events = [];

// Mendapatkan anggota tim dan achievement berdasarkan ID tim
if (!empty($teams)) {
    $idteam = $teams; // Asumsikan data tim memiliki key 'id'
    $members = $team->displayTeam_Member($idteam);
    $achievements = $team->displayAchievement_Team($idteam);
    $events = $team->displayEvent_Team($idteam);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Team</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="position">
        <nav class="navigation">
            <ul>
                <li><a href="../index.php">Halaman Utama</a></li>
                <li><a href="../Member/applyteam.php">Apply Team</a></li>
                <li><a href="../Team/displayteam.php">Lihat Team</a></li>
                <li><a href="../Portal/logout.php">Logout</a></li>
            </ul>
        </nav>
    </div>

    <!-- Tampilkan anggota tim jika ada -->
    <?php if (!empty($members)): ?>
        <h2>Anggota Tim</h2>
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Nama Team</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($members as $member): ?>
                    <?php 

                    
                    
                    $namaMember = $member['nama'];
                    if (strcasecmp($namaMember, $nama) == 0) { // Membandingkan tanpa memperhatikan huruf besar/kecil
                        $namaMember .= " (saya)";
                    }
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($namaMember) ?></td>
                        <td><?= htmlspecialchars($member['team_name']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Tim ini tidak memiliki anggota.</p>
    <?php endif; ?>

    <br><br>

    <!-- Tampilkan achievement jika ada -->
    <?php if (!empty($achievements)): ?>
        <h2>Prestasi Tim</h2>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul Prestasi</th>
                    <th>Deskripsi</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                foreach ($achievements as $achievement): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($achievement['name']) ?></td>
                        <td><?= htmlspecialchars($achievement['description']) ?></td>
                        <td><?= htmlspecialchars($achievement['date']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Tim ini belum memiliki prestasi.</p>
    <?php endif; ?>

    <br><br>

    <!-- Tampilkan event jika ada -->
    <?php if (!empty($events)): ?>
        <h2>Event yang Diikuti Tim</h2>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Event</th>
                    <th>Deskripsi</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                foreach ($events as $event): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($event['name']) ?></td>
                        <td><?= htmlspecialchars($event['description']) ?></td>
                        <td><?= htmlspecialchars($event['date']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Tim ini belum mengikuti event apa pun.</p>
    <?php endif; ?>
</body>
</html>
