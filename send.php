<?php
// ユーザー名とメッセージが送信されていたら実行する
if (isset($_GET['username']) && isset($_GET['message'])) {
  $username = $_GET['username'];
  $message = $_GET['message'];

  echo $username;
}

// // プリペアステートメントとして用意
// $stmt = $mysqli->prepare('INSERT INTO messages (username, message) VALUES (?, ?)');
// // パラメータを設定
// $stmt->bind_param('ss', $username, $message);
// // SQLを実行
// $stmt->execute();

header('Location: index.php');
