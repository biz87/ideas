<?php

class ideasItemDisableProcessor extends modObjectProcessor
{
    public $objectType = 'ideasStatus';
    public $classKey = 'ideasStatus';
    public $languageTopics = ['ideas'];
    //public $permission = 'save';


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
            return $this->failure($this->modx->lexicon('ideas_status_err_ns'));
        }

        foreach ($ids as $id) {
            /** @var ideasItem $object */
            if (!$object = $this->modx->getObject($this->classKey, $id)) {
                return $this->failure($this->modx->lexicon('ideas_status_err_nf'));
            }

            $object->set('active', false);
            $object->save();
        }

        return $this->success();
    }

}

return 'ideasItemDisableProcessor';
