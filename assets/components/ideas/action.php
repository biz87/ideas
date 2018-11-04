<?php
$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
if (empty($_POST['action']) && !$isAjax) {
    die('Access denied');
}

define('MODX_API_MODE', true);
require_once($_SERVER['DOCUMENT_ROOT'].'/index.php');

$modx = new modX();
$modx->initialize('web');
$modx->getService('error','error.modError', '', '');
$modx->setLogLevel(modX::LOG_LEVEL_ERROR);

$ideas = $modx->getService('ideas', 'ideas', MODX_CORE_PATH . 'components/ideas/model/');
if (!$ideas) {
    $modx->log(modX::LOG_LEVEL_ERROR, '[ideas] Could not load ideas class!');
    return '';
}

$action = trim( filter_input(INPUT_POST,'action',  FILTER_SANITIZE_STRING) );
switch($action){
    case 'vote':
        $post_id = filter_input(INPUT_POST,'post_id', FILTER_VALIDATE_INT);
        $vote_action = trim( filter_input(INPUT_POST,'vote_action',  FILTER_SANITIZE_STRING) );
        $response = $ideas->vote($post_id, $vote_action);
        break;

}


echo $response;
die();