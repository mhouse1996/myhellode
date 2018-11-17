<?php
namespace App\Post;

use PDO;

use App\Core\AbstractRepository;

class CommentsRepository extends AbstractRepository
{
  public function getTableName()
  {
    return "comments";
  }

  public function getModelName()
  {
    return "App\\Post\\CommentModel";
  }

  public function addComment($postId, $content)
  {
    $table = $this->getTableName();
    $stmt = $this->pdo->prepare("INSERT INTO `$table` (post_id, content) VALUES (:post_id, :content)");
    $stmt->execute(['post_id' => $postId,
                    'content' => $content]);
  }

  public function fetchCommentByPost($id)
  {
    $table = $this->getTableName();
    $model = $this->getModelName();
    $stmt = $this->pdo->prepare("SELECT * FROM `$table` WHERE post_id= :id");
    $stmt->execute(['id' => $id]);
    $comments = $stmt->fetchAll(PDO::FETCH_CLASS, $model);
    return $comments;
  }

}

?>
