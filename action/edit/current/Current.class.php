<?php

class Patchworks_Action_Edit_Current extends Action
{
	// リクエストパラメータを受け取るため
	var $block_id = null;
	var $patchworks_id = null;

	// 使用コンポーネントを受け取るため
	var $db = null;
    // 使用コンポーネントを受け取るため
    var $patchworksAction = null;
    var $patchworksView = null;


	function execute()
	{
       $x = $this->patchworksView->getConfig($this->patchworks_id);

       if (!$this->patchworksAction->setPatchworks( intval($this->block_id),
           intval($this->patchworks_id))) {
		return 'error';
        }
		return 'success';
	}
}
?>
