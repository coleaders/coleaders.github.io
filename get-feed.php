<?php
 
	// ライブラリの読み込み
	require_once "feed.php" ;
 
	// 取得するフィードのURLを指定
	$url = "https://note.com/shihotan/rss" ;
 
	// インスタンスの作成
	$feed = new Feed ;
 
	// RSSを読み込む
	$rss = $feed->loadRss( $url ) ;
 
	// HTML表示用
	$html = '' ;
 
	$MAX_feed = 6;// 表示させる件数
	$feed_count = 0; $feed = new Feed ; $rss = $feed->loadRss( $url ) ;
 
 
	foreach( $rss->item as $item ){
		if ($feed_count >= $MAX_feed) { break; }
		// 各エントリーの処理
		$feed_count++;
 
		$title = $item->title ;	// タイトル
		$link = $item->link ;	// リンク
		$description = $item->description ;	// 詳細
 
 
		// 日付の取得(UNIX TIMESTAMP)
		foreach( array( "pubDate" , "date_timestamp" , "dc:date" , "published" , "issued" ) as $time )
		{
			if( isset( $item->{ $time } ) && !empty( $item->{ $time } ) )
			{
				$timestamp = ( is_int( $item->{ $time } ) ) ? $item->{ $time } : strtotime( $item->{ $time } ) ;
				break ;
			}
		}
 
 
		// 仮に日付が取得できなかったら現在時刻を表示
		if( !isset( $timestamp ) )
		{
			$timestamp = time() ;
		}
 
		// 表示
		$html .= '<dl><dt><a href="' . $link . '" target="_blank"><img src="'. $item->children('media',true)->thumbnail . '"></a></dt><dd><a href="' . $link . '" target="_blank">' . $title . '</a></dd></dl>' ;
	}
?>
 
 
<?php echo $html ?>