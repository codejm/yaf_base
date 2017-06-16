<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *
 *      $Id: count.php 2017-06-06 09:04:06 codejm $
 */


header("Content-type: text/html; charset=gbk");
function getDB($host='10.10.16.88', $dbname='qdrbs', $username='clubserver', $pwd='jszxclub', $charset='latin1') {
    /* {{{ */
    $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING);
    $config = array('database'=>array(
        'dbtype' => 'mysql',
        'host' => $host,
        'dbname' => $dbname,
        'username' => $username,
        'password' => $pwd
    ));
    $database = new PDO($config['database']['dbtype'] . ':host=' . $config['database']['host'] . ';dbname=' . $config['database']['dbname'], $config['database']['username'], $config['database']['password'], $options);
    $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $database->exec('SET CHARACTER SET '.$charset);
    return $database;
    /* }}} */
}


$db = getDB();

$sql = 'select * from px_board where flag=1';
$result = $db->prepare($sql);
$result->execute();
$boards = $result->fetchAll(PDO::FETCH_ASSOC);
$result->closeCursor();

$db2 = getDB('10.10.16.88', 'qdrbs_22');
$start = strtotime(date('Y-m-d', time()-86400));
$stop = strtotime(date('Y-m-d', time()));

$cdata = array();
$zarr = array();
$zc = 0;
$rc = 0;
foreach ($boards as $board) {
    if($board['board_id']  == 113 || $board['board_id']  ==  1240)
        continue;
    // 主
    $sql = 'select count(*) from m_topic'.$board['board_id'].' where timestamp_new>='.$start.' and timestamp_new<='.$stop.' and through=1';
    $result = $db2->prepare($sql);
    $result->execute();
    $zrow = $result->fetchColumn();
    $result->closeCursor();
    $zc += $zrow;

    // 回
    $sql = 'select count(*) from r_topic'.$board['board_id'].' where timestamp_new>='.$start.' and timestamp_new<='.$stop.' and through=1';
    $result = $db->prepare($sql);
    $result->execute();
    $hrow = $result->fetchColumn();
    $result->closeCursor();
    $rc += $hrow;

    $cdata[] = array(
        'board_id' => $board['board_id'],
        'board_name' => $board['board_name'],
        'topic' => $zrow,
        'reply' => $hrow
    );
    $zarr[] = $zrow;

}

array_multisort($zarr, SORT_DESC, $cdata);

echo '总主帖:'.$zc.', 总回帖:'.$rc.'<br/></br/>';

foreach ($cdata as $item) {
    echo '<a href="http://club.qingdaonews.com/club_entry_'.$item['board_id'].'_2_0_1_1.htm" target="_blank">'.$item['board_name'].'</a>:主帖['.$item['topic'].'], 回帖['.$item['reply'].']<br /><br />';
}

