<!--レコード削除確認画面-->

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
    <p id="title">PepperOCS 学科データ削除確認画面</p>
    <p id="subtitle">by TeamOSASHIMI</p>
    
    
    <?php 
    
    $department = $_POST["department"];
    //削除用関数の実行
    $result = delete($department);
    
    if($result === false){//クエリの実行結果がfalseだった場合
        
        echo "<p>うまく削除できませんでした</p>";
        echo "<p>{$department}学科</p>";
        
    } else {
        echo "<h3 id=\"manual\">以下の学科を削除しました。</h3>";
        echo "<p>{$department}学科</p>";
        echo " <input type=\"button\" id=\"button02\" value=\"戻る\"
        onclick=\"location.href='schoolintroduct.php'\">";
    }

    
    ?>


</body>
</html>


<?php 
//データ削除用関数
    function delete($department){
        $con = dbconnect();
        $sql = "DELETE FROM school_introduction WHERE department = '{$department}'";
        $result = sqlsrv_query($con,$sql);
        
        $result;
    }

?>