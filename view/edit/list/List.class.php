<?php

class Patchworks_View_Edit_List extends Action
{
    // パラメータを受け取るため
    var $module_id = null;
	var $block_id = null;

    // 使用コンポーネントを受け取るため
    var $patchworksView = null;
    var $patchworksAction = null;
    var $request = null;
    var $session = null;
    var $config = null;

    /**
     * 工事中
     *
     * @access  public
     */
    function execute()
    {
      //インストール直後の処理、999999 を設定
      $x = $this->patchworksView->getConfig(999999);
      if (count($x)== 0 ) {
      $x = parse_ini_file(BASE_DIR .
      "/extra/addin/patchworksID/999999/name.ini");
      $config->patchworks_active = $x['list'];
      $this->patchworksAction->setConfig(999999,json_encode($config));
      $x = $config; 
      }
      // name.ini には、1,2,3とか書いてある。 
      $x = $x['patchworks_active'];
      $xarray=explode(",",$x);  

      $xx=array();
      foreach ( $xarray as $k=>$v ) {
        $x=$this->patchworksView->getConfig($v);
        if ( $x ) {
            $xx[$v]['name'] = $x['patchworks_name'];
        } else {
           $xx[$v]['name'] = "";
           $x = BASE_DIR .
           "/extra/addin/patchworksID/".$v."/name.ini";
           if (is_file($x)) {
             $x = parse_ini_file($x);
// name.ini 情報を漬け込む、パッチワーク名と、その概要の説明のみ
               if (isset($x['name'])) {
                   $xx[$v]['name'] = $x['name'];
               } else {
                   $xx[$v]['name'] = "dummy";
               }

               if (isset($x['description'])) {
                   $xx[$v]['description'] = $x['description'];
               } else {
                   $xx[$v]['description'] = "dummy";
               }

            }
      // 
      $config = null; 
      $config->patchworks_name = 
      $xx[$v]['name'];;
      $config->patchworks_description = 
      $xx[$v]['description'];;
      $config->patchworks_id = $v;;
      
      $this->patchworksAction->setConfig($v,json_encode($config));
      }
        $xx[$v]['id'] = $v;
      }

      $this->patchworks_list= $xx;
      
      $this->patchworks_id = 
      $this->patchworksView->getPatchworksID($this->block_id);
            if ($this->patchworks_id === false) {
                return "error";
            }
      //$this->xxx= print_r($xx,true);
      $x = BASE_DIR ."/webapp/modules/patchworks/templates/default/patchworks_view_edit_list_one.html";
      $this->view_edit_list_one_template=$x;

      return "success";
}
}
?>
