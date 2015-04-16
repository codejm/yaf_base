<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *      model rules 验证类
 *      $Id: CValidator.php 2014-07-30 09:42:26 codejm $
 */

class Validation_CValidation {
    private $fields = array();
    private $labels = array();
    public $errors = array();
    private $messages = array();
    private $data = array();
    private $mode = '';
    private $rules = array();

    /**
     * 初始化规则
     */
    public function __construct($rules = array(), $labels = array()) {
        $this->rules = $rules;
        $this->labels = $labels;
    }

    /**
     * 初始化
     *
     *
     */
    private function init($mode='') {

        // 验证类
        $this->validator = new \Validation_Validation;

        // 初始化
        $this->reset();

        // 加载默认提示语
        $this->loadDefaultMessages();

        $this->mode = $mode;
        // 加载验证
        // codejm 2014-07-30 09:52:15 读取rules S
        if($this->rules) {

            // default
            if((strpos($this->mode, 'only_') === false) && isset($this->rules['default'])  && !empty($this->rules['default'])){
                foreach ($this->rules['default'] as $value) {
                    if(!isset($value[2]))
                        $value[2] = '';
                    $this->addRule($value[0], $value[1], $value[2]);
                }
            }
            // currmode
            foreach($this->rules as $key=>$value) {
                if($this->mode == $key){
                    foreach ($this->rules[$key] as $k=>$v) {
                        if(!isset($v[2]))
                            $v[2] = '';
                        $this->addRule($v[0], $v[1], $v[2]);
                    }
                }
            }
        }
        // E
    }


    /**
     * 解析验证规则
     *
     */
    private function parseRule($input) {
        $return = array();

        # Split the string on pipe to get individual rules.
        $rules = explode('|', $input);

        foreach ($rules as $r) {

            $rule_name = $r;
            $rule_params = array();

            // For each rule in the list, see if it has any parameters. Example: minlength[5].
            if (preg_match('/\[(.*?)\]/', $r, $matches)) {

                // This one has parameters. Split out the rule name from it's parameters.
                $rule_name = substr($r, 0, strpos($r, '['));

                // There may be more than one parameters.
                $rule_params = explode(',', $matches[1]);
            } elseif (preg_match('/\{(.*?)\}/', $r, $matches)) {
                // This one has an array parameter. Split out the rule name from it's parameters.
                $rule_name = substr($r, 0, strpos($r, '{'));

                // There may be more than one parameter.
                $rule_params = array(explode(',', $matches[1]));
            }

            $return[$rule_name] = $rule_params;
        }

        return $return;
    }

    /**
     * 添加属性验证规则
     *
     *
     */
    private function addRule($field = null, $rules = null, $label = null) {
        if (empty($field) || empty($rules)) {
            throw new InvalidArgumentException('Field, and Rules are required.');
        }

        // Add this field to our list of fields (unless it already exists).
        if (!array_key_exists($field, $this->fields)) {
            if(empty($label)) {
                if(empty($this->labels))
                    $this->labels = $this->attributeLabels();

                if(isset($this->labels[$field]))
                    $label = $this->labels[$field];
            }
            $this->fields[$field] = array('label' => $label);
        }

        if ($rules instanceof \Closure) {
            $closure = $rules;
            $this->fields[$field]['rules'][] = $closure;
        } else {
            $rules = $this->parseRule($rules);

            foreach ($rules as $rule => $params) {
                if (count($params) > 0) {
                    foreach ($params as $param) {
                        $this->fields[$field]['rules'][$rule]['params'][] = $param;
                    }
                } else {
                    $this->fields[$field]['rules'][$rule]['params'] = array();
                }
            }
        }
    }

    /**
     * 验证
     * @params array $data 要验证的数据
     * @params string $mode 验证模式
     * @return bool
     *
     */
    public function validate($data = array(), $mode='') {
        if(empty($this->fields))
            $this->init($mode);

        $this->data = $data;
        foreach ($this->fields as $id => $attributes) {

            $input = array_key_exists($id, $data) ? $data[$id] : null;
            $label = $attributes['label'];

            foreach ($attributes['rules'] as $method => $opts) {

                if ($opts instanceof \Closure) {
                    list($success, $message) = $opts($this->data, $id, $label);

                    if (!$success) {
                        $this->errors[$id][] = $message;
                    }
                } else {
                    $args = array();
                    $args[] = $input;

                    foreach ($opts['params'] as $param) {
                        $args[] = $param;
                    }

                    $success = true;
                    $success = call_user_func_array(array($this->validator, $method), $args);

                    if (!$success) {
                        $this->errors[$id][] = $this->getMessage($label, $method, $opts['params']);
                    }
                }
            }
        }

        return $this->hasErrors() ? false : true;
    }

    /**
     * 获取错误数组
     *
     */
    public function getErrorSummary() {
        $summary = array();

        foreach ($this->errors as $field => $messages) {
            foreach ($messages as $message) {
                $summary[$field] = $message;
            }
        }
        return $summary;
    }

    /**
     * 获取所有错误与一个字符串
     *
     */
    public function getErrorSummaryFormatted($outerwrapper = array('<div class="alert alert-danger"><ul>','</ul></div>'), $innerwrapper = array('<li>','</li>')) {
        $summary = $this->getErrorSummary();

        if (count($summary) > 0) {
            $formatted = array();

            $formatted[] = $outerwrapper[0];

            foreach ($summary as $s) {
                $formatted[] = $innerwrapper[0];
                $formatted[] = $s;
                $formatted[] = $innerwrapper[1];
            }

            $formatted[] = $outerwrapper[1];

            return join($formatted, PHP_EOL);

        } else {
            return null;
        }
    }

    /**
     * 获取错误详情
     *
     */
    public function getErrorDetail() {
        $detail = array();

        foreach ($this->errors as $field => $messages) {
            $detail[] = array('field' => $field, 'messages' => $messages);
        }

        return $detail;
    }

    /**
     * 获取错误字段
     *
     */
    public function getErrorFields() {
        $fields = array();

        foreach ($this->errors as $field => $messages) {
            $fields[] = $field;
        }
        return $fields;

    }

    /**
     * 获取必填字段
     *
     */
    public function getRequiredFields() {
        $required = array();

        foreach ($this->fields as $field => $attributes) {
            if (array_key_exists('required', $attributes['rules'])) {
                $required[] = $field;
            }
        }

        return $required;
    }

    /**
     * 默认提示语
     *
     */
    private function loadDefaultMessages() {
        $messages = array();
        $messages['required'] = '{name} 是必填项.';
        $messages['date'] = '{name} 必须是一个有效的日期.';
        $messages['minlength'] = '{name} 必须至少有 %s 个字符.';
        $messages['maxlength'] = '{name} 不能超过 %d 个字符.';
        $messages['exactlength'] = '{name} 必需恰好 %d 个字符.';
        $messages['greaterthan'] = '{name} 必须大于 %d.';
        $messages['lessthan'] = '{name} 必须小于 %d.';
        $messages['alpha'] = '{name} 只能包含字母A-Z.';
        $messages['alphanumeric'] = '{name} 只能包含字母A-Z和数字0-9.';
        $messages['integer'] = '{name} 必需是整数没有小数.';
        $messages['float'] = '{name} 必须是一个带小数的数字.';
        $messages['numeric'] = '{name} 必须是数字.';
        $messages['email'] = '{name} 必须是一个有效的电子邮件地址.';
        $messages['url'] = '{name} 必须是一个有效的URL.';
        $messages['phone'] = '{name} 必须是一个有效的手机号码.';
        $messages['zipcode'] = '{name} 必须是一个有效的邮政编码.';
        $messages['startswith'] = '{name} 必需开始与 %s.';
        $messages['endswith'] = '{name} 必须结束与 %s.';
        $messages['contains'] = '{name} 必需包含 %s.';
        $messages['regex'] = '{name} 为不正确的格式.';
        $messages['captcha'] = '{name} 错误，请重新填写.';

        foreach ($messages as $key => $value) {
            $this->messages[$key] = $value;
        }
    }

    /**
     * 获取字段提示信息
     *
     */
    private function getMessage($field, $rule, $params = array()) {

        if (!array_key_exists($rule, $this->messages)) {
            $format = '{name} 无效, 请重新填写.';
        } else {
            $format = $this->messages[$rule];
        }

        $string = str_replace('{name}', $field, $format);
        return vsprintf($string, $params);
    }

    /**
     * 是否有任何验证错误
     */
    private function hasErrors() {
        return (count($this->errors) > 0);
    }

    /**
     * 重置
     *
     */
    private function reset() {
        $this->fields = array();
        $this->errors = array();
        $this->messages = array();
        $this->data = array();
    }
}
