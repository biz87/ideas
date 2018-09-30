<?php
/** @var modX $modx */
/** @var array $scriptProperties */
/** @var ideas $ideas */
$ideas = $modx->getService('ideas', 'ideas', MODX_CORE_PATH . 'components/ideas/model/', $scriptProperties);
if (!$ideas) {
    $modx->log(modX::LOG_LEVEL_ERROR, 'Could not load ideas class!');
    return '';
}

$allow_jquery_modal = $modx->getOption('ideas_allow_jquery_modal', null, true);
if($allow_jquery_modal){
    $modx->regClientCSS(MODX_ASSETS_URL . 'components/ideas/css/jquery.modal.min.css');
    $modx->regClientScript(MODX_ASSETS_URL. 'components/ideas/js/jquery.modal.min.js');
}

$pdoFetch = $modx->getService('pdoFetch');

$ideasPosts = $pdoFetch->getCollection(
    'ideasPosts',
    array('active' => 1),
    array(
        'sortby' => 'createdon',
        'sortdir' => 'asc',
        'innerJoin' => array(
            'Status' => array(
                'class' => 'ideasStatus',
                'on' => 'ideasPosts.status = Status.id'
            ),
            'Type' => array(
                'class' => 'ideasType',
                'on' => 'ideasPosts.type = Type.id'
            )
        ),
        'select' => array(
            'ideasPosts' => 'name, description',
            'Status' => 'Status.name as status_name',
            'Type' => 'Type.name as type_name'
        ),
        'limit' => 20
    )
);


