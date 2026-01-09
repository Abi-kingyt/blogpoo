<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'acceuil</title>
</head>
<h1>Page d'acceuil</h1>
<body>
    <!-- les boutons vers afficher les users/articles/comments -->
    <a href="users">- Afficher les utilisateurs</a><br>
    <a href="index">- Afficher les articles</a><br>
    <a href="comments">- Afficher les commentaires</a>

</body>
</html>

<?php
// <!-- si on a blog/users: verifier si on a un ID derrerire -> affiche liste des users ou l'id-->
//  <!-- on a blog/articles: verifier si on a un ID derrerire -> affiche liste des articles ou l'id -->
//   <!-- if on a blog/comments: verifier si on a un ID derrerire -> affiche liste des comments ou l'id --> 

//recuperer lurl
$url = $_SERVER['REQUEST_URI'];




/**
 * 1. Connexion à la base de données avec PDO
 * Attention, on précise ici deux options :
 * - Le mode d'erreur : le mode exception permet à PDO de nous prévenir violament quand on fait une erreur ;-)
 * - Le mode d'exploitation : FETCH_ASSOC veut dire qu'on exploitera les données sous la forme de tableaux associatifs
 */
require_once('libraries/models/Article.php');
require_once('libraries/models/Comment.php');
require_once('libraries/models/Model.php');

$model = new Article();
$commentsModel = new Comment();

$pdo = getPdo();

/**
 * 2. Récupération des articles
 */
$articles = $model->findAll("created_at DESC");

/**
 * 3. Affichage
 */
include_once('libraries/outils.php');
$pageTitle = "Accueil";
render('articles/index',compact('pageTitle','articles'));
?>