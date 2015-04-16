<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *
 *      $Id: QQ.php 2013-11-27 11:26:40 codejm $
 */

class Oauth_Strategy_QQ extends Oauth_Strategy {

    /**
     * Compulsory config keys, listed as unassociative arrays
     */
    public $expects = array('key', 'secret', 'vendor');

    /**
     * Optional config keys with respective default values, listed as associative arrays
     */
    public $defaults = array(
        'redirect_uri' => '{complete_url_to_strategy}qq_callback'
    );

    /**
     * Auth request
     */
    public function request(){
        $url = 'https://graph.qq.com/oauth2.0/authorize';
        $params = array(
            'client_id' => $this->strategy['key'],
            'redirect_uri' => $this->strategy['redirect_uri'],
            'response_type' => 'code'
        );
        $this->clientGet($url, $params);
    }

    /**
     * Internal callback, after QQ's OAuth
     */
    public function qq_callback(){
        if (array_key_exists('code', $_GET) && !empty($_GET['code'])){
            $url = 'https://graph.qq.com/oauth2.0/token';
            $params = array(
                'client_id' =>$this->strategy['key'],
                'client_secret' => $this->strategy['secret'],
                'redirect_uri'=> $this->strategy['redirect_uri'],
                'code' => $_GET['code'],
                'grant_type' => 'authorization_code'
            );
            $response = $this->serverPost($url, $params, null, $headers);
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

            parse_str($response, $results);

            $params = array(
                'access_token'=> $results['access_token']
            );
            $open = $this->serverget('https://graph.qq.com/oauth2.0/me', $params);
            $open = str_replace(array('callback(', ');'), array('', ''), $open);
            $open = trim($open);
            $open = json_decode($open, true);
            $results['openid'] = $open['openid'];
            $qquser = $this->getuserinfo($results);

            $this->auth = array(
                'uid' => $open['openid'],
                'info' => array(
                    'nickname' => $qquser['nickname'],
                    'name' => '',
                    'url' => 'http://user.qzone.qq.com/'.$open['openid'],
                    'face' => $qquser['figureurl_qq_2'],
                    'location' => '',
                    'gender' => $qquser['gender'] == '女' ? 0 : $qquser['gender'] == '男' ? 1 : 2
                ),
                'credentials' => array(
                    'token' => $results['access_token'],
                    'expires' => date('c', time() + $results['expires_in'])
                ),
                'raw' => $qquser
            );
            $this->callback();
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

    private function getuserinfo($results){
        $params = array(
            'oauth_consumer_key' =>$this->strategy['key'],
            'access_token'=> $results['access_token'],
            'openid'=> $results['openid'],
            'oauth_version' => '2.a',
            'scope' => 'all',
            'appfrom' => 'opauth-qq',
            'seqid' => time(),
        );
        $qquser = $this->serverget('https://graph.qq.com/user/get_user_info', $params);
        if (!empty($qquser)){
            $response = json_decode($qquser, true);
            return $response;
        }
        else{
            $error = array(
                'code' => 'Get User error',
                'message' => 'Failed when attempting to query for user information',
                'raw' => array(
                    'access_token' => $results['access_token'],
                    'headers' => $headers
                )
            );

            $this->errorCallback($error);
        }
    }
}
