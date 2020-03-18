<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Мовні ресурси назв пунтків меню
    |--------------------------------------------------------------------------
    |
    | Наступні мовні ресурси використовуються в назвах
    | пунтків меню усієї вашої програми.
    | Ви можете вільно змінювати ці мовні ресурси відповідно до вимог
    | вашої програми.
    |
    */

    'backend' => [
        'access' => [
            'title' => 'Адміністрування',
            'roles' => [
                'all' => 'Всі ролі',
                'create' => 'Створити роль',
                'edit' => 'Редагувати роль',
                'management' => 'Керування доступом',
                'main' => 'Ролі',
            ],
            'users' => [
                'all' => 'Усі користувачі',
                'change-password' => 'Змінити пароль',
                'create' => 'Створити користувача',
                'deactivated' => 'Заблоковані користувачі',
                'deleted' => 'Вилучені користувачі',
                'edit' => 'Редагувати користувача',
                'main' => 'Користувачі',
                'view' => 'Переглянути обліковий запис',
            ],
        ],
        'log-viewer' => [
            'main' => 'Журнал помилок',
            'dashboard' => 'Огляд',
            'logs' => 'Всі записи',
        ],
        'sidebar' => [
            'dashboard' => 'Системна панель',
            'general' => 'Головна',
            'system' => 'Система',
        ],
    ],
    'language-picker' => [
        'language' => 'Мова',
        /*
         * Додайте нову мову до цього масиву.
         * Ключ повинен мати той самий код мови, що і ім'я папки.
         * Рядок має бути: 'Language-name-in-your-own-language (Language-name-in-English)'.
         * Обов'язково додайте нову мову в алфавітному порядку.
         */
        'langs' => [
            'ar' => 'Арабська (Arabic)',
            'az' => 'Azerbaijan',
            'zh' => 'Китайська (Chinese Simplified)',
            'zh-TW' => 'Китайська (Chinese Traditional)',
            'da' => 'Датська (Danish)',
            'de' => 'Німецька (German)',
            'el' => 'Грецька (Greek)',
            'en' => 'Англійська (English)',
            'es' => 'Іспанська (Spanish)',
            'fa' => 'Персидська (Persian)',
            'fr' => 'Французська (French)',
            'he' => 'Іврит (Hebrew)',
            'id' => 'Індонезійська (Indonesian)',
            'it' => 'Італійська (Italian)',
            'ja' => 'Японська (Japanese)',
            'nl' => 'Голландська (Dutch)',
            'no' => 'Норвезька (Norwegian)',
            'pt_BR' => 'Бразильська Португальська (Brazilian Portuguese)',
            'ru' => 'Російська (Russian)',
            'sv' => 'Шведська (Swedish)',
            'th' => 'Тайська (Thai)',
            'tr' => 'Турецька (Turkish)',
            'uk' => 'Українська (Ukrainian)',
        ],
    ],
];