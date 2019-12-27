<?php
/**
 * Test for pickles2\px2-include-php-code
 */

class publishTest extends PHPUnit_Framework_TestCase{

	/**
	 * setup
	 */
	public function setup(){
		$this->fs = new \tomk79\filesystem();
	}

	/**
	 * パブリッシュ後に出力されたdistコードのテスト
	 */
	public function testPublish(){


		// Pickles 2 実行
		$output = $this->passthru( [
			'php',
			__DIR__.'/testdata/standard/.px_execute.php' ,
			'/?PX=publish.run' ,
		] );

		// トップページのソースコードを検査
		$indexHtml = $this->fs->read_file( __DIR__.'/testdata/standard/px-files/dist/index.html' );
		// var_dump($indexHtml);
		$this->assertTrue( 1 < strpos( $indexHtml, '<p><?php echo "echo in theme"; ?></p>' ) );
		$this->assertTrue( 1 < strpos( $indexHtml, '<p><?php echo "echo in contents"; ?></p>' ) );
		$this->assertTrue( 1 < strpos( $indexHtml, '<?php include($_SERVER[\'DOCUMENT_ROOT\'].\'/common/includes/test.inc\'); ?>' ) );
		$this->assertFalse( strpos( $indexHtml, '<p>echo in theme</p>' ) );
		$this->assertFalse( strpos( $indexHtml, '<p>echo in contents</p>' ) );
		$this->assertFalse( strpos( $indexHtml, '<p>include file.</p>' ) );
		$this->assertTrue( 1 < strpos( $indexHtml, '<?php if( 1 ){ ?>' ) );
		$this->assertTrue( 1 < strpos( $indexHtml, '<p><?php echo htmlspecialchars(\'複数のPHPブロックに分けて実装するテスト\'); ?></p>' ) );
		$this->assertTrue( 1 < strpos( $indexHtml, '<?php } ?>' ) );


		// コンテンツテンプレートサンプルのソースコードを検査
		$indexHtml = $this->fs->read_file( __DIR__.'/testdata/standard/px-files/dist/include_test/virtual/directory/index.html' );
		$this->assertTrue( 1 < strpos( $indexHtml, 'IncTest 2 | px2-include-php-code' ) );


		// 後始末
		$output = $this->passthru( [
			'php',
			__DIR__.'/testdata/standard/.px_execute.php' ,
			'/?PX=clearcache' ,
		] );

	}//testPublish()



	/**
	 * コマンドを実行し、標準出力値を返す
	 * @param array $ary_command コマンドのパラメータを要素として持つ配列
	 * @return string コマンドの標準出力値
	 */
	private function passthru( $ary_command ){
		$cmd = array();
		foreach( $ary_command as $row ){
			$param = '"'.addslashes($row).'"';
			array_push( $cmd, $param );
		}
		$cmd = implode( ' ', $cmd );
		ob_start();
		passthru( $cmd );
		$bin = ob_get_clean();
		return $bin;
	}// passthru()

}
