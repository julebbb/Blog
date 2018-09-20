<!doctype html>
<html class="no-js" lang="fr">

<head>
  <?php
    include("../../mdp/mdp.php");
    try
    {
      $bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', $mdp);
    }
    catch(Exception $e)
    {
            die('Erreur : '.$e->getMessage());
    }

   ?>

  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Blog</title>
  <meta name="description" content="C'est un mini chat fait pour ma formation Yes We Web">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="manifest" href="site.webmanifest">
  <link rel="apple-touch-icon" href="icon.png">
  <!-- Place favicon.ico in the root directory -->
  <!--32x32 le favicon -->

  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/main.css">
</head>

<body>
  <!--[if lte IE 9]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
  <![endif]-->

  <!-- Add your site or application content here -->
  <section>
    <h1>Mon super blog !</h1>

    <p>Les derniers billets du blog :</p>

    <?php
    $respond = $bdd->query('SELECT id, name_article, content,
    DATE_FORMAT(date_create, "%d/%m/%Y") AS date_now,
    DATE_FORMAT(date_create, "%H:%i:%s") AS date_time
    FROM article
    ORDER BY date_create
    DESC LIMIT 0, 5');

    while($data = $respond->fetch()) {
     ?>

     <h3><?php echo $data['name_article'] . " le " . $data['date_now'] . " à " . $data['date_time'];  ?></h3>
     <p><?php echo $data['content']; ?></p>
     <a href="comment.php?index=<?php echo $data['id']; ?>">Commentaires</a>

     <?php }  ?>

     <?php
     $req = $bdd->query('SELECT count(*) as id from article');
     $id = $req->fetch();
     $article_length = $id['id'];

     if ($article_length > 5) {
       echo "Papta";
     } ?>
  </section>

  <script src="js/vendor/modernizr-3.6.0.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script>window.jQuery || document.write('<script src="js/vendor/jquery-3.3.1.min.js"><\/script>')</script>
  <script src="js/plugins.js"></script>
  <script src="js/main.js"></script>

  <!-- Google Analytics: change UA-XXXXX-Y to be your site's ID. -->
  <script>
    window.ga = function () { ga.q.push(arguments) }; ga.q = []; ga.l = +new Date;
    ga('create', 'UA-XXXXX-Y', 'auto'); ga('send', 'pageview')
  </script>
  <script src="https://www.google-analytics.com/analytics.js" async defer></script>
</body>

</html>
