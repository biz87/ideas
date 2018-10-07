<?php

class ideasItemCreateProcessor extends modObjectCreateProcessor
{
    public $objectType = 'ideasPost';
    public $classKey = 'ideasPost';
    public $languageTopics = ['ideas'];
    //public $permission = 'create';


    /**
     * @return bool
     */
    public function beforeSet()
    {
        $name = trim($this->getProperty('name'));
        if (empty($name)) {
            $this->modx->error->addField('name', $this->modx->lexicon('ideas_item_err_name'));
        } elseif ($this->modx->getCount($this->classKey, ['name' => $name])) {
            $this->modx->error->addField('name', $this->modx->lexicon('ideas_item_err_ae'));
        }

        return parent::beforeSet();
    }

}

return 'ideasItemCreateProcessor';