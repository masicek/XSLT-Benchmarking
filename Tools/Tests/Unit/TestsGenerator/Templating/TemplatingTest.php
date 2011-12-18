<?php

/**
 * XSLT Benchmarking
 * @link https://github.com/masicek/XSLT-Benchmarking
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\XSLTBenchmark\TestsGenerator\Templating;

use \Tests\XSLTBenchmark\TestCase;
use \XSLTBenchmark\TestsGenerator\Templating;

require_once ROOT_TOOLS . '/TestsGenerator/Templating.php';

/**
 * TemplatingTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers XSLTBenchmark\TestsGenerator\Templating::__construct
 */
class TemplatingTest extends TestCase
{


	public function testSimple()
	{
		$templating = new Templating('simple', __DIR__);
		$driver = $this->getPropertyValue($templating, 'driver');
		$this->assertInstanceOf('\XSLTBenchmark\TestsGenerator\ITemplatingDriver', $driver);
		$this->assertInstanceOf('\XSLTBenchmark\TestsGenerator\SimpleTemplatingDriver', $driver);
	}


	public function testSmarty()
	{
		$templating = new Templating('smarty', __DIR__);
		$driver = $this->getPropertyValue($templating, 'driver');
		$this->assertInstanceOf('\XSLTBenchmark\TestsGenerator\ITemplatingDriver', $driver);
		$this->assertInstanceOf('\XSLTBenchmark\TestsGenerator\SmartyTemplatingDriver', $driver);
	}


	public function testUnknown()
	{
		$this->setExpectedException('\XSLTBenchmark\InvalidArgumentException');
		$templating = new Templating('foo', __DIR__);
	}


	public function testBadTmp()
	{
		$this->setExpectedException('\PhpPath\NotExistsPathException');
		$templating = new Templating('simple', './fooBar');
	}


}