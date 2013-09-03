<?php

class Patchworks_View_Edit_Config extends Action
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
     // ブロックIDから割り当てられているパッチーワークIDを取得する
     // ブロックIDに patchworksIDが割り当てられていないならエラーにする
     // patchworksID は、長いので、 id にする 
     $id = 
     intval($this->patchworksView->getPatchworksID($this->block_id));
     if ( $id == 0 ){return "error";};

     //パッチワークスの設定情報を取得する。設定されていない場合もあるのに注意 
     $this->config=$this->patchworksView->getConfig($id);
     
 
      
     $this->multis=$this->patchworksView->getMultis();

     $this->patchworks_id = $id;
     // テンプレートが読み込む、スクリプトファイル
     $x=BASE_DIR .
     "/webapp/modules/patchworks/templates/patchworks_script.html";
     $this->patchworks_script = $x;

 
     $x=BASE_DIR ."/extra/addin/patchworksID/".$this->patchworks_id . 
     "/patchworks_view_edit_config_".$this->patchworks_id. ".html";
     if (! is_file($x)) {
         $x=""; 
     }
     $this->view_edit_config_template=$x;

     if ( isset($this->config['patchworks_id']) )
     {$this->patchworks_data_flag=1;}
     $x = BASE_DIR .'/extra/addin/patchworksID/' . 
     $this->patchworks_id.'/view_edit_config.php';
     if ( is_file( $x ) ) {
       include($x);
     } // end of execution

        return "config";
    }
}
?>
