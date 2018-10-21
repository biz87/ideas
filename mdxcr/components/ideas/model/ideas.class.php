<?php

class ideas
{
    /** @var modX $modx */
    public $modx;


    /**
     * @param modX $modx
     * @param array $config
     */
    function __construct(modX &$modx, array $config = [])
    {
        $this->modx =& $modx;
        $corePath = MODX_CORE_PATH . 'components/ideas/';
        $assetsUrl = MODX_ASSETS_URL . 'components/ideas/';

        $this->config = array_merge([
            'corePath' => $corePath,
            'modelPath' => $corePath . 'model/',
            'processorsPath' => $corePath . 'processors/',

            'connectorUrl' => $assetsUrl . 'connector.php',
            'assetsUrl' => $assetsUrl,
            'cssUrl' => $assetsUrl . 'css/',
            'jsUrl' => $assetsUrl . 'js/',
        ], $config);

        $this->modx->addPackage('ideas', $this->config['modelPath']);
        $this->modx->lexicon->load('ideas:default');
    }


    function vote($post_id = 0, $action = '')
    {
        if(empty($action)){
            $this->modx->log(modX::LOG_LEVEL_ERROR, '[ideas] empty action');
            return;
        }

        if(intval($post_id) == 0){
            $this->modx->log(modX::LOG_LEVEL_ERROR, '[ideas] incorrect or empty post_id '.$post_id);
            return;
        }

        $ses_id = $_COOKIE['PHPSESSID'];
        $user_id = $this->modx->user->get('id');
        $user_ip = $_SERVER['REMOTE_ADDR'];

        if($user_id > 0){
            $vote = $this->modx->getObject('ideasVote', array('user_id' => $user_id, 'post_id' => $post_id));
        }else{
            $vote = $this->modx->getObject('ideasVote', array('user_ip' => $user_ip, 'user_ses_id' => $ses_id, 'post_id' => $post_id));
        }

        if(!$vote){
            switch($action){
                case 'vote_for':
                    $vote = $this->modx->newObject('ideasVote');
                    $vote->fromArray(array(
                        'post_id' => intval($post_id),
                        'user_id' => intval($user_id),
                        'vote' => 1,
                        'user_ip' => $user_ip,
                        'user_ses_id' => $ses_id
                    ));
                    if($vote->save()){
                        $data = [];
                        $data['success'] = true;
                        return json_encode($data);
                    }


                    break;
                case 'vote_aganist':
                    $vote = $this->modx->newObject('ideasVote');
                    $vote->fromArray(array(
                        'post_id' => intval($post_id),
                        'user_id' => intval($user_id),
                        'vote' => -1,
                        'user_ip' => $user_ip,
                        'user_ses_id' => $ses_id
                    ));
                    if($vote->save()){
                        $data = [];
                        $data['success'] = true;
                        return json_encode($data);
                    }
                    break;
            }
        }else{
            $data = [];
            $data['success'] = false;
            return json_encode($data);
        }

    }

}