# spam_block
moodleのEメールによる自己登録スパムを防ぐためのプラグイン

## 動作環境
moodle 3.11+
mysql 8.0.25
> **Warning**
> データベースが`postgresql`の場合動作しません.

## インストール
cd <moodle directory>/auth
git clone https://github.com/j19201/spamblockbeta.git spamblock
chown -R apache: spamblock
