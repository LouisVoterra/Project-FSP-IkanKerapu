<?php
require_once("../class/teamclass.php");
require_once("../Class/gameclass.php");

$game = new Game();
$result = $game->getGame('');

if (isset($_GET['idteam'])) {
    $idteam = intval($_GET['idteam']);
} else {
    die("ID tim tidak ditemukan.");
}

$teamObj = new Team();


$limit = 5; 
$pageMembers = isset($_GET['pageMembers']) ? (int)$_GET['pageMembers'] : 1;
$pageEvents = isset($_GET['pageEvents']) ? (int)$_GET['pageEvents'] : 1;
$pageAchievements = isset($_GET['pageAchievements']) ? (int)$_GET['pageAchievements'] : 1;

$offsetMembers = ($pageMembers - 1) * $limit;
$offsetEvents = ($pageEvents - 1) * $limit;
$offsetAchievements = ($pageAchievements - 1) * $limit;


$totalMembers = $teamObj->getTotalDataMembers($idteam);
$totalEvents = $teamObj->getTotalDataEvents($idteam);
$totalAchievements = $teamObj->getTotalDataAchievements($idteam);

$totalPagesMembers = ceil($totalMembers / $limit);
$totalPagesEvents = ceil($totalEvents / $limit);
$totalPagesAchievements = ceil($totalAchievements / $limit);


$members = $teamObj->displayTeam_Member($idteam, $offsetMembers, $limit);
$events = $teamObj->displayEvent_Team($idteam, $offsetEvents, $limit);
$achievements = $teamObj->displayAchievement_Team($idteam, $offsetAchievements, $limit);


$teamDetails = $teamObj->getTeamById($idteam);
if (!$teamDetails) {
    die("Tim tidak ditemukan.");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Tim - <?= htmlspecialchars($teamDetails['name']) ?></title>
    <link rel="stylesheet" href="../style.css">
    <script>
        function submitForm() {
            document.getElementById("game-form").submit();
        }
    </script>
</head>
<body>
    <!-- Navbar -->
    <div class="position">
        <nav class="navigation">
            <ul>
                <li><a href="../Portal/login.php">Login</a></li>
                <li>
                    <form id="game-form" action="../Team/daftar_team.php" method="GET">
                        <select name="idgame" id="game-dropdown" onchange="submitForm()">
                            <option value="" disabled selected>-- Pilih Game --</option>
                            <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $selected = ($row['idgame'] == $teamDetails['idgame']) ? 'selected' : '';
                                        echo '<option value="' . $row['idgame'] . '" ' . $selected . '>' . htmlspecialchars($row['name']) . '</option>';
                                    }
                                } else {
                                    echo '<option value="">Tidak ada game tersedia</option>';
                                }          
                            ?> 
                        </select>
                    </form>
                </li>
                <li><a href="../about.php">Tentang</a></li>
                <li><a href="../index.php">Utama</a></li>
            </ul>
        </nav>
    </div>
    
    <br><br>

    <h2>Nama Tim: <?= htmlspecialchars($teamDetails['name']) ?></h2>

    <!-- Daftar Member -->
    <h3>Anggota Tim:</h3>
    <?php if (!empty($members)): ?>
        <table>
            <thead>
                <tr>
                    <th>Nama Member</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($members as $member): ?>
                    <tr>
                        <td><?= htmlspecialchars($member['nama']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="pagination">
            <?php for ($i = 1; $i <= $totalPagesMembers; $i++): ?>
                <a href="?idteam=<?= $idteam ?>&pageMembers=<?= $i ?>"><?= $i ?></a>
            <?php endfor ?>
        </div>
    <?php else: ?>
        <p>Tim ini tidak memiliki anggota.</p>
    <?php endif; ?>

    <!-- Daftar Event -->
    <h3>Event yang Diikuti:</h3>
    <?php if (!empty($events)): ?>
        <table>
            <thead>
                <tr>
                    <th>Nama Event</th>
                    <th>Tanggal</th>
                    <th>Deskripsi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($events as $event): ?>
                    <tr>
                        <td><?= htmlspecialchars($event['name']) ?></td>
                        <td><?= htmlspecialchars($event['date']) ?></td>
                        <td><?= htmlspecialchars($event['description']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="pagination">
            <?php for ($i = 1; $i <= $totalPagesEvents; $i++): ?>
                <a href="?idteam=<?= $idteam ?>&pageEvents=<?= $i ?>"><?= $i ?></a>
            <?php endfor; ?>
        </div>
    <?php else: ?>
        <p>Tim ini belum mengikuti event apapun.</p>
    <?php endif; ?>

    <!-- Daftar Pencapaian -->
    <h3>Pencapaian Tim:</h3>
    <?php if (!empty($achievements)): ?>
        <table>
            <thead>
                <tr>
                    <th>Nama Pencapaian</th>
                    <th>Tanggal</th>
                    <th>Deskripsi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($achievements as $achievement): ?>
                    <tr>
                        <td><?= htmlspecialchars($achievement['name']) ?></td>
                        <td><?= htmlspecialchars($achievement['date']) ?></td>
                        <td><?= htmlspecialchars($achievement['description']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="pagination">
            <?php for ($i = 1; $i <= $totalPagesAchievements; $i++): ?>
                <a href="?idteam=<?= $idteam ?>&pageAchievements=<?= $i ?>"><?= $i ?></a>
            <?php endfor; ?>
        </div>
    <?php else: ?>
        <p>Tim ini belum memiliki pencapaian.</p>
    <?php endif; ?>

</body>
</html>