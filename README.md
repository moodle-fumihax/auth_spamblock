# spam_block
moodleのEメールによる自己登録スパムを防ぐためのプラグイン

## 動作環境
moodle 3.11+
mysql 8.0.25
> **Warning**
> データベースが`postgresql`の場合動作しません.

## インストール
```
# cd <moodle directory>/auth
# git clone https://github.com/moodle-fumihax/auth_spamblock.git spamblock
# chown -R apache: spamblock
```

## 設定
- サイト管理 － プラグイン － 認証 － 認証管理 － 自己登録
