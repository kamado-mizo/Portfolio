<!-- 学科紹介文入力確認ページ -->

<html>
 
<head>
    
<!--    DB接続用のPHPファイルを読み込む-->
    <?php 
        include('./php/dbcon.php');
    ?>
    
<title>PepperOCS</title>

<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta charset="UTF-8"> 
<meta name="description" content="PepperOCS">
<meta name="author" content="Copyright c 2018 TeamOSASHIMI All Rights Reserved.">
<meta name="viewport" content="width=device-width, initial-scale=1">
 
<!-- スタイルシートURIを記述 -->
<link rel="stylesheet" href="style/mainStyle.css">
<!-- ファビコンファイルのURIを記述 -->
<link rel="shortcut icon" href="">

<!-- スクリプトでブロッキングを起こさないものはここに記述
     可能であれば「async（文書の読み込みが完了した時点でスクリプトを実行）」を使用
     例: <script src="" async></script> -->
</head>
    
    <body>
        <form action = "schoolintroductdetail.php" method = "post">
    <p id="title">PepperOCS 学科紹介内容確認</p>
    <p id="subtitle">by TeamOSASHIMI</p>
            <?php
    
            $department = $_POST["department"];
            $beforeInformation = $_POST["inputtext"];
            $colorpicker = $_POST["colorpicker"];
            $selectType = $_POST["select"];
            global $count;
            
            $information = spaceReplace($beforeInformation);
            
            if($selectType == "新規登録"){
                $con = dbconnect();
                $sql = "SELECT COUNT(*) AS selectcount FROM school_introduction WHERE department = '{$department}'";
                $sqlCheck = sqlCheck($department,$information);
                $spaceCheck = spaceCheck($department);//空白文字が無かったら0が返ってくる
                if($spaceCheck == "NG"){ //学科名にスペースが入っていた時
                    echo "<p id=\"manual\">学科名にスペースは使わないでね</p>";
                    returnButton();//戻るボタンの描写
                } else {//空白チェックはOKだった時の処理
                    if($sqlCheck == 0){//不正文字が入力されてない時
                        $result = sqlsrv_query($con,$sql);
                        $row = sqlsrv_fetch_array($result);
                        $count = $row["selectcount"];
                        if($count > 0){//すでに登録されている学科だった場合
                            echo "<p id=\"manual\">すでに登録されている学科です</p>";
                            returnButton();//戻るボタンの描写
                            echo "<input type=\"hidden\" name=\"error\" value=\"エラー\">";
                        } else {//学科名の重複がなかった時の処理
                
                            if((empty($information)) or (empty($department))){//空欄があったら
                    
                                echo "<p id=\"manual\">空欄があります</p>";
                                returnButton();//戻るボタンの描写
                                echo "<input type=\"hidden\" name=\"error\" value=\"エラー\">";
                    
                            } else if(strpos($department,'学科')) {//入力された文字列に'学科'が含まれていた場合
                    
                                echo "<p id=\"manual\">学科名に学科が入力されています。省いてください。";
                                echo "<input type=\"hidden\" name=\"insertDepartment\" value=\" {$department}\">";
                                echo "<input type=\"hidden\" name=\"error\" value=\"エラー\">";
                                returnButton();//戻るボタンの描写
                    
                            } else {//文字列に学科が含まれていなかったら
                      
                                $result = insert($department,$information,$colorpicker);
                    
                                if ($result === false){//クエリ実行がちゃんとできてなかたら
                                    echo "<p id=\"manual\">うまく登録ができませんでした。</p>";
                                    returnButton();//戻るボタンの描写
                                    echo $department;
                                    echo $count;
                                } else {//登録が成功した場合
                                    echo "<p id=\"manual\">下記の内容で登録しました。</p>";
                                    echo "<h3 id=\"manualTitle\">学科名</h3>";
                                    echo "<p class=\"previewtext\">{$department}</p>";
                                    echo "<h3 id=\"manualTitle\">学科カラー</h3>";
                                    echo "<div style=\"width:100px;height:100px;background:{$colorpicker};margin-left:auto;margin-right:auto;\"></div>";
                                    echo "<h3 id=\"manualTitle\">説明文</h3>";
                                    echo "<p class=\"previewtext\">{$beforeInformation}</p>";
                                    returnButton();//戻るボタンの描写

                                }//登録が成功した場合の締め
                            }//文字列に学科が含まれてなかったらの締め
                        }//学科名の重複がなかった時の締め
                    } else { //SQLインジェクションチェックで引っかかった場合
                        echo "<p id=\"manual\">不正文字列が含まれています。</p>";
                        returnButton();//戻るボタンの描写
                    }
                }
                } else { //データの更新をする場合
                    $sqlCheck = sqlCheck($department,$information);
                    if($sqlCheck == "OK"){
                        if(empty($information) == false){
                            $result = update($department,$information,$colorpicker);
                            if ($result === false) {
                                echo "<p id=\"manual\">うまく更新ができませんでした。</p>";
                            } else {//更新が成功した場合
                                echo "<h2 id=\"manual\">下記の内容で更新しました。</h2>";
                                echo "<h3>学科名</h3>";
                                echo "<p class=\"previewtext\">{$department}</p>";
                                echo "<h3>学科カラー</h3>";
                                echo "<div style=\"width:100px;height:100px;background:{$colorpicker};margin-left:auto;margin-right:auto;\"></div>";
                                echo "<h3>説明文</h3>";
                                echo "<p class=\"previewtext\">{$beforeInformation}</p><br/><br/>";
                                returnButton();//戻るボタンの描写
                            }
                        }else{
                            echo "<p id=\"manual\">空欄があります</p>";
                            returnButton();//戻るボタンの描写
                            echo "<input type=\"hidden\" name=\"error\" value=\"エラー\">";
                        }
                    }else{//SQLインジェクションチェックで引っかかった場合
                        echo "<p id=\"manual\">不正文字列が含まれています。</p>";
                        returnButton();//戻るボタンの描写
                    }   
                }

            
            
            ?>
    
   
    </body>
</html>
    
<?php 
    //データ更新用の関数
    function update($department,$information,$colorcode){
        $con = dbconnect();
        $sql = "UPDATE school_introduction SET information = '{$information}',colorcode = '{$colorcode}' WHERE department = '{$department}'";
        $result = sqlsrv_query($con, $sql);
        
        return $result;
    }
    //データ登録用の関数
    function insert($department,$information,$colorcode){
        $con = dbconnect();
        $sql = "INSERT INTO school_introduction VALUES('{$department}','{$information}','{$colorcode}')";
        $result = sqlsrv_query($con, $sql);
        return $result;
    }
    
    //重複登録確認用の関数
    function overlapCheck($department){
        $con = dbconnect();
        $sql = "SELECT COUNT(*) AS selectcount FROM school_introduction WHERE department = '{$department}'";
        $result = sqlsrv_query($con,$sql);
        return $result;
    }
    
    //SQLインジェクションチェック用の関数
    function sqlCheck($department,$information){
        
        $checkResult = "OK";    
        //学科名のチェック '  " = * % の中のいずれかの文字が含まれているか調べる
        $checkCount = preg_match("/['\"=*%]/",$department);

        if(0 < $checkCount){//学科名にサニタイジング対象文字が含まれていた場合
            $checkResult = "NG";
            return $checkResult;
        } else{//学科名は大丈夫だった場合
            //紹介文のチェック　'  " = * % の中のいずれかの文字が含まれているか調べる
            $checkCount = preg_match("/['\"=*%]/",$information);
            if(0 < $checkCount){
                $checkResult = "NG";
                return $checkResult;
            }
        }
        return $checkResult;

    }
    
    //スペースチェック
    function spaceCheck($department){
        $checkResult = "OK";
        $pattern = "/( |　)+/";
        $checkCount = preg_match($pattern,$department);
        if(0 < $checkCount){
            $checkResult = "NG";
            return $checkResult;
        }
        return $checkResult;
        
    }

    //戻るボタンの描写
    function returnButton(){
        echo " <input type=\"button\" id=\"button02\" value=\"戻る\"
        onclick=\"location.href='schoolintroduct.php'\">";
    }
        
    //改行文字を削除する
    function spaceReplace($str){
        
        $replaceStr = str_replace(array("\r", "\n"),"",$str);
        
        return $replaceStr;
    }
    
    
?>