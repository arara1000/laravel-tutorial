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

## ch4
- ヘルパー関数の作り方には色々あるが、今回は`app/Helpers/Helper.php`内の`Helper`クラスを作成し、そのstaticメソッドとして実装した。本来はロジック部分の汎用的なヘルパー関数を追加する場所かも
- 他にも色々ある
    - [View Composers](https://laravel.com/docs/12.x/views#view-composers) : viewがレンダリングされる際に呼び出される。view用のロジックはここで定義するのがlaravelっぽい？
    - [Raw PHP](https://laravel.com/docs/12.x/blade#raw-php): メソッドとして定義しなくても、bladeは関数を直接インポートできる

- PHPコード内から`@yield`を呼び出せないので、`Illuminate\Support\Facades\View::getSection`でセクションを読み込む

```php
// これだとエラーが発生する
<title>{{ Helper::fullTitleHelper(@yield('title')) }}</title>

// これは問題ない
<title>{{ Helper::fullTitleHelper(View::getSection('title')) }}</title>
```

## デプロイ
- ~~公式を参考にデプロイする~~
- https://render.com/docs/deploy-php-laravel-docker
- ~~imageは古めだがちゃんと成功した~~
- ~~`vite build` でフロント用のファイルをビルドする必要がある。~~
- 失敗し続けるので一旦デプロイはなし
- ローカルでも *500 Server Error* が出たり出なかったりして今の知識では原因がわからない。
- `docker compose up --build` 後にコンテナを落として再度 `docker compose up` すると *500 Server Error* になったりならなかったりする。
- render.com側はずっと Server Error 
- log [Render.com側](./memolog/failed_deploy_from_render.log.text), [local側](./memolog/failed_compose_up.text)

## ch5 レイアウトを作成する

- styling は `tailwind.css`を利用する（デフォルトでインストールされていたため）
- そんなに気合は入れずにそれっぽい感じのスタイルで妥協する
- railsのパーシャルのような機能として[サブビュー](https://laravel.com/docs/12.x/blade#including-subviews)と[blade コンポーネント](https://laravel.com/docs/12.x/blade#components) があるが、簡単のために今回はサブビューを採用

>@include ディレクティブを自由に使用することは可能ですが、Blade コンポーネントを使用すると同様またはそれ以上の機能を利用でき、データバインディングや属性バインディングといった追加の利点が得られます。

- DOMに対するアサーションは素のlaravelとPHPUnitだと再現できなさそう

```ruby:rails
  test "layout links" do
    get root_path
    assert_template 'static_pages/home'
    assert_select "a[href=?]", root_path, count: 2
    assert_select "a[href=?]", help_path
    assert_select "a[href=?]", about_path
    assert_select "a[href=?]", contact_path
  end
```

```php:laravel
    public function layout_links(): void
    {
        $response = $this->get(route('root'));
        $response->assertViewIs('static_pages.home');
        $response->assertSeeHtml('href="' . route('root'));
        $response->assertSeeHtml('href="' . route('help'));
        $response->assertSeeHtml('href="' . route('about'));
        $response->assertSeeHtml('href="' . route('contact'));
    }
```

- 