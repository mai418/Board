<!DOCTYPE>
<html>
    <head>
        <meta charset="utf-8">
    </head>
    <form action="" method="post">
        <h3>名前</h3>
        <input type="text" name="name">
        <h3>コメント</h3>
        <input type="text" name="comment">
        <h3>パスワード</h3>
        <input type="text" name="pass">
        <input type="submit" name="submit" value="送信">
        <h3>削除</h3>
        <input type="number" name="delete">
        <input type="submit" name="submit" value="削除">
        <h3>編集</h3>
        <input type="number" name="edit">
        <input type="text" name="text">
        <input type="submit" name="submit" value="編集">
        <h3>パスワード認証</h3>
        <input type="text" name="certify">
        <input type="submit" name="submit" value="認証">
    </form>
    <body>
        <?php
            // DB接続設定
            $dsn = 'mysql:dbname=tb240358db;host=localhost';
            $user = 'tb-240358';
            $password = 'ZSd8RabTgy';
            $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
            
            //テーブルの作成
            $sql = "CREATE TABLE IF NOT EXISTS tbtest"
            ." ("
            . "id INT AUTO_INCREMENT PRIMARY KEY,"
            . "name char(32),"
            . "comment TEXT"
            .");";
            $stmt = $pdo->query($sql);
            
            $name = $_POST["name"];
            $comment = $_POST["comment"];
            $num = $_POST["delete"];
            $edit= $_POST["edit"];
            $text= $_POST["text"];
            $pass= $_POST["pass"];
            $cerify=$_POST["certify"];
            if(TRUE){
                #新規投稿する場合
                if(!empty($_POST["comment"])&&!empty($_POST["name"])&&!empty($_POST["pass"])){
                    $sql = $pdo -> prepare("INSERT INTO tbtest (name, comment) VALUES (:name, :comment)");
                    $sql -> bindParam(':name', $name, PDO::PARAM_STR);
                    $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
                    //$sql -> bindParam(':pass', $pass, PDO::PARAM_STR);
                    //$name = '山田';
                    //$comment = 'コメント';  
                    $sql -> execute();
                #削除する場合
                if(!empty($_POST["delete"]) ){
                    //if($pass==$cerify) {
                    $id = $num;
                    echo $id;
                    $sql = 'delete from tbtest where id=:id';
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmt->execute();
                    //}
                }
                #編集する場合
                if(!empty($_POST["edit"])){
                    //if($pass==$cerify){
                        $id = $edit; //変更する投稿番号
                        $name = "（変更したい名前）";
                        $comment = "（変更したいコメント）"; //変更したい名前、変更したいコメントは自分で決めること
                        $sql = 'UPDATE tbtest SET name=:name,comment=:comment WHERE id=:id';
                        $stmt = $pdo->prepare($sql);
                        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                        $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
                        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                        $stmt->execute();
                    //}
                }
            }
            } 
            //表示
            $sql = 'SELECT * FROM tbtest';
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();
            foreach ($results as $row){
                //$rowの中にはテーブルのカラム名が入る
                echo $row['id'].',';
                echo $row['name'].',';
                echo $row['comment'].'<br>';
            echo "<hr>";
            }
        ?>
    </body>
</html>