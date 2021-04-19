<?php

$filename = 'ykmlog.xml';
$xml = new SimpleXMLElement("../xml/{$filename}", 0, true);

date_default_timezone_set('Asia/Tokyo'); // タイムゾーンを日本に設定

$id = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '';
$title = isset($_POST['title']) ? htmlspecialchars($_POST['title']) : '';
$content = isset($_POST['content']) ? htmlspecialchars($_POST['content']) : '';
$meeting_date = isset($_POST['meeting_date']) ? htmlspecialchars($_POST['meeting_date']) . " 00:00:00" : "00-00-00 00:00:00";
$creator_id = isset($_POST['creator_id']) ? htmlspecialchars($_POST['creator_id']) : '';
$created_at = date("Y-m-d H:i:s", time());

if($xml && $id != null && $title != null && $creator_id != null)
{
    $logs = $xml -> logs -> log;

    foreach($logs as $log)
    {
        if($id == $log -> id)
        {
            $log -> title = $title;
            $log -> content = $content;
            $log -> meeting_date = $meeting_date;
            $log -> creator_id = $creator_id;
            $log -> created_at = $created_at;
        }
    }

    $file = @fopen("../xml/{$filename}", 'w');
    @fwrite($file, $xml -> asXML());
    @fclose($file);
}

header('Location: ./show.php?id=' . $id);

?>