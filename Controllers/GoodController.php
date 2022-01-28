<?php

require_once ROOT_PATH.'Models/Good.php';

class GoodController
{
    private $request;  // リクエストパラメータ(GET,POST)
    private $Good;

    public function __construct()
    {
        // リクエストパラメータの取得
        $this->request['get'] = $_GET;
        $this->request['post'] = $_POST;

        // // モデルオブジェクトの生成
        $this->Good = new Good();
    }

    /*
     * いいねの確認.
     * $params int $user_id
     * $params int $review_id
     *
     * @return bool
     */

    public function check_good_duplicate($user_id, $review_id)
    {
        $result = $this->Good->check_good($user_id, $review_id);

        return $result;
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
        $result = $this->Good->good_entry($user_id, $review_id);

        return $result;
    }

    /*
         * いいねの解除.
         * $params int $user_id
         * $params int $review_id
         *
         * @return bool
         */

    public function good_exit($user_id, $review_id)
    {
        $result = $this->Good->good_exit($user_id, $review_id);

        return $result;
    }

    /*
    * いいねの個数取得.
    * $params int $id ユーザーid
    *
    * @return bool
    */

    public function findById($id)
    {
        $goods = $this->Good->good_count($id);

        return $goods;
    }

    /*
    * いいねした投稿取得.
    * $params int $id ユーザーid
    *
    * @return bool
    */

    public function goodReviewsById($id)
    {
        $good_reviews = $this->Good->good_reviews($id);

        return $good_reviews;
    }
}
