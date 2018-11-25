<?php

return [
    'ideas' => [
        'file' => 'ideas',
        'description' => '',
        'properties' => [
            'tpl' => [
                'type' => 'textfield',
                'value' => 'tpl.ideas.tpl',
            ],
            'sortby' => [
                'type' => 'textfield',
                'value' => 'createdon',
            ],
            'sortdir' => [
                'type' => 'textfield',
                'value' => 'asc',
            ],
            'limit' => [
                'type' => 'numberfield',
                'value' => 20,
            ],
        ],
    ],
];