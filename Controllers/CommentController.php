<?php

require_once ROOT_PATH.'Models/Comment.php';

class CommentController
{
    private $request;  // リクエストパラメータ(GET,POST)
    private $Comment;

    public function __construct()
    {
        // リクエストパラメータの取得
        $this->request['get'] = $_GET;
        $this->request['post'] = $_POST;

        // // モデルオブジェクトの生成
        $this->Comment = new Comment();
    }

    /**
     * コメント登録.
     *
     * @return array
     */
    public function createTweet($newTweet)
    {
        $result = $this->Comment->tweetCreate($newTweet);

        return $result;
    }

    /**
     * コメント取得.
     *
     * @return array
     */
    public function commentAll($id)
    {
        $comments = $this->Comment->allComment($id);

        return $comments;
    }

    /**
     * コメント削除.
     *
     * @return array
     */
    public function comment_delete()
    {
        // var_dump($_GET);
        // exit();
        $comment_d = $this->Comment->delete_comment($this->request['get']['id']);

        return $comment_d;
    }
}
