<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *      文件上传　根据https://github.com/olaferlandsen/FileUpload-for-PHP改写, 源代码有bug
 *      $Id: FileUpload.php 2014-12-16 14:46:04 codejm $
 */

class Files_FileUpload {

    const VERSION = '1.5';

    // upload function name
    private $upload_function = 'move_uploaded_file';

    /**
    *    Array with the information obtained from the
    *    variable $_FILES or $HTTP_POST_FILES.
    */
    private $file_array = array();

    // 是否允许覆盖
    private $overwrite_file = false;

    // input name
    private $input;

    // 上传路径
    private $destination_directory;

    // 文件名称
    private $filename;

    // 文件允许大小
    private $max_file_size = 0;

    // 允许上传类型
    private $allowed_mime_types = array();

    // Callbacks
    private $callbacks = array('before'=>null, 'after'=>null);

    // File object
    private $file;

    // 系统自定义类型
    private $mime_helping = array(
        'text' => array('text/plain',),
        'image' => array(
            'image/jpeg',
            'image/jpg',
            'image/pjpeg',
            'image/png',
            'image/gif',
            'application/octet-stream',
        ),
        'document' => array(
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'application/vnd.ms-powerpoint',
            'application/vnd.ms-excel',
            'application/vnd.oasis.opendocument.spreadsheet',
            'application/vnd.oasis.opendocument.presentation',
        ),
        'video' => array(
            'video/3gpp',
            'video/3gpp',
            'video/x-msvideo',
            'video/avi',
            'video/mpeg4',
            'video/mp4',
            'video/mpeg',
            'video/mpg',
            'video/quicktime',
            'video/x-sgi-movie',
            'video/x-ms-wmv',
            'video/x-flv',
        ),
    );

    // 创建的目录权限
    private $destination_permissions = 0777;

    // 初始化
    public function __construct() {
        $this->file = array(
            'status'                =>    false,    // True: success upload
            'mime'                  =>    '',       // Empty string
            'filename'              =>    '',       // Empty string
            'original'              =>    '',       // Empty string
            'size'                  =>    0,        // 0 Bytes
            'sizeFormated'          =>    '0B',     // 0 Bytes
            'destination'           =>    './',     // Default: ./
            'allowed_mime_types'    =>    array(),  // Allowed mime types
            'log'                   =>    array(),  // Logs
            'error'                 =>    0,        // File error
        );

        // Change dir to current dir
        $this->destination_directory = dirname(__FILE__).DIRECTORY_SEPARATOR;
        chdir($this->destination_directory);

        // Set file array
        if(isset($_FILES) && is_array($_FILES)) {
            $this->file_array = $_FILES;
        } elseif(isset($HTTP_POST_FILES) && is_array($HTTP_POST_FILES)) {
            $this->file_array = $HTTP_POST_FILES;
        }
    }

    // 设置表单名称
    public function setInput($input) {
        if(!empty($input) && (is_string($input) || is_numeric($input))) {
            $this->log('Capture set to %s', $input);
            $this->input = $input;
            return true;
        }
        return false;
    }

    // 设置文件名称
    public function setFilename($filename) {
        if($this->isFilename($filename)) {
            $this->log('Filename set to %s', $filename);
            $this->filename = $filename;
            return true;
        }
        return false;
    }

    // 名称设置为自动生成
    public function setAutoFilename() {
        $this->log('Automatic filename is enabled');
        $this->filename = sha1(mt_rand(1, 9999).uniqid());
        $this->filename .= time();
        $this->filename .= '.%s';
        $this->log('Filename set to %s', $this->filename);
        return true;
    }

    // 设置文件允许大小
    public function setMaxFileSize($file_size) {
        $file_size = Tools_help::sizeInBytes($file_size);
        if(is_numeric($file_size) && $file_size>-1) {
            // Get php config
            $size = Tools_help::sizeInBytes(ini_get('upload_max_filesize'));
            $this->log('PHP settings have set the maximum file upload size to %s(%d)', Tools_help::sizeFormat($size), $size);

            // Calculate difference
            if($size<$file_size) {
                $this->log('WARNING! The PHP configuration allows a maximum size of %s', Tools_help::sizeFormat($size));
                return false;
            }

            $this->log('[INFO]Maximum allowed size set at %s(%d)', Tools_help::sizeFormat($file_size), $file_size);

            $this->max_file_size = $file_size;
            return true;
        }
        return false;
    }

    // 设置允许的文件类型
    public function setAllowedMimeTypes(array $mimes) {
        if(count($mimes) > 0) {
            array_map(array($this, 'setAllowMimeType'), $mimes);
            return true;
        }

        return false;
    }

    // 调用前置 callback function
    public function setCallbackInput($callback) {
        if(is_callable($callback, false)) {
            $this->callbacks['input'] = $callback;
            return true;
        }
        return false;
    }

    // 调用后置callback function
    public function setCallbackOutput($callback) {
        if(is_callable($callback, false)) {
            $this->callbacks['output'] = $callback;
            return true;
        }
        return false;
    }

    // 设置允许的文件类型
    public function setAllowMimeType($mime) {
        if(!empty($mime) && is_string($mime)) {
            if(preg_match('#^[-\w\+]+/[-\w\+\.]+$#', $mime)) {
                $this->log('IMPORTANT! Mime %s enabled', $mime);
                $this->allowed_mime_types[] = strtolower($mime);
                $this->file['allowed_mime_types'][] = strtolower($mime);
                return true;
            } else {
                return $this->setMimeHelping($mime);
            }
        }
        return false;
    }

    // 设置系统默认的文件类型
    public function setMimeHelping($mime) {
        if(!empty($mime) && is_string($mime)) {
            if(array_key_exists($mime, $this->mime_helping)) {
                return $this->setAllowedMimeTypes($this->mime_helping[$mime]);
            }
        }
        return false;
    }

    // 设置上传使用的方法
    public function setUploadFunction($function) {
        if(!empty($function) && (is_array($function) || is_string($function))) {
            if(is_callable($function)) {
                $this->log('IMPORTANT! The function for uploading files is set to: %s', $function);
                $this->upload_function = $function;
                return true;
            }
        }
        return false;
    }

    // 清除允许上传的类型
    public function clearAllowedMimeTypes() {
        $this->allowed_mime_types = array();
        $this->file['allowed_mime_types'] = array();
        return true;
    }

    // 设置保存的路径
    public function setDestinationDirectory($destination_directory, $create_if_not_exist=false) {
        //$destination_directory = realpath($destination_directory);
        if(substr($destination_directory, -1) != DIRECTORY_SEPARATOR) {
            $destination_directory .= DIRECTORY_SEPARATOR;
        }

        if($this->isDirpath($destination_directory)) {
            if($this->dirExists($destination_directory)) {
                $this->destination_directory = $destination_directory;
                if(substr($this->destination_directory, -1) != DIRECTORY_SEPARATOR) {
                    $this->destination_directory .= DIRECTORY_SEPARATOR;
                }
                chdir($destination_directory);
                return true;
            } elseif($create_if_not_exist) {
                if(mkdir($destination_directory, $this->destination_permissions, true)) {
                    if($this->dirExists($destination_directory)) {
                        $this->destination_directory = $destination_directory;
                        if(substr($this->destination_directory, -1) != DIRECTORY_SEPARATOR) {
                            $this->destination_directory .= DIRECTORY_SEPARATOR;
                        }
                        chdir($destination_directory);
                        return true;
                    }
                }
            }
        }
        return false;
    }

    // 检测文件是否存在
    public function fileExists($file_destination) {
        if($this->isFilename($file_destination)) {
            return (file_exists($file_destination) && is_file($file_destination));
        }
        return false;
    }

    // 检测目录是否存在
    public function dirExists($path) {
        if($this->isDirpath($path)) {
            return (file_exists($path) && is_dir($path));
        }
        return false;
    }

    // 检测文件名是否有效
    public function isFilename($filename) {
        $filename = basename($filename);
        return (!empty($filename) && (is_string($filename) || is_numeric($filename)));
    }

    // 检测文件类型是否有效
    public function checkMimeType($mime) {
        if(count($this->allowed_mime_types) == 0) {
            return true;
        }
        return in_array(strtolower($mime), $this->allowed_mime_types);
    }

    // 返回上传状态
    public function getStatus() {
        return $this->file['status'];
    }

    // 检测是否有效的路径
    public function isDirpath($path) {
        if(!empty($path) && (is_string($path) || is_numeric($path))) {
            if(DIRECTORY_SEPARATOR == '/') {
                return (preg_match('/^[^*?"<>|:]*$/', $path) == 1 );
            } else {
                return (preg_match('/^[^*?\"<>|:]*$/', substr($path,2)) == 1);
            }
        }
        return false;
    }

    // 允许覆盖文件
    public function allowOverwriting() {
        $this->log('Overwrite enabled');
        $this->allowOverwriting = true;
        return true;
    }

    // 返回文件信息
    public function getInfo() {
        return (object)$this->file;
    }

    // 保存文件
    public function save() {
        if(count($this->file_array) > 0) {
            $this->log('Capturing input %s',$this->input);
            if(array_key_exists($this->input, $this->file_array)) {
                // set original filename if not have a new name
                if(empty($this->filename)) {
                    $this->log('Using original filename %s', $this->file_array[$this->input]['name']);
                    $this->filename = $this->file_array[$this->input]['name'];
                }

                // 扩展名
                //$extension = preg_replace(
                    //"/^[\p{L}\d\s\-\_\.\(\)]*\.([\d\w]+)$/iu",
                    //'$1',
                    //$this->file_array[$this->input]["name"]
                //);
                $extension = Tools_help::getFileExt($this->file_array[$this->input]['name']);
                $this->filename = sprintf($this->filename, $extension);

                // set file info
                $this->file['mime']         = $this->file_array[$this->input]['type'];
                $this->file['tmp']          = $this->file_array[$this->input]['tmp_name'];
                $this->file['original']     = $this->file_array[$this->input]['name'];
                $this->file['size']         = $this->file_array[$this->input]['size'];
                $this->file['sizeFormated'] = Tools_help::sizeFormat($this->file['size']);
                $this->file['destination']  = $this->destination_directory . $this->filename;
                $this->file['filename']     = $this->filename;
                $this->file['error']        = $this->file_array[$this->input]['error'];

                // Check if exists file
                if($this->fileExists($this->destination_directory.$this->filename)) {
                    $this->log('%s file already exists', $this->filename);
                    // Check if overwrite file
                    if($this->overwrite_file === false) {
                        $this->log('You don\'t allow overwriting. Show more about FileUpload::allowOverwriting');
                        return false;
                    }
                    $this->log('The %s file is overwritten', $this->filename);
                }

                // Execute input callback
                if(!empty($this->callbacks['input'])) {
                    $this->log('Running input callback');
                    call_user_func($this->callbacks['input'], (object)$this->file);
                }

                // Check mime type
                $this->log("Check mime type");
                if(!$this->checkMimeType($this->file['mime'])) {
                    $this->log('Mime type %s not allowed', $this->file['mime']);
                    return false;
                }

                $this->log('Mime type %s allowed', $this->file['mime']);

                // Check file size
                if($this->max_file_size > 0) {
                    $this->log('Checking file size');

                    if($this->max_file_size < $this->file["size"]) {
                        $this->log('The file exceeds the maximum size allowed(Max: %s; File: %s)', Tools_help::sizeFormat($this->max_file_size), Tools_help::sizeFormat($this->file["size"]));
                        return false;
                    }
                }

                // Copy tmp file to destination and change status
                $this->log('Copy tmp file to destination %s', $this->destination_directory);
                $this->log('Using upload function: %s', $this->upload_function);

                $this->file['status'] = call_user_func_array(
                    $this->upload_function, array(
                        $this->file_array[$this->input]['tmp_name'],
                        $this->destination_directory . $this->filename
                    )
                );

                // Execute output callback
                if(!empty($this->callbacks['output'])) {
                    $this->log('Running output callback');
                    call_user_func($this->callbacks['output'], (object)$this->file);
                }
                return $this->file['status'];
            }
        }
    }

    // 创建日志
    public function log() {
        $params = func_get_args();
        $this->file['log'][] = call_user_func_array('sprintf', $params);
        return true;
    }

}
