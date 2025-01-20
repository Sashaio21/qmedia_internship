<?php namespace Selector;

include_once(MODX_BASE_PATH.'assets/tvs/selector/lib/controller.class.php');

class RelatedController extends SelectorController {
    public function __construct($modx) {
        parent::__construct($modx);

        // Устанавливаем параметры для запроса DocLister
        $this->dlParams['parents'] = 5;
        $this->dlParams['addWhereList'] = 'c.published = 1';

        // Добавляем параметры limit и depth
        $this->dlParams['limit'] = 0;    // Не ограничиваем количество элементов
        $this->dlParams['depth'] = 2;    // Устанавливаем глубину поиска
    }
}
