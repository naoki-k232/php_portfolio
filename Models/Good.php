<?php

require_once ROOT_PATH.'/Models/Db.php';
class Good extends Db
{
    public function __construct($dbh = null)
    {
        parent::__construct($dbh);
    }

    /*
     * いいねの確認.
     * $params int $user_id
     * $params int $review_id
     *
     * @return bool
     */
    public function check_good($user_id, $review_id)
    {
        try {
            $sth = $this->dbh;
            $sql = 'SELECT * FROM goods WHERE user_id = :user_id AND shrines_id = :shrines_id';
            $stmt = $sth->prepare($sql);
            $stmt->bindValue(':user_id', (int) $user_id, PDO::PARAM_INT);
            $stmt->bindValue(':shrines_id', (int) $review_id, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result;
        } catch (PDOException $e) {
            exit($e->getMessage());

            return $result = false;
        }
    }

    /*
     * いいねの登録.
     * $params int $user_id
     * $params int $review_id
     *
     * @return bool
     */
    public function good_entry($user_id, $review_id)
    {
        try {
            $sth = $this->dbh;
            $sql = 'INSERT INTO goods(user_id, shrines_id) VALUES (:user_id, :shrines_id)';
            $stmt = $sth->prepare($sql);
            $stmt->bindValue(':user_id', (int) $user_id, PDO::PARAM_INT);
            $stmt->bindValue(':shrines_id', (int) $review_id, PDO::PARAM_INT);
            $result = $stmt->execute();

            return $result;
        } catch (PDOException $e) {
            exit($e->getMessage());

            return $result = false;
        }
    }

    /*
         * いいねの削除.
         * $params int $user_id
         * $params int $review_id
         *
         * @return bool
         */

    public function good_exit($user_id, $review_id)
    {
        try {
            $sth = $this->dbh;
            $sql = 'DELETE FROM goods WHERE user_id = :user_id AND shrines_id = :shrines_id';
            $stmt = $sth->prepare($sql);
            $stmt->bindValue(':user_id', (int) $user_id, PDO::PARAM_INT);
            $stmt->bindValue(':shrines_id', (int) $review_id, PDO::PARAM_INT);
            $result = $stmt->execute();

            return $result;
        } catch (PDOException $e) {
            exit($e->getMessage());

            return $result = false;
        }
    }

    /**
     * 個々ユーザーのいいねを取得
     * fetchColumn.
     *
     * @return int $count 件数
     */
    public function good_count($id)
    {
        $sth = $this->dbh;
        $sql = 'SELECT count(*) as count FROM goods WHERE user_id = :user_id';
        $stmt = $sth->prepare($sql);
        $stmt->bindValue(':user_id', $id, PDO::PARAM_STR);
        $stmt->execute();
        $goods = $stmt->fetchColumn();
        // var_dump($goods);
        // exit();

        return $goods;
    }

    /**
     * いいねをした投稿情報を取得.
     *
     * @return array
     */
    public function good_reviews($id)
    {
        $sth = $this->dbh;
        $sql = 'SELECT u.name AS user_name, s.*
                FROM goods AS g
                JOIN users AS u ON u.id = g.user_id
                JOIN shrines_review AS s ON s.id = g.shrines_id
                WHERE g.user_id = :user_id
                ORDER BY id DESC';
        $stmt = $sth->prepare($sql);
        $stmt->bindValue(':user_id', $id, PDO::PARAM_STR);
        $stmt->execute();
        $goods = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // echo '<pre>';
        // var_dump($goods);
        // echo '</pre>';
        // exit();

        return $goods;
    }
}
