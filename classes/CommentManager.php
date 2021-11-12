<?php

namespace App\Classes;

use App\Interfaces\Manager;
use App\Classes\Database;

class CommentManager implements Manager
{

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
        // list($post_id, $nickname, $content) = $comment;
        $nickname = $comment['nickname'];
        $content = $comment['content'];
        $post_id = $comment['post_id'];
        //requéte SQL + mot de passe crypté
        $sql = "INSERT INTO `comments` (`nickname`, `content`, `post_id`) 
            VALUES ('$nickname', '$content', '$post_id')";
        // Exécuter la requête sur la base de données

        $addComment = $this->db->prepare($sql);
        $addComment->execute();
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
