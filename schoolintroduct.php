
<!-- 学科紹介文学科選択ページ -->

<html>
 
<head>
    
<!--DB接続用のPHPファイルを読み込む-->
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
    <p id="title">PepperOCS 学科紹介内容設定</p>
    <p id="subtitle">by TeamOSASHIMI</p>

    <p id="manual">学科名</p>

<!--学科選択のプルダウンメニュー-->
    <?php
    //dbconnectを呼び出してDBと接続する
    $con = dbconnect();
    $sql = "SELECT * FROM テーブル名";
    
    //クエリを実行する
    $result = sqlsrv_query($con, $sql);
    
     if( ($errors = sqlsrv_errors() ) != null) {
        foreach( $errors as $error ) {
            echo "SQLSTATE: ".$error[ 'SQLSTATE']."<br />";
            echo "code: ".$error[ 'code']."<br />";
            echo "message: ".$error[ 'message']."<br />";
        }
    }
    
    if($result === false){
        
        echo "取り出せてないよ";
            
    }else{
        echo "<form action=\"schoolintroductdetail.php\" method = \"post\">";                                                          
        echo "<select name = \"department\" id = \"departmentList\">";
        
        //
            while($row = sqlsrv_fetch_array($result)){
            $department = $row['department'];
                echo "<option>{$department}</option>";
            }
        echo "<option>新規登録</option>";
        echo "</select>";
    }
    dbclose($con,$result);
    
//学科選択プルダウン終わり
    echo "<p id=\"manual\">学科の新規登録をする場合は<br/>新規登録を選択してください。</p>";
    
    $department = $_POST["department"];
    
    ?>
    <br/>
    <input type="button" id="button02" value="戻る">
    <input type="submit" id="button02" value="選択">

    
    
    </form>
</body>
</html>