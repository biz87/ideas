<?php

class ideasVoteProcessor extends modObjectCreateProcessor
{
    public $objectType = 'ideasVote';
    public $classKey = 'ideasVote';
    public $languageTopics = ['ideas'];
    //public $permission = 'create';


    /**
     * @return bool
     */
    public function beforeSet()
    {
        $this->modx->log(1, print_r($this->getProperties, 1));
//        $name = trim($this->getProperty('name'));
//        if (empty($name)) {
//            $this->modx->error->addField('name', $this->modx->lexicon('ideas_type_err_name'));
//        } elseif ($this->modx->getCount($this->classKey, ['name' => $name])) {
//            $this->modx->error->addField('name', $this->modx->lexicon('ideas_type_err_ae'));
//        }

        return parent::beforeSet();
    }

    /**
     * @return bool
     */
//    public function beforeSave()
//    {
//        $this->object->fromArray(array(
//            'rank' => $this->modx->getCount($this->classKey),
//        ));
//
//        return parent::beforeSave();
//    }
}

return 'ideasVoteProcessor';