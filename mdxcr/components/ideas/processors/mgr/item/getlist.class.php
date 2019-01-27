<?php

class ideasItemGetListProcessor extends modObjectGetListProcessor
{
    public $objectType = 'ideasPost';
    public $classKey = 'ideasPost';
    public $defaultSortField = 'id';
    public $defaultSortDirection = 'DESC';
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
        $query = trim($this->getProperty('query'));
        if ($query) {
            $c->where([
                'name:LIKE' => "%{$query}%",
                'OR:description:LIKE' => "%{$query}%",
            ]);
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

        // Get user data
        if(isset($array['user_id']) && $array['user_id'] > 0){
            $userProfile = $object->getOne('UserProfile');

            if($userProfile){
                if(!empty($userProfile->get('fullname'))){
                    $array['user'] = $userProfile->get('fullname');
                }else{
                    $user = $object->getOne('User');
                    $array['user'] = $user->get('username');
                }
            }else{
                $array['user'] = '';
            }


        }else{
            $array['user'] = $this->modx->lexicon('ideas_items_user_anonimus');
            $array['username'] = $this->modx->lexicon('ideas_items_user_anonimus');
            $array['email'] = $this->modx->lexicon('ideas_items_user_anonimus');
        }
        

        // Get Status data
        if(isset($array['status']) && $array['status'] > 0){
            $status = $object->getOne('Status');

            if($status){
                $array['status'] = $status->get('name');
            }
        }

        // Get type data
        if(isset($array['type']) && $array['type'] > 0){
            $type = $object->getOne('Type');

            if($type){
                $array['type'] = $type->get('name');
            }
        }

        //Get resource
        if(!empty($array['resource_id']) && $array['resource_id'] > 0){
            $resource = $this->modx->getObject('modResource', array('id'  => $array['resource_id']));
            if(!$resource){
                $array['resource_id'] = 0;
            }
        }else{
            $array['resource_id'] = 0;
        }



        $array['actions'] = [];

        // Edit
        $array['actions'][] = [
            'cls' => '',
            'icon' => 'icon icon-edit',
            'title' => $this->modx->lexicon('ideas_item_update'),
            //'multiple' => $this->modx->lexicon('ideas_items_update'),
            'action' => 'updateItem',
            'button' => true,
            'menu' => true,
        ];

        if (!$array['active']) {
            $array['actions'][] = [
                'cls' => '',
                'icon' => 'icon icon-power-off action-green',
                'title' => $this->modx->lexicon('ideas_item_enable'),
                'multiple' => $this->modx->lexicon('ideas_items_enable'),
                'action' => 'enableItem',
                'button' => true,
                'menu' => true,
            ];
        } else {
            $array['actions'][] = [
                'cls' => '',
                'icon' => 'icon icon-power-off action-gray',
                'title' => $this->modx->lexicon('ideas_item_disable'),
                'multiple' => $this->modx->lexicon('ideas_items_disable'),
                'action' => 'disableItem',
                'button' => true,
                'menu' => true,
            ];
        }

        // Remove
        $array['actions'][] = [
            'cls' => '',
            'icon' => 'icon icon-trash-o action-red',
            'title' => $this->modx->lexicon('ideas_item_remove'),
            'multiple' => $this->modx->lexicon('ideas_items_remove'),
            'action' => 'removeItem',
            'button' => true,
            'menu' => true,
        ];

        return $array;
    }

}

return 'ideasItemGetListProcessor';