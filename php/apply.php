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
		$cond = array();
		$cond['follow'] = true;
		$cond['index'] = false;
		$cond['archive'] = null;

		$meta = $this->meta_tag($cond);

		$src = preg_replace('/(<\/head>)/si', $meta.'$1', $src);

		return $src;
	}


	/**
	 * meta content 文字列を生成する
	 * @return string meta content string.
	 */
	private function meta_content( $cond = null ){
		if( !is_array($cond) ){
			return '';
		}
		$strs = array();
		foreach($cond as $key=>$val){
			switch( strtolower($key) ){
				case 'index':
				case 'follow':
				case 'archive':
					$str = $this->val_to_str($key, $val);
					if( strlen($str) ){
						array_push($strs, $str);
					}
					break;
			}
		}
		return implode(',', $strs);
	}

	/**
	 * meta content 値となる文字列を得る
	 * @return string string.
	 */
	private function val_to_str( $key, $val ){
		$bool = utils::to_boolean($val);
		if( $bool === true ){
			return $key;
		}elseif( $bool === false ){
			return 'no'.$key;
		}
		return '';
	}

	/**
	 * meta 要素を生成する
	 * @return string meta content string.
	 */
	private function meta_tag( $cond = null ){
		$meta_content = $this->meta_content($cond);
		$meta = '<meta name=”robots” content="'.htmlspecialchars($meta_content).'" />';
		return $meta;
	}

}
