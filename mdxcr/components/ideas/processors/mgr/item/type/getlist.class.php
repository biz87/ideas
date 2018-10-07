<?php

class ideasItemGetListProcessor extends modObjectGetListProcessor
{
    public $objectType = 'ideasType';
    public $classKey = 'ideasType';
    public $defaultSortField = 'rank';
    public $defaultSortDirection = 'ASC';
    //public $permission = 'list';


    /**
     * We do a special check of permissions
     * because our objects is not an instances of modAccessibleObject
     *
     * @return boolean|string
     */
    public function beforeQuery()
    {
        if (!$this->checkPermissions()) {
            return $this->modx->lexicon('access_denied');
        }

        return true;
    }


    /**
     * @param xPDOQuery $c
     *
     * @return xPDOQuery
     */
    public function prepareQueryBeforeCount(xPDOQuery $c)
    {
        if ($this->getProperty('combo')) {
            $c->select('id,name');
            $c->where(array('active' => 1));
        }else{
            $query = trim($this->getProperty('query'));
            if ($query) {
                $c->where([
                    'name:LIKE' => "%{$query}%",
                    'OR:description:LIKE' => "%{$query}%",
                ]);
            }

        }


        return $c;
    }


    /**
     * @param xPDOObject $object
     *
     * @return array
     */
    public function prepareRow(xPDOObject $object)
    {
        $array = $object->toArray();


        return $array;
    }

}

return 'ideasItemGetListProcessor';