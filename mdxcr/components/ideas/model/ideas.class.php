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
            $this->modx->log(modX::LOG_LEVEL_ERROR, '[ideas] incorrect or empty post_id');
            return;
        }

//        if(empty($phpsessid)){
//            $this->modx->log(modX::LOG_LEVEL_ERROR, '[ideas] incorrect or empty post_id');
//            return;
//        }

        $this->log(1, print_r($_COOKIE, 1));

//
//        switch($action){
//            case 'vote_for':
//                $vote = $this->modx->newObject();
//                $vote->fromArray(array(
//                    'post_id' => intval($post_id),
//                    'user_id' => intval($user_id),
//                    'vote' => 1
//                ));
//                if($vote->save()){
//
//                }
//
//
//                break;
//            case 'vote_aganist':
//                $vote = $this->modx->newObject();
//                $vote->fromArray(array(
//                    'post_id' => intval($post_id),
//                    'user_id' => intval($user_id),
//                    'vote' => -1
//                ));
//                $vote->save();
//                break;
//        }


        $data = [];
        $data['success'] = true;

        return json_encode($data);
    }

}