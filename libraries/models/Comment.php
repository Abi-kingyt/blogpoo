<?php 
require_once(__DIR__ . '/Model.php');
class Comment extends Model {
    protected $table="comments";
    public function findAllWithArticle()
    {
        $resultats = $this->pdo->query('SELECT * FROM comments ORDER BY created_at DESC'); 
        // On fouille le résultat pour en extraire les données réelles 
        $comments = $resultats->fetchAll(); 
        return $comments; 
    }

    public function insert(string $author, string $content, int $article_id)
    {
        $query = $this->pdo->prepare('INSERT INTO comments SET author = :author, content = :content, article_id = :article_id, created_at = NOW()');
        $query->execute(compact('author', 'content', 'article_id'));
    }

    public function findByArticle(int $article_id) : array
    {
        $query = $this->pdo->prepare('SELECT * FROM comments WHERE article_id = :article_id ORDER BY created_at ASC');
        $query->execute(['article_id' => $article_id]);
        return $query->fetchAll();
    }



}