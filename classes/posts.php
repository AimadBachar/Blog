<?php
namespace App\classes;

use App\classes\Db;

// class Posts
class Posts extends Db {
    // attributs
    private $db;

    // constructeur
    public function __construct() {
        $this->db = new Db();
    }

    // methodes
    public function findAll() {
        $sql = 'SELECT 
        posts.id, title, 
        SUBSTRING(content, 1, 150) AS content, DATE_FORMAT(created_at, "%W %e %M %Y") AS created_at, categories.name, authors.firstname, authors.lastname 
        FROM `posts` 
        INNER JOIN categories ON categories.id = posts.category_id 
        INNER JOIN authors ON authors.id = posts.author_id 
        ORDER BY created_at DESC
        LIMIT 10
        ';

        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }
}