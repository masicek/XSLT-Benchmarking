<?php

/**
 * XSLT Benchmarking
 * @link https://github.com/masicek/XSLT-Benchmarking
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\XSLTBenchmarking\TestsGenerator\Params;

use \Tests\XSLTBenchmarking\TestCase;
use \XSLTBenchmarking\TestsGenerator\Params;

require_once ROOT_TOOLS . '/TestsGenerator/Params/Params.php';
require_once ROOT_TOOLS . '/TestsGenerator/XmlGenerator/XmlGenerator.php';

/**
 * GetTestParamsFileNameTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers XSLTBenchmarking\TestsGenerator\Params::getTestParamsFileName
 */
class GetTestParamsFileNameTest extends TestCase
{


	public function testDefaultValue()
	{
		$params = new Params(new \XSLTBenchmarking\TestsGenerator\XmlGenerator(), __DIR__);
		$params->setFile($this->setDirSep(__DIR__ . '/params.xml'));
		$driver = \Mockery::mock('\XSLTBenchmarking\TestsGenerator\IParamsDriver');
		$driver->shouldReceive('getTestParamsFileName')->with('Lorem ipsum')->andReturn(NULL);
		$this->setPropertyValue($params, 'driver', $driver);

		$this->assertEquals('__params.xml', $params->getTestParamsFileName('Lorem ipsum'));
	}


	public function testSetValue()
	{
		$params = new Params(new \XSLTBenchmarking\TestsGenerator\XmlGenerator(), __DIR__);
		$params->setFile($this->setDirSep(__DIR__ . '/params.xml'));
		$driver = \Mockery::mock('\XSLTBenchmarking\TestsGenerator\IParamsDriver');
		$driver->shouldReceive('getTestParamsFileName')->with('Lorem ipsum')->andReturn('myParams.xml');
		$this->setPropertyValue($params, 'driver', $driver);

		$this->assertEquals('myParams.xml', $params->getTestParamsFileName('Lorem ipsum'));
	}


}
