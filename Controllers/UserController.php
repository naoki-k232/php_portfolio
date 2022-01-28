<?php

require_once ROOT_PATH.'Models/User.php';

class UserController
{
    private $request;  // リクエストパラメータ(GET,POST)
    private $User;     // userモデル

    public function __construct()
    {
        // リクエストパラメータの取得
        $this->request['get'] = $_GET;
        $this->request['post'] = $_POST;

        // // モデルオブジェクトの生成
        $this->User = new User();
    }

    /**
     * ユーザーDB登録.
     *
     * @param array $post
     *
     * @return
     */
    public function createUser($post)
    {
        $result = $this->User->userCreate($post);

        return $result;
    }

    /**
     * ユーザー情報取得.
     *
     * @return array $params
     */
    public function findById($id)
    {
        $params = $this->User->findUserInfo($id);

        return $params;
    }

    /*
    * ユーザー情報更新
    * @param array $post
    *
    * @return bool $result
    */
    public function userUpdate($post)
    {
        $result = $this->User->updateUser($post);

        return $result;
    }

    /*
     * ユーザー名二重チェック
     *
     * @param array $post
     *
     * @return bool
     */
    public function checkName($post)
    {
        $result = $this->User->nameCheck($post);

        return $result;
    }

    /*
    * ユーザー名二重チェック
    *
    * @param array $post
    *
    * @return bool
    */
    public function checkEmail($post)
    {
        $result = $this->User->emailCheck($post);

        return $result;
    }

    /*
    * ログイン
    *
    * @param array $post
    *
    * @return bool
    */
    public function userLogin($post)
    {
        $user = $this->User->login($post);
    }

    /*
    * パスワード再発行ユーザー確認
    *
    * @param array $email
    *
    * @return bool
    */
    public function findUserEmail($email)
    {
        $result = $this->User->userFindEmail($email);

        return $result;
    }

    /*
    * パスワード再発行ユーザー確認
    * ワンタイムトークン更新
    * @param array $post
    *
    * @return bool
    */
    public function user_reset_Update($post)
    {
        $result = $this->User->upUser($post);

        return $result;
    }

    /*
    * メール送信用
    *
    * @param array $post
    *
    * @return array $params
    */
    public function getUser($email)
    {
        $params = $this->User->userGet($email);

        return $params;
    }

    /*
    * パスワード忘れた場合の
    * パスワード更新更新
    * @param array $post
    *
    * @return bool
    */
    public function passUpdate($post)
    {
        $result = $this->User->upPass($post);

        return $result;
    }

    /*
    * パスワード忘れた場合の
    * ユーザー情報取得
    * @param array $key
    *
    * @return bool
    */
    public function userFindByKey($key)
    {
        $result = $this->User->findByKey($key);

        return $result;
    }

    /*
    * ログインチェック
    * @param array $user
    *
    * @return bool
    */
    public function checkLogin($user)
    {
        $result = $this->User->loginCheck($user);

        return $result;
    }

    /*
    * ユーザー削除
    * @param array $id
    *
    * @return bool
    */
    public function userDelete()
    {
        if (empty($this->request['get']['id'])) {
            echo '指定のパラメータが不正です。このページは表示できません。';
            exit;
        }
        $result = $this->User->deleteUser($this->request['get']['id']);

        return $result;
    }

    /*
    * pass更新
    * @param array $post
    *
    * @return bool
    */
    public function passUp($post)
    {
        $result = $this->User->updatePass($post);

        return $result;
    }

    /*
    * ログアウト
    */
    public function logout()
    {
        $_SESSION = [];
        session_destroy();
    }
}
