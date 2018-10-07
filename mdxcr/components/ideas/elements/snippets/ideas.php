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
    $modx->regClientCSS(MODX_ASSETS_URL . 'components/ideas/css/defau.css');
    $modx->regClientScript(MODX_ASSETS_URL. 'components/ideas/js/jquery.modal.min.js');
}



$pdoFetch = $modx->getService('pdoFetch');
$pdo = $modx->getService('pdoTools');
//
//$ideasPosts = $pdoFetch->getCollection(
//    'ideasPosts',
//    array('active' => 1),
//    array(
//        'sortby' => 'createdon',
//        'sortdir' => 'asc',
//        'innerJoin' => array(
//            'Status' => array(
//                'class' => 'ideasStatus',
//                'on' => 'ideasPosts.status = Status.id'
//            ),
//            'Type' => array(
//                'class' => 'ideasType',
//                'on' => 'ideasPosts.type = Type.id'
//            )
//        ),
//        'select' => array(
//            'ideasPosts' => 'name, description',
//            'Status' => 'Status.name as status_name',
//            'Type' => 'Type.name as type_name, Type.id as type_id'
//        ),
//        'limit' => 20
//    )
//);
//
//
//$tabs = [];
//foreach($ideasPosts as $ideasPost){
//    $tabs[$ideasPost['type_id']]['tab_name'] = $ideasPost['type_name'];
//    $tabs[$ideasPost['type_id']]['posts'] = $ideasPost;
//}
//
//
//
return $pdo->getChunk('tpl.ideas.tpl', array('tabs' => $tabs));