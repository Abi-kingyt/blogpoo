<?php 
/** * Retourne une connexion à la base de données * */ 
function getPdo() 
{
$pdo = new PDO('mysql:host=localhost;dbname=blogpoo;charset=utf8', 'root', '', 
    [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ]); 
return $pdo; 
}

function findAllArticles() 
{ 
    $pdo =getPdo(); 
    $resultats = $pdo->query('SELECT * FROM articles ORDER BY created_at DESC'); 
    // On fouille le résultat pour en extraire les données réelles 
    $articles = $resultats->fetchAll(); 
    return $articles; 
}

function findArticle(int $id) 
{ 
    $pdo =getPdo(); 
    $query = $pdo->prepare("SELECT * FROM articles WHERE id = :article_id"); 
    // On exécute la requête en précisant le paramètre :article_id
    $query->execute(['article_id' => $id]);
    // On fouille le résultat pour en extraire les données réelles de l'article 
    $article = $query->fetch();
    return $article;
}

function findAllComments()
{
    $pdo =getPdo(); 
    $resultats = $pdo->query('SELECT * FROM comments ORDER BY created_at DESC'); 
    // On fouille le résultat pour en extraire les données réelles 
    $comments = $resultats->fetchAll(); 
    return $comments; 
}

function deleteArticle(int $id)
{
    $pdo =getPdo(); 
    $query = $pdo->prepare('DELETE FROM articles WHERE id = :id');
    $query->execute(['id' => $id]);
}

function findComment(int $id)
{
    $pdo =getPdo(); 
    $query = $pdo->prepare("SELECT * FROM comments WHERE id = :id"); 
    $query->execute(['id' => $id]);
    $comment = $query->fetch();
    return $comment;
}

function deleteComment(int $id)
{
    $pdo =getPdo(); 
    $query = $pdo->prepare('DELETE FROM comments WHERE id = :id');
    $query->execute(['id' => $id]);
}

function insertComment(string $author, string $content, int $article_id)
{
    $pdo =getPdo(); 
    $query = $pdo->prepare('INSERT INTO comments SET author = :author, content = :content, article_id = :article_id, created_at = NOW()');
    $query->execute(compact('author', 'content', 'article_id'));
}

function findCommentsByArticle(int $article_id)
{
    $pdo = getPdo();
    $query = $pdo->prepare('SELECT * FROM comments WHERE article_id = :article_id ORDER BY created_at ASC');
    $query->execute(['article_id' => $article_id]);
    $comments = $query->fetchAll();

    // si tu veux, tu peux mettre "Auteur inconnu" par défaut pour ceux sans author
    foreach ($comments as &$c) {
        if (empty($c['author'])) {
            $c['author'] = 'Auteur inconnu';
        }
    }
    unset($c);

    return $comments;
}

?>