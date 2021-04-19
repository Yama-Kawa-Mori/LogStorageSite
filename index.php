<?php

$filename = 'ykmlog.xml';
$xml = new SimpleXMLElement("./xml/{$filename}", 0, true);
$query = !(isset($_GET['all'])) && isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '';
$result = array();

if($xml)
{
    $logs = $xml -> logs -> log;

    $n = 0;
    foreach($logs as $log)
    {
        if($query == '' || ($query != '' && preg_match("/$query/", $log -> title)))
        {
            $result[$n]['id'] = $log -> id;
            $result[$n]['title'] = $log -> title;
            $result[$n]['content'] = $log -> content;
            $result[$n]['meeting_date'] = $log -> meeting_date;
            $result[$n]['creator_id'] = $log -> creator_id;
            $result[$n]['created_at'] = $log -> created_at;
            $n++;
        }
    }

    for($i = 0; $i < count($result) - 1; $i++)
    {
        for($j = 0; $j < count($result) - 1; $j++)
        {
            if(strtotime($result[$j]['meeting_date']) < strtotime($result[$j + 1]['meeting_date']))
            {
                $r = $result[$j];
                $result[$j] = $result[$j + 1];
                $result[$j + 1] = $r;
            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>山と川と森 メンバー専用サイト</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@200&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="./css/style.css">
        <script src="https://kit.fontawesome.com/1ba927dfc7.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="container">
            <header>
                <h1><a href="./index.php"><span>山と川と森</span><span>メンバー専用サイト</span></a></h1>
            </header>
            <main>
                <table id="logs">
                    <?php

                    function setLogo($num)
                    {
                        $str = '';
                        switch($num)
                        {
                            case 0: $str = 'fas fa-mountain'; break;
                            case 1: $str = 'fas fa-water'; break;
                            case 2: $str = 'fas fa-seedling'; break;
                        }
                        return $str;
                    }

                    function setClass($num)
                    {
                        $str = '';
                        switch($num)
                        {
                            case 0: $str = 'yama'; break;
                            case 1: $str = 'kawa'; break;
                            case 2: $str = 'mori'; break;
                        }
                        return $str;
                    }
                    
                    if($result != '' && $result != null)
                    {
                        for($i = 0; $i < count($result); $i++)
                        {
                            echo "<tr class=" . setClass($result[$i]['creator_id']) . ">";
                            echo "<th class='title' colspan='2'><a href='./Controllers/show.php?id={$result[$i]['id']}'>{$result[$i]['title']}</a></th>";
                            echo "</tr>";
                            echo "<tr class=" . setClass($result[$i]['creator_id']) . ">";
                            echo "<td class='content' colspan='2'><a href='./Controllers/show.php?id={$result[$i]['id']}'>{$result[$i]['content']}</a></td>";
                            echo "</tr>";
                            echo "<tr class=" . setClass($result[$i]['creator_id']) . ">";
                            echo "<td class='meeting_date'><a href='./Controllers/show.php?id={$result[$i]['id']}'>" . date('Y-m-d', strtotime($result[$i]['meeting_date'])) . "</a></td>";
                            echo "<td class='creator_id'><a href='./Controllers/show.php?id={$result[$i]['id']}'><span class='" . setLogo($result[$i]['creator_id']) . "'></span></a></td>";
                            echo "</tr>";
                            echo "<tr><td colspan='2'></td></tr>";
                        }
                    }

                    ?>
                </table>
            </main>
            <footer>
                <table id="menu">
                    <tr>
                        <td><button onclick="Search();">検索</button></td>
                        <td><button onclick="location.href='./index.php?all=true'">すべて表示</button></td>
                    </tr>
                    <tr>
                        <td><button onclick="location.href='./Controllers/create.php'">議事録作成</button></td>
                        <td><button onclick="toHomepageCheck();">ホームページ</button></td>
                    </tr>
                </table>
            </footer>
        </div>

        <script src="./script/script.js"></script>
    </body>
</html>