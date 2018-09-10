<!-- 学科紹介文入力ページ -->

<html>
 
<head>
    
<!--    DB接続用のPHPファイルを読み込む-->
    <?php 
        include('dbcon.php');
    ?>
    
<title>PepperOCS</title>

<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta charset="UTF-8"> 
<meta name="description" content="PepperOCS">
<meta name="author" content="Copyright c 2018 TeamOSASHIMI All Rights Reserved.">
<meta name="viewport" content="width=device-width, initial-scale=1">
 
<!-- スタイルシートURIを記述 -->
<link rel="stylesheet" href="mainStyle.css">
<!-- ファビコンファイルのURIを記述 -->
<link rel="shortcut icon" href="">

<!-- スクリプトでブロッキングを起こさないものはここに記述
     可能であれば「async（文書の読み込みが完了した時点でスクリプトを実行）」を使用
     例: <script src="" async></script> -->
</head>
<body>
    <form action = "schoolintroductupdate.php" method = "post">
    <p id="title">PepperOCS 学科紹介内容設定</p>
    <p id="subtitle">by TeamOSASHIMI</p>

<p id="manual">学科名</p>
<?php 
        //グローバル変数の宣言
        global $department;
        $department = $_POST["department"];
        $insertDepartment = $_POST["insertDepartment"];
        $error = $_POST["error"];
        echo $error;
        if($error == "エラー" or $department == "新規登録"){//新規登録の時の処理
            echo "<p id=\"manual\">学科は省き、学科名のみ入力してください</p>";
            echo "<input type=text name=\"department\" id=\"department\" value=\"{$insertDepartment}\">学科";
            echo "<p id=\"manual\">学科カラー : <input type=\"color\" name=\"colorpicker\" id=\"colorPick\"></p>";
            echo "<textarea id=\"inputtext\" name=\"inputtext\" placeholder=\"ここに学科の紹介文を入力してください\"></textarea>";
            echo "<input type=hidden name=\"select\" value=\"新規登録\">";
            
        }else{//情報を更新するときの処理
            $con = dbconnect();
//            選択した学科の情報をDBから取得
            $sql = "SELECT * FROM school_introduction WHERE department = '{$department}'";
            $result = sqlsrv_query($con, $sql);
            $row = sqlsrv_fetch_array($result);
            $information = $row['information'];
            $colorcode = $row['colorcode'];
//            学科名のテキストエリアに選択学科を表示、変更はできない設定
            echo "<input type=text  id=\"department\"  value=\"{$department}\" disabled = \"disabled\">学科";
            echo "<input type=hidden name=\"department\" value = \"{$department}\">";
//            カラーコードピッカー
            echo "<p id=\"manual\">学科カラー : <input type=\"color\" name=\"colorpicker\" value =\"{$colorcode}\" id = \"colorPick\"></p>";
//            紹介文テキストエリア
            echo "<p id=\"manual\">学科紹介文</p>";
            echo "<textarea id=\"inputtext\" name=\"inputtext\">{$information}</textarea>";
            echo "<input type=hidden name=\"select\" value=\"{$department}\">";

        }

//<!--学科選択プルダウン終わり-->
echo "<br/>";  
echo "<br/>";
echo "<input type=\"button\" id=\"button02\" value=\"戻る\" onclick=\"location.href='schoolintroduct.php'\">";
echo "<input type=\"submit\" name=\"send\" id=\"button02\" value=\"送信\" >";
echo "</form>";
//<!--    学科削除確認画面にポストする-->
echo "<form action = \"schoolintroductdelete.php\" method = \"post\">";
if($department != "新規登録"){
    echo "<input type=\"submit\" name=\"delete\" id=\"button02\" value=\"削除\">";
}
echo "<input type=\"hidden\" name=\"department\" value=\"{$department}\">";
echo "</form>";
    ?>
</body>
</html>
