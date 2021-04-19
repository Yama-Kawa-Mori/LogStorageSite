<?php

$filename = 'ykmlog.xml';
$xml = new SimpleXMLElement("../xml/{$filename}", 0, true);

date_default_timezone_set('Asia/Tokyo'); // タイムゾーンを日本に設定

$title = isset($_POST['title']) ? htmlspecialchars($_POST['title']) : '';
$content = isset($_POST['content']) ? htmlspecialchars($_POST['content']) : '';
$meeting_date = isset($_POST['meeting_date']) ? htmlspecialchars($_POST['meeting_date']) . " 00:00:00" : "2021-01-01 00:00:00";
$creator_id = isset($_POST['creator_id']) ? htmlspecialchars($_POST['creator_id']) : '';
$created_at = date('Y-m-d H:i:s', time());

if($xml && $title != null && $creator_id != null)
{
    $logs = $xml -> logs -> log;
    $last = $logs[count($logs) - 1] -> id + 1;
    
    $newdata = $xml -> logs -> addChild('log', '');
    $newdata -> addChild('id', "$last");
    $newdata -> addChild('title', "$title");
    $newdata -> addChild('content', "$content");
    $newdata -> addChild('meeting_date', "$meeting_date");
    $newdata -> addChild('creator_id', "$creator_id");
    $newdata -> addChild('created_at', "$created_at");

    $file = @fopen("../xml/{$filename}", 'w');
    @fwrite($file, $xml -> asXML());
    @fclose($file);

    header('Location: ../index.php');
}

?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>新規作成</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@200&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="../css/style.css">
        <script src="https://kit.fontawesome.com/1ba927dfc7.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="container">
            <header>
                <h1><a href="../index.php"><span>山と川と森</span><span>メンバー専用サイト</span></a></h1>
            </header>
            <main>
                <form method="post" action="./create.php">
                    <fieldset>
                    <p><input class="title" type="text" name="title" title="タイトル" required></p>
                    <p><textarea class="content" name="content" title="本文"></textarea></p>
                    <p><input class="meeting_date" type="date" name="meeting_date" min="2021-01-01" max="2022-03-31" title="会議日程"></p>
                    <p class="creator_id" title="作成者">
                        <input class="radio" id="yama" type="radio" name="creator_id" value="0" required>
                        <label class="fas fa-mountain" for="yama"></label>
                        <input class="radio" id="kawa" type="radio" name="creator_id" value="1">
                        <label class="fas fa-water" for="kawa"></label>
                        <input class="radio" id="mori" type="radio" name="creator_id" value="2">
                        <label class="fas fa-seedling" for="mori"></label>
                    </p>
                    <p class='btnOfText'><input type="submit" value="作成"></p>
                    </fieldset>
                </form>
            </main>
            <footer>
                <table id="menu">
                    <tr>
                        <td><button onclick="location.href='../index.php'">トップページ</button></td>
                        <td><button onclick="toHomepageCheck();">ホームページ</button></td>
                    </tr>
                </table>
            </footer>
        </div>

        <script src="../script/script.js"></script>
    </body>
</html>