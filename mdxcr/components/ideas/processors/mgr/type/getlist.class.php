<?php

class ideasTypeGetListProcessor extends modObjectGetListProcessor
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


        $array['actions'] = [];

        // Edit
        $array['actions'][] = [
            'cls' => '',
            'icon' => 'icon icon-edit',
            'title' => $this->modx->lexicon('ideas_type_update'),
            //'multiple' => $this->modx->lexicon('ideas_items_update'),
            'action' => 'updateType',
            'button' => true,
            'menu' => true,
        ];

        if (!$array['active']) {
            $array['actions'][] = [
                'cls' => '',
                'icon' => 'icon icon-power-off action-green',
                'title' => $this->modx->lexicon('ideas_type_enable'),
                'multiple' => $this->modx->lexicon('ideas_types_enable'),
                'action' => 'enableType',
                'button' => true,
                'menu' => true,
            ];
        } else {
            $array['actions'][] = [
                'cls' => '',
                'icon' => 'icon icon-power-off action-gray',
                'title' => $this->modx->lexicon('ideas_type_disable'),
                'multiple' => $this->modx->lexicon('ideas_types_disable'),
                'action' => 'disableType',
                'button' => true,
                'menu' => true,
            ];
        }

        // Remove
        $array['actions'][] = [
            'cls' => '',
            'icon' => 'icon icon-trash-o action-red',
            'title' => $this->modx->lexicon('ideas_type_remove'),
            'multiple' => $this->modx->lexicon('ideas_types_remove'),
            'action' => 'removeType',
            'button' => true,
            'menu' => true,
        ];

        return $array;
    }

}

return 'ideasTypeGetListProcessor';