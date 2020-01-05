<?php
/**
 * px2-search-bots-headers
 */
namespace tomk79\pickles2\px2_search_bots_headers;

/**
 * apply.php
 */
class apply{

	/**
	 * Picklesオブジェクト
	 */
	private $px;

	/**
	 * mainオブジェクト
	 */
	private $main;

	/**
	 * constructor
	 * @param object $px Picklesオブジェクト
	 * @param object $main mainオブジェクト
	 */
	public function __construct( $px, $main ){
		$this->px = $px;
		$this->main = $main;
	}

	/**
	 * apply output filter
	 * @param string $src HTML, CSS, JavaScriptなどの出力コード
	 * @return string 加工後の出力コード
	 */
	public function append($src){

		$meta = '<meta name=”robots” content="noindex, nofollow" />';

		$src = preg_replace('/(<\/head>)/si', $meta.'$1', $src);

		return $src;
	}

}
