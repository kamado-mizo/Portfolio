<?php
/*
dbcon@phpScript
by Relief@shimamura

*使用に際して*
    クエリを実行するコード
    //クエリーを実行
        $result = sqlsrv_query($conn, "SQL文");
        
    結果開放、およびコネクションクローズするコード
    ※利用後には必ず実行すること
        dbclose($コネクション, $結果リソース)
*/

//データベースを接続
//戻り値$conn:接続したコネクション


//必要に応じて変更を加えてください
function dbconnect(){
    $serverName = "サーバ名";
    //接続情報を指定
    $connectionInfo = array(
                "UID"=>"sa",
                "PWD"=>"",
                "Database"=>"データベース名",
                "CharacterSet"=>"UTF-8");
    $conn = sqlsrv_connect($serverName, $connectionInfo);
    
    return $conn;
}

function dbclose($conn, $result){
    //クエリー結果の開放
       // sqlsrv_free_stmt($result);
    //コネクションのクローズ
        sqlsrv_close($conn); 
}
?>