<?php

require_once ROOT_PATH.'/Models/Db.php';
class User extends Db
{
    public function __construct($dbh = null)
    {
        parent::__construct($dbh);
    }

    /**
     * ユーザー登録.
     *
     * @param array $post
     *
     * @return bool
     */
    public function userCreate($post)
    {
        try {
            $sth = $this->dbh;
            $sql = 'INSERT INTO users (name,email,password)
                    VALUES (:name,:email,:password)';
            $password = password_hash($post['password'], PASSWORD_DEFAULT);
            $stmt = $sth->prepare($sql);
            $stmt->bindValue(':name', $post['name'], PDO::PARAM_STR);
            $stmt->bindValue(':email', $post['email'], PDO::PARAM_STR);
            $stmt->bindValue(':password', $password, PDO::PARAM_STR);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            // exit($e->getMessage());

            return false;
        }
    }

    /**
     * ユーザー情報取得.
     *
     * @return array $params
     */
    public function findUserInfo($id)
    {
        try {
            $sth = $this->dbh;
            $sql = 'SELECT * FROM users WHERE id = :id';
            $stmt = $sth->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_STR);
            $stmt->execute();
            $params = $stmt->fetch(PDO::FETCH_ASSOC);

            return $params;
        } catch (PDOException $e) {
            exit($e->getMessage());

            return false;
        }
    }

    /**
     * ユーザー情報更新.
     *
     *@return bool
     */
    public function updateUser($post)
    {
        try {
            $sth = $this->dbh;
            $sql = 'UPDATE users SET name = :name, email = :email WHERE id = :id';
            $stmt = $sth->prepare($sql);
            $stmt->bindValue(':name', $post['name'], PDO::PARAM_STR);
            $stmt->bindValue(':email', $post['email'], PDO::PARAM_STR);
            $stmt->bindValue(':id', $post['id'], PDO::PARAM_STR);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    /*
     * ユーザー名チェック.
     *
     * @param array $post
     *
     * @return bool $result
     */
    public function nameCheck($post)
    {
        $result = false;
        try {
            $sth = $this->dbh;
            $sql = 'SELECT id FROM users WHERE name = :name';
            $stmt = $sth->prepare($sql);
            $stmt->bindValue('name', $post, PDO::PARAM_STR);
            $stmt->execute();
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $result = false;

                return $result;
            } else {
                $result = true;

                return $result;
            }
        } catch (PDOException $e) {
            $e->getMessage();

            return;
        }
    }

    /*
     * メールチェック.
     *
     * @param array $post
     *
     * @return array $_SESSION
     */
    public function emailCheck($post)
    {
        $result = false;

        try {
            $sth = $this->dbh;
            $sql = 'SELECT id FROM users WHERE email = :email';
            $stmt = $sth->prepare($sql);
            $stmt->bindValue('email', $post, PDO::PARAM_STR);
            $stmt->execute();
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $result = false;

                return $result;
            } else {
                $result = true;

                return $result;
            }
        } catch (PDOException $e) {
            exit($e->getMessage());

            return;
        }
    }

    /**
     * ログイン処理.
     *
     * @return array|bool $result|true
     */
    public function login($post)
    {
        $email = $post['email'];
        $password = $post['password'];
        // ユーザーをemailから検索して取得
        $user = self::getUserByEmail($email);

        if (!$user) {
            $_SESSION['msg']['email'] = 'emailが一致しません。';

            return;
        }
        // パスワード照会
        if (password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['login_user'] = $user;
        } else {
            $_SESSION['msg']['password'] = 'パスワードが一致しません。';

            return;
        }
    }

    /**
     * emailからユーザーを取得.
     *
     * @param string $email
     *
     * @return array|bool $user|false
     */
    public function getUserByEmail($email)
    {
        try {
            $sth = $this->dbh;
            $sql = 'SELECT * FROM users WHERE email = ?';
            // ユーザーデータを配列に入れる
            $arr = [];
            $arr[] = $email; // email
            $stmt = $sth->prepare($sql);
            $stmt->execute($arr);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            return $user;
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * emailからユーザーを取得.
     * パスワード再発行用.
     *
     * @param string $email
     *
     * @return bool
     */
    public function userFindEmail($email)
    {
        // var_dump($email);
        // exit();
        try {
            $sth = $this->dbh;
            $sql = 'SELECT * FROM users WHERE email = :email';
            $stmt = $sth->prepare($sql);
            $stmt->bindValue('email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch();
            if (!$user) {
                return false;
            } else {
                return true;
            }
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * ワンタイムトークン更新.
     * パスワード再発行用.
     *
     * @return array $post
     */
    public function upUser($post)
    {
        try {
            $sth = $this->dbh;
            $update_sql = 'UPDATE users SET reset_date = :reset_date, secret_key = :secret_key WHERE email = :email';
            $stmt = $sth->prepare($update_sql);
            $stmt->bindValue('email', $post['email'], PDO::PARAM_STR);
            $stmt->bindValue('reset_date', $post['reset_date'], PDO::PARAM_STR);
            $stmt->bindValue('secret_key', $post['secret_key'], PDO::PARAM_STR);
            $user = $stmt->execute();

            return $user;
        } catch (PDOException $e) {
            return false;
        }
        exit();
    }

    /**
     * ユーザー情報取得.
     * emailから
     * パスワード再発行用.
     *
     * @return array $post
     */
    public function userGet($email)
    {
        try {
            $sth = $this->dbh;
            $email_sql = 'SELECT * FROM users WHERE email = :email';
            $stmt = $sth->prepare($email_sql);
            $stmt->bindValue('email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            return $user;
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * ユーザー情報取得.
     * Keyから
     * パスワード再発行用.
     *
     * @return array $key
     */
    public function findByKey($key)
    {
        try {
            $sth = $this->dbh;
            $sql = 'SELECT * FROM users WHERE secret_key = :secret_key';
            $stmt = $sth->prepare($sql);
            $stmt->bindValue('secret_key', $key, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result;
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * パスワード再発行
     * 更新処理.
     *
     * @return array $post
     */
    public function upPass($post)
    {
        // echo '<pre>';
        // var_dump($post);
        // echo '</pre>';
        // exit();
        $result = false;
        try {
            $sth = $this->dbh;
            // $sql = 'UPDATE users SET password = :password, reset_date = :reset_date, secret_key = NULL
            //         WHERE :reset_date <= date_add(reset_date, INTERVAL 30 MINUTE) AND secret_key = :secret_key';
            $sql = 'UPDATE users SET password = :password, reset_date = :reset_date, secret_key = NULL 
                    WHERE secret_key = :secret_key';
            $password = password_hash($post['password'], PASSWORD_DEFAULT);
            $stmt = $sth->prepare($sql);
            $stmt->bindValue(':reset_date', $post['reset_date'], PDO::PARAM_STR);
            $stmt->bindValue(':secret_key', $post['key'], PDO::PARAM_STR);
            $stmt->bindValue(':password', $password, PDO::PARAM_STR);
            $result = $stmt->execute();

            return $result;
        } catch (PDOException $e) {
            return $result;
        }
    }

    /**
     *ログインチェック.
     *
     *@param void
     *
     *@return bool $result
     */
    public function loginCheck($user)
    {
        $result = false;

        //セッションにログインユーザーが入っていなかったらfalse
        if (isset($user) && $user['id'] > 0) {
            return $result = true;
        }

        return $result;
    }

    /**
     * ユーザーpass更新.
     *
     *@param array $post
     *
     *@return bool
     */
    public function updatePass($post)
    {
        $old_pass = $post['old_pass'];
        $new_pass = $post['new_pass'];
        $id = $post['id'];
        $new_password = password_hash($new_pass, PASSWORD_DEFAULT);
        // パスワード照会
        if (password_verify($old_pass, $_SESSION['login_user']['password'])) {
            session_regenerate_id(true);
        } else {
            $_SESSION['msg'] = '登録されているパスワードと古いパスワードが一致しません。';
            header('Location: pass_reset.php');
            exit();
        }
        try {
            $sth = $this->dbh;
            //SQLの準備
            $sth->beginTransaction();
            $sql = 'UPDATE users SET password = :password WHERE id = :id';
            $stmt = $sth->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->bindValue(':password', $new_password, PDO::PARAM_STR);
            //SQL実行
            $result = $stmt->execute();
            $sth->commit();

            return $result;
        } catch (PDOException $e) {
            $sth->rollBack();

            return $result = false;
        }
    }

    /**
     * ユーザー情報削除.
     *
     *@param array $id
     *
     *@return bool $result
     */
    public function deleteUser($id)
    {
        // var_dump($id);
        // exit();
        if (empty($id)) {
            exit('IDが不正です。');
        }

        $sql = 'DELETE FROM `users` WHERE `users`.`id` = :id';

        try {
            $sth = $this->dbh;
            //SQLの準備
            $sth->beginTransaction();
            $stmt = $sth->prepare($sql);
            $stmt->bindValue(':id', (int) $id, PDO::PARAM_INT);
            //SQL実行
            $result = $stmt->execute();
            $sth->commit();

            return $result;
        } catch (PDOException $e) {
            $sth->rollBack();

            return $result = false;
        }
    }
}
