## ch3

- コントローラーの作成は `php artisan make:contoroller <controller_name> --test` 。 `--test` オプションを付けるとコントローラーと同時にテストファイルも作成してくれる。
- ルーティングにprefixを設定できる. [Laravelのroutingでprefixにパラメーターを入れる事ができる](https://qiita.com/kazuhei/items/fa7826c31a3767217aa9), [Route Prefixes](https://laravel.com/docs/12.x/routing#route-group-prefixes)
- ルートに名前を付ける。[Named Routes](https://laravel.com/docs/12.x/routing#named-routes)
- viewのテスト [Testing View](https://laravel.com/docs/12.x/http-tests#testing-views)
- htmlのテストはちょっとしんどい [PHP Laravel の HTTP テストで HTML のテストを書くときの書き方](https://www.utakata.work/entry/2022/07/29/223537)
- `$response->assertSeeHtml($value)` や `$response->assertSeeHtmlInOrder(array $values)` は一見問題なさそうだが、ちょっとした表記ブレがあっても通るべきテストが落ちたり、落ちるべきテストが通ったりする。

```php
// <title>Home</title>
// <title>Home Page</title>
// どちらも通ってしまう
$response = $this->get(route('home'));
$response->assertSeeHtmlInOrder(['<title>', 'Home', '</title>']);

// <title>Home</title>
// <title>Home </title>
// 後者のように余分なスペースが含まれると通らない
$response = $this->get(route('home'));
$response->assertSeeHtml('<title>Home</title>');
```

- 今回はとりあえず `$response->assertSeeHtmlInOrder(array $values)` でテストを書いていく。

- テストのsetup関数の書き方

```php
protected function setUp(): void
{
    parent::setUp();
}
```

- シグネチャは完全に一致させる必要がある。（返り値も明示的に指定する）
- laravelのPHPUnitはおそらく各ライフサイクルで自前の対応する関数(setUp()やtearDown())を叩いているので、オーバーライドしていない親のメソッドも呼び出す必要がある。

- htmlのヘッドの置き換え

```erb
<head>
    <%= csrf_meta_tags %>
    <%= csp_meta_tag %>
    <%= stylesheet_link_tag ... %>
    <%= javascript_importmap_tags %>
</head>
```

```blade.php
<head>
    <%= csrf_meta_tags %>
    <%= csp_meta_tag %>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
```

- view側のリソースはデフォルトでインストールされるviteで管理できる
- cspは一旦設定せずに後々ちゃんと調べる
- [laravel-cspでLaravelでCSPを設定する](https://tamakoma.com/blog/laravel-csp/)
- [csrf](https://laravel.com/docs/12.x/csrf#main-content)


- formatterはPintというものがデフォルトでインストールされる[LaravelのFormatter(Pint)の導入](https://qiita.com/aosan/items/333d048f412bc293dc53)
- blade のフォーマッタはよくわかってないので[Laravel Blade formatter](https://marketplace.visualstudio.com/items?itemName=shufo.vscode-blade-formatter)というアドオンを使用する