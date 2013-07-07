<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * patchworks 登録処理
 *
 * @package     NetCommons
 * @author      Noriko Arai,Ryuji Masukawa
 * @copyright   2006-2007 NetCommons Project
 * @license     http://www.netcommons.org/license.txt  NetCommons License
 * @project     NetCommons Project, supported by National Institute of Informatics
 * @access      public
 */
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
       $this->patchworks_id=intval($this->patchworksView->getPatchworksID($this->block_id));
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
