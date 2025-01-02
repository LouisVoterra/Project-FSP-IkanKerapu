<?php
require_once("../Class/gameclass.php");
require_once("../Class/teamclass.php"); 

session_start();
$loggedInUser = isset($_SESSION['username']) ? $_SESSION['username'] : '';

$team = new Team();
$teams = $team->getAllTeams(); 

$members = [];
$achievements = [];
$events = [];

// Mendapatkan anggota tim dan achievement berdasarkan ID tim yang dipilih
if (isset($_POST['idteam']) && !empty($_POST['idteam'])) {
    $idteam = $_POST['idteam'];
    $members = $team->displayTeam_Member($idteam);
    $achievements = $team->displayAchievement_Team($idteam); // Ambil achievement tim
    $events = $team->displayEvent_Team($idteam); 
}

$game = new Game();
$games = $game->getGame('');

// Mendapatkan tim berdasarkan ID game yang dipilih
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idgame']) && !empty($_POST['idgame'])) {
    $idgame = $_POST['idgame'];
    $teams = $team->getTeamsByGameId($idgame); 
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
                <li><a href="../team/daftarteam.php">Daftar Team</a></li>
                <li><a href="../Member/applyteam.php">Apply Team</a></li>
                <li><a href="../Team/displayteam.php">Lihat Team</a></li>
                <li><a href="../Portal/logout.php">Logout</a></li>
            </ul>
        </nav>
    </div>

    <!-- Form untuk memilih game -->
    <form method="POST" action="">
        <label for="select_game">Pilih Game:</label>
        <select id="select_game" name="idgame" onchange="this.form.submit()">
            <option value="">Pilih Game</option>
            <?php while ($row = $games->fetch_assoc()): ?>
                <option value="<?= htmlspecialchars($row['idgame']) ?>" <?= (isset($_POST['idgame']) && $_POST['idgame'] === $row['idgame']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($row['name']) ?>
                </option>
            <?php endwhile; ?>
        </select>
    </form>

    <?php if (!empty($teams)): ?>
        <form method="POST" action="">
            <label for="select_team">Pilih Team:</label>
            <select id="select_team" name="idteam" onchange="this.form.submit()">
                <option value="">Pilih Team</option>
                <?php foreach ($teams as $team): ?>
                    <option value="<?= htmlspecialchars($team['idteam']) ?>" <?= (isset($_POST['idteam']) && $_POST['idteam'] === $team['idteam']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($team['team_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>
    <?php endif; ?>

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
        if ($namaMember === $loggedInUser) {
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
    <?php elseif (isset($_POST['idteam']) && empty($members)): ?>
        <p>Tim ini tidak memiliki anggota.</p>
    <?php endif; ?>

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
    <?php elseif (isset($_POST['idteam']) && empty($achievements)): ?>
        <p>Tim ini belum memiliki prestasi.</p>
    <?php endif; ?>
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
    <?php elseif (isset($_POST['idteam']) && empty($events)): ?>
        <p>Tim ini belum mengikuti event apa pun.</p>
    <?php endif; ?>
</body>
</html>
