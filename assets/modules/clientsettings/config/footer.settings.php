<?php
return array (
  'caption' => 'Настройки футера',
  'introtext' => '',
  'settings' => [
        'footer_company_info' => [
            'caption' => 'Описание компании',
            'type'  => 'textareamini',
            'note'  => '',
        ],
        'footer_info_menu' => [
            'caption' => 'Информационное меню (рядом с каталогом)',
            'type'  => 'custom_tv:selector',
            'note'  => '',
        ],
        'footer_phones' => [
            'caption' => 'Список телефонов',
            'type'  => 'custom_tv:multitv',
            'note'  => '',
        ],
        'footer_emails' => [
            'caption' => 'Список почтовых ящиков',
            'type'  => 'custom_tv:multitv',
            'note'  => '',
        ]
    ],
    
);