<?php

namespace App\Classes;

use App\Interfaces\Manager;
use App\Classes\Database;
use App\Traits\Notification;

class CommentManager implements Manager
{
    use Notification;

    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAll()
    {
        $sql = 'SELECT * FROM comments';
        $comments = $this->db->query($sql);
        return $comments;
    }

    public function get(int $id)
    {
        $sql = "SELECT 
            comments.post_id,
            DATE_FORMAT(comments.created_at, '%W %e %M %Y') AS created_at, comments.id, comments.nickname, comments.content
            FROM `posts`
            INNER JOIN comments ON comments.post_id = posts.id
            WHERE posts.id = $id
            ORDER BY created_at DESC";
        $comment = $this->db->prepare($sql);
        $comment->execute();
        return $comment->fetchAll();
    }

    public function add(array $comment)
    {   
        $sql = 'INSERT INTO
                    comments
                    (nickname, content, post_id)
                VALUES (?, ?, ?)';
        // Exécuter la requête sur la base de données

        $this->db->launchQuery($sql, $comment);
        return $this->db->lastInsertId() ? true : false;
    }

    public function update(array $values, int $id)
    {

    }

    public function remove(int $id)
    {
        $sql = 'DELETE FROM comments WHERE id = ?';
        $deleteComment = $this->db->prepare($sql);
        $deleteComment->execute(array($id));
    }


    // 
}
