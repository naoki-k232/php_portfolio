<?php

require_once ROOT_PATH.'Models/Shrine.php';

class ShrineController
{
    private $request;  // リクエストパラメータ(GET,POST)
    private $Shrine;

    public function __construct()
    {
        // リクエストパラメータの取得
        $this->request['get'] = $_GET;
        $this->request['post'] = $_POST;

        // // モデルオブジェクトの生成
        $this->Shrine = new Shrine();
    }

    /**
     * 全レビュー取得.
     *
     * @return array
     */
    public function reviewFindAll()
    {
        $page = 0;
        if (isset($this->request['get']['page'])) {
            $page = $this->request['get']['page'];
        }
        $reviews = $this->Shrine->findAll($page);
        $reviews_count = $this->Shrine->countAll();
        $params = [
            'reviews' => $reviews,
            'pages' => $reviews_count / 6,
        ];

        return $params;
    }

    /**
     * レビューDB登録.
     *
     * @return
     */
    public function createReview($user_id, $review, $save_path)
    {
        $result = $this->Shrine->reviewCreate($user_id, $review, $save_path);

        return $result;
    }

    /**
     * 編集用のレビュー取得.
     *
     * @return array
     */
    public function edit($id)
    {
        $review = $this->Shrine->reviewFindById($id);

        return $review;
    }

    /**
     * レビュー更新.
     *
     * @return
     */
    public function updateReview($id, $reviewEdit, $new_save_path)
    {
        $result = $this->Shrine->reviewUpdate($id, $reviewEdit, $new_save_path);

        return $result;
    }

    /*
     * レビュー件数取得
     * カウント件数
     * @return
     */
    public function findById($id)
    {
        $count = $this->Shrine->findId($id);

        return $count;
    }

    /*
     * レビュー取得
     * @return
     */
    public function reviewsById($id)
    {
        $reviews = $this->Shrine->reviewsId($id);

        return $reviews;
    }

    /**
     * レビュー削除.
     *
     * @return array
     */
    public function shrine_delete()
    {
        $result_d = $this->Shrine->delete_shrine($this->request['get']['id']);

        return $result_d;
    }
}
