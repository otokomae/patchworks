<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * 登録フォームデータ登録コンポーネントクラス
 *
 * @package     NetCommons Components
 * @author      Noriko Arai,Ryuji Masukawa
 * @copyright   2006-2007 NetCommons Project
 * @license     http://www.netcommons.org/license.txt  NetCommons License
 * @project     NetCommons Project, supported by National Institute of Informatics
 * @access      public
 */
class Patchworks_Components_Action
{
	/**
	 * @var DBオブジェクトを保持
	 *
	 * @access	private
	 */
	var $_db = null;

	/**
	 * @var Requestオブジェクトを保持
	 *
	 * @access	private
	 */
	var $_request = null;

	/**
	 * コンストラクター だけ
	 *
	 * @access	public
	 */
	function Patchworks_Components_Action()
	{
		$container =& DIContainerFactory::getContainer();
		$this->_db =& $container->getComponent("DbObject");
		$this->_request =& $container->getComponent("Request");
	}
    
    function setConfig($patchworks_id,$config){
        // 不要だと思うけど、念の為に型判定
        $patchworks_id = intval($patchworks_id);
        if (  $patchworks_id < 1 ) {
            return false;
        }

        $params = array($patchworks_id);

        // すでに設定情報が登録されているかどうかの判定
        $sql = "SELECT patchworks_id ".
                "FROM {patchworks_config} ".
                "WHERE patchworks_id = ?";
        

        $xxx = $this->_db->execute($sql, $params);
        if ($xxx === false) {
            $this->_db->addError();
            return false;
        }

       $params = array(
            "patchworks_id" => $patchworks_id,
            "config" => $config
        );

        // データがない場合には、insert する
        if ( isset($xxx[0]['patchworks_id'])) {
            $xxx = $this->_db->updateExecute("patchworks_config", $params, "patchworks_id", true);
        } else {
            $xxx = $this->_db->insertExecute("patchworks_config", $params, true);
        }
        if ($xxx === false) {
            $this->_db->addError();
            return false;
        }
        return true;

    }
   /**
     * patchworks 個別情報をつけこむ
     *
     * @return boolean  true or false
     * @access  public
     */
    function setItem($block_id,$item) {
        //$item = json_encode($this->_request->getParameters());
        $params = array(
            "block_id" => $block_id,
            "item" => $item
        );
       $xxx = $this->_db->updateExecute("patchworks",
        $params, "block_id", true);
        if ($xxx === false) {
            $this->_db->addError();
            return false;
        }
        return true;
    }

   /**
     * patchworks をブロックに割り当てる
     *
     * @return boolean  true or false
     * @access  public
     */
    function setPatchworks($block_id,$patchworks_id)
    {   
        // 割り当てる対象のブロックと patchworks_id を同じにする
/**
        $block_id = 
        $this->_request->getParameter("block_id");
        $patchworks_id =  
        intval($this->_request->getParameter("patchworks_id"));
**/
        //  
        if ( $patchworks_id == 0 ){
            return false;
        } 
 
        $params = array($block_id);
        $sql = "SELECT patchworks_id ".
                "FROM {patchworks} ".
                "WHERE block_id = ?";
        //
        $id = $this->_db->execute($sql, $params);

        if ($id === false) {
            $this->_db->addError();
            return false;
        }
 
        // 変更なしならそのまま
        if ($id === $patchworks_id) {
            return true;
        }
        $params = array(
            "block_id" => $block_id,
            "patchworks_id" => $patchworks_id,
            "item" => "");
       if (!empty($id)) {
            // item をクリヤ
            $result = 
            $this->_db->updateExecute("patchworks", $params, "block_id", true);
        } else {
            $result = $this->_db->insertExecute("patchworks", $params, true);
        }
        if (!$result) {
            return false;
        }
        if (!$result) {
            return false;
        }
       return true;

    }


}
?>
