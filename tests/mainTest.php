<?php
/**
 * Test for px2-search-bots-headers
 */

class mainTest extends PHPUnit_Framework_TestCase{

	/**
	 * setup
	 */
	public function setup(){
		$this->fs = new \tomk79\filesystem();
		require_once(__DIR__.'/helper/helper.php');
		$this->helper = new tests_helper_helper();
	}

	/**
	 * プレビュー表示時のテスト
	 */
	public function testPreview(){

		// トップページの出力コードを検査
		$indexHtml = $this->helper->passthru( [
			'php',
			__DIR__.'/testdata/standard/.px_execute.php' ,
			'-u', 'Mozilla/0.5',
			'/index.html' ,
		] );
		// var_dump($indexHtml);

		$this->assertTrue( 1 < strpos( $indexHtml, '<meta name=”robots” content="noindex, nofollow" />' ) );


		// 後始末
		$output = $this->helper->passthru( [
			'php',
			__DIR__.'/testdata/standard/.px_execute.php' ,
			'/?PX=clearcache' ,
		] );

	}//testPreview()

}
