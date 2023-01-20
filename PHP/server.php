<?php
// Connect to the database
$conn = mysqli_connect("host", "username", "PASSWORD_HERE", "reactapi");

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];

    $check_query = "SELECT * FROM entries WHERE email = '$email'";
    $check_result = mysqli_query($conn, $check_query);
    $num_submissions = mysqli_num_rows($check_result);

    if ($num_submissions >= 3) {
        echo "You have been disqualified for having more than 2 submissions.";
    } else {
        $chance = 1;
        if ($num_submissions == 2) {
            $chance = 2;
        } elseif ($num_submissions == 5) {
            $chance = 3;
        }

        $query = "INSERT INTO entries (name, email, chance) VALUES ('$name', '$email', '$chance')";
        mysqli_query($conn, $query);
    }
}

if (isset($_GET['pick_winner'])) {
    $query = "SELECT * FROM entries";
    $result = mysqli_query($conn, $query);

    $total_chance = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        $total_chance += $row['chance'];
    }

    $rand = rand(0, $total_chance);

    $winner = "";
    $counter = 0;
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $counter += $row['chance'];
        if ($counter >= $rand) {
            $winner = $row;
            break;
        }
    }

    echo "The winner is: " . $winner['name'] . " (" . $winner['email'] . ")";
}

// <?php
    //header('Access-Control-Allow-Origin: http://localhost:3000');
    //$user = $_POST['name'];
    //echo ("Hello from server: $user");
// 