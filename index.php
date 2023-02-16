<?php
session_start();
function data($cell, $i)
{
   if ($cell[$i] == 0) {
      echo ('<input type="radio" name="index" value="' . $i . '">');
   } else {
      echo ($cell[$i]);
   }
}

if (!(isset($_SESSION["gameboard"]) and
   isset($_SESSION["move_counter"]) and
   isset($_SESSION["X_score"]) and
   isset($_SESSION["O_score"]) and
   isset($_SESSION["first_player"])
)) {
   $_SESSION["gameboard"] = array(0, 0, 0, 0, 0, 0, 0, 0, 0);
   $_SESSION["move_counter"] = 0;
   $_SESSION["X_score"] = 0;
   $_SESSION["O_score"] = 0;
   $_SESSION["first_player"] = rand(1, 2);
}

$winner = "none";

if ($_POST and $_SESSION["move_counter"] <= 9) {
   $i = $_POST["index"];

   if ($_SESSION["gameboard"][$i] == 0) {
      if ($_SESSION["first_player"] == 1) {

         if ($_SESSION["move_counter"] % 2 == 0) {
            $_SESSION["gameboard"][$i] = "X";
            $_SESSION["move_counter"] += 1;
         } else {
            $_SESSION["gameboard"][$i] = "O";
            $_SESSION["move_counter"] += 1;
         }
      } else {

         if ($_SESSION["move_counter"] % 2 == 0) {
            $_SESSION["gameboard"][$i] = "O";
            $_SESSION["move_counter"] += 1;
         } else {
            $_SESSION["gameboard"][$i] = "X";
            $_SESSION["move_counter"] += 1;
         }
      }
   } else {
      echo ('<p class="error_message">Mossa non valida, riprova!</p>');
   }
}



if ($_SESSION["move_counter"] >= 5) {
   if (
      $_SESSION["gameboard"][0] == $_SESSION["gameboard"][1] and
      $_SESSION["gameboard"][1] == $_SESSION["gameboard"][2]
   ) {
      $winner = $_SESSION["gameboard"][0];
   } elseif (
      $_SESSION["gameboard"][3] == $_SESSION["gameboard"][4] and
      $_SESSION["gameboard"][4] == $_SESSION["gameboard"][5]
   ) {
      $winner = $_SESSION["gameboard"][3];
   } elseif (
      $_SESSION["gameboard"][6] == $_SESSION["gameboard"][7] and
      $_SESSION["gameboard"][7] == $_SESSION["gameboard"][8]
   ) {
      $winner = $_SESSION["gameboard"][6];
   } elseif (
      $_SESSION["gameboard"][0] == $_SESSION["gameboard"][3] and
      $_SESSION["gameboard"][3] == $_SESSION["gameboard"][6]
   ) {
      $winner = $_SESSION["gameboard"][0];
   } elseif (
      $_SESSION["gameboard"][1] == $_SESSION["gameboard"][4] and
      $_SESSION["gameboard"][4] == $_SESSION["gameboard"][7]
   ) {
      $winner = $_SESSION["gameboard"][1];
   } elseif (
      $_SESSION["gameboard"][2] == $_SESSION["gameboard"][5] and
      $_SESSION["gameboard"][5] == $_SESSION["gameboard"][8]
   ) {
      $winner = $_SESSION["gameboard"][2];
   } elseif (
      $_SESSION["gameboard"][0] == $_SESSION["gameboard"][4] and
      $_SESSION["gameboard"][4] == $_SESSION["gameboard"][8]
   ) {
      $winner = $_SESSION["gameboard"][0];
   } elseif (
      $_SESSION["gameboard"][2] == $_SESSION["gameboard"][4] and
      $_SESSION["gameboard"][4] == $_SESSION["gameboard"][6]
   ) {
      $winner = $_SESSION["gameboard"][2];
   } elseif (
      $_SESSION["move_counter"] == 9 and (!($_SESSION["gameboard"][0] == $_SESSION["gameboard"][1] and $_SESSION["gameboard"][1] == $_SESSION["gameboard"][2]) and
         !($_SESSION["gameboard"][3] == $_SESSION["gameboard"][4] and $_SESSION["gameboard"][4] == $_SESSION["gameboard"][5]) and
         !($_SESSION["gameboard"][6] == $_SESSION["gameboard"][7] and $_SESSION["gameboard"][7] == $_SESSION["gameboard"][8]) and
         !($_SESSION["gameboard"][0] == $_SESSION["gameboard"][3] and $_SESSION["gameboard"][3] == $_SESSION["gameboard"][6]) and
         !($_SESSION["gameboard"][1] == $_SESSION["gameboard"][4] and $_SESSION["gameboard"][4] == $_SESSION["gameboard"][7]) and
         !($_SESSION["gameboard"][2] == $_SESSION["gameboard"][5] and $_SESSION["gameboard"][5] == $_SESSION["gameboard"][8]) and
         !($_SESSION["gameboard"][0] == $_SESSION["gameboard"][4] and $_SESSION["gameboard"][4] == $_SESSION["gameboard"][8]) and
         !($_SESSION["gameboard"][2] == $_SESSION["gameboard"][4] and $_SESSION["gameboard"][4] == $_SESSION["gameboard"][6])
      )
   ) {
      $winner = "pareggio";
   }

   if ($winner == "X") {
      $_SESSION["X_score"] += 1;
      $_SESSION["gameboard"] = array(0, 0, 0, 0, 0, 0, 0, 0, 0);
      $_SESSION["move_counter"] = 0;
      $_SESSION["first_player"] = rand(1, 2);
   } elseif ($winner == "O") {
      $_SESSION["O_score"] += 1;
      $_SESSION["gameboard"] = array(0, 0, 0, 0, 0, 0, 0, 0, 0);
      $_SESSION["move_counter"] = 0;
      $_SESSION["first_player"] = rand(1, 2);
   } elseif ($winner == "pareggio") {
      $_SESSION["gameboard"] = array(0, 0, 0, 0, 0, 0, 0, 0, 0);
      $_SESSION["move_counter"] = 0;
      $_SESSION["first_player"] = rand(1, 2);
   }
}
/* 
print_r($_SESSION["gameboard"]);
echo "<br>move_counter: " . $_SESSION["move_counter"];
echo "<br>X_score: " . $_SESSION["X_score"];
echo "<br>O_score: " . $_SESSION["O_score"];
echo "<br>first_player: " . $_SESSION["first_player"]; */


?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
   <link rel="stylesheet" href="./style.css">
   <title>TRIS</title>
</head>

<body>
   <header>
      <h1>X <span><?php echo ($_SESSION["X_score"]) ?></span> - <span><?php echo ($_SESSION["O_score"]) ?></span> O</h1>
      <h2>Primo a giocare: <span>
            <?php
            if ($_SESSION["first_player"] == 1) {
               echo ("X");
            } else {

               echo ("O");
            }
            ?>
         </span></h2>
   </header>
   <form action="./index.php" method="post">
      <div class="gamefield">
         <div class="area a1"><?php data($_SESSION["gameboard"], 0) ?></div>
         <div class="area a2"><?php data($_SESSION["gameboard"], 1) ?></div>
         <div class="area a3"><?php data($_SESSION["gameboard"], 2) ?></div>
         <div class="area a4"><?php data($_SESSION["gameboard"], 3) ?></div>
         <div class="area a5"><?php data($_SESSION["gameboard"], 4) ?></div>
         <div class="area a6"><?php data($_SESSION["gameboard"], 5) ?></div>
         <div class="area a7"><?php data($_SESSION["gameboard"], 6) ?></div>
         <div class="area a8"><?php data($_SESSION["gameboard"], 7) ?></div>
         <div class="area a9"><?php data($_SESSION["gameboard"], 8) ?></div>
         <div class="confirm">
            <td colspan="3"><button type="submit">Conferma</button>
         </div>
      </div>
   </form>
</body>

</html>