<?php
  // データベースに接続
  $mysqli = new mysqli('localhost', 'root', 'root', 'skillup-bbs');
  // 接続エラーを表示
  if ($mysqli->connect_error){
    echo "接続失敗：" . $mysqli->connect_error;
    exit();
  }
  // データが送信されていた場合は登録する
  if (isset($_GET['username']) && isset($_GET['message'])) {
    $username = $_GET['username'];
    $message = $_GET['message'];

    // プリペアステートメントとして用意
    $stmt = $mysqli->prepare('INSERT INTO messages (username, message) VALUES (?, ?)');
    // パラメータを設定
    $stmt->bind_param('ss', $username, $message);
    // SQLを実行
    $stmt->execute();
  }
?>

<!-- View部分 -->
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Skillup 掲示板</title>
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
</head>
<body>
  <div class="container">
    <div class="jumbotron">
      <!-- 送信フォーム -->
      <form action="" method="GET">
        <div class="form-group">
          <label for="inputUsername">ユーザー名</label>
          <input type="text" name="username" id="inputUsername" class="form-control" value="<?php echo $username ?>" placeholder="ユーザー名を入力">
        </div>
        <div class="form-group">
          <label for="inputMessage">メッセージ</label>
          <textarea name="message" id="inputMessage" class="form-control" placeholder="メッセージを入力"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">送信</button>
      </form>
    </div>
    <!-- 掲示板 -->
    <?php
      $result = $mysqli->query('SELECT * FROM messages ORDER BY created DESC');
      if ($result) {
        while ($row = $result->fetch_object()) {   
    ?>
      <div class="panel panel-default">
        <div class="panel-body">
          【 <?php echo htmlspecialchars($row->username) ?> 】
          <?php echo htmlspecialchars($row->message) ?>
          ( <?php echo htmlspecialchars($row->created) ?> )
        </div>
      </div>
    <?php
        }
      }
    ?>
  </div>
</body>
</html>

<?php
  // データベースから接続
  $mysqli->close();
?>