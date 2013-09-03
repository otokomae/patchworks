<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * patchwork 表示関連コンポーネント
 *
 * @package     NetCommons Components
 * @author      Noriko Arai,Ryuji Masukawa
 * @copyright   2006-2007 NetCommons Project
 * @license     http://www.netcommons.org/license.txt  NetCommons License
 * @project     NetCommons Project, supported by National Institute of Informatics
 * @access      public
 */
class Patchworks_Components_View
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
	var $_container = null;
	var $_request = null;

	/**
	 * コンストラクター
	 *
	 * @access	public
	 */
	function Patchworks_Components_View()
	{
		$container =& DIContainerFactory::getContainer();
		$this->_db =& $container->getComponent("DbObject");
		$this->_request =& $container->getComponent("Request");
		$this->_session =& $container->getComponent("Session");
	}


	/**
	 * block ごとの設定情報を取得する
	 *
	 * @return string
	 * @access	public
	 */
	function getItem($block_id) {
        $block_id=intval($block_id);
        if ( $block_id <1  ) {
         return false;
        }
		$params = array($block_id);
		$sql = "SELECT item ".
				"FROM {patchworks} ".
				"WHERE block_id = ?";
		$x = $this->_db->execute($sql,$params);
		if ($x === false) {
			$this->_db->addError();
			return $x;
		}
// array として返す
		if( isset($x[0]["item"]) ) {  
		    return json_decode($x[0]["item"] , true);} else
        {return 0;}


      }
	/**
	 * patchworks_id の設定情報を取得する
	 *
	 * @return string
	 * @access	public
	 */
	function getConfig($patchworks_id) {
      // $patchworksID が自然数かどうかの判定を行なっている  

      $patchworks_id=intval($patchworks_id);
      if ( $patchworks_id <1  ) {
        return false;
      }
		$params = array($patchworks_id);
		$sql = "SELECT config ".
				"FROM {patchworks_config} ".
				"WHERE patchworks_id = ?";
		$x = $this->_db->execute($sql,$params);

		if ($x === false) {
			$this->_db->addError();
			return array();
		}

		if(isset($x[0]["config"]) ) { 
		   return json_decode($x[0]["config"] , true);} else
        {return array();}

    }

	/**
	 * 現在配置されている patchworks_id を取得する
	 *
	 * @return string
	 * @access	public
	 */
	function &getPatchworksID($block_id)
	{
		$params = array($block_id);
		$sql = "SELECT patchworks_id ".
				"FROM {patchworks} ".
				"WHERE block_id = ?";

		$x = $this->_db->execute($sql,$params);
		if ($x === false) {
			$this->_db->addError();
			return $x;
		}
		if(isset($x[0]["patchworks_id"])) {
		return $x[0]["patchworks_id"];} else
        {return $x;}
	}

	/**
	 * multidatabase の一覧を取得
	 *
	 * @return string
	 * @access	public
	 */
	function getMultis() {
		$sql = "SELECT multidatabase_id,multidatabase_name ".
				"FROM {multidatabase} ";
		$x = $this->_db->execute($sql);
        
        $xarray  = array();
        if ( ! $x  ) {return  array();};
        foreach ($x as $k=>$v){
          $xarray[$v['multidatabase_id']]['multidatabase_name'] = 
          $v['multidatabase_name'];
          $xarray[$v['multidatabase_id']]['multidatabase_id'] = 
          $v['multidatabase_id'];
        }
        return $xarray;
    }

	/**
	 * multidatabase からデータを読み込む
	 *
	 * @return string
	 * @access	public
	 */

	function getMultiMetaData($multidatabase_id) {
    // Meta data のデータを取得　キーは、メタデータID
		$params = array(intval($multidatabase_id));
		$sql = "SELECT  * ".
				"FROM {multidatabase_metadata} ".
				"WHERE multidatabase_id = ?";
		$x = $this->_db->execute($sql, $params);
        // error のときは、空の配列を返す
		if ($x === false) {
			$this->_db->addError();
			return array();
		}
        $xxx=array();
        foreach ($x as $k=>$v) {
         $xxx[$v['metadata_id']]=$v; 
        }
        return $xxx; 

    }
	function getMultiMetaName($multidatabase_id) {
    // Meta data の一覧を取得し、名前をキーにして戻す
		$params = array(intval($multidatabase_id));
		$sql = "SELECT  metadata_id,name ".
				"FROM {multidatabase_metadata} ".
				"WHERE multidatabase_id = ?";
		$x = $this->_db->execute($sql, $params);
		if ($x === false) {
			$this->_db->addError();
			return false;
		}
        $xxx=array();
        foreach ($x as $k=>$v) {
         $xxx[$v['name']]=$v['metadata_id']; 
        }
        return $xxx; 
    }
	
    function getMultiTitle($multidatabase_id) {
    // 指定された汎用DBのタイトルをもってくる
		$params = array($multidatabase_id);
        // title を取得
		$sql = "SELECT title_metadata_id ".
				"FROM {multidatabase} ".
				"WHERE multidatabase_id = ? ";
		$x = $this->_db->execute($sql, $params);
        if ( ! $x  ) {return  array();};

        if ( isset($x[0]['title_metadata_id']) ) {
		   $params = array($x[0]['title_metadata_id']);
		   $sql = "SELECT   content_id,content ".
		     	  "FROM {multidatabase_metadata_content} ".
				  "WHERE metadata_id = ? ";
        } else { return array();
        }
		$x = $this->_db->execute($sql, $params);
        //return array("x y z");
        if ( ! $x  ) {return  array();};
        return $x;
    }

    function getMultiByContentID($content_id) {
		 $sql = "SELECT  metadata_id,content ".
				"FROM {multidatabase_metadata_content} ".
				"WHERE content_id = ? ";
		 $params = array($content_id);
		 $x = $this->_db->execute($sql, $params);
         if ( ! $x  ) {return  array();};
   
          if ( isset($x[0]) ) {
          $xx = array();
          foreach ($x as $k=>$v) {
            $xx[$v['metadata_id']] = $v['content'];
          }
         } else { return array();};
          return $xx;
    }  
    function getMultiByBlockID($multidatabase_id,$block_id) {
    // 指定された汎用DBが、項目名として、block_id を持っている場合に、
    // そのコンテンツを戻す
       $xxx = array();
	   $metadata=$this->getMultiMetaName($multidatabase_id); 

       if ( isset($metadata['block_id']) ){
		$metadata_block_id=$metadata['block_id'];
		$params = array($metadata_block_id,$block_id);
		$sql = "SELECT content_id ".
				"FROM {multidatabase_metadata_content} ".
				"WHERE metadata_id = ? and  content = ?";
		$x = $this->_db->execute($sql, $params);

        if ( isset($x[0]['content_id']) ) {
         $content_id = $x[0]['content_id'];
		 $sql = "SELECT  metadata_id,content ".
				"FROM {multidatabase_metadata_content} ".
				"WHERE content_id = ? ";
		 $params = array($content_id);
         // content_id のデータを全部もってくる
		 $x = $this->_db->execute($sql, $params);
         if ( isset($x[0]) ) {
         // metadata の名前をキーにした連想配列をつくり戻す
		 $xx = array();
         foreach ($metadata as $k=>$v) {
		 $xx[$v] = $k;
         }
         foreach ($x as $k=>$v) {
          $xxx[$xx[$v['metadata_id']]] = $v['content'];
         }
         } 
         } 
         }
       return $xxx; 
    }
	/**
	 * pages から group room の情報を読取る
	 * group room は、pages の中に埋め込まれている
     * root_id が、2 のものがそうなっている。
     * pages_users_link では、room とヒモ付になっているか？
     * ページなのか不明
	 * @return string
	 * @access	public
	 */


	function getRoomList() {
    // group room一覧情報を取得( room は、特別 page )
		$params = array(2);
		$sql = "SELECT room_id,page_name ".
				"FROM {pages} ".
				"WHERE root_id = ?";
		$x = $this->_db->execute($sql, $params);
		if ($x === false) {
			  $this->_db->addError();
			  return $x;
              }
        $xx=array();
        foreach ($x as $k=>$v) {
            $xx[$v['room_id']] = $v['page_name']; 
        }
		return $xx;
    }
	
	/**
     * ユーザがどのroomとヒモ付されているかの一覧を返す
     * room は、pages の一種類。root_id = 2 のものに直接ぶら下がっているのがroom
     * pages_users_link  
     * ページなのか不明
	 * @return string
	 * @access	public
	 */
    function getRoomsByUser($user_id) {
		$params = array($user_id);
		$sql = "SELECT room_id,role_authority_id ".
				"FROM {pages_users_link} ".
				"WHERE user_id = ?";

		$x = $this->_db->execute($sql, $params);

		if ($x === false) {
			  $this->_db->addError();
			  return $x;
              }
        $xx=array();
        foreach ($x as $k=>$v) {
            $xx[$v['room_id']] = $v['role_authority_id']; 
        }
		return $xx;
    }
    
    // 設定情報の取得
    function getGlobalConfigByName($conf_name) {
		$params = array($conf_name);
		$sql = "SELECT conf_value ".
				"FROM {config} ".
				"WHERE conf_name = ?";

		$x = $this->_db->execute($sql, $params);

		if ($x === false) {
			  $this->_db->addError();
			  return $x;
              }
        return $x[0]['conf_value'];
    }

    // sql を直接送ってデータ取得
    // なんでもあり
    function getDataBySql($params,$sql) {
		$x = $this->_db->execute($sql, $params);
		if ($x === false) {
			  $this->_db->addError();
			  return $x;
              }
		return $x;
    }

	function getOnlineMember(){
	    $session = $this->_session;
        
        $onlineTime = 300;

		$baseSessionID = $session->getParameter("_base_sess_id");
		if (empty($baseSessionID)) {
			$baseSessionID = session_id();
		}

		$date = date("YmdHis", time() - $onlineTime);
		$params = array(
			$date,
			$baseSessionID,
			_OFF
		);
		$sql = "SELECT base_sess_id, sess_data ".
				"FROM {session} ".
				"WHERE sess_updated > ? ".
				"AND base_sess_id != ? ".
				"AND old_flag = ?";

		$result = $this->_db->execute($sql, $params);
		if ($result === false) {
			$this->_db->addError();
			return "error";
		}

		$sessionIDs = array();
		$member = 0;

        $x=array();
		foreach (array_keys($result) as $key) {
			if (in_array($result[$key]["base_sess_id"], $sessionIDs)) {
				continue;
			}
			
			$sessionIDs[] = $result[$key]["base_sess_id"];
			
			if (preg_match('/;_user_id\|s:40:"([0-9a-zA-Z]+)";/', $result[$key]["sess_data"], $matches)) {
				$member++;
			}
		}
		$user = count($sessionIDs) + 1;

		$userID = $session->getParameter("_user_id");
		if (!empty($userID)) {
			$member++;
		}
		
		$userMember = array("xxx" =>$x,
                           "user" => $user,
						   "member" => $member);
		
		return $userMember;
	}

}

?>
