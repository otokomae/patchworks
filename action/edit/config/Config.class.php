<?php

class Patchworks_Action_Edit_Config extends Action
{
	// リクエストパラメータを受け取るため
	var $block_id = null;
	var $patchworks_id = null;
    var $request =  null;

	// 使用コンポーネントを受け取るため
	var $db = null;
    var $patchworksAction = null;

	function execute()
	{

     $error_flag = false;
     $config = $this->request->getParameters();

     $x = BASE_DIR .
     '/extra/addin/patchworksID/'.$this->patchworks_id.'/action_edit_config.php';
     if (is_file($x) ) {
     include($x);
     }
  
        if ($this->patchworksAction->setConfig($this->patchworks_id,json_encode($config)) ) {
		return "success";
        }
        return "error";
    }
}
?>
