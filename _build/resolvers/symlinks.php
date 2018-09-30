<?php
/** @var xPDOTransport $transport */
/** @var array $options */
/** @var modX $modx */
if ($transport->xpdo) {
    $modx =& $transport->xpdo;

    $dev = MODX_BASE_PATH . 'Extras/ideas/';
    /** @var xPDOCacheManager $cache */
    $cache = $modx->getCacheManager();
    if (file_exists($dev) && $cache) {
        if (!is_link($dev . 'assets/components/ideas')) {
            $cache->deleteTree(
                $dev . 'assets/components/ideas/',
                ['deleteTop' => true, 'skipDirs' => false, 'extensions' => []]
            );
            symlink(MODX_ASSETS_PATH . 'components/ideas/', $dev . 'assets/components/ideas');
        }
        if (!is_link($dev . 'core/components/ideas')) {
            $cache->deleteTree(
                $dev . 'core/components/ideas/',
                ['deleteTop' => true, 'skipDirs' => false, 'extensions' => []]
            );
            symlink(MODX_CORE_PATH . 'components/ideas/', $dev . 'core/components/ideas');
        }
    }
}

return true;