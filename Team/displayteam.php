    <?php
    require_once("../Class/userclass.php");
    session_start();


    if (!isset($_SESSION['username']) || $_SESSION['proposal_status'] !== 'approved') {
        header("Location: ../index.php");
        exit();
    }
    
    // if($user->proposal_accepted($profile)){
    //     echo "test";
    // }
    // else{
    //     echo "daftar dulu";
    //     header("Location: ../index.php");
    // }
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
                    <li><a href="../Member/applyteam.php">Apply Team</a></li>
                    <li><a href="../Team/displayteam.php">Lihat Team</a></li>
                    <li><a href="../Portal/logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>

        <br>

        <select id="select_game" name="idgame" required>
            <option value="">Pilih Game</option>
            <?php
            require_once ("../Class/gameclass.php");
            $team = new Game(); 
            $result = $team->getGame(''); 

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row["idgame"] . "'>" . htmlspecialchars($row["name"]) . "</option>";
                }
            } else {
                echo "<option value=''>No games available</option>";
            }
            ?>
        </select>
        
        <select id="select_team">
            <option value="">Pilih Team</option>
        </select>

        <br><br>

        <table id="member_table">
            <thead>
                <tr>
                    <th>Member Name</th>
                    <th>Team Name</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>

        <br><br><br>

      
        <table id="event_table">
            <thead>
                <tr>
                    <th>ID Event</th>
                    <th>Name Event</th>
                </tr>
            </thead>
        <tbody></tbody>
        </table>
        


        <table id="achievement_table">
            <thead>
                <tr>
                    <th>ID Achievement</th>
                    <th>Name Achievement</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>

        <br><br>
        <button id="view_event_details" style="display: none;">Lihat Detail Semua Event</button>
        <button id="view_achievement_details" style="display: none;">Lihat Detail Semua Achievement</button>

        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>    
        <script>
            $("body").on("change", "#select_game", function(){
        var idgame = $(this).val();
        $.post("getteam.php", { idgame: idgame })
        .done(function(data) {
            var json = JSON.parse(data);
            console.log("Teams fetched: ", json); 
            
            $("#select_team").html("<option value=''>Pilih Team</option>");
            for (var i = 0; i < json.length; i++) {
                var teamName = json[i].name;
                var idteam = json[i].idteam;
                var str = "<option value='" + idteam + "'>" + teamName + "</option>";
                $("#select_team").append(str);
            }
        });
    });

    $("body").on("change", "#select_team", function(){
        var idteam = $(this).val();
        if (idteam) {
            $.post("getmember.php", { idteam: idteam })
            .done(function(data) {
                var json = JSON.parse(data);
                console.log("Members fetched: ", json); 

                var tableBody = $("#member_table tbody");
                tableBody.empty();

                if (json.length > 0) {
                    $("#member_table").show();
                    for (var i = 0; i < json.length; i++) {
                        var memberName = json[i].nama;
                        var teamName = json[i].team_name;
                        var row = "<tr><td>" + memberName + "</td><td>" + teamName + "</td></tr>";
                        tableBody.append(row);
                    }
                } else {
                    $("#member_table").hide();
                }
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                console.error("Error fetching members: ", textStatus, errorThrown);
            });
        } else {
            $("#member_table").hide();
        }
    });

    $("body").on("change", "#select_team", function() {
    var idteam = $(this).val();
    if (idteam) {
        $.post("getevent.php", { idteam: idteam })
        .done(function(data) {
            var json = JSON.parse(data);
            var tableBody = $("#event_table tbody");
            tableBody.empty();

            if (json.length > 0) {
                $("#event_table").show();
                $("#view_event_details").show(); 
                
                
                $("#view_event_details").attr("data-idteam", idteam); 

                for (var i = 0; i < json.length; i++) {
                    var idEvent = json[i].id;
                    var eventName = json[i].event_name;
                    var row = "<tr><td>" + idEvent + "</td><td>" + eventName + "</td></tr>";
                    tableBody.append(row);
                }
            } else {
                $("#event_table").hide();
                $("#view_event_details").hide(); 
            }
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            console.error("Error fetching events: ", textStatus, errorThrown);
        });
    } else {
        $("#event_table").hide();
        $("#view_event_details").hide();
    }
});

$("body").on("change", "#select_team", function() {
    var idteam = $(this).val();
    if (idteam) {
        $.post("getachievement.php", { idteam: idteam })
        .done(function(data) {
            var json = JSON.parse(data);
            var tableBody = $("#achievement_table tbody");
            tableBody.empty();

            if (json.length > 0) {
                $("#achievement_table").show();
                $("#view_achievement_details").show(); 
                
                
                $("#view_achievement_details").attr("data-idteam", idteam); 
                for (var i = 0; i < json.length; i++) {
                    var idAchievement = json[i].id;
                    var achievementName = json[i].name;
                    var row = "<tr><td>" + idAchievement + "</td><td>" + achievementName + "</td></tr>";
                    tableBody.append(row);
                }
            } else {
                $("#achievement_table").hide();
                $("#view_achievement_details").hide(); 
            }
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            console.error("Error fetching achievements: ", textStatus, errorThrown);
        });
    } else {
        $("#achievement_table").hide();
        $("#view_achievement_details").hide();
    }
});


$("#view_event_details").on("click", function() {
    var idEvent = $(this).attr("data-idteam");  
    if (idEvent) {
        window.location.href = "event_detail.php?idteam=" + idEvent;  
    }
});

$("#view_achievement_details").on("click", function() {
    var idAchievement = $(this).attr("data-idteam");  
    if (idAchievement) {
        window.location.href = "achievement_detail.php?idteam=" + idAchievement;  
    }
});

        </script>
    </body>
    </html>
