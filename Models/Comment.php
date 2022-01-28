<?php

require_once ROOT_PATH.'/Models/Db.php';
class Comment extends Db
{
    public function __construct($dbh = null)
    {
        parent::__construct($dbh);
    }

    /**
     * コメント登録.
     *
     * @return bool
     */
    public function tweetCreate($newTweet)
    {
        try {
            $sth = $this->dbh;
            $sql = 'INSERT INTO Comments (user_id,shrines_id,text)
                    VALUES (:user_id,:shrines_id,:text)';
            $stmt = $sth->prepare($sql);
            $stmt->bindValue(':user_id', (int) $newTweet['user_id'], PDO::PARAM_INT);
            $stmt->bindValue(':shrines_id', (int) $newTweet['review_id'], PDO::PARAM_INT);
            $stmt->bindValue(':text', $newTweet['text'], PDO::PARAM_STR);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            exit($e->getMessage());

            return false;
        }
    }

    /*
     * 全コメント取得.
     *
     * @return bool
     */
    public function allComment($id)
    {
        $sth = $this->dbh;
        $sql = 'SELECT u.name AS user_name, c.*
                FROM Comments AS c
                JOIN users AS u ON u.id = c.user_id
                WHERE c.shrines_id = :shrines_id
                ORDER BY c.created_at DESC';
        $stmt = $sth->prepare($sql);
        $stmt->bindValue(':shrines_id', (int) $id, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll();

        return $results;
    }

    /*
     * コメント削除.
     *
     * @return bool
     */
    public function delete_comment($id)
    {
        try {
            $sth = $this->dbh;
            $sql = 'DELETE FROM comments WHERE id = :id';
            $stmt = $sth->prepare($sql);
            $stmt->bindValue(':id', (int) $id, PDO::PARAM_INT);
            $result = $stmt->execute();

            return $result;
        } catch (PDOException $e) {
            exit($e->getMessage());

            return false;
        }
    }
}
