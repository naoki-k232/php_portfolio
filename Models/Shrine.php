<?php

require_once ROOT_PATH.'/Models/Db.php';
class Shrine extends Db
{
    public function __construct($dbh = null)
    {
        parent::__construct($dbh);
    }

    /**
     * レビュー登録.
     *
     * @return bool
     */
    public function reviewCreate($user_id, $review, $save_path)
    {
        $result = false;
        try {
            $sth = $this->dbh;
            $sth->beginTransaction();
            $sql = 'INSERT INTO Shrines_review (title, recommends, description, image, user_id)
                    VALUES (:title,:recommends,:description,:image,:user_id)';
            $stmt = $sth->prepare($sql);
            $stmt->bindValue(':title', $review['title'], PDO::PARAM_STR);
            $stmt->bindValue(':recommends', (int) $review['score'], PDO::PARAM_INT);
            $stmt->bindValue(':description', $review['description'], PDO::PARAM_STR);
            $stmt->bindValue(':image', $save_path, PDO::PARAM_STR);
            $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
            $stmt->execute();
            $sth->commit();

            return true;
        } catch (PDOException $e) {
            $sth->rollBack();

            return false;
        }
    }

    /*
     * 全レビュー取得.
     *
     * @return bool
     */
    public function findAll($page = 0): array
    {
        $sql = 'SELECT u.name AS user_name, s.* 
                FROM Shrines_review AS s 
                JOIN users AS u on u.id = s.user_id 
                ORDER BY id DESC';
        $sql .= ' LIMIT 6 OFFSET '.(6 * $page);
        $sth = $this->dbh->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    /**
     * 全データを取得
     * fetchColumn
     * 結果セットの次行から単一カラムを返す.
     *
     * @return int $count 件数
     */
    public function countAll(): int
    {
        $sql = 'SELECT count(*) as count FROM Shrines_review';
        $sth = $this->dbh->prepare($sql);
        $sth->execute();
        $count = $sth->fetchColumn();

        return $count;
    }

    /**
     * 個々のユーザー投稿データを取得
     * fetchColumn
     * 結果セットの次行から単一カラムを返す.
     *
     * @return int $count 件数
     */
    public function findId($id)
    {
        $sth = $this->dbh;
        $sql = 'SELECT count(*) as count FROM Shrines_review WHERE user_id = :user_id';
        $stmt = $sth->prepare($sql);
        $stmt->bindValue(':user_id', $id, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        return $count;
    }

    /**
     * 個々のユーザー投稿データを取得.
     *
     * @return array $result
     */
    public function reviewsId($id)
    {
        $sth = $this->dbh;
        $sql = 'SELECT u.name AS user_name, s.* 
                FROM shrines_review AS s
                JOIN users AS u ON u.id = s.user_id
                WHERE s.user_id = :user_id';
        $stmt = $sth->prepare($sql);
        $stmt->bindValue(':user_id', $id, PDO::PARAM_STR);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $results;
    }

    /*
     * 編集用レビュー取得.
     *
     * @return bool
     */
    public function reviewFindById($id)
    {
        $sql = 'SELECT u.name AS user_name, s.* FROM Shrines_review AS s JOIN users AS u on u.id = s.user_id WHERE s.id = :id';
        $sth = $this->dbh->prepare($sql);
        $sth->bindValue(':id', $id, PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    /**
     * レビュー更新.
     *
     * @return bool
     */
    public function reviewUpdate($id, $reviewEdit, $new_save_path)
    {
        $sql = 'UPDATE shrines_review 
                SET title= :title, recommends= :recommends, description = :description, image = :image 
                WHERE id = :id';
        try {
            $sth = $this->dbh;
            $sth->beginTransaction();
            $stmt = $sth->prepare($sql);
            $stmt->bindValue(':id', (int) $id, PDO::PARAM_INT);
            $stmt->bindValue(':title', $reviewEdit['title'], PDO::PARAM_STR);
            $stmt->bindValue(':recommends', (int) $reviewEdit['score'], PDO::PARAM_INT);
            $stmt->bindValue(':description', $reviewEdit['description'], PDO::PARAM_STR);
            $stmt->bindValue(':image', $new_save_path, PDO::PARAM_STR);
            $stmt->execute();
            $sth->commit();

            return;
        } catch (PDOException $e) {
            // exit($e->getMessage());
            $sth->rollBack();

            return;
        }
    }

    /*
     * コメント削除.
     *
     * @return bool
     */
    public function delete_shrine($id)
    {
        try {
            $sth = $this->dbh;
            $sql = 'DELETE FROM shrines_review WHERE id = :id';
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
