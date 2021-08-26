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
    <title>Edit yout movies with the most efficient way posible, with the new edit form 2000 just 9.99 for this one and more in a life time super long title so I can test when will html force me to stop and get some help.            And its still going because ther is no limit on this and I can do what I want here, of course whit in scope wouldn't it be wild if I sudenly sad a bad no no word here where nobody would look          haha gatcha I wont do such a thing, but the joke is running long so I will stop now thank you for listening to my ted talk.</title>
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

        .editList {
            margin-left: 4%;
        }

        .editList input {
            width: 70%;
            height: 36px;
            color: white;
            background-color: rgba(20, 1, 1);
            border: 2px solid rgba(20, 1, 1);
        }

        .editList button {
            width: 30%;
            color: white;
            padding: 8px 10px 10px 10px;
            background-color: rgba(20, 1, 1);
            border: 2px solid rgba(20, 1, 1);
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
            padding: 5px 12px ;
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

        .row th, .row td {
            border: 1px solid #ddd;
        }

        .editList table {
            width: 80%;
        }
        .editList tr, .editList th{
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
</head>

<body>

    <div class='banner'>
        <h1>Edit</h1>
        <div class='menu'>
            <?php if (isset($_SESSION['username'])) { ?>
                <div class='my_list'>
                    <a class="nav-link" href="index.php"> <button>Back to main</button></a>
                </div>
            <?php } ?>
        </div>
    </div>
    <br>
    <div class="editList">
        <table>
            <tr>
                <th >
                <br>
                    <form method="POST" action="adminpage.php" novalidate>
                    <div class="form-group">
                            <input type="hidden" class="form-control" id="id" aria-describedby="id" name="editedid" value="<?php echo $unEditedMovieId ?>">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="title" aria-describedby="title" placeholder="title" name="editedtitle" value="<?php echo $unEditedMovieTitle ?>">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="picture" aria-describedby="Picture" placeholder="picture" name="editedpicture" value="<?php echo $unEditedMoviePicture; ?>">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="descreption" aria-describedby="Descreption" placeholder="descreption" name="editeddescreption" value="<?php echo $unEditedMovieDescreption; ?>">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="day" aria-describedby="day" placeholder="Day" name="editedday" value="<?php echo $unEditedMovieDay; ?>">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="location" aria-describedby="location" placeholder="Location" name="editedlocation" value="<?php echo $unEditedMovieLocation; ?>">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="time" aria-describedby="time" placeholder="Time" name="editedtime" value="<?php echo $unEditedMovieTime; ?>">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="price" aria-describedby="price" placeholder="Price" name="editedprice" value="<?php echo $unEditedMoviePrice; ?>">
                        </div>
                        <div class="form-group">
                            <input type="number" class="form-control" id="numberOfSeats" aria-describedby="numberOfSeats" placeholder="Number Of Seats" name="editednumberOfSeats" value="<?php echo $unEditedMovieSeats; ?>">
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary" name="edited_movie">Edit movie</button>
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
</body>

</html>