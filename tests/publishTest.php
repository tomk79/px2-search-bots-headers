<?php
/**
 * Test for px2-search-bots-headers
 */

class publishTest extends PHPUnit_Framework_TestCase{

	/**
	 * setup
	 */
	public function setup(){
		$this->fs = new \tomk79\filesystem();
		require_once(__DIR__.'/helper/helper.php');
		$this->helper = new tests_helper_helper();
	}

	/**
	 * パブリッシュ後に出力されたdistコードのテスト
	 */
	public function testPublish(){


		// Pickles 2 実行
		$output = $this->helper->passthru( [
			'php',
			__DIR__.'/testdata/standard/.px_execute.php' ,
			'/?PX=publish.run' ,
		] );

		// トップページのソースコードを検査
		$indexHtml = $this->fs->read_file( __DIR__.'/testdata/standard/px-files/dist/index.html' );
		// var_dump($indexHtml);
		$this->assertTrue( 1 < strpos( $indexHtml, '<meta name=”robots” content="noindex, nofollow" />' ) );


		// コンテンツテンプレートサンプルのソースコードを検査
		$indexHtml = $this->fs->read_file( __DIR__.'/testdata/standard/px-files/dist/include_test/virtual/directory/index.html' );
		$this->assertTrue( 1 < strpos( $indexHtml, 'IncTest 2 | px2-search-bots-headers' ) );


		// 後始末
		$output = $this->helper->passthru( [
			'php',
			__DIR__.'/testdata/standard/.px_execute.php' ,
			'/?PX=clearcache' ,
		] );

	}//testPublish()

}
