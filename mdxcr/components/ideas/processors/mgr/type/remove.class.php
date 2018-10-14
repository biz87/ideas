<?php

class ideasTypeRemoveProcessor extends modObjectProcessor
{
    public $objectType = 'ideasType';
    public $classKey = 'ideasType';
    public $languageTopics = ['ideas'];
    //public $permission = 'remove';


    /**
     * @return array|string
     */
    public function process()
    {
        if (!$this->checkPermissions()) {
            return $this->failure($this->modx->lexicon('access_denied'));
        }

        $ids = $this->modx->fromJSON($this->getProperty('ids'));
        if (empty($ids)) {
            return $this->failure($this->modx->lexicon('ideas_type_err_ns'));
        }

        foreach ($ids as $id) {
            /** @var ideasItem $object */
            if (!$object = $this->modx->getObject($this->classKey, $id)) {
                return $this->failure($this->modx->lexicon('ideas_type_err_nf'));
            }

            $object->remove();
        }

        return $this->success();
    }

}

return 'ideasTypeRemoveProcessor';