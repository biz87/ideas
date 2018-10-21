<?php
/** @var modX $modx */
switch ($modx->event->name) {
    case 'OnHandleRequest':
        // Handle ajax requests
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
        if (!$isAjax) {
            return;
        }
        $modx->log(1, 'Сработал onHandleRequest');
        break;
}