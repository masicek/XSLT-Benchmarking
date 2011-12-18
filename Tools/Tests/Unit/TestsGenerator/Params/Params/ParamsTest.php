<?php

/**
 * XSLT Benchmarking
 * @link https://github.com/masicek/XSLT-Benchmarking
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\XSLTBenchmark\TestsGenerator\Params;

use \Tests\XSLTBenchmark\TestCase;
use \XSLTBenchmark\TestsGenerator\Params;

require_once ROOT_TOOLS . '/TestsGenerator/Params/Params.php';

/**
 * ParamsTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers \XSLTBenchmark\TestsGenerator\Params::__construct
 */
class ParamsTest extends TestCase
{


	public function testBadParams()
	{
		$this->setExpectedException('\PhpPath\NotExistsPathException');
		$params = new Params('./foo.xml', __DIR__);
	}


	public function testBadTmp()
	{
		$this->setExpectedException('\PhpPath\NotExistsPathException');
		$params = new Params($this->setDirSep(__DIR__ . '/params.xml'), $this->setDirSep('./foo-bar'));
	}


	public function testXml()
	{
		$params = new Params($this->setDirSep(__DIR__ . '/params.xml'), __DIR__);
		$driver = $this->getPropertyValue($params, 'driver');
		$this->assertInstanceOf('\XSLTBenchmark\TestsGenerator\IParamsDriver', $driver);
		$this->assertInstanceOf('\XSLTBenchmark\TestsGenerator\XmlParamsDriver', $driver);
	}


}