<?php
$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
if (empty($_REQUEST['action']) && !$isAjax) {
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

$response = $ideas->vote($_REQUEST['post_id'], $_REQUEST['action']);
echo $response;
die();