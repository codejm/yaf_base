<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *      Oauth 核心类
 *      $Id: Core.php 2014-12-20 15:38:29 codejm $
 */

class Oauth_Core {

    // 配置
    public $config;

    // 全局参数
    public $env;

    // 第三方列表
    public $strategyMap;

    // 第三方名称
    public $strategyName;

    // 第三方名称
    public $strategyCallback = 0;

    // 初始化
    public function __construct($config = array(), $strategyName, $strategyCallback=0, $run = true) {

        // 初始化配置
        $this->config = array_merge(array(
            'host' => ((array_key_exists('HTTPS', $_SERVER) && $_SERVER['HTTPS'])?'https':'http').'://'.$_SERVER['HTTP_HOST'],
            'callback_transport' => 'session',

            'security_iteration' => 300,
        ), $config);

        // 全局参数
        $this->env = array_merge(array(
            'request_uri' => $_SERVER['REQUEST_URI'],
            'complete_path' => $this->config['host'].$this->config['path'],
            'lib_dir' => dirname(__FILE__).'/',
            'strategy_dir' => dirname(__FILE__).'/Strategy/'
        ), $this->config);

        // name callback
        $this->strategyName = $strategyName;
        $this->strategyCallback = $strategyCallback;

        // 处理所有第三方配置
        $this->loadStrategies();

        if ($run) {
            $this->run();
        }
    }

    /**
     * Run Opauth:
     * Parses request URI and perform defined authentication actions based based on it.
     */
    public function run() {

        if (!empty($this->strategyName)) {
            if (array_key_exists($this->strategyName, $this->strategyMap)) {
                // 当前oauth配置
                $strategy = $this->env['Strategy'][$this->strategyName];
                // 当前oauth执行方法
                if(!empty($this->strategyCallback)){
                    $this->strategyCallback = strtolower($this->strategyName).'_callback';
                    $this->env['params']['action'] = $this->strategyCallback;
                }

                // 调用对应oauth类
                $className = 'Oauth_Strategy_'.$this->strategyName;
                $safeEnv = $this->env;
                unset($safeEnv['Strategy']);
                $this->Strategy = new $className($strategy, $safeEnv);

                if (empty($this->env['params']['action'])) {
                    $this->env['params']['action'] = 'request';

                    // 记录来源 S
                    $referer = '';
                    if(isset($_GET['ref'])){
                        $referer = addslashes($_GET['ref']);
                    } else if(isset($_SERVER["HTTP_REFERER"])) {
                        $referer = addslashes($_SERVER["HTTP_REFERER"]);
                    }
                    if(!empty($referer)){
                        Tools_help::setSession('oauth_referer', $referer);
                    }
                    // 记录来源 E
                }

                // 调用oauth对应方法
                $this->Strategy->callAction($this->env['params']['action']);
            } else {
                trigger_error('未定义的Oauth - '.$this->env['params']['strategy'], E_USER_ERROR);
            }
        }
    }

    /**
     * 处理所有第三方配置
     */
    private function loadStrategies() {
        if (isset($this->env['Strategy']) && is_array($this->env['Strategy']) && count($this->env['Strategy']) > 0) {
            foreach ($this->env['Strategy'] as $key => $strategy) {
                if (!is_array($strategy)) {
                    $key = $strategy;
                    $strategy = array();
                }

                $strategyClass = $key;
                if (array_key_exists('strategy_class', $strategy)) {
                    $strategyClass = $strategy['strategy_class'];
                } else {
                    $strategy['strategy_class'] = $strategyClass;
                }

                $strategy['strategy_name'] = $key;

                // Define a URL-friendly name
                if (empty($strategy['strategy_url_name'])) {
                    $strategy['strategy_url_name'] = strtolower($key);
                }

                $this->strategyMap[$strategy['strategy_url_name']] = array(
                    'name' => $key,
                    'class' => strtolower($strategyClass)
                );

                $this->env['Strategy'][$key] = $strategy;
            }
        } else {
            trigger_error('No Opauth strategies defined', E_USER_ERROR);
        }
    }
}
