<?php include('server.php');

if (!isset($_SESSION['username'])) {
  header('location: index.php');
}


?>
<!DOCTYPE html>
<html lang='en'>

<head>
  <meta charset='UTF-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  <title>Confirm</title>
</head>

<body>
  <style>
    *,
    html {
      margin: 0;
      padding: 0;
    }

    html {
      position: absolute;
      height: 110%;
      width: 110%;
      overflow: hidden;
    }

    html::before {
      content: '';
      display: block;
      position: absolute;
      top: 0;
      bottom: 0;
      left: 0;
      right: 0;
      width: 100%;
      height: 100%;
      background: #fff url('https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fwallpapercave.com%2Fwp%2Fwp2177525.gif&f=1&nofb=1') center center fixed no-repeat;
      background-size: cover;
      -webkit-filter: blur(2px);
      filter: blur(2px);
      -webkit-transform: scale(1.3);
      transform: scale(1.3);
    }

    .conf {
      background-color: rgba(20, 1, 1, 0.863);
      color: rgb(255, 255, 255);
      font-weight: bold;
      position: absolute;
      top: 25%;
      left: 30%;
      width: 30%;
      padding: 20px;
      text-align: center;
    }

    button {
      background-color: brown;
      border: none;
      color: white;
      width: 180px;
      padding: 15px 32px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 16px;
    }
  </style>
  <div class='conf'>
    <h1>Confirm</h1>
    <br>
    <div class="container text-center">
      <div>
        <?php
        if(isset($_POST['purches_ticket'])){
        foreach ($movietable as $key => $movie) : ?>
          <?php if ($movie->id == $nonCfMovieId) : ?>
            <h2><?= $movie->title ?></h2>
            <h3><?= $movie->time ?></h3>
            <p><?= $movie->day ?></p>
            <h4><?= $movie->location ?>. teremben</h4>
          <?php endif ?>
        <?php endforeach ?>
          <p>number of tickets: <?= $nonCfNumberOfTickets ?></p>
          <p>The total price: <?= $nonCfNumberOfTickets * $nonCfMoviePrice ?>$</p>
        <br>
        <form method="post" action="confirm.php" novalidate>
          <input type="hidden" name="nonCfUsername" value="<?= $nonCfUsername ?>">
          <input type="hidden" name="nonCfMovieId" value="<?= $nonCfMovieId ?>">
          <input type="hidden" name="nonCfNumberOfTickets" value="<?= $nonCfNumberOfTickets ?>">
          <input type="hidden" name="nonCfMoviePrice" value="<?= $nonCfMoviePrice ?>">
          <button type="submit" name="confrm">Confirm</button> <button formaction="index.php">Decline</button>
        </form>
        <?php
        } else{
        ?>
        <h3>Are you sure you want to refund the ticket?</h3>
        <br>
        <form method="post" action="confirm.php" novalidate>
        <input type="hidden" name="delete_movieId" value="<?= $deletm_movieId ?>">
          <button type="submit" name="confrm_delete">Confirm</button> <button formaction="usrmovies.php">Decline</button>
        </form>
        <?php } ?>
      </div>
    </div>
</body>

</html>