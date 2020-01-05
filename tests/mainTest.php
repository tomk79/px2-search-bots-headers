<?php
/**
 * Test for px2-search-bots-headers
 */

use tomk79\pickles2\px2_search_bots_headers\utils;

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
	 * Utils: $apply->to_boolean()
	 */
	public function testUtilsToBoolean(){

		$this->assertSame( utils::to_boolean(null), null );
		$this->assertSame( utils::to_boolean(true), true );
		$this->assertSame( utils::to_boolean(false), false );
		$this->assertSame( utils::to_boolean(0), false );
		$this->assertSame( utils::to_boolean(1), true );
		$this->assertSame( utils::to_boolean(1.001), true );
		$this->assertSame( utils::to_boolean(2), true );
		$this->assertSame( utils::to_boolean(-2), false );
		$this->assertSame( utils::to_boolean(-0.002), false );
		$this->assertSame( utils::to_boolean(''), null );
		$this->assertSame( utils::to_boolean('null'), null );
		$this->assertSame( utils::to_boolean('NULL'), null );
		$this->assertSame( utils::to_boolean('Null'), null );
		$this->assertSame( utils::to_boolean('NulL'), null );
		$this->assertSame( utils::to_boolean('true'), true );
		$this->assertSame( utils::to_boolean('TRUE'), true );
		$this->assertSame( utils::to_boolean('True'), true );
		$this->assertSame( utils::to_boolean('TruE'), true );
		$this->assertSame( utils::to_boolean('1'), true );
		$this->assertSame( utils::to_boolean('01'), true );
		$this->assertSame( utils::to_boolean('+1'), true );
		$this->assertSame( utils::to_boolean('+1.2'), true );
		$this->assertSame( utils::to_boolean('yes'), true );
		$this->assertSame( utils::to_boolean('on'), true );
		$this->assertSame( utils::to_boolean('false'), false );
		$this->assertSame( utils::to_boolean('FALSE'), false );
		$this->assertSame( utils::to_boolean('False'), false );
		$this->assertSame( utils::to_boolean('FaLsE'), false );
		$this->assertSame( utils::to_boolean('0'), false );
		$this->assertSame( utils::to_boolean('00'), false );
		$this->assertSame( utils::to_boolean('-1'), false );
		$this->assertSame( utils::to_boolean('-1.2'), false );
		$this->assertSame( utils::to_boolean('no'), false );
		$this->assertSame( utils::to_boolean('off'), false );
		$this->assertSame( utils::to_boolean('abcde'), true );

	}//testUtilsToBoolean()

	/**
	 * 基本テスト
	 */
	public function testMain(){

		// トップページの出力コードを検査
		$indexHtml = $this->helper->php( [
			__DIR__.'/testdata/standard/.px_execute.php' ,
			'-u', 'Mozilla/0.5',
			'/index.html' ,
		] );
		// var_dump($indexHtml);
		$this->assertFalse( 1 < strpos( $indexHtml, '<meta name=”robots”' ) );


		$indexHtml = $this->helper->php( [
			__DIR__.'/testdata/standard/.px_execute.php' ,
			'-u', 'Mozilla/0.5',
			'/test/all_null.html' ,
		] );
		// var_dump($indexHtml);
		$this->assertFalse( 1 < strpos( $indexHtml, '<meta name=”robots”' ) );


		$indexHtml = $this->helper->php( [
			__DIR__.'/testdata/standard/.px_execute.php' ,
			'-u', 'Mozilla/0.5',
			'/test/all_yes.html' ,
		] );
		// var_dump($indexHtml);
		$this->assertTrue( 1 < strpos( $indexHtml, '<meta name=”robots” content="follow,index,archive" />' ) );


		$indexHtml = $this->helper->php( [
			__DIR__.'/testdata/standard/.px_execute.php' ,
			'-u', 'Mozilla/0.5',
			'/test/all_no.html' ,
		] );
		// var_dump($indexHtml);
		$this->assertTrue( 1 < strpos( $indexHtml, '<meta name=”robots” content="nofollow,noindex,noarchive" />' ) );


		$indexHtml = $this->helper->php( [
			__DIR__.'/testdata/standard/.px_execute.php' ,
			'-u', 'Mozilla/0.5',
			'/test/nofollow_noindex.html' ,
		] );
		// var_dump($indexHtml);
		$this->assertTrue( 1 < strpos( $indexHtml, '<meta name=”robots” content="nofollow,noindex" />' ) );


		// 後始末
		$output = $this->helper->php( [
			__DIR__.'/testdata/standard/.px_execute.php' ,
			'/?PX=clearcache' ,
		] );

	}//testMain()

}
