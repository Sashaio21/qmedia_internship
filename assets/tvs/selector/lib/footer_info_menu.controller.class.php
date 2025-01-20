<?php namespace Selector;

include_once(MODX_BASE_PATH.'assets/tvs/selector/lib/controller.class.php');

class Footer_Info_MenuController extends SelectorController {
    public function __construct($modx) {
        parent::__construct($modx);
        $this->dlParams['parents'] = 0;
        $this->dlParams['addWhereList'] = 'c.published = 1';
        $this->dlParams['limit'] = 0;   
        $this->dlParams['depth'] = 1;   
    }
}
