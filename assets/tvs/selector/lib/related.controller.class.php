<?php namespace Selector;
include_once(MODX_BASE_PATH.'assets/tvs/selector/lib/controller.class.php');
class RelatedController extends SelectorController {
    public function __construct($modx) {
        parent::__construct($modx);
        $this->dlParams['parents'] = 0;
        $this->dlParams['addWhereList'] = 'c.published = 1';
    }
}