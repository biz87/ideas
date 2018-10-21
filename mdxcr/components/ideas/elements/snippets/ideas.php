<?php
/** @var modX $modx */
/** @var array $scriptProperties */
/** @var ideas $ideas */
$ideas = $modx->getService('ideas', 'ideas', MODX_CORE_PATH . 'components/ideas/model/', $scriptProperties);
if (!$ideas) {
    $modx->log(modX::LOG_LEVEL_ERROR, '[ideas] Could not load ideas class!');
    return '';
}

$allow_jquery_modal = $modx->getOption('ideas_allow_jquery_modal', null, true);
if($allow_jquery_modal){
    $modx->regClientCSS(MODX_ASSETS_URL . 'components/ideas/css/jquery.modal.min.css');
    $modx->regClientCSS(MODX_ASSETS_URL . 'components/ideas/css/default.css');
    $modx->regClientScript(MODX_ASSETS_URL. 'components/ideas/js/jquery.modal.min.js');
    $modx->regClientScript(MODX_ASSETS_URL. 'components/ideas/js/default.js');
}



$pdoFetch = $modx->getService('pdoFetch');
$pdo = $modx->getService('pdoTools');

$types = $pdoFetch->getCollection(
    'ideasType',
    array('active' => 1),
    array(
        'sortby' => 'rank',
        'sortdir' => 'asc',
    )
);

if(count($types) > 0){
    foreach($types as $key => $type){
        $types[$key]['posts'] = $pdoFetch->getCollection(
            'ideasPost',
            array('active' => 1, 'type' => $type['id']),
            array(
                'sortby' => 'createdon',
                'sortdir' => 'asc',
                'leftJoin' => array(
                    'Status' => array(
                        'class' => 'ideasStatus',
                        'on' => 'ideasPost.status = Status.id'
                    ),
                    'Type' => array(
                        'class' => 'ideasType',
                        'on' => 'ideasPost.type = Type.id'
                    ),
                ),
                'select' => array(
                    'ideasPost' => '*',
                    'Status' => 'Status.name as status_name',
                    'Type' => 'Type.name as type_name, Type.id as type_id'
                ),

                'limit' => 20
            )
        );

    }


    return $pdo->getChunk('tpl.ideas.tpl', array('data' => $types));
}else{
    $modx->log(modX::LOG_LEVEL_ERROR, '[ideas] type not found');
}