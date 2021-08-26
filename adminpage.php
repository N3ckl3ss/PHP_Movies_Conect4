<?php
include("server.php");

if (!$_SESSION['admin']) {
    header("location: index.php");
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
            height: 260px;
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
            margin-top: 10px;
            height: 30px;
            color: white;
            background-color: black;
            border: 2px solid black;
            font-size: larger;
            border-radius: 25px;
            padding-left: 20px;
        }

        .search input {
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
            margin-left: 4%;
        }

        .addToList input {
            width: 70%;
            height: 36px;
            color: white;
            background-color: rgba(20, 1, 1);
            border: 2px solid rgba(20, 1, 1);
        }

        .addToList button {
            width: 30%;
            color: white;
            padding: 8px 10px 10px 10px;
            background-color: rgba(20, 1, 1);
            border: 2px solid rgba(20, 1, 1);
        }

        .hidden {
            display: none;
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
            padding: 5px 12px;
            border: none;
            color: white;
            text-align: center;
            display: inline-block;
            font-size: 14px;
            cursor: pointer;
            width: 100%;
            margin-bottom: 3px;
        }


        .row table {
            border-collapse: collapse;
            border-spacing: 0;
            width: 90%;
            border: 1px solid #ddd;
            margin-left: 4%;
            margin-right: 4%;
        }

        .row th,
        .row td {
            border: 1px solid #ddd;
        }

        .addToList table {
            width: 80%;
        }

        .addToList tr,
        .addToList th {
            width: 50%;
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

        .btn input {
            width: 30%;
            height: 36px;
            color: white;
            background-color: black;
            border: 2px solid black;
            border-radius: 25px;
            font-size: medium;
            padding: 8px 10px 10px 10px;
        }
    </style>


    <script type="text/javascript" src="search.js"></script>
    <script type="text/javascript">
        function usersWhoBought(id) {

            let wichMovies = document.getElementsByName(id)

            for (let wichMovie of wichMovies) {
                if (wichMovie.classList.value === "hidden") {
                    wichMovie.classList.remove('hidden');
                } else {
                    wichMovie.classList.add('hidden');
                }
            }
        }
    </script>
</head>

<body>

    <div class='banner'>
        <h1>Admin Panel!</h1>
        <div class='menu'>
            <?php if (isset($_SESSION['username'])) { ?>
                <div class='my_list'>
                    <a class="nav-link" href="index.php"> <button>Back to main</button></a>
                </div>
            <?php } ?>
        </div>
    </div>
    <br>
    <div class="addToList">
        <table>
            <tr>
                <th>
                    <br>
                    <form method="POST" action="adminpage.php" novalidate>
                        <div class="form-group">
                            <input type="text" class="form-control" id="title" aria-describedby="title" placeholder="title" name="title" value="<?php echo $title ?>">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="picture" aria-describedby="Picture" placeholder="picture" name="picture" value="<?php echo $picture; ?>">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="descreption" aria-describedby="Descreption" placeholder="descreption" name="descreption" value="<?php echo $descreption; ?>">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="day" aria-describedby="day" placeholder="Day" name="day" value="<?php echo $day; ?>">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="location" aria-describedby="location" placeholder="Location" name="location" value="<?php echo $location; ?>">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="time" aria-describedby="time" placeholder="Time" name="time" value="<?php echo $time; ?>">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="price" aria-describedby="price" placeholder="Price" name="price" value="<?php echo $price; ?>">
                        </div>
                        <div class="form-group">
                            <input type="number" class="form-control" id="numberOfSeats" aria-describedby="numberOfSeats" placeholder="Number Of Seats" name="numberOfSeats" value="<?php echo $numberOfSeats; ?>">
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary" name="add_movie">Add movie</button>
                    </form>
                </th>
                <th align="center">
                    <?php foreach ($errors as $error) : ?>
                        <br> <?= $error ?> <br>
                    <?php endforeach ?>
                </th>
            </tr>
        </table>
    </div>
    <div class='search'>
        <br>
        <input type="text" id="search" onkeyup="searchFunction()" placeholder="Search for names..">
    </div>
    <br>
    <div class="row">
        <table>
            <?php foreach ($movietable as $key => $movie) : ?>
                <tr class="boxtr">
                    <th width="10%">
                        <h2 class="title"><?= $movie->title ?></h2>
                    </th>
                    <th>
                        <?php if (strlen($movie->descreption) > 110){
                            $str = substr($movie->descreption, 0, 110) . '...'; 
                        } else{
                            $str = $movie->descreption;
                        }?>
                        <p><?= $str ?></p>
                    </th>
                    <th width="10%">
                        <h4><?= $movie->location ?>. theater</h4>
                    </th>
                    <th align="center" width="10%">
                        <h3><?= $movie->day ?></h3>
                        <h3><?= $movie->time ?></h3>
                    </th>
                    <th align="center" width="10%">
                        <h4><?= $movie->price ?>$</h4>
                        <h4><?= $movie->numberOfSeats ?> seats remain</h4>
                    </th>
                    <th width="20%">
                        <form method="post" action="edit.php" novalidate>
                            <input type="hidden" name="movieId" value="<?= $movie->id ?>">
                            <input type="hidden" name="moviePicture" value="<?= $movie->picture ?>">
                            <input type="hidden" name="movieTitle" value="<?= $movie->title ?>">
                            <input type="hidden" name="movieDescreption" value="<?= $movie->descreption ?>">
                            <input type="hidden" name="movieLocation" value="<?= $movie->location ?>">
                            <input type="hidden" name="movieDay" value="<?= $movie->day ?>">
                            <input type="hidden" name="movieTime" value="<?= $movie->time ?>">
                            <input type="hidden" name="moviePrice" value="<?= $movie->price ?>">
                            <input type="hidden" name="movieSeats" value="<?= $movie->numberOfSeats ?>">
                            <button type="submit" name="edit_movie">Edit</button>
                        </form>
                        <?php if ($movie->available) { ?>
                            <form method="post" action="adminpage.php" novalidate>
                                <input type="hidden" name="movieId" value="<?= $movie->id ?>">
                                <button type="submit" name="admin_unavailable">Make un available</button>
                            </form>
                        <?php } else { ?>
                            <form method="post" action="adminpage.php" novalidate>
                                <input type="hidden" name="movieId" value="<?= $movie->id ?>">
                                <button type="submit" name="admin_available">Make available</button>
                            </form>
                        <?php } ?>
                        <button id="revealUsers" onclick="usersWhoBought(<?= $movie->id ?>)">Who bought tickets</button>
                    </th>
                </tr>
                <?php foreach ($usermovietable as $key => $usrmovie) {
                    if ($movie->id == $usrmovie->movieId) {
                        foreach ($usertable as $key => $user) {
                            if ($usrmovie->username == $user->nev) {
                ?>
                                <tr name="<?= $movie->id ?>" class="hidden">
                                    <td></td>
                                    <td>
                                        <p><?= $user->nev ?></p>
                                    </td>
                                    <td>
                                        <p><?= $user->email ?></p>
                                    </td>
                                    <td>
                                        <p><?= $user->phone ?></p>
                                    </td>
                                </tr>
                <?php
                            }
                        }
                    }
                } ?>
            <?php endforeach ?>
        </table>
    </div>
    <br>
</body>

</html>