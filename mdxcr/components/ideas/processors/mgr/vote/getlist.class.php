<?php

class ideasVoteGetListProcessor extends modObjectGetListProcessor
{
    public $objectType = 'ideasVote';
    public $classKey = 'ideaVote';
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
            $c->select('id,user_id,vote');
            $c->where(array('post_id' => 1));
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