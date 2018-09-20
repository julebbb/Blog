<!doctype html>
<html class="no-js" lang="fr">

<head>
  <?php
    //For password database
    include("../../mdp/mdp.php");

    //Active database
    try
    {
      $bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', $mdp);
    }
    catch(Exception $e)
    {
            die('Erreur : '.$e->getMessage());
    }

    //Take length element in table article
    $respond = $bdd->query('SELECT count(*) as id from article');
    $data = $respond->fetch();
    $article_length = $data['id'];
    $respond->closeCursor();

    //Secure $_GET index
    $index = htmlspecialchars($_GET['index']);
    $index = (int) $index;

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

    <?php
    if (isset($index) AND ! empty($index) AND $index > 0 AND $index <= $article_length) {

      $link = $bdd->query('SELECT id, name_article, content,  DATE_FORMAT(date_create, "%d/%m/%Y") AS date_now, DATE_FORMAT(date_create, "%H:%i:%s") AS date_time FROM article WHERE id = "'.$index.'" ');
      $donne = $link->fetch();
    } else {
      header('Location: 404.html');
    }


     ?>
     <h1><?php echo $donne['name_article'] . " le " . $donne['date_now'] . " à " . $donne['date_time'];  ?></h1>
     <p><?php echo $donne['content']; ?></p>
     <a href="index.php">Retour à l'accueil</a>
     <?php $com = $bdd->query('SELECT  pseudo, DATE_FORMAT(date_create, "%d/%m/%Y") AS date_now, DATE_FORMAT(date_create, "%H:%i:%s") AS date_time, content, article_id FROM comment WHERE article_id = "'.$index.'" ORDER BY date_now DESC');
     while($comment = $com->fetch()) {
      ?>
      <p>Posté le <?php echo $comment['date_now']; ?> à <?php echo $comment['date_time']; ?> par <?php echo $comment['pseudo']; ?></p>
      <p><?php echo $comment['content']; ?></p>

      <?php
     }

     $com->closeCursor();
      ?>
      <p>Ajouter un commentaire :</p>
      <form class="" action="" method="post">
        <input type="text" name="pseudo">
        <textarea name="content"></textarea>
        <input type="submit" name="envoie" value="envoyer">
      </form>

      <?php
      if (isset($_POST['pseudo']) AND isset($_POST['content'])) {
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $content = htmlspecialchars($_POST['content']);

        $addcom = $bdd->prepare('INSERT INTO comment(pseudo, date_create, content, article_id) VALUES(:pseudo, NOW(), :content, :article_id)');

        $addcom->execute(array(
          'pseudo' => $pseudo,
          'content' => $content,
          'article_id' => $index
        ));
        header('Location: comment.php?index='.$index);
        $addcom->closeCursor();
      }
      ?>




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
