<?php
/**
 * px2-search-bots-headers
 */
namespace tomk79\pickles2\px2_search_bots_headers;

/**
 * main.php
 */
class main{

	/**
	 * Picklesオブジェクト
	 */
	private $px;

	/**
	 * 検索ボット向けの制御メタ情報 を head要素内に追加する。
	 *
	 * @param object $px Picklesオブジェクト
	 */
	public static function append( $px, $plugin_conf ){
		$me = new self( $px );
		$apply = new apply( $px, $me );
		$key = 'main';
		$src = $px->bowl()->get_clean( $key );
		$src = $apply->append($src);
		$px->bowl()->replace( $src, $key );
	}

	/**
	 * constructor
	 * @param object $px Picklesオブジェクト
	 */
	public function __construct( $px ){
		$this->px = $px;
	}

}
