<?php
/**
 * Created by PhpStorm.
 * User: nikolaysavin
 * Date: 30.09.2018
 * Time: 17:01
 */

/** @var xPDOTransport $transport */
/** @var array $options */
/** @var modX $modx */

if ($transport->xpdo) {
    $modx =& $transport->xpdo;
    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:

            $ideas = $modx->getService('ideas', 'ideas', MODX_CORE_PATH . 'components/ideas/model/');
            if (!$ideas) {
                return 'Could not load ideas class!';
            }
            $statuses = array(
                1 => array(
                    'name' => 'На рассмотрении',
                ),
                2 => array(
                    'name' => 'Запланировано',
                ),
                3 => array(
                    'name' => 'Отклонено',
                ),
                4 => array(
                    'name' => 'Выполнено',
                ),
                5 => array(
                    'name' => 'Делается',
                ),
            );
            foreach ($statuses as $id => $properties) {
                if (!$status = $modx->getCount('ideasStatus', array('id' => $id))) {
                    $status = $modx->newObject('ideasStatus', array_merge(array(
                        'active' => 1,
                        'rank' => $id - 1,
                    ), $properties));
                    $status->set('id', $id);
                    $status->save();
                }
            }

            $types = array(
                1 => array(
                    'name' => 'Идеи',
                ),
                2 => array(
                    'name' => 'Вопросы',
                ),
                3 => array(
                    'name' => 'Проблемы',
                ),
            );
            foreach ($types as $id => $properties) {
                if (!$type = $modx->getCount('ideasType', array('id' => $id))) {
                    $type = $modx->newObject('ideasType', array_merge(array(
                        'active' => 1,
                        'rank' => $id - 1,
                    ), $properties));
                    $type->set('id', $id);
                    $type->save();
                }
            }

            break;
        case xPDOTransport::ACTION_UNINSTALL:
            $modx->removeCollection('modSystemSetting', array(
                'namespace' => 'ideas',
            ));
            break;
    }
}
return true;