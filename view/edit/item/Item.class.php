<?php

class Patchworks_View_Edit_Item extends Action
{
    // パラメータを受け取るため
    var $module_id = null;
	var $block_id = null;

    // 使用コンポーネントを受け取るため
    var $patchworksView = null;
    var $request = null;
    var $session = null;



    /**
     * 工事中
     *
     * @access  public
     */
    function execute()
    {
     $this->patchworks_id = 
     intval($this->patchworksView->getPatchworksID($this->block_id));
     // patchworks_id が設定されていないときは、エラーにする。
     // ブロックを設定したては、ブロックとpatchworksがひもづけられていない。
     if ($this->patchworks_id === false 
     || $this->patchworks_id === 0) {
                return "error";
     }

  if (isset($this->config['multidatabase_id'])  ) {
   $multi_by_block = 
   $this->patchworksView->getMultiByBlockID(
   $this->config['multidatabase_id'],$this->block_id);
  } else {
    $multi_by_block = array();
    $this->config['multidatabase_id'] = 0;
  } 
  $this->multi_by_block=$multi_by_block;
     // patchworks の設定情報取得
     $this->config=$this->patchworksView->getConfig($this->patchworks_id);
     // ブロック毎の情報を取得
     $this->item=$this->patchworksView->getItem($this->block_id);
    // テンプレートが読み込む、スクリプトファイル 
    //
    $x=BASE_DIR ."/webapp/modules/patchworks/templates/patchworks_script.html";
    $this->patchworks_script = $x;

     // ブロック毎の情報が設定されていない場合にフラグをたてる
     if ( isset($this->item['patchworks_id']) )
       {$this->patchworks_data_flag=1;}
       $x=BASE_DIR ."/extra/addin/patchworksID/" . 
       $this->patchworks_id."/patchworks_view_edit_item_" . 
       $this->patchworks_id. ".html";
     // edit_item 用のテンプレートがあったらそちらを使う
     if (!is_file($x)){$x = "";}
     $this->view_edit_item_template=$x;
     // edit_item 用のスクリプトがあるかどうかをチェックする。
     // あったらそちらを使う
     // ここでコードを読み込む
     $x = BASE_DIR .'/extra/addin/patchworksID/' . 
     $this->patchworks_id.'/view_edit_item.php';
     if ( is_file( $x ) ) {
       include($x);
     } // end of execution
       return "item";
 }
}
?>
