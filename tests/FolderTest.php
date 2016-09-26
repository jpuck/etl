<?php
use jpuck\etl\Sources\Folder;
use jpuck\etl\Data\XML;

class FolderTest extends PHPUnit_Framework_TestCase {
	public $dataDir = __DIR__.'/data';

	public function invalidFolderURIdataProvider(){
		return [
			[[]], // path not set
			[['path']], // path empty
			[['path'=>'/dev/null/4QyQocFbdhDgz8J1']], // invalid path
			[[$this->dataDir]], // valid path without key
		];
	}

	/**
	 *  @testdox Can invalidate Folder URI
	 *  @dataProvider invalidFolderURIdataProvider
	 */
	public function testCanInvalidateFolderURI($invalidFolderURI){
		$this->expectException(InvalidArgumentException::class);
		$folder = new Folder($invalidFolderURI);
	}

	/**
	 *  @testdox Can validate Folder URI in constructor
	 */
	public function testCanValidateFolderURIinConstructor(){
		$expected = ['path'=>$this->dataDir];

		$folder = new Folder($expected);
		$actual = $folder->uri();

		$this->assertEquals($expected, $actual);
	}

	/**
	 *  @testdox Can validate Folder URI with accessor
	 */
	public function testCanValidateFolderURIwithAccessor(){
		$folder   = new Folder(['path'=>__DIR__]);
		$expected = ['path'=>$this->dataDir];

		$folder->uri($expected);
		$actual = $folder->uri();

		$this->assertEquals($expected, $actual);
	}

	/**
	 *  @testdox Can validate Folder URI with accessor return
	 */
	public function testCanValidateFolderURIwithAccessorReturn(){
		$folder   = new Folder(['path'=>__DIR__]);
		$expected = ['path'=>$this->dataDir];

		$actual = $folder->uri($expected);

		$this->assertEquals($expected, $actual);
	}

	/**
	 *  @testdox Can fetch XML from Folder
	 */
	public function testCanFetchXMLfromFolder(){
		$folder   = new Folder(['path'=>"{$this->dataDir}/xml"]);
		$expected = file_get_contents("{$this->dataDir}/xml/sample.xml");

		$xml = $folder->fetch("sample.xml", XML::class);

		$this->assertTrue($xml instanceof XML);
		$this->assertSame($expected, $xml->raw());
	}
}
