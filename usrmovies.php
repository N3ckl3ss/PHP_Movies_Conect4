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
    header('location: index.php');
}
if ($_SESSION['admin']) {
    header('location: index.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Tickets</title>
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
                <h2><mark>All your upcoming movies, <?php echo $_SESSION['username']; ?></mark></h2>
            </div>
        <?php } ?>
        <h1>My Ticket List</h1>
        <div class='menu'>
            <?php if (isset($_SESSION['username'])) { ?>
                <div class='my_list'>
                    <a class="nav-link" href="index.php"><button>Back to main</button></a>
                    <a class="nav-link" href="index.php?logout='1'"> <button>Logout</button></a>
                </div>
            <?php } ?>
        </div>
    </div>
    <br>
    <div class='search'>
        <br>
        <input type="text" id="search" onkeyup="searchFunction()" placeholder="Search for names..">
    </div>
    <br>
    <div class="row">
        <table>
            <tr>
                <th>
                    <h2>Title</h2>
                </th>
                <th>
                    <h2>Day</h2>
                </th>
                <th>
                    <h2>Location</h2>
                </th>
                <th>
                    <h2>Time of start</h2>
                </th>
                <th>
                    <h2>Number of Tickets</h2>
                </th>
                <th>
                    <h2>The pricer</h2>
                </th>
                <th>
                    <h2>Refound</h2>
                </th>
            </tr>
            <?php foreach ($movietable as $key => $movie) : ?>
                <?php foreach ($usermovietable as $key => $usrmovie) : ?>
                    <?php if ($movie->id == $usrmovie->movieId && $usrmovie->username == $_SESSION['username']) : ?>
                        <tr>
                            <th>
                                <p><?= $movie->title ?></p>
                            </th>
                            <th>
                                <p><?= $movie->day ?></p>
                            </th>
                            <th>
                                <p><?= $movie->location ?></p>
                            </th>
                            <th>
                                <p><?= $movie->time ?></p>
                            </th>
                            <th>
                                <p><?= $usrmovie->numberOfTickets ?></p>
                            </th>
                            <th>
                                <p><?= $usrmovie->moviePrice ?>$</p>
                            </th>
                            <th>
                                <?php if($day < $movieDay):?>
                            <form method="POST" action="confirm.php" novalidate>
                                <input type="hidden" name="movieId" value="<?=$usrmovie->movieId?>">
                                <button type="submit" name="delete_ticket">Delete</button>
                            </form>
                            <?php endif?>
                            </th>
                        </tr>
                    <?php endif ?>

                <?php endforeach ?>
            <?php endforeach ?>
        </table>
    </div>
</body>
<script src="search.js"></script>

</html>