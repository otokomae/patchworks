<?php

class Patchworks_View_Main_Init extends Action
{
    /**
     * [[機能説明]]
     *
     * @access  public
     */
    // リクエストパラメータを受け取るため
    var $block_id = null;
   // 使用コンポーネントを受け取るため
    var $patchworksView = null;
    var $db = null;
    var $session = null;
    var $request = null;

    function execute()
    {

    $this->patchworks_id = 
    intval($this->patchworksView->getPatchworksID($this->block_id));
     
     if (  $this->patchworks_id == 0 ) {
     return "error";
     } 
        // patchworks_id を簡便のために id とする
        $id = $this->patchworks_id;
         
        $this->config = $this->patchworksView->getConfig($id);
        $this->item = $this->patchworksView->getItem($this->block_id);
        $this->role_auth_id = $this->session->getParameter('_role_auth_id');
        $this->user_id = $this->session->getParameter('_user_id');

        // テンプレートが読み込む、スクリプトファイル 
        $x=BASE_DIR ."/webapp/modules/patchworks/templates/patchworks_script.html";
        $this->patchworks_script = $x;

// ここでコードを読み込む
       $x=BASE_DIR .'/extra/addin/patchworksID/'.$id.'/view_main_init.php';
       if (is_file($x)) {include($x);};
// パッチーク別のテンプレートを読み込む       
       $x=BASE_DIR ."/extra/addin/patchworksID/".$id."/patchworks_view_main_init_".$id. ".html";
       if (is_file($x)) {
       $this->view_main_init_template=$x;
       };
// パッチーク別のエラーテンプレートを読み込む       
       $x=BASE_DIR ."/extra/addin/patchworksID/".$id."/patchworks_view_error_".$id. ".html";
       if (is_file($x)) {
       $this->view_error_template=$x;
       };

         //return  'success' . $this->patchworks_id; 

       return 'success';
    }
}
?>
