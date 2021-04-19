<?php

$filename = 'ykmlog.xml';
$xml = new SimpleXMLElement("../xml/{$filename}", 0, true);
$id = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '';

if($xml && $id != null)
{
    foreach($xml -> logs -> log as $log)
    {
        if($id == $log -> id)
        {
            $dom = dom_import_simplexml($log);
            $dom -> parentNode -> removeChild($dom);
        }
    }

    $file = @fopen("../xml/{$filename}", 'w');
    @fwrite($file, $xml -> asXML());
    @fclose($file);
}

header('Location: ../index.php');

?>