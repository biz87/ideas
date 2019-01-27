<?php

class ideasVoteGetListProcessor extends modObjectGetListProcessor
{
    public $objectType = 'ideasVote';
    public $classKey = 'ideasVote';
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
//        if ($this->getProperty('combo')) {
//            $c->select('id,user_id,vote');
//            $c->where(array('post_id' => 1));
//        }else{
//            $query = trim($this->getProperty('query'));
//            if ($query) {
//                $c->where([
//                    'name:LIKE' => "%{$query}%",
//                    'OR:description:LIKE' => "%{$query}%",
//                ]);
//            }
//
//        }


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
        }

        //Get post
        if(!empty($array['post_id']) && $array['post_id'] > 0){
            //$post = $object->getOne('Ideas');
            $post = $this->modx->getObject('ideasPost', array('id' => $array['post_id']));
            if($post){
                $array['post'] = $post->name;
            }else{
                $array['post'] = '';
            }
        }else{
            $array['post'] = '';
        }

        //Get vote
        if(!empty($array['vote'])){
            if($array['vote'] == 1){
                $array['vote'] = 'за';
            }
            if($array['vote'] == -1){
                $array['vote'] = 'против';
            }
        }else{
            $array['vote'] = '';
        }


        $array['actions'] = [];

        // Remove
        $array['actions'][] = [
            'cls' => '',
            'icon' => 'icon icon-trash-o action-red',
            'title' => $this->modx->lexicon('ideas_vote_remove'),
            'multiple' => $this->modx->lexicon('ideas_votes_remove'),
            'action' => 'removeVote',
            'button' => true,
            'menu' => true,
        ];

        return $array;
    }

}

return 'ideasVoteGetListProcessor';