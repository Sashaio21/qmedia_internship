<?php

return array (
  'caption' => 'Настройки шапки',
  'introtext' => '',
  'settings' => [
        'header_menu' => [
            'type' => 'custom_tv:selector', 
            'caption' => 'Меню в верхней части',
            'note' => 'Выберите меню для отображения в верхней части сайта', 
        ],
        'header_phones' => [
            'type' => 'custom_tv:multitv', 
            'caption' => 'Список телефонов',
            'note' => 'Добавьте контактные телефоны для отображения в шапке', 
        ],
    ],
);