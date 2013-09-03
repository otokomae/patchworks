<?php

class Patchworks_Action_Edit_Delblock extends Action
{
	// リクエストパラメータを受け取るため
	var $block_id = null;
	
	// 使用コンポーネントを受け取るため
	var $db = null;
	

	function execute()
	{
	// block_id を読みだして削除する
		$result = $this->db->selectExecute("patchworks", array("block_id"=>$this->block_id));
    	if ($result === false) {
    		return 'error';
    	}
    	if(!isset($result[0])) {
    		return 'success';
    	}
		$patchworks = $result[0];

		$result = $this->db->deleteExecute("patchworks", array("block_id"=>$this->block_id));
    	if ($result === false) {
    		return 'error';
    	}
		
		return 'success';
	}
}
?>
