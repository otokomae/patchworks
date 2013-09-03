<?php
class Patchworks_Action_Edit_Init extends Action
{
	// リクエストパラメータを受け取るため
	var $block_id = null;
	var $patchworks_id = null;
	var $request =  null;

	// 使用コンポーネントを受け取るため
	var $db = null;
    var $patchworksAction = null;
    var $patchworksView = null;

	function execute()
	{
     $this->patchworks_id =
     intval($this->patchworksView->getPatchworksID($this->block_id));
     $id = $this->patchworks_id;
     $this->item = $this->patchworksView->getItem($this->block_id);
     $this->config = $this->patchworksView->getConfig($id);
     $this->role_auth_id = $this->session->getParameters('_role_auth_id');
     $this->user_id = $this->session->getParameter('_user_id');
 
     $error_flag = false;
     $x = BASE_DIR .
     '/extra/addin/patchworksID/'.$this->patchworks_id.'/action_edit_init.php';
     if (is_file($x) ) {
         include($x);
     }

     if ( $error_flag ) { return "error"; }
     return "success";
    }
}
?>
