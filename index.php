<?php
include("server.php");

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    unset($_SESSION['admin']);
    header("location: index.php");
}
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    $username = null;
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Legitimate Cinema Site</title>
    <style>
        *,
        html {
            margin: 0;
            padding: 0;
        }

        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #888;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        .banner {
            background-image: url('https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fwallpapercave.com%2Fwp%2Fwp2177525.gif&f=1&nofb=1');
            background-size: cover;
            color: aliceblue;
            background-position: 100%;
            width: 100%;
            height: 300px;
            background-position-y: 80%;
            background-position-x: center;
            margin-left: 0%;
            background-attachment: fixed;
            background-repeat: no-repeat;
            align-items: center;


        }

        .banner h1 {
            align-self: start;
            color: white;
            text-align: center;
            padding-bottom: 5%;
            font-size: 100px;
        }

        .searchtext {
            width: 50%;
            margin-left: 20%;
            margin-top: 6px;
            height: 30px;
            color: white;
            background-color: black;
            border: 2px solid black;
            font-size: larger;

            border-radius: 25px;
            padding-left: 20px;
        }

        input {
            width: 50%;
            height: 20px;
            color: white;
            background-color: rgba(20, 1, 1);
            border: 2px solid black;
            border-radius: 25px;
            font-size: medium;
            padding: 8px 10px 10px 10px;
        }

        .search {

            margin-left: 30%;
        }

        .addToList {
            width: 5%;
            height: 36px;
            color: white;
            background-color: black;
            border: 2px solid black;
            border-radius: 25px;
        }

        .login {
            text-align: right;
            padding-top: 10px;
            padding-right: 10px;
        }

        /*Welcoming Message*/
        .wmsg {
            text-align: right;
            padding-top: 10px;
            padding-right: 10px;
        }

        mark {
            background-color: rgba(20, 1, 1);
            color: white;
        }

        .guidlist td:ntd-child(even) {
            background-color: #faeeba;
        }

        .guidlist td:hover {
            background-color: rgba(221, 221, 221, 0.911);
        }

        a:link {
            color: black;
            padding: 14px 16px;
        }

        /* visited link */
        a:visited {
            color: rgb(255, 255, 255);
            padding: 14px 16px;
        }

        /* mouse over link */
        a:hover {
            color: rgb(214, 206, 206);
            padding: 14px 16px;
        }

        /* selected link */
        a:active {
            color: rgb(255, 255, 255);
        }

        button {
            background-color: rgba(20, 1, 1);
            background-repeat: no-repeat;
            padding: 15px 32px;
            border: none;
            color: white;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 20px;
            cursor: pointer;
        }

        .row button {
            background-color: rgba(20, 1, 1);
            background-repeat: no-repeat;
            padding: 10px 20px;
            border: none;
            color: white;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 15px;
            cursor: pointer;
            margin-bottom: 5px;
        }

        .row {
            display: flex;
        }

        table {
            border-collapse: collapse;
            border-spacing: 0;
            width: 90%;
            border: 1px solid #ddd;
            margin-left: 4%;
            margin-right: 4%;
        }

        table tr {
            border-bottom: 2px solid black;
            padding-bottom: 20px;
        }

        img {
            width: 40%;
            height: auto;
            margin-left: 10%;
        }

        .menu {
            background-color: transparent;
            overflow: hidden;
        }

        .menu a {
            float: left;
            color: rgb(247, 170, 55);
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            font-size: 17px;
        }

        .menu a:hover {
            background-color: transparent;
            color: rgb(247, 170, 55);
        }

        .menu a.active {
            background-color: #4CAF50;
            color: rgb(247, 170, 55);
        }

        .nav-link {
            color: rgb(247, 170, 55);
        }

        .details {
            width: 80%;
            margin-left: 8%;
        }

        .actors {
            margin-right: 10%;
            float: right;
        }

        .time {
            font-weight: bold;
        }

        #color-overlay {
            background-color: black;
            opacity: 0.6;
            color: white;
        }
    </style>
</head>

<body>

    <div class='banner'>
        <?php if (!isset($_SESSION['username'])) { ?>
            <div class='login'>
                <a class="nav-link" href='login.php'>
                    <h2><mark>Sign in</mark></h2>
                </a>
            </div>
        <?php } else { ?>
            <div class='wmsg'>
                <h2><mark>Welcome, <?php echo $_SESSION['username']; ?></mark></h2>
            </div>
        <?php } ?>
        <h1>Legitimate Cinema!</h1>
        <div class='menu'>
            <?php if (isset($_SESSION['username'])) { ?>
                <div class='my_list'>
                    <?php if (!$_SESSION['admin']) { ?>
                        <a class="nav-link" href="usrmovies.php"><button>My list</button></a>
                    <?php } ?>
                    <a class="nav-link" href="Counter-Four/C4.html"><button>For fun</button></a>
                    <a class="nav-link" href="index.php?logout='1'"> <button>Logout</button></a>
                    <?php if ($_SESSION['admin']) { ?>
                        <a class="nav-link" href="adminpage.php"> <button>Admin</button></a>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>
    <br>
    <div class='search'>
        <input type="text" id="search" onkeyup="searchFunction()" placeholder="Search for names..">
    </div>
    <br>
    <div class="row">
        <table>
            <?php foreach ($movietable as $key => $movie) : ?>
                <tr class="boxtr" <?php if (!$movie->available) : ?>id="color-overlay" <?php endif ?>>
                    <td width="35%">
                        <br>
                        <img src="<?= $movie->picture ?>">
                    </td>
                    <td width="40%">
                        <h2 class="title"><?= $movie->title ?></h2>
                        <br>
                        <p><?= $movie->descreption ?></p>
                    </td>
                    <td align="center">
                        <h3><?= $movie->time ?></h3>
                        <p><?= $movie->day ?></p>
                        <h4><?= $movie->location ?>. theater</h4>
                    </td>
                    <td align="center">
                        <?php if ($movie->available && isset($_SESSION['username']) && !$_SESSION['admin']) : ?>
                            <form method="POST" action="confirm.php" novalidate>
                                <button type="submit" name="purches_ticket">Buy Ticket </button>
                                <input type="hidden" name="username" value="<?= $_SESSION['username'] ?>">
                                <input type="hidden" name="movieId" value="<?= $movie->id ?>">
                                <input type="hidden" name="numberOfSeats" value="<?= $movie->numberOfSeats ?>">
                                <input type="hidden" name="moviePrice" value="<?= $movie->price ?>">
                                <br>
                                <input type="number" id="numberOfTickets" name="numberOfTickets" min="1" max="<?= $movie->numberOfSeats ?>" value="1">
                                <h4><?= $movie->price ?>$/person</h4>
                            </form>
                        <?php endif ?>
                    </td>
                </tr>
            <?php endforeach ?>
        </table>
    </div>
</body>
<script src="search.js"></script>

</html>