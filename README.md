# tomk79/px2-search-bots-headers

[Pickles 2](https://pickles2.pxt.jp/) に、検索ボット向けのメタ情報を制御する機能を追加します。


## セットアップ - Setup

### 1. インストール - Installation

Pickles 2 をセットアップしたあとに、次のコマンドを実行します。

```
$ composer require tomk79/px2-search-bots-headers;
```

### 2. processor->html に設定する

設定ファイル config.php (通常は `./px-files/config.php`) を編集し、次のように追記します。
テーマの後に実行されるように設定してください。

```php
$conf->funcs->processor->html = array(

    // 〜中略〜

    // px2-search-bots-headers
    // 検索ボット向けの制御メタ情報 を head要素内に追加する。
    'tomk79\pickles2\px2_search_bots_headers\main::append()' ,

    // 〜中略〜

);
```

### 3. sitemap を拡張

sitemap に次の列を追加します。

- `robots:follow`
- `robots:index`
- `robots:archive`


## 使い方 - Usage

sitemapに追加した拡張列に、各ページの設定を入力します。

- `on`、 `yes`、 `true`、 `1` のように入力した場合は、肯定の命令(例: `follow`) が出力されます。
- `off`、 `no`、 `false`、 `0` のように入力した場合は、否定の命令(例: `nofollow`) が出力されます。
- 空白か、列が未定義か、または `null` のように入力した場合は、出力されません。

3つの項目のうちの何れか1つ以上が設定されている場合、
`head` 要素の閉じタグの直前に、
`<meta name="robots" content="follow,noindex" />` のようなコードが出力されます。


## 更新履歴 - Change log

### tomk79/px2-search-bots-headers 0.1.0 (リリース日未定)

- Initial Release.


## ライセンス - License

MIT License


## 作者 - Author

- Tomoya Koyanagi <tomk79@gmail.com>
- website: <https://www.pxt.jp/>
- Twitter: @tomk79 <https://twitter.com/tomk79/>
