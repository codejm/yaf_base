<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *
 *      $Id: crud.php 2014-08-22 16:32:43 codejm $
 */
date_default_timezone_get('PRC');
$options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING);
$table_pre = 'yaf_';
$db = new PDO('mysql:host=127.0.0.1;dbname=yaf', 'root', 'root', $options);
$db->exec('SET CHARACTER SET UTF8');

$query = "SHOW TABLES";
$sth = $db->prepare($query);
$sth->execute();
$getTablesResult = $sth->fetchAll(PDO::FETCH_ASSOC);

$_dbTables = array();
$dbTables = array();

foreach($getTablesResult as $getTableResult){

    $_dbTables[] = reset($getTableResult);

    $dbTables[] = array(
        "name" => reset($getTableResult),
        "columns" => array()
    );
}

foreach($dbTables as $dbTableKey => $dbTable){
    $query = "SHOW COLUMNS FROM `" . $dbTable['name'] . "`";
    $sth = $db->prepare($query);
    $sth->execute();
    $getTableColumnsResult = $sth->fetchAll(PDO::FETCH_ASSOC);

    foreach($getTableColumnsResult as $getTableColumnResult){

        $query = 'select column_comment from INFORMATION_SCHEMA.COLUMNS where TABLE_NAME = \''.$dbTable['name'].'\' and column_name=\''.$getTableColumnResult['Field'].'\'';
        $sth = $db->prepare($query);
        $sth->execute();
        $comment = $sth->fetchAll(PDO::FETCH_ASSOC);
        $getTableColumnResult['comment'] = $comment[0]['column_comment'];

        $dbTables[$dbTableKey]['columns'][] = $getTableColumnResult;
    }

}

$tables = array();
foreach($dbTables as $dbTable){

    if(count($dbTable['columns']) <= 1){
        continue;
    }

    $table_name = $dbTable['name'];
    $table_columns = array();
    $primary_key = false;

    $primary_keys = 0;
    $primary_keys_auto = 0;
    foreach($dbTable['columns'] as $column){
        if($column['Key'] == "PRI"){
            $primary_keys++;
        }
        if($column['Extra'] == "auto_increment"){
            $primary_keys_auto++;
        }
    }

    if($primary_keys === 1 || ($primary_keys > 1 && $primary_keys_auto === 1)){

        foreach($dbTable['columns'] as $column){

            $external_table = false;

            if($primary_keys > 1 && $primary_keys_auto == 1){
                if($column['Extra'] == "auto_increment"){
                    $primary_key = $column['Field'];
                }
            }
            else if($primary_keys == 1){
                if($column['Key'] == "PRI"){
                    $primary_key = $column['Field'];
                }
            }
            else{
                continue 2;
            }

            if(substr($column['Field'], -3) == "_id"){
                $_table_name = substr($column['Field'], 0, -3);

                if(in_array($_table_name, $_dbTables)){
                    $external_table = $_table_name;
                }
            }

            $table_columns[] = array(
                "name" => $column['Field'],
                "primary" => $column['Field'] == $primary_key ? true : false,
                "nullable" => $column['Null'] == "NO" ? true : false,
                "auto" => $column['Extra'] == "auto_increment" ? true : false,
                "external" => $column['Field'] != $primary_key ? $external_table : false,
                "type" => $column['Type'],
                "comment" => $column['comment'],
            );
        }

    }
    else{
        continue;
    }


    $tables[$table_name] = array(
        "primary_key" => $primary_key,
        "columns" => $table_columns
    );

}

$MENU_OPTIONS = "";
$BASE_INCLUDES = "";

foreach($tables as $table_name => $table){

    $table_columns = $table['columns'];

    $TABLENAME = $table_name;
    $TABLE_PRIMARYKEY = $table['primary_key'];

    $TABLECOLUMNS_ARRAY = "";
    $TABLECOLUMNS_RULES_ARRAY = "";
    $TABLECOLUMNS_INITIALDATA_EMPTY_ARRAY = "";
    $TABLECOLUMNS_INITIALDATA_ARRAY = "";

    $FIELDS_FOR_FORM = "";
    $FIELDS_TH = "";
    $FIELDS_TD = "";

    $INSERT_QUERY_FIELDS = array();
    $INSERT_EXECUTE_FIELDS = array();
    $UPDATE_QUERY_FIELDS = array();
    $UPDATE_EXECUTE_FIELDS = array();

    $EDIT_FORM_TEMPLATE = "";
    $EDIT_FORM_TEMPLATE_STYLE = "";
    $EDIT_FORM_TEMPLATE_SCRIPT = "";
    $CONTROLLER_ADD_PRE = "";
    $CONTROLLER_ADD = "";
    $CONTROLLER_ADD_AFTER = "";
    $CONTROLLER_EDIT_PRE = "";
    $CONTROLLER_EDIT = "";
    $CONTROLLER_EDIT_AFTER = "";


    $MENU_OPTIONS .= "" .
        "<li class=\"treeview {% if option is defined and (option == '" . $TABLENAME . "_list' or option == '" . $TABLENAME . "_create' or option == '" . $TABLENAME . "_edit') %}active{% endif %}\">" . "\n" .
        "    <a href=\"#\">" . "\n" .
        "        <i class=\"fa fa-folder-o\"></i>" . "\n" .
        "        <span>" . $TABLENAME . "</span>" . "\n" .
        "        <i class=\"fa pull-right fa-angle-right\"></i>" . "\n" .
        "    </a>" . "\n" .
        "    <ul class=\"treeview-menu\" style=\"display: none;\">" . "\n" .
        "        <li {% if option is defined and option == '" . $TABLENAME . "_list' %}class=\"active\"{% endif %}><a href=\"{{ path('" . $TABLENAME . "_list') }}\" style=\"margin-left: 10px;\"><i class=\"fa fa-angle-double-right\"></i> List</a></li>" . "\n" .
        "        <li {% if option is defined and option == '" . $TABLENAME . "_create' %}class=\"active\"{% endif %}><a href=\"{{ path('" . $TABLENAME . "_create') }}\" style=\"margin-left: 10px;\"><i class=\"fa fa-angle-double-right\"></i> Create</a></li>" . "\n" .
        "    </ul>" . "\n" .
        "</li>" . "\n\n";

    $BASE_INCLUDES .= "require_once __DIR__.'/" . $TABLENAME . "/index.php';" . "\n";

    $count_externals = 0;
    foreach($table_columns as $table_column){

        $TABLENAMEBAK = $TABLENAME;
        if($table_pre == '_') {
            $TABLENAMEBAK = str_replace($table_pre, '', $TABLENAMEBAK);
            $TABLENAMEBAK = ucwords($TABLENAMEBAK);
            //$TABLENAMEBAK = str_replace(' ', '', $TABLENAMEBAK);
        } else {
            $TABLENAMEBAK = str_replace($table_pre, '', $TABLENAMEBAK);
        }
        $TABLENAMEBAK = str_replace("_", '', $TABLENAMEBAK);
        $TABLENAMEBAK = ucwords($TABLENAMEBAK);
        //$TABLENAMEBAK = str_replace(" ", '', $TABLENAMEBAK);
        $TABLENAMES = lcfirst($TABLENAMEBAK);

        $columnType = '';
        $columnHidden = '';
        $comment = $table_column['name'];
        if($table_column['comment']) {
            $comment = explode(",", $table_column['comment']);
            if(isset($comment[1]) && !empty($comment[1])) {
                $columnType = $comment[1];
            }
            if(isset($comment[2]) && !empty($comment[2])){
                $columnHidden = $comment[2];
            }
            $comment = $comment[0];
        }

        if(empty($columnHidden)){
            $FIELDS_TH .= "\t\t\t\t\t\t\t<th><a href=\"{{ url('curr_url', {'sort':'{$table_column['name']}'})}}\">{$comment}</a></th>\n";
            if($table_column['name'] == 'status') {
                $FIELDS_TD .= "\t\t\t\t\t\t<td class=\"hidden-480\">\n\t\t\t\t\t\t\t{% if row.status>0 %}\n\t\t\t\t\t\t\t\t<a href=\"{{ url('backend/".$TABLENAMES."/status', {'".$TABLE_PRIMARYKEY."':row.".$TABLE_PRIMARYKEY.", 'status':row.status}) }}\" class=\"label label-sm label-success\">已通过</a>\n\t\t\t\t\t\t\t{% else %}\n\t\t\t\t\t\t\t\t<a href=\"{{ url('backend/".$TABLENAMES."/status', {'".$TABLE_PRIMARYKEY."':row.".$TABLE_PRIMARYKEY.", 'status':row.status}) }}\" class=\"label label-sm label-warning\">未通过</a>\n\t\t\t\t\t\t\t{% endif %}\n\t\t\t\t\t\t</td>";
            } else if($columnType  == 'radio') {
                $FIELDS_TD .= "\t\t\t\t\t\t<td> {{row.{$table_column['name']} ? '是' : '否'}} </td>\n";
            } else if($columnType  == 'time') {
                $FIELDS_TD .= "\t\t\t\t\t\t<td> {{row.{$table_column['name']} | date('Y-m-d H:i:s')}} </td>\n";
            } else if($columnType  == 'date') {
                $FIELDS_TD .= "\t\t\t\t\t\t<td> {{row.{$table_column['name']} | date('Y-m-d')}} </td>\n";
            } else {
                $FIELDS_TD .= "\t\t\t\t\t\t<td> {{row.{$table_column['name']}}} </td>\n";
            }
        }

        $TABLECOLUMNS_ARRAY .= "\t\t\t" . "'". $table_column['name'] . "' => '".$comment."', \n";

        if(!$table_column['primary']){
            $str = '';
            if($table_column['nullable'] && stripos($table_column['type'], 'tinyint') === false)
                $str .= 'required|';
            if($table_column['type']) {
                $reg='/\d+/is';
                preg_match_all($reg,$table_column['type'],$result);
                if(isset($result[0])  && isset($result[0][0])){
                    $str .= 'maxlength['.$result[0][0].']|';
                }
            }
            if($table_column['name'] == 'email'){
                $str .= 'email|';
            }
            if($table_column['name'] == 'mobile'){
                $str .= 'phone|';
            }
            if(stripos($table_column['type'], 'int') !== false){
                $str .= 'integer|';
            }
            $str = rtrim($str, '|');
            if(!empty($str))
                $TABLECOLUMNS_RULES_ARRAY .= "\t\t\t\t" . "array('".$table_column['name']."', '".$str."'),\n";
        }

        if(!$table_column['primary'] || ($table_column['primary'] && !$table_column['auto'])){
            $TABLECOLUMNS_INITIALDATA_EMPTY_ARRAY .= "\t\t" . "'". $table_column['name'] . "' => '', \n";
            $TABLECOLUMNS_INITIALDATA_ARRAY .= "\t\t" . "'". $table_column['name'] . "' => \$row_sql['".$table_column['name']."'], \n";

            $INSERT_QUERY_FIELDS[] = "`" . $table_column['name'] . "`";
            $INSERT_EXECUTE_FIELDS[] = "\$data['" . $table_column['name'] . "']";
            $UPDATE_QUERY_FIELDS[] = "`" . $table_column['name'] . "` = ?";
            $UPDATE_EXECUTE_FIELDS[] = "\$data['" . $table_column['name'] . "']";

            $isnull = $table_column['nullable'] ? "<span class=\"red\">*</span>" : "";

            if($columnType  == 'textarea'){
                $EDIT_FORM_TEMPLATE .= "" .
                    "\t\t\t" . "<div class=\"form-group{% if errors['".$table_column['name']."'] is not empty %} has-error{%endif%}\">" . "\n" .
                    "\t\t\t" . "    <label for=\"".$table_column['name']."\" class=\"col-xs-12 col-sm-3 col-md-3 control-label no-padding-right\">".$comment.$isnull."</label>" . "\n" .
                    "\t\t\t" . "    <div class=\"col-xs-12 col-sm-4\">" . "\n" .
                    "\t\t\t" . "        <span class=\"block input-icon input-icon-right\">" . "\n" .
                    "\t\t\t" . "            <textarea id=\"".$table_column['name']."\" name=\"".$table_column['name']."\" class=\"autosize-transition form-control\" style=\"overflow: hidden; word-wrap: break-word; resize: horizontal; height: 52px;\">{{".$TABLENAMES.".".$table_column['name']."}}</textarea>" . "\n" .
                    "\t\t\t" . "        </span>" . "\n" .
                    "\t\t\t" . "    </div>" . "\n" .
                    "\t\t\t" . "    <div class=\"help-block col-xs-12 col-sm-reset inline\"> {% if errors['".$table_column['name']."'] is not empty %}{{errors['".$table_column['name']."']}}{% else %} {%endif%} </div>\n".
                    "\t\t\t" . "</div>" . "\n\n";
            } else if($columnType  == 'time') {
                $EDIT_FORM_TEMPLATE .= "" .
                    "\t\t\t" . "<div class=\"form-group{% if errors['".$table_column['name']."'] is not empty %} has-error{%endif%}\">" . "\n" .
                    "\t\t\t" . "    <label for=\"".$table_column['name']."\" class=\"col-xs-12 col-sm-3 col-md-3 control-label no-padding-right\">".$comment.$isnull."</label>" . "\n" .
                    "\t\t\t" . "    <div class=\"col-xs-12 col-sm-4\">" . "\n" .
                    "\t\t\t" . "        <span class=\"block input-icon input-icon-right\">" . "\n" .
                    "\t\t\t" . "            <input type=\"text\" id=\"".$table_column['name']."\" placeholder=\"".$comment."\" name=\"".$table_column['name']."\" class=\"form-control date-picker\" value=\"{{".$TABLENAMES.".".$table_column['name']." | date('Y-m-d H:i:s')}}\"/>" . "\n" .
                    "\t\t\t" . "        </span>" . "\n" .
                    "\t\t\t" . "    </div>" . "\n" .
                    "\t\t\t" . "    <div class=\"help-block col-xs-12 col-sm-reset inline\"> {% if errors['".$table_column['name']."'] is not empty %}{{errors['".$table_column['name']."']}}{% else %} {%endif%} </div>\n".
                    "\t\t\t" . "</div>" . "\n\n";
                $EDIT_FORM_TEMPLATE_SCRIPT .= ""  .
                    "\t$('#".$table_column['name']."').datetimepicker({format: 'YYYY-MM-DD hh:mm:ss'}).next().on(ace.click_event, function(){\n".
                    "\t\t$(this).prev().focus();\n".
                    "\t});\n";

            } else if($columnType  == 'date') {
                $EDIT_FORM_TEMPLATE .= "" .
                    "\t\t\t" . "<div class=\"form-group{% if errors['".$table_column['name']."'] is not empty %} has-error{%endif%}\">" . "\n" .
                    "\t\t\t" . "    <label for=\"".$table_column['name']."\" class=\"col-xs-12 col-sm-3 col-md-3 control-label no-padding-right\">".$comment.$isnull."</label>" . "\n" .
                    "\t\t\t" . "    <div class=\"col-xs-12 col-sm-4\">" . "\n" .
                    "\t\t\t" . "        <span class=\"block input-icon input-icon-right\">" . "\n" .
                    "\t\t\t" . "            <input type=\"text\" id=\"".$table_column['name']."\" placeholder=\"".$comment."\" name=\"".$table_column['name']."\" class=\"form-control date-picker\" value=\"{{".$TABLENAMES.".".$table_column['name']."}}\" data-date-format=\"yyyy-mm-dd\"/>" . "\n" .
                    "\t\t\t" . "        </span>" . "\n" .
                    "\t\t\t" . "    </div>" . "\n" .
                    "\t\t\t" . "    <div class=\"help-block col-xs-12 col-sm-reset inline\"> {% if errors['".$table_column['name']."'] is not empty %}{{errors['".$table_column['name']."']}}{% else %} {%endif%} </div>\n".
                    "\t\t\t" . "</div>" . "\n\n";

            } else if($columnType  == 'hidden') {
                $EDIT_FORM_TEMPLATE .= "".
                    "\t\t\t" . "<input type=\"hidden\" name=\"".$table_column['name']."\" value=\"{{".$TABLENAMES.".".$table_column['name']."}}\"/>";

            } else if($columnType  == 'select') {
                $EDIT_FORM_TEMPLATE .= "" .
                    "\t\t\t" . "<div class=\"form-group{% if errors['".$table_column['name']."'] is not empty %} has-error{%endif%}\">" . "\n" .
                    "\t\t\t" . "    <label for=\"".$table_column['name']."\" class=\"col-xs-12 col-sm-3 col-md-3 control-label no-padding-right\">".$comment.$isnull."</label>" . "\n" .
                    "\t\t\t" . "    <div class=\"col-xs-12 col-sm-4\">" . "\n" .
                    "\t\t\t" . "        <span class=\"block input-icon input-icon-right\">" . "\n" .
                    "\t\t\t" . "            <select class=\"form-control\"  id=\"".$table_column['name']."\" name=\"".$table_column['name']."\">" . "\n" .
                    "\t\t\t" . "                <option value=\"\"></option>" . "\n" .
                    "\t\t\t" . "            </select>" . "\n" .
                    "\t\t\t" . "        </span>" . "\n" .
                    "\t\t\t" . "    </div>" . "\n" .
                    "\t\t\t" . "    <div class=\"help-block col-xs-12 col-sm-reset inline\"> {% if errors['".$table_column['name']."'] is not empty %}{{errors['".$table_column['name']."']}}{% else %} {%endif%} </div>\n".
                    "\t\t\t" . "</div>" . "\n\n";

            } else if($columnType  == 'textareas') {
                $EDIT_FORM_TEMPLATE .= "" .
                    "\t\t\t" . "<div class=\"form-group{% if errors['".$table_column['name']."'] is not empty %} has-error{%endif%}\">" . "\n" .
                    "\t\t\t" . "    <label for=\"".$table_column['name']."\" class=\"col-xs-12 col-sm-3 col-md-3 control-label no-padding-right\">".$comment.$isnull."</label>" . "\n" .
                    "\t\t\t" . "    <div class=\"wysiwyg-editor\" id=\"".$table_column['name']."_editor\">{{".$TABLENAMES.".".$table_column['name']."|raw}}</div>\n".
                    "\t\t\t" . "    <input type=\"hidden\" name=\"".$table_column['name']."\" id=\"".$table_column['name']."\" value=\"{{".$TABLENAMES.".".$table_column['name']."}}\" />\n".
                    "\t\t\t" . "    <div class=\"help-block col-xs-12 col-sm-reset inline\"> {% if errors['".$table_column['name']."'] is not empty %}{{errors['".$table_column['name']."']}}{% else %} {%endif%} </div>\n".
                    "\t\t\t" . "</div>" . "\n\n";

                $EDIT_FORM_TEMPLATE_SCRIPT .= "\n".
                    "   $('#".$table_column['name']."_editor').ace_wysiwyg({\n".
                    "      'wysiwyg': {\n".
                    "           uploadScript: \"{{ url('backend/upload/upload', {'dir':'".$TABLENAMES."'}) }}\",\n".
                    "           uploadOptions: {\n".
                    "               post_id: '10',\n".
                    "               revision_id: '3'\n".
                    "           }\n".
                    "       }\n".
                    "   });\n".
                    "   $('#".$table_column['name']."_editor').focusout(function() {\n".
                    "       $('#".$table_column['name']."').val($('#".$table_column['name']."_editor').html());\n".
                    "   });\n";

            } else if($columnType == 'file') {
                $EDIT_FORM_TEMPLATE .= "" .
                    "\t\t\t" . "<div class=\"form-group{% if errors['".$table_column['name']."'] is not empty %} has-error{%endif%}\">" . "\n" .
                    "\t\t\t" . "    <label for=\"".$table_column['name']."\" class=\"col-xs-12 col-sm-3 col-md-3 control-label no-padding-right\">".$comment.$isnull."</label>" . "\n" .
                    "\t\t\t" . "    <div class=\"col-xs-12 col-sm-4\">" . "\n" .
                    "\t\t\t" . "        <span class=\"block input-icon input-icon-right\">" . "\n" .
                    "\t\t\t" . "            <input multiple=\"\" type=\"file\" id=\"".$table_column['name']."\" placeholder=\"".$comment."\" name=\"".$table_column['name']."\" class=\"col-xs-12\" value=\"{{".$TABLENAMES.".".$table_column['name']."}}\" />\n" .
                    "\t\t\t" . "        </span>" . "\n" .
                    "\t\t\t" . "    </div>" . "\n" .
                    "\t\t\t" . "    <div class=\"help-block col-xs-12 col-sm-reset inline\"> {% if errors['".$table_column['name']."'] is not empty %}{{errors['".$table_column['name']."']}}{% else %} {%endif%} </div>\n".
                    "\t\t\t" . "</div>" . "\n\n";

                $EDIT_FORM_TEMPLATE_STYLE .= "\n".
                    "<style>\n".
                    "\t.ace-file-multiple .ace-file-container .ace-file-name .ace-icon{\n".
                    "\twidth:100%;\n".
                    "\theight:100px;\n".
                    "}\n".
                    ".fa-".$table_column['name']." {\n".
                    "\tbackground-image: url(\"{{".$TABLENAMES.".".$table_column['name']."}}\");\n".
                    "\tbackground-size:100% 100%;\n".
                    "\tbackground-repeat:no-repeat;\n".
                    "}\n".
                    "</style>\n";

                $EDIT_FORM_TEMPLATE_SCRIPT .= "\n".
                    "       $('#".$table_column['name']."').ace_file_input({\n".
                    "           style:'well',\n".
                    "           btn_choose:'点击这里修改图片',\n".
                    "           btn_change:null,\n".
                    "           no_icon:'ace-icon fa {% if ".$TABLENAMES.".".$table_column['name']." %}fa-".$table_column['name']."{% else %}fa-cloud-upload{% endif %}',\n".
                    "           droppable:false,\n".
                    "           thumbnail:'large'//large | fit\n".
                    "       });\n";

                // controller
                $CONTROLLER_EDIT_PRE .= "".
                    "           \$imageInfo = Tools_help::upload('".$table_column['name']."', '".$TABLENAMES."');\n".
                    "           if(!empty(\$imageInfo)) {\n" .
                    "               \$pdata['".$table_column['name']."'] = \$imageInfo;\n".
                    "           } else {\n".
                    "               unset(\$pdata['".$table_column['name']."']);\n".
                    "           }\n";

                $CONTROLLER_EDIT_AFTER .= "\n".
                    "       // 图片处理\n".
                    "       if(\$".$TABLENAMES."Model->".$table_column['name']."){\n".
                    "           \$".$TABLENAMES."Model->".$table_column['name']." = Tools_help::fbu(\$".$TABLENAMES."Model->".$table_column['name'].");\n".
                    "       }\n";

            } else if($columnType  == 'radio') {
                $EDIT_FORM_TEMPLATE .= "" .
                    "\t\t\t" . "<div class=\"form-group{% if errors['".$table_column['name']."'] is not empty %} has-error{%endif%}\">" . "\n" .
                    "\t\t\t" . "    <label for=\"".$table_column['name']."\" class=\"col-xs-12 col-sm-3 col-md-3 control-label no-padding-right\">".$comment.$isnull."</label>" . "\n" .
                    "\t\t\t" . "    <div class=\"col-xs-12 col-sm-4\">" . "\n" .
                    "\t\t\t" . "        <span class=\"block input-icon input-icon-right\">" . "\n" .
                    "\t\t\t" . "            <input type=\"checkbox\" id=\"".$table_column['name']."_radio\" placeholder=\"".$comment."\" name=\"".$table_column['name']."_radio\" class=\"ace ace-switch ace-switch-5\"{% if ".$TABLENAMES.".".$table_column['name']." %} checked=\"checked\"{% endif %} />" . "\n" .
                    "\t\t\t" . "            <span class=\"lbl\"></span>" . "\n" .
                    "\t\t\t" . "            <input type=\"hidden\" name=\"".$table_column['name']."\" id=\"".$table_column['name']."\" value=\"{{".$TABLENAMES.".".$table_column['name']."}}\"/>\n".
                    "\t\t\t" . "        </span>" . "\n" .
                    "\t\t\t" . "    </div>" . "\n" .
                    "\t\t\t" . "    <div class=\"help-block col-xs-12 col-sm-reset inline\"> {% if errors['".$table_column['name']."'] is not empty %}{{errors['".$table_column['name']."']}}{% else %} {%endif%} </div>\n".
                    "\t\t\t" . "</div>" . "\n\n";

            } else if($table_column['name']  == 'password') {
                $EDIT_FORM_TEMPLATE .= "" .
                    "\t\t\t" . "<div class=\"form-group{% if errors['".$table_column['name']."'] is not empty %} has-error{%endif%}\">" . "\n" .
                    "\t\t\t" . "    <label for=\"".$table_column['name']."\" class=\"col-xs-12 col-sm-3 col-md-3 control-label no-padding-right\">".$comment.$isnull."</label>" . "\n" .
                    "\t\t\t" . "    <div class=\"col-xs-12 col-sm-4\">" . "\n" .
                    "\t\t\t" . "        <span class=\"block input-icon input-icon-right\">" . "\n" .
                    "\t\t\t" . "            <input type=\"password\" id=\"".$table_column['name']."\" placeholder=\"".$comment."\" name=\"".$table_column['name']."\" class=\"col-xs-12\" value=\"{{".$TABLENAMES.".".$table_column['name']."}}\" />" . "\n" .
                    "\t\t\t" . "        </span>" . "\n" .
                    "\t\t\t" . "    </div>" . "\n" .
                    "\t\t\t" . "    <div class=\"help-block col-xs-12 col-sm-reset inline\"> {% if errors['".$table_column['name']."'] is not empty %}{{errors['".$table_column['name']."']}}{% else %} {%endif%} </div>\n".
                    "\t\t\t" . "</div>" . "\n\n";
            }
            else {
                $EDIT_FORM_TEMPLATE .= "" .
                    "\t\t\t" . "<div class=\"form-group{% if errors['".$table_column['name']."'] is not empty %} has-error{%endif%}\">" . "\n" .
                    "\t\t\t" . "    <label for=\"".$table_column['name']."\" class=\"col-xs-12 col-sm-3 col-md-3 control-label no-padding-right\">".$comment.$isnull."</label>" . "\n" .
                    "\t\t\t" . "    <div class=\"col-xs-12 col-sm-4\">" . "\n" .
                    "\t\t\t" . "        <span class=\"block input-icon input-icon-right\">" . "\n" .
                    "\t\t\t" . "            <input type=\"text\" id=\"".$table_column['name']."\" placeholder=\"".$comment."\" name=\"".$table_column['name']."\" class=\"col-xs-12\" value=\"{{".$TABLENAMES.".".$table_column['name']."}}\" />" . "\n" .
                    "\t\t\t" . "        </span>" . "\n" .
                    "\t\t\t" . "    </div>" . "\n" .
                    "\t\t\t" . "    <div class=\"help-block col-xs-12 col-sm-reset inline\"> {% if errors['".$table_column['name']."'] is not empty %}{{errors['".$table_column['name']."']}}{% else %} {%endif%} </div>\n".
                    "\t\t\t" . "</div>" . "\n\n";
            }
            if($columnType  == 'date'){
                $CONTROLLER_EDIT_PRE .= "\n".
                    "   \$pdata['".$table_column['name']."'] = Tools_help::htime(\$".$TABLENAMES."Model->".$table_column['name'].");\n";
            }
            if($columnType  == 'time'){
                $CONTROLLER_EDIT_PRE .= "\n".
                    "   \$pdata['".$table_column['name']."'] = Tools_help::htime(\$".$TABLENAMES."Model->".$table_column['name'].");\n";
            }
        }

        $field_nullable = $table_column['nullable'] ? "true" : "false";

        if($table_column['external']){
            $external_table = $tables[$table_column['external']];

            $external_primary_key = $external_table['primary_key'];
            $external_select_field = false;

            foreach($external_table['columns'] as $external_column){
                if($external_column['name'] == "name" ||
                    $external_column['name'] == "title" ||
                    $external_column['name'] == "email" ||
                    $external_column['name'] == "username"){
                        $external_select_field = $external_column['name'];
                    }
            }

            if(!$external_select_field){
                $external_select_field = $external_primary_key;
            }

            $external_cond = $count_externals > 0 ? "else if" : "if";

            $count_externals++;
        }
        else{
            if(!$table_column['primary']){

                if(strpos($table_column['type'], 'text') !== false){
                    $FIELDS_FOR_FORM .= "" .
                        "\t" . "\$form = \$form->add('" . $table_column['name'] . "', 'textarea', array('required' => " . $field_nullable . "));" . "\n";
                }
                else{
                    $FIELDS_FOR_FORM .= "" .
                        "\t" . "\$form = \$form->add('" . $table_column['name'] . "', 'text', array('required' => " . $field_nullable . "));" . "\n";
                }
            }
            else if($table_column['primary'] && !$table_column['auto']){
                $FIELDS_FOR_FORM .= "" .
                    "\t" . "\$form = \$form->add('" . $table_column['name'] . "', 'text', array('required' => " . $field_nullable . "));" . "\n";
            }
        }
    }

    $INSERT_QUERY_VALUES = array();
    foreach($INSERT_QUERY_FIELDS as $INSERT_QUERY_FIELD){
        $INSERT_QUERY_VALUES[] = "?";
    }
    $INSERT_QUERY_VALUES = implode(", ", $INSERT_QUERY_VALUES);
    $INSERT_QUERY_FIELDS = implode(", ", $INSERT_QUERY_FIELDS);
    $INSERT_EXECUTE_FIELDS = implode(", ", $INSERT_EXECUTE_FIELDS);

    $UPDATE_QUERY_FIELDS = implode(", ", $UPDATE_QUERY_FIELDS);
    $UPDATE_EXECUTE_FIELDS = implode(", ", $UPDATE_EXECUTE_FIELDS);

    $_controller = file_get_contents(__DIR__.'/../gen/controller.php');
    $_controller = str_replace("__TABLENAME__", $TABLENAMEBAK, $_controller);
    $_controller = str_replace("__TABLENAMES__", $TABLENAMES, $_controller);

    $query = "SHOW TABLE STATUS WHERE Name=\"{$TABLENAME}\"";
    $sth = $db->prepare($query);
    $sth->execute();
    $getTablesResult = $sth->fetchAll(PDO::FETCH_ASSOC);
    $_controller = str_replace("__TABLENAMEREMARK__", $getTablesResult[0]['Comment'], $_controller);

    $_controller = str_replace("__TABLE_PRIMARYKEY__", $TABLE_PRIMARYKEY, $_controller);
    $_controller = str_replace("__TABLECOLUMNS_ARRAY__", $TABLECOLUMNS_ARRAY, $_controller);
    $_controller = str_replace("__TABLECOLUMNS_INITIALDATA_EMPTY_ARRAY__", $TABLECOLUMNS_INITIALDATA_EMPTY_ARRAY, $_controller);
    $_controller = str_replace("__TABLECOLUMNS_INITIALDATA_ARRAY__", $TABLECOLUMNS_INITIALDATA_ARRAY, $_controller);
    $_controller = str_replace("__FIELDS_FOR_FORM__", $FIELDS_FOR_FORM, $_controller);

    $_controller = str_replace("__INSERT_QUERY_FIELDS__", $INSERT_QUERY_FIELDS, $_controller);
    $_controller = str_replace("__INSERT_QUERY_VALUES__", $INSERT_QUERY_VALUES, $_controller);
    $_controller = str_replace("__INSERT_EXECUTE_FIELDS__", $INSERT_EXECUTE_FIELDS, $_controller);

    $_controller = str_replace("__UPDATE_QUERY_FIELDS__", $UPDATE_QUERY_FIELDS, $_controller);
    $_controller = str_replace("__UPDATE_EXECUTE_FIELDS__", $UPDATE_EXECUTE_FIELDS, $_controller);
    $_controller = str_replace("__CONTROLLER_ADD_PRE__", $CONTROLLER_ADD_PRE, $_controller);
    $_controller = str_replace("__CONTROLLER_ADD__", $CONTROLLER_ADD, $_controller);
    $_controller = str_replace("__CONTROLLER_ADD_AFTER__", $CONTROLLER_ADD_AFTER, $_controller);
    $_controller = str_replace("__CONTROLLER_EDIT_PRE__", $CONTROLLER_EDIT_PRE, $_controller);
    $_controller = str_replace("__CONTROLLER_EDIT__", $CONTROLLER_EDIT, $_controller);
    $_controller = str_replace("__CONTROLLER_EDIT_AFTER__", $CONTROLLER_EDIT_AFTER, $_controller);
    $_controller = str_replace("__FILETIME__", date('Y-m-d H:i:s'), $_controller);

    $_models = file_get_contents(__DIR__.'/../gen/model.php');
    $_models = str_replace("__TNAME__", $TABLENAME, $_models);
    $_models = str_replace("__TABLENAMEREMARK__", $getTablesResult[0]['Comment'], $_models);
    $_models = str_replace("__TABLENAME__", $TABLENAMEBAK, $_models);
    $_models = str_replace("__TABLENAMES__", $TABLENAMES, $_models);
    $_models = str_replace("__TABLE_PRIMARYKEY__", $TABLE_PRIMARYKEY, $_models);
    $_models = str_replace("__TABLECOLUMNS_ARRAY__", rtrim($TABLECOLUMNS_ARRAY), $_models);
    $_models = str_replace("__TABLECOLUMNS_RULES_ARRAY__", $TABLECOLUMNS_RULES_ARRAY, $_models);
    $_models = str_replace("__FILETIME__", date('Y-m-d H:i:s'), $_models);


    $_list_template = file_get_contents(__DIR__.'/../gen/list.html');
    $_list_template = str_replace("__TABLENAME__", $TABLENAME, $_list_template);
    $_list_template = str_replace("__TABLENAMEUP__", ucfirst(strtolower($TABLENAME)), $_list_template);
    $_list_template = str_replace("__TABLENAMES__", $TABLENAMES, $_list_template);
    $_list_template = str_replace("__TABLE_PRIMARYKEY__", $TABLE_PRIMARYKEY, $_list_template);
    $_list_template = str_replace("__FIELDS_TH_", rtrim($FIELDS_TH), $_list_template);
    $_list_template = str_replace("__FIELDS_TD_", rtrim($FIELDS_TD), $_list_template);

    $_create_template = file_get_contents(__DIR__.'/../gen/create.html');
    $_create_template = str_replace("__TABLENAME__", $TABLENAME, $_create_template);
    $_create_template = str_replace("__TABLENAMES__", $TABLENAMES, $_create_template);
    $_create_template = str_replace("__TABLE_PRIMARYKEY__", $TABLE_PRIMARYKEY, $_create_template);
    $_create_template = str_replace("__TABLENAMEUP__", ucfirst(strtolower($TABLENAME)), $_create_template);
    $_create_template = str_replace("__EDIT_FORM_TEMPLATE__", $EDIT_FORM_TEMPLATE, $_create_template);
    $_create_template = str_replace("__EDIT_FORM_TEMPLATE_STYLE__", $EDIT_FORM_TEMPLATE_STYLE, $_create_template);
    $_create_template = str_replace("__EDIT_FORM_TEMPLATE_SCRIPT__", $EDIT_FORM_TEMPLATE_SCRIPT, $_create_template);

    $_edit_template = file_get_contents(__DIR__.'/../gen/edit.html');
    $_edit_template = str_replace("__TABLENAME__", $TABLENAME, $_edit_template);
    $_edit_template = str_replace("__TABLENAMES__", $TABLENAMES, $_edit_template);
    $_edit_template = str_replace("__TABLE_PRIMARYKEY__", $TABLE_PRIMARYKEY, $_edit_template);
    $_edit_template = str_replace("__TABLENAMEUP__", ucfirst(strtolower($TABLENAME)), $_edit_template);
    $_edit_template = str_replace("__EDIT_FORM_TEMPLATE__", $EDIT_FORM_TEMPLATE, $_edit_template);
    $_edit_template = str_replace("__EDIT_FORM_TEMPLATE_STYLE__", $EDIT_FORM_TEMPLATE_STYLE, $_edit_template);
    $_edit_template = str_replace("__EDIT_FORM_TEMPLATE_SCRIPT__", $EDIT_FORM_TEMPLATE_SCRIPT, $_edit_template);

    @mkdir(__DIR__."/../web/controllers/", 0755, true);
    @mkdir(__DIR__."/../web/models/", 0755, true);
    @mkdir(__DIR__."/../web/views/", 0755, true);
    @mkdir(__DIR__."/../web/views/".$TABLENAMES, 0755);

    $fp = fopen(__DIR__."/../web/controllers/".$TABLENAMEBAK.".php", "w+");
    $_controller = str_replace("\t", '    ', $_controller);
    fwrite($fp, $_controller);
    fclose($fp);

    $fp = fopen(__DIR__."/../web/models/".$TABLENAMEBAK.".php", "w+");
    $_models = str_replace("\t", '    ', $_models);
    fwrite($fp, $_models);
    fclose($fp);

    $fp = fopen(__DIR__."/../web/views/".$TABLENAMES."/index.html", "w+");
    $_list_template = str_replace("\t", '    ', $_list_template);
    fwrite($fp, $_list_template);
    fclose($fp);

    $fp = fopen(__DIR__."/../web/views/".$TABLENAMES."/add.html", "w+");
    $_create_template = str_replace("\t", '    ', $_create_template);
    fwrite($fp, $_create_template);
    fclose($fp);

    $fp = fopen(__DIR__."/../web/views/".$TABLENAMES."/edit.html", "w+");
    $_edit_template = str_replace("\t", '    ', $_edit_template);
    fwrite($fp, $_edit_template);
    fclose($fp);
}
echo "create all success\n\n";
?>
