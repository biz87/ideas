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
    $modx->regClientScript(MODX_ASSETS_URL. 'components/ideas/js/jquery.modal.min.js');

    $modx->regClientCSS(MODX_ASSETS_URL . 'components/ideas/lib/iziToast.css');
    $modx->regClientScript(MODX_ASSETS_URL. 'components/ideas/lib/iziToast.min.js');

}

$js_frontend = $modx->getOption('ideas_frontend_js', null, MODX_ASSETS_URL.'components/ideas/js/default.js');
if(!empty($js_frontend)){
    $modx->regClientScript($js_frontend);
}


$css_frontend = $modx->getOption('ideas_frontend_css', null, MODX_ASSETS_URL.'components/ideas/css/default.css');
if(!empty($css_frontend)){
    $modx->regClientScript($css_frontend);
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