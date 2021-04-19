<?php

$filename = 'ykmlog.xml';
$xml = new SimpleXMLElement("../xml/{$filename}", 0, true);
$id = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '';
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
        <title>山と川と森 議事録まとめサイト 新規作成</title>
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
                <form method="post" action="./update.php?id=<?php echo $id; ?>">
                    <fieldset>
                        <?php
                            echo "<p><input class='title' type='text' name='title' value='{$result['title']}' title='タイトル' required></p>";
                            echo "<p><textarea class='content' name='content' title='本文'>{$result['content']}</textarea></p>";
                            echo "<p><input class='meeting_date' type='date' name='meeting_date' value='" . date('Y-m-d', strtotime($result['meeting_date'])) . "' min='2021-01-01' max='2022-03-31' title='会議日程'></p>";
                            echo "<p class='creator_id' title='作成者'>";
                            echo "<input class='radio' id='yama' type='radio' name='creator_id' value='0'" . isChecked($result['creator_id'], 0) . " required>";
                            echo "<label class='fas fa-mountain' for='yama'></label>";
                            echo "<input class='radio' id='kawa' type='radio' name='creator_id' value='1'" . isChecked($result['creator_id'], 1) . ">";
                            echo "<label class='fas fa-water' for='kawa'></label>";
                            echo "<input class='radio' id='mori' type='radio' name='creator_id' value='2'" . isChecked($result['creator_id'], 2) . ">";
                            echo "<label class='fas fa-seedling' for='mori'></label>";
                            echo "</p>";
                            echo "<p class='btnOfText'><input type='submit' value='更新'></p>";

                            function isChecked($c_id, $num)
                            {
                                $str = $c_id == $num ? ' checked' : '';
                                return $str;
                            }
                        ?>
                    </fieldset>
                </form>
                <form method="post" action="./delete.php?id=<?php echo $id; ?>" onsubmit="return Check();">
                    <p class='btnOfText'><input type="submit" value="削除"></p>
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