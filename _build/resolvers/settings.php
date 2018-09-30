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
$this->modx->log(modX::LOG_LEVEL_INFO, 'hello resolver settings');
if ($transport->xpdo) {
    $modx =& $transport->xpdo;
    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
        case xPDOTransport::ACTION_UPGRADE:
//            $modelPath = $modx->getOption('core_path') . 'components/ideas/' . 'model/';
//
//            $modx->addPackage('minishop2', $modelPath);
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
                    'name' => 'Запланировано',
                ),
                5 => array(
                    'name' => 'Выполнено',
                ),
                6 => array(
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
//            /** @var msDelivery $delivery */
//            if (!$delivery = $modx->getObject('msDelivery', 1)) {
//                $delivery = $modx->newObject('msDelivery');
//                $delivery->fromArray(array(
//                    'id' => 1,
//                    'name' => !$lang ? 'Самовывоз' : 'Self-delivery',
//                    'price' => 0,
//                    'weight_price' => 0,
//                    'distance_price' => 0,
//                    'active' => 1,
//                    'requires' => 'email,receiver',
//                    'rank' => 0,
//                ), '', true);
//                $delivery->save();
//            }


            break;
        case xPDOTransport::ACTION_UNINSTALL:
            $modx->removeCollection('modSystemSetting', array(
                'namespace' => 'minishop2',
            ));
            break;
    }
}
return true;