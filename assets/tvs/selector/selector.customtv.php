<?php
/**
 * Created by PhpStorm.
 * User: Pathologic
 * Date: 22.05.2015
 * Time: 20:43
 */

if (!IN_MANAGER_MODE) {
    die('<h1>ERROR:</h1><p>Please use the MODx Content Manager instead of accessing this file directly.</p>');
}

global $content;

// Подключаем класс селектора
include_once(MODX_BASE_PATH.'assets/tvs/selector/lib/selector.class.php');

// Проверяем, существуют ли необходимые ключи в массиве $content
$documentData = array(
    'id' => isset($content['id']) ? (int)$content['id'] : 0,
    'template' => isset($content['template']) ? (int)$content['template'] : 0,
    'parent' => isset($content['parent']) ? (int)$content['parent'] : 0,
);

// Создаем объект селектора
$selector = new \Selector\Selector (
    $modx,
    $row,
    $documentData
);

// Рендерим результат
echo $selector->render();
