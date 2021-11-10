<?php
namespace App\classes;

use App\Interfaces\Manager;
use App\Classes\Database;

// class Posts
class PostManager implements Manager {
    // attributs
    private $db;

    // constructeur
    public function __construct() {
        $this->db = new Database();
    }

    // methodes
    public function indexPosts() {
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

    public function getAll()
    {
        $query = 'SELECT * FROM posts';
        $result = $this->db->prepare($query);
        $result->execute();

        return $result->fetchAll();
    }
    public function get(int $id)
    {
        $sql = "SELECT title, 
        content, DATE_FORMAT(created_at, '%W %e %M %Y') AS created_at, categories.name, authors.firstname, authors.lastname
        FROM `posts`
        INNER JOIN categories ON categories.id = posts.category_id 
        INNER JOIN authors ON authors.id = posts.author_id
        WHERE posts.id = $id";

        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetch();
    }
    public function add(array $values)
    {

    }
    public function update(array $values, int $id)
    {

    }
    public function remove(int $id)
    {

    }

}