<?php

class Patchworks_View_Edit_Base extends Action
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
     $this->patchworks_id=999999;
     $this->config=$this->patchworksView->getConfig($this->patchworks_id);
     $x = scandir(BASE_DIR . "/extra/addin/patchworksID");
     $xarray = array();
     // 一覧に 999999 はでてこない
     foreach ($x as $k=>$v) {
       if (intval($v) >0 && intval($v) <> 999999) {
         $xarray[]=$v;
       }  
     }
     sort($xarray); 

     //$this->xxx = print_r($xarray,true);
     $this->config['patchworks_all'] = implode(',',$xarray); 
     if (isset($this->config['patchworks_id'])) 
         {$this->patchworks_data_flag = 1 ;}
            if ($this->patchworks_id === false) {
                return "error";
            }
        return "base";
    }
}
?>
