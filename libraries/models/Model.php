<?php 
require_once(__DIR__ . '/../database.php');
abstract class Model 
{ 
    protected $pdo; 
    public function __construct() 
    { 
        $this->pdo = getPdo(); 
    }
    protected $table;
    public function find(int $id)
    //ne renvoie pas forcement un tableau si c'est vide c'est un boolen False 
    { 
        $query = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        // On exécute la requête en précisant le paramètre :id 
        $query->execute(['id' => $id]); 
        // On fouille le résultat pour en extraire les données réelles de l'article
        $item = $query->fetch(); 
        return $item; 
    }
    public function delete(int $id)
    {
        $query = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = :id");
        $query->execute(['id' => $id]);
    }
    public function findAll(?string $order="") : array
    { 
        $sql = "SELECT * FROM {$this->table}";
        if ($order) {
            $sql .= " ORDER BY {$order}";
        }
        $resultats = $this->pdo->query($sql);
        // On fouille le résultat pour en extraire les données réelles 
        $items = $resultats->fetchAll(); 
        return $items; 
    }
}
?>