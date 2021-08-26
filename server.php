<?php

session_start();


$username = "";
$email    = "";
$phone = "";
$title = "";
$picture = "";
$descreption = "";
$day = "";
$location = "";
$time = "";
$price = "";
$numberOfSeats = "";
$available = true;
$adminMadeFalse = false;

$errors = array();
$_SESSION['success'] = "";

function jsonBeolvas($filenev)
{
    return json_decode(file_get_contents($filenev));
}

function jsonKiir($filenev, $adat)
{
    file_put_contents($filenev, json_encode($adat, JSON_PRETTY_PRINT));
}

$usertable = jsonBeolvas('user.json');
$usermovietable = jsonBeolvas('usermovies.json');
$movietable = jsonBeolvas('movies.json');

foreach ($movietable as $key => $movie) {
    if (!$movie->adminMadeFalse && $movie->numberOfSeats > 0) {
        $time = date("H:i");
        $day = date('N');
        $movieDay = date('N', strtotime($movie->day)); 
        if($day < $movieDay){
            $movie->available = true;
        }
        elseif ($day == $movieDay) {
            $isItNotAvilable = strtotime($time) + 60 * 60;
            $isItNotAvilable = date('H:i', $isItNotAvilable);
            $movie->available = $movie->time <= $isItNotAvilable ? false : true;
            $time = "";
        } else {
            $movie->available = false;
        }
        $time = "";
        $day = "";
    }
    if ($movie->numberOfSeats <= 0) {
        $movie->available = false;
    }
}
jsonKiir('movies.json', $movietable);


function letezik($string, $table, $varible)
{
    foreach ($table as $key => $elem) {
        if ($elem->$varible == $string) {
            return true;
        }
    }
    return false;
}


function newID($table)
{
    $maxid = 0;
    foreach ($table as $key => $movies) {
        if ((int)$movies->id > $maxid) {
            $maxid = (int)$movies->id;
        }
    }
    return $maxid + 1;
}

if (isset($_POST['reg_user'])) {

    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password_1 = $_POST['password_1'];
    $password_2 = $_POST['password_2'];
    $admin = false;



    if (empty($username)) {
        array_push($errors, "User name must be set!");
    }
    if (empty($email)) {
        array_push($errors, "Email must be set!");
    }
    if (empty($password_1)) {
        array_push($errors, " Password must be set!");
    }
    if (empty($phone)) {
        array_push($errors, " Phone number must be set!");
    }

    if ($password_1 != $password_2) {
        array_push($errors, "Passwords do not match!");
    }


    if (count($errors) === 0) {

        if (letezik($username, $usertable, 'nev')) {

            $name_error = "Username is already taken";
            echo '<script type="text/javascript">';
            echo 'alert("Username is already taken");';
            echo 'window.location.href = "registration.php";';
            echo '</script>';
        } else if (letezik($email, $usertable, 'email')) {

            echo '<script type="text/javascript">';
            echo 'alert("Email is already taken");';
            echo 'window.location.href = "registration.php";';
            echo '</script>';
        } else {


            $password = md5($password_1);

            if (count($errors) == 0) {
                $obj = (object) array('nev' => $username, 'email' => $email, 'password' => $password, 'phone' => $phone, 'admin' => $admin);
                $usertable[] = $obj;
                jsonKiir('user.json', $usertable);
            }

            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['admin'] = false;
            $_SESSION['success'] = "Succesfull login";
            header('location: login.php');
        }
    }
}



if (isset($_POST['login_user'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username)) {
        array_push($errors, "Username is empty!");
    }
    if (empty($password)) {
        array_push($errors, "Password is empty!");
    }

    $found = false;
    if (count($errors) == 0) {
        $password = md5($password);


        if (letezik($username, $usertable, 'nev')) {

          
            foreach ($usertable as $key => $user) {
                if ($user->nev == $username && $user->password == $password) {
                    $found = true;
                    $_SESSION['username'] = $username;
                    $_SESSION['admin'] = $user->admin;
                    $_SESSION['success'] = "Succfully logedin!";
                    header('location: index.php');
                }
            }
            if(!$found){
                array_push($errors, "Wrong username or password!");
            }

        } else {
            array_push($errors, "Wrong username or password!");
        }
    }
}

if (isset($_POST['add_movie'])) {

    $id = newID($movietable);
    $title = $_POST['title'];
    $picture = $_POST['picture'];
    $descreption = $_POST['descreption'];
    $day = $_POST['day'];
    $location = $_POST['location'];
    $time = $_POST['time'];
    $price = $_POST['price'];
    $numberOfSeats = $_POST['numberOfSeats'];
    $available = true;
    $adminMadeFalse = false;

    if (empty($title)) {
        array_push($errors, "Title must be set!");
    }
    if (empty($picture)) {
        array_push($errors, "Picture must be set!");
    }
    if (empty($descreption)) {
        array_push($errors, "Description must be set!");
    }
    if (empty($day)) {
        array_push($errors, "Day must be set!");
    }
    if (empty($location)) {
        array_push($errors, "Location must be set!");
    }
    if (empty($time)) {
        array_push($errors, "Time must be set!");
    }
    if (empty($price)) {
        array_push($errors, "Price must be set!");
    }
    if (empty($numberOfSeats)) {
        array_push($errors, "The number of seats must be set!");
    }

    if (count($errors) === 0) {

        $obj = (object) array(
            'id' => $id, 'title' => $title, 'picture' => $picture, 'descreption' => $descreption, 'day' => $day, 'location' => $location, 'time' => $time,
            'price' => $price, 'numberOfSeats' => $numberOfSeats, 'available' => $available , 'adminMadeFalse' => $adminMadeFalse
        );

        $movietable[] = $obj;
        jsonKiir('movies.json', $movietable);
    }
}

if (isset($_POST['purches_ticket'])) {
    $nonCfUsername = $_POST['username'];
    $nonCfMovieId = $_POST['movieId'];
    $nonCfNumberOfTickets = $_POST['numberOfTickets'];
    $nonCfMoviePrice = $_POST['moviePrice'];
    $chWNumberOfSeats = $_POST['numberOfSeats'];

    if ($nonCfNumberOfTickets > $chWNumberOfSeats) {
        echo '<script type="text/javascript">';
        echo 'alert("You cannot buy this many tickets");';
        echo 'window.location.href = "index.php";';
        echo '</script>';

        $nonCfUsername = "";
        $nonCfMovieId = "";
        $nonCfNumberOfTickets = "";
        $nonCfMoviePrice = "";
        $chWNumberOfSeats = "";
    }
}
if (isset($_POST['confrm'])) {
    $username = $_POST['nonCfUsername'];
    $movieId = $_POST['nonCfMovieId'];
    $numberOfTickets = $_POST['nonCfNumberOfTickets'];
    $moviePrice = $_POST['nonCfMoviePrice'];

    $needToAdd = true;

    $moviePrice = $moviePrice * $numberOfTickets;

    foreach ($usermovietable as $key => $movie) {
        if ($username == $movie->username && $movieId == $movie->movieId) {
            $needToAdd = false;
            $movie->numberOfTickets += $numberOfTickets;
            $movie->moviePrice += $moviePrice;
        }
    }

    if ($needToAdd) {
        $obj = (object) array('username' => $username, 'movieId' => $movieId, 'moviePrice' => $moviePrice, 'numberOfTickets' => $numberOfTickets);
        $usermovietable[] = $obj;
    }
    jsonKiir('usermovies.json', $usermovietable);


    foreach ($movietable as $key => $movie) {
        if ($movie->id == $movieId) {
            $movie->numberOfSeats -= $numberOfTickets;
        }
    }
    jsonKiir('movies.json', $movietable);

    echo '<script type="text/javascript">';
    echo 'alert("Congratulation ' . $username . ', you bought the ticket");';
    echo 'window.location.href = "usrmovies.php";';
    echo '</script>';
}

if (isset($_POST["delete_ticket"])) {
    $deletm_movieId = $_POST["movieId"];
}
if (isset($_POST["confrm_delete"])) {
    $delete_movieId = $_POST["delete_movieId"];
    $numberOfSeatsFreed = 0;

    $i = 0;
    foreach ($usermovietable as $key => $movie) {
        if ($movie->username == $_SESSION['username'] &&  $delete_movieId == $movie->movieId) {
            unset($usermovietable[$i]);
            $numberOfSeatsFreed = $movie->numberOfTickets;
        }
        $i++;
    }
    jsonKiir('usermovies.json', $usermovietable);

    foreach ($movietable as $key => $movie) {
        if ($movie->id == $movieId) {
            $movie->numberOfSeats += $numberOfSeatsFreed;
        }
    }
    jsonKiir('movies.json', $movietable);

    header('location: usrmovies.php');
}

if(isset($_POST['admin_unavailable'])){
    $adminMadeUnavailable = $_POST['movieId'];

    foreach ($movietable as $key => $movie) {
        if ($movie->id == $adminMadeUnavailable) {
            $movie->available = false;
            $movie->adminMadeFalse = true;
        }
    }
     jsonKiir('movies.json', $movietable);
}
if(isset($_POST['admin_available'])){
    $adminMadeAvailable = $_POST['movieId'];

    foreach ($movietable as $key => $movie) {
        if ($movie->id == $adminMadeAvailable) {
            $movie->available = true;
            $movie->adminMadeFalse = false;
        }
    }
     jsonKiir('movies.json', $movietable);
}

if(isset($_POST['edit_movie'])){
    $unEditedMovieId = $_POST['movieId'];
    $unEditedMovieTitle = $_POST['movieTitle'];
    $unEditedMoviePicture = $_POST['moviePicture'];
    $unEditedMovieDescreption = $_POST['movieDescreption'];
    $unEditedMovieLocation = $_POST['movieLocation'];
    $unEditedMovieDay = $_POST['movieDay'];
    $unEditedMovieTime = $_POST['movieTime'];
    $unEditedMoviePrice = $_POST['moviePrice'];
    $unEditedMovieSeats = $_POST['movieSeats'];
    
}
if(isset($_POST['edited_movie'])){
    $editedMovieId = $_POST['editedid'];
    $editedMovieTitle = $_POST['editedtitle'];
    $editedMoviePicture = $_POST['editedpicture'];
    $editedMovieDescreption = $_POST['editeddescreption'];
    $editedMovieDay = $_POST['editedday'];
    $editedMovieLocation = $_POST['editedlocation'];
    $editedMovieTime = $_POST['editedtime'];
    $editedMoviePrice = $_POST['editedprice'];
    $editedMovieSeats = $_POST['editednumberOfSeats'];

    if (empty($editedMovieTitle)) {
        array_push($errors, "Title must be set!");
    }
    if (empty($editedMoviePicture)) {
        array_push($errors, "Picture must be set!");
    }
    if (empty($editedMovieDescreption)) {
        array_push($errors, "Description must be set!");
    }
    if (empty($editedMovieDay)) {
        array_push($errors, "Day must be set!");
    }
    if (empty($editedMovieLocation)) {
        array_push($errors, "Location must be set!");
    }
    if (empty($editedMovieTime)) {
        array_push($errors, "Time must be set!");
    }
    if (empty($editedMoviePrice)) {
        array_push($errors, "Price must be set!");
    }
    if (empty($editedMovieSeats)) {
        array_push($errors, "The number of seats must be set!");
    }

    if (count($errors) === 0) {

        foreach ($movietable as $key => $movie) {
            if ($movie->id == $editedMovieId) {
                $movie->title = $editedMovieTitle;
                $movie->picture =$editedMoviePicture;
                $movie->descreption = $editedMovieDescreption;
                $movie->day = $editedMovieDay;
                $movie->location = $editedMovieLocation;
                $movie->time = $editedMovieTime;
                $movie->price = $editedMoviePrice;
                $movie->numberOfSeats = $editedMovieSeats;
            }
        }
        jsonKiir('movies.json', $movietable);
    }
}