<?php

$filename = 'ykmlog.xml';
$xml = new SimpleXMLElement("../xml/{$filename}", 0, true);
$id = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '';
$result = array();

$result = array();

if($xml && $id != null)
{
    $logs = $xml -> logs -> log;

    foreach($logs as $log)
    {
        if($id == $log -> id)
        {
            $result['title'] = $log -> title;
            $result['content'] = $log -> content;
            $result['meeting_date'] = $log -> meeting_date;
            $result['creator_id'] = $log -> creator_id;
            $result['created_at'] = $log -> created_at;
        }
    }
}

?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title><?php echo $result[0]['title']; ?></title>
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
                <article>
                    <?php
                        echo "<h2 class='title'>{$result['title']}</h2>";
                        echo "<p class='content'>{$result['content']}</p>";
                        echo "<p class='meeting_date'>" . date('Y-m-d', strtotime($result['meeting_date'])) . "</p>";
                        echo "<p class='creator_id'><span class='" . setClassAndLogo($result['creator_id']) . "'></span></p>";
                        echo "<p class='btnOfText'><button onclick='location.href=\"./edit.php?id=$id\"'>編集</button></p>";

                        function setClassAndLogo($c_id)
                        {
                            $str = '';
                            switch($c_id)
                            {
                                case 0: $str = 'fas fa-mountain yama'; break;
                                case 1: $str = 'fas fa-water kawa'; break;
                                case 2: $str = 'fas fa-seedling mori'; break;
                            }
                            return $str;
                        }
                    ?>
                </article>
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