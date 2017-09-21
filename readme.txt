
トリガーは「motion」というプログラム
 http://www.lavrsen.dk/foswiki/bin/view/Motion/WebHome
WEBカメラで動体検知してくれる


/etc/motion/motion.conf
　動体検知したらスクリプト(1)を実行するよう設定しておく
　
 設定
 http://safe-linux.homeip.net/web/motion/motion-03.html

事前に
　slackのトークン取得
　LINEAPIのアカウント登録
　LINEAPIのアクセストークン取得
などが必要

=== 通知処理
(1)post2slack4image.php
　
　Slackへ、検知した画像をアップロードする
　
　アップロードした画像を公開設定にする（画像のURLがLINEAPIのパラメータで必要なため）
　※Slackを介しているが、LINEAPIに直接画像ファイルを送れるならばSlackへの画像アップロードは不要
　
　スクリプト(2)を実行しLINEAPI経由で画像を通知する
　
(2)pushImage.php
　必要なリクエストパラメータをセットしてLINEAPIをコールする


=== アカウント追加
(3)callback.php
LINEアカウント追加した際に呼び出される。
sqliteにLINEIDなどを保存している。
(2)のリクエストパラメータのTOを改造して、保存したLINEID分処理を繰り返せれば、全員に送れる

=== テスト用
(4)push.php
メッセージ通知テスト

