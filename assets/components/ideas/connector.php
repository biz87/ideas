<?php
$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
if (empty($_POST['action']) && !$isAjax) {
    die('Access denied');
}

if (file_exists(dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php')) {
    /** @noinspection PhpIncludeInspection */
    require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php';
} else {
    require_once dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/config.core.php';
}
/** @noinspection PhpIncludeInspection */
require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
/** @noinspection PhpIncludeInspection */
require_once MODX_CONNECTORS_PATH . 'index.php';

$ideas = $modx->getService('ideas', 'ideas', MODX_CORE_PATH . 'components/ideas/model/');
if (!$ideas) {
    $modx->log(modX::LOG_LEVEL_ERROR, '[ideas] Could not load ideas class!');
    return '';
}
$modx->lexicon->load('ideas:default');

// handle request
$corePath = $modx->getOption('modextra_core_path', null, $modx->getOption('core_path') . 'components/ideas/');
$path = $modx->getOption('processorsPath', $ideas->config, $corePath . 'processors/');
$modx->getRequest();

/** @var modConnectorRequest $request */
$request = $modx->request;
$request->handleRequest([
    'processors_path' => $path,
    'location' => '',
]);