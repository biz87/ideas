<?php

class ideas
{
    /** @var modX $modx */
    public $modx;
    public $pdo;

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

        $this->pdo = $this->modx->getService('pdoTools');
    }


    function vote($post_id = 0, $action = '')
    {
        if(empty($action)){
            $this->modx->log(modX::LOG_LEVEL_ERROR, '[ideas] vote empty action');
            return;
        }

        if(intval($post_id) == 0){
            $this->modx->log(modX::LOG_LEVEL_ERROR, '[ideas] vore incorrect or empty post_id '.$post_id);
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

        $allow_vote_anonimus = $this->modx->getOption('ideas_allow_vote_anonimus', null, false);
        if(!$vote){
            if($user_id == 0 && !$allow_vote_anonimus){
                $data = [];
                $data['message'] = 'Анонимам голосовать запрещено';
                $data['success'] = false;
                return json_encode($data);
            }
            switch($action){
                case 'vote_for':
                    $response = $this->process_vote($post_id, $user_id, 1, $user_ip, $ses_id);
                    if($response['success']){
                        $data = [];
                        $data['count'] = $response['count'];
                        $data['message'] = 'Ваш голос учтен';
                        $data['success'] = true;
                        return json_encode($data);
                    }
                    break;
                case 'vote_aganist':
                    $response = $this->process_vote($post_id, $user_id, -1, $user_ip, $ses_id);
                    if($response['success']){
                        $data = [];
                        $data['count'] = $response['count'];
                        $data['message'] = 'Ваш голос учтен';
                        $data['success'] = true;
                        return json_encode($data);
                    }
                    break;
            }
        }else{
            $data = [];
            $data['message'] = 'Вы уже голосовали';
            $data['success'] = false;
            return json_encode($data);
        }

    }

    private function process_vote($post_id, $user_id, $vote, $user_ip, $ses_id)
    {
        //  Голосую
        $voteObj = $this->modx->newObject('ideasVote');
        $voteObj->fromArray(array(
            'post_id' => intval($post_id),
            'user_id' => intval($user_id),
            'vote' => $vote,
            'user_ip' => $user_ip,
            'user_ses_id' => $ses_id
        ));
        if($voteObj->save()){
            // Записываю количество положительных голосов в итоговую таблицу поста
            $q = $this->modx->newQuery('ideasVote', array(
                'post_id' => intval($post_id),
                'vote' => $vote
            ));
            $q->select(array(
                "count(*) as count"
            ));
            $s = $q->prepare();
            $s->execute();
            $rows = $s->fetchAll(PDO::FETCH_ASSOC);
            $count = $rows[0]['count'];

            $post = $this->modx->getObject('ideasPost', array('id' => $post_id));
            if($post){
                if($vote == 1){
                    $post->set('vote_for', $count);
                }else{
                    $post->set('vote_aganist', $count);
                }
                $post->save();
            }
            $data = [];
            $data['count'] = $count;
            $data['success'] = true;
            return $data;
        }
    }

    function add_idea($idea_type = 0, $idea_title = '', $idea_description = '')
    {
        if($idea_type == 0){
            $data = [];
            $data['message'] = 'Не указан тип идеи';
            $data['success'] = false;
            return json_encode($data);
        }

        if(!empty($idea_title)){
            $idea_title = $this->modx_tags($idea_title);
        }else{
            $data = [];
            $data['message'] = 'Пустой заголовок идеи';
            $data['success'] = false;
            return json_encode($data);
        }

        if(!empty($idea_description)){
            $idea_description = $this->modx_tags($idea_description);
        }

        $user_id = $this->modx->user->get('id');
        $active = $this->modx->getOption('ideas_allow_published', null, 0);
        $allow_anonimus = $this->modx->getOption('ideas_allow_new_ideas_anonimus', null, 0);

        if($user_id == 0 && !$allow_anonimus){
            $data = [];
            $data['message'] = 'Новые идеи для анонимов запрещены';
            $data['success'] = false;
            return json_encode($data);
        }
        $status = $this->modx->getOption('ideas_first_status', null, '');
        if(empty($status)){
            $q = $this->modx->newQuery('ideasStatus');
            $q->limit(1);
            $q->sortby('rank');
            $o = $this->modx->getObject('ideasStatus', $q);
            if($o){
                $status = $o->id;
            }

        }

        $idea = $this->modx->newObject('ideasPost');
        $idea->fromArray(array(
            'name' => $idea_title,
            'description' => $idea_description,
            'status' => $status,
            'user_id' => $user_id,
            'createdon' => time(),
            'active' => $active,
            'type' => $idea_type
        ));
        if($idea->save()){

            $emails = array_map('trim', explode(',',
                    $this->modx->getOption('ideas_manager_email', null, $this->modx->getOption('emailsender')))
            );

            $subject = 'Новая идея на сайте';

            $chunk = $this->modx->getOption('ideas_email_tpl', null, 'tpl.email.new.manager');
            $ideaArr = $idea->toArray();
            $type = $idea->getOne('Type');
            $status = $idea->getOne('Status');
            $ideaArr['type'] = $type->name;
            $ideaArr['status'] = $status->name;
            $body = $this->pdo->getChunk($chunk, array('idea' => $ideaArr));
            foreach ($emails as $email) {
                if (preg_match('#.*?@.*#', $email)) {
                    $this->sendEmail($email, $subject, $body);
                }
            }



            $data = [];
            $data['message'] = 'Идея записана';
            $data['success'] = true;
            return json_encode($data);
        }else{
            $data = [];
            $data['message'] = 'Что-то пошло не так';
            $data['success'] = false;
            return json_encode($data);
        }



    }

    private function modx_tags($str = ''){
        $str = str_replace("[", "&#91;", $str);
        $str = str_replace("]", "&#93;", $str);
        $str = str_replace("{", "&#123;", $str);
        $str = str_replace("}", "&#125;", $str);
        return $str;
    }

    public function sendEmail($email, $subject, $body = '')
    {
        /** @var modPHPMailer $mail */
        $mail = $this->modx->getService('mail', 'mail.modPHPMailer');
        $mail->setHTML(true);

        $mail->address('to', trim($email));
        $mail->set(modMail::MAIL_SUBJECT, trim($subject));
        $mail->set(modMail::MAIL_BODY, $body);
        $mail->set(modMail::MAIL_FROM, $this->modx->getOption('emailsender'));
        $mail->set(modMail::MAIL_FROM_NAME, $this->modx->getOption('site_name'));
        if (!$mail->send()) {
            $this->modx->log(modX::LOG_LEVEL_ERROR,
                'An error occurred while trying to send the email: ' . $mail->mailer->ErrorInfo
            );
        }
        $mail->reset();
    }

}