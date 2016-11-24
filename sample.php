
<?php
// phpQueryの読み込み
require_once("./phpQuery-onefile.php");

// HTMLデータを取得する
$HTMLData = file_get_contents('http://person-link.co.jp/');

// HTMLをオブジェクトとして扱う
$phpQueryObj = phpQuery::newDocument($HTMLData);



// 続きから

// h1タグを片っ端から取得
$titleArr = $phpQueryObj['h1'];
$titleP = $phpQueryObj['class'];

// ただの配列なのでぶん回す
foreach($titleArr as $val) {
    // pq()メソッドでオブジェクトとして再設定しつつさらに下ってhrefを取得
    echo pq($val)->find('a')->attr('href').PHP_EOL;
}




// h1タグを片っ端からぶん回す
foreach($phpQueryObj['h1'] as $val) {
    // 連続実行すると怒られちゃうのでとりあえず5秒待機
    sleep(5);

    // pq()メソッドでオブジェクトとして再設定しつつさらに下ってhrefを取得
    $title = pq($val)->find('p')->text();
    $url = pq($val)->find('a')->attr('href');
    echo 'タイトル：' . $title . PHP_EOL;
    echo 'ページURL：'. $url . PHP_EOL;
    getChiledPage($url);

    echo PHP_EOL.PHP_EOL;
}

/**
* もろもろ競合しちゃうと嫌なので関数化
* 小見出しを取得して出力
* @param string $url 子ページのURL
*/
function getChiledPage($url) {
    // ページを取得してオブジェクト化！
    $phpQueryObj = phpQuery::newDocument(file_get_contents($url));

    // ループでぶん回す
    foreach($phpQueryObj['h2'] as $i => $val) {
        $komidashi = pq($val)->text();
        echo '小見出し['. $i .']：' . $komidashi . PHP_EOL;
    }
}
?>