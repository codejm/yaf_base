<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *
 *      $Id: weibo.php 2014-12-20 17:31:47 codejm $
 */

class Oauth_Strategy_Weibo extends Oauth_Strategy {

    /**
     * Compulsory config keys, listed as unassociative arrays
     */
    public $expects = array('key', 'secret', 'vendor');

    /**
     * Auth request
     */
    public function request(){
        $url = 'https://api.weibo.com/oauth2/authorize';
        $params = array(
            'client_id' => $this->strategy['key'],
            'redirect_uri' => $this->strategy['redirect_uri']
        );

        if (!empty($this->strategy['scope'])) $params['scope'] = $this->strategy['scope'];
        if (!empty($this->strategy['state'])) $params['state'] = $this->strategy['state'];
        if (!empty($this->strategy['response_type'])) $params['response_type'] = $this->strategy['response_type'];
        if (!empty($this->strategy['display'])) $params['display'] = $this->strategy['display'];
        if (!empty($this->strategy['auth_type'])) $params['auth_type'] = $this->strategy['auth_type'];

        $this->clientGet($url, $params);
    }

    /**
     * Internal callback, after Sina's OAuth
     */
    public function weibo_callback(){
        if (array_key_exists('code', $_GET) && !empty($_GET['code'])){
            $url = 'https://api.weibo.com/oauth2/access_token';
            $params = array(
                'client_id' =>$this->strategy['key'],
                'client_secret' => $this->strategy['secret'],
                'redirect_uri'=> $this->strategy['redirect_uri'],
                'code' => $_GET['code'],
                'grant_type' => 'authorization_code'
            );
            $response = $this->serverPost($url, $params,null,$headers);
            if (empty($response)){
                $error = array(
                    'code' => 'Get access token error',
                    'message' => 'Failed when attempting to get access token',
                    'raw' => array(
                        'headers' => $headers
                    )
                );
                $this->errorCallback($error);
            }

            $results=json_decode($response,true);

            //$uid = $this->getuid($results['access_token']);
            $sinauser = $this->getuser($results['access_token'],$results['uid']);

            $this->auth = array(
                'uid' => $sinauser['idstr'],
                'info' => array(
                    'nickname' => $sinauser['screen_name'],
                    'name' => $sinauser['name'],
                    'url' => 'http://weibo.com/u/'.$sinauser['idstr'],
                    'face' => $sinauser['profile_image_url'],
                    'location' => $sinauser['location'],
                    'gender' => $sinauser['gender'] == 'f' ? 0 : $sinauser['gender'] == 'm' ? 1 : 2
                ),
                'credentials' => array(
                    'token' => $results['access_token'],
                    'expires' => date('c', time() + $results['expires_in'])
                ),
                'raw' => $sinauser
            );

           // if (!empty($sinauser->name)) $this->auth['info']['name'] = $sinauser->name;
           // if (!empty($sinauser->screen_name)) $this->auth['info']['nickname'] = $sinauser->screen_name;
           // if (!empty($sinauser->location)) $this->auth['info']['location'] = $sinauser->location;
           // if (!empty($sinauser->avatar_large)) $this->auth['info']['image'] = $sinauser->avatar_large;

            //Uncomment to see what Sina returns
            //debug($results);
            //debug($sinauser);
            //debug($this->auth);
            $this->callback();

            // If the data doesn't seem to be written to the session, it is probably because your sessions are
            // not set up for UTF8. The following lines will jump over the security but will allow you to use
            // the plugin without utf8 support in the database.

            // $completeUrl = Configure::read('Opauth._cakephp_plugin_complete_url');
            // if (empty($completeUrl)) $completeUrl = Router::url('/opauth-complete');
            // $CakeRequest = new CakeRequest('/opauth-complete');
            // $data['auth'] = $this->auth;
            // $CakeRequest->data = $data;
            // $Dispatcher = new Dispatcher();
            // $Dispatcher->dispatch( $CakeRequest, new CakeResponse() );
            // exit();
        }
        else
        {
            $error = array(
                'code' => $_GET['error'],
                'message' => $_GET['error_description'],
                'raw' => $_GET
            );

            $this->errorCallback($error);
        }
    }


    private function getuid($access_token){
        $uid = $this->serverget('https://api.weibo.com/2/account/get_uid.json', array('access_token' => $access_token));
        if (!empty($uid)){
            return json_decode($uid, true);
        }
        else{
            $error = array(
                'code' => 'Get UID error',
                'message' => 'Failed when attempting to query for user UID',
                'raw' => array(
                    'access_token' => $access_token,
                    'headers' => $headers
                )
            );

            $this->errorCallback($error);
        }
    }

    private function getuser($access_token,$uid){
        $sinauser = $this->serverget('https://api.weibo.com/2/users/show.json', array('access_token' => $access_token,'uid'=>$uid));
        if (!empty($sinauser)){
            return json_decode($sinauser, true);
        }
        else{
            $error = array(
                'code' => 'Get User error',
                'message' => 'Failed when attempting to query for user information',
                'raw' => array(
                    'access_token' => $access_token,
                    'headers' => $headers
                )
            );

            $this->errorCallback($error);
        }
    }

    /**
     * 发布一条新微博
     * @param string $content 要发表的微博内容
     * @return array
     */
    function newWeibo($access_token, $content) {
        $result = $this->serverPost('https://api.weibo.com/2/statuses/update.json', array('access_token' => $access_token, 'status'=>$content));
        return $result;
    }
}

?>
