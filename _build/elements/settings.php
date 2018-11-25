<?php

return [
    'allow_jquery_modal' => [
        'xtype' => 'combo-boolean',
        'value' => true,
        'area' => 'ideas_main',
    ],
    'frontend_js' => [
        'xtype' => 'textfield',
        'value' => '[[++assets_url]]components/ideas/js/default.js',
        'area' => 'ideas_main',
    ],
    'frontend_css' => [
        'xtype' => 'textfield',
        'value' => '[[++assets_url]]components/ideas/css/default.css',
        'area' => 'ideas_main',
    ],
    'allow_vote_anonimus' => [
        'xtype' => 'combo-boolean',
        'value' => true,
        'area' => 'ideas_main',
    ],
    'first_status' => [
        'xtype' => 'numberfield',
        'value' => 1,
        'area' => 'ideas_main',
    ],
    'allow_new_ideas_anonimus' => [
        'xtype' => 'combo-boolean',
        'value' => false,
        'area' => 'ideas_main',
    ],
    'allow_published' => [
        'xtype' => 'combo-boolean',
        'value' => false,
        'area' => 'ideas_main',
    ],
    'manager_email' => [
        'xtype' => 'textfield',
        'value' => '',
        'area' => 'ideas_main',
    ],
    'email_tpl' => [
        'xtype' => 'textfield',
        'value' => 'tpl.email.new.manager',
        'area' => 'ideas_main',
    ],

];