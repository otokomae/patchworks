<?php

class Patchworks_Action_Edit_Item extends Action
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
    $config = $this->patchworksView->getConfig($this->patchworks_id);
     //file_put_contents('temp.out',$this->patchworks_id);
     $item = $this->request->getParameters();
     $x = BASE_DIR .
     '/extra/addin/patchworksID/'.$this->patchworks_id.'/action_edit_item.php';
     if (is_file($x) ) {
     include($x);
     }

        $item = json_encode($item);
        if ($this->patchworksAction->setItem($this->block_id,$item) ) {
		return "success";
        }

        return "error";
    }
}
?>
