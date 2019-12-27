<?php
/**
 * Test for pickles2\px2-include-php-code
 */

class mainTest extends PHPUnit_Framework_TestCase{

	/**
	 * setup
	 */
	public function setup(){
		$this->fs = new \tomk79\filesystem();
	}

	/**
	 * プレビュー表示時のテスト
	 */
	public function testPreview(){

		// トップページの出力コードを検査
		$indexHtml = $this->passthru( [
			'php',
			__DIR__.'/testdata/standard/.px_execute.php' ,
			'-u', 'Mozilla/0.5',
			'/index.html' ,
		] );
		// var_dump($indexHtml);

		$this->assertFalse( strpos( $indexHtml, '<p><?php echo "echo in theme"; ?></p>' ) );
		$this->assertFalse( strpos( $indexHtml, '<p><?php echo "echo in contents"; ?></p>' ) );
		$this->assertFalse( strpos( $indexHtml, '<?php include($_SERVER[\'DOCUMENT_ROOT\'].\'/common/includes/test.inc\'); ?>' ) );
		$this->assertTrue( 1 < strpos( $indexHtml, '<p>echo in theme</p>' ) );
		$this->assertTrue( 1 < strpos( $indexHtml, '<p>echo in contents</p>' ) );
		$this->assertTrue( 1 < strpos( $indexHtml, '<p>include file.</p>' ) );
		$this->assertTrue( 1 < strpos( $indexHtml, '<p>複数のPHPブロックに分けて実装するテスト</p>' ) );


		// 後始末
		$output = $this->passthru( [
			'php',
			__DIR__.'/testdata/standard/.px_execute.php' ,
			'/?PX=clearcache' ,
		] );

	}//testPreview()

	/**
	 * 相対パスの解決
	 */
	public function testResolveRelativePath(){

		// トップページの出力コードを検査
		$indexHtml = $this->passthru( [
			'php',
			__DIR__.'/testdata/standard/.px_execute.php' ,
			'-u', 'Mozilla/0.5',
			'/include_test/index.html' ,
		] );
		// var_dump($indexHtml);

		$this->assertTrue( 1 < strpos( $indexHtml, '<div class="cont_include_1"><p>include file.</p>' ) );
		$this->assertTrue( 1 < strpos( $indexHtml, '<div class="cont_include_2"><p>include file.</p>' ) );


		// 後始末
		$output = $this->passthru( [
			'php',
			__DIR__.'/testdata/standard/.px_execute.php' ,
			'/?PX=clearcache' ,
		] );

	}//testResolveRelativePath()



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
