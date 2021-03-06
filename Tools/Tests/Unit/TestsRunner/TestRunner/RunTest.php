<?php

/**
 * XSLT Benchmarking
 * @link https://github.com/masicek/XSLT-Benchmarking
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\XSLTBenchmarking\TestsRunner\TestRunner;

require_once ROOT_TOOLS . '/TestsRunner/TestRunner.php';

use \Tests\XSLTBenchmarking\TestCase;
use \XSLTBenchmarking\TestsRunner\TestRunner;

/**
 * RunTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers \XSLTBenchmarking\TestsRunner\TestRunner::run
 */
class RunTest extends TestCase
{


	public function test()
	{
		$factory = $this->getMock('\XSLTBenchmarking\Factory', array('getReport'));
		$processor = $this->getMock('\XSLTBenchmarking\TestsRunner\Processor', array('getAvailable'), array(), '', FALSE);
		$processor->expects($this->any())
			->method('getAvailable')
			->will($this->returnValue(array(
				'processor1' => 'prcessor1Driver',
				'processor2' => 'prcessor2Driver')
			));
		$controlor = $this->getMock('\XSLTBenchmarking\TestsRunner\Controlor');
		$runner = new TestRunner(
			$factory,
			$processor,
			TRUE,
			array(),
			123,
			$controlor,
			__DIR__
		);


		// test 1
		$test1 = $this->getMock('\XSLTBenchmarking\TestsRunner\Test', array('getName', 'getTemplatePath', 'getCouplesPaths'), array(), '', FALSE);
		$test1->expects($this->once())->method('getName')->will($this->returnValue('Test name 1'));
		$test1->expects($this->once())->method('getTemplatePath')->will($this->returnValue('Test template path 1'));
		$test1->expects($this->once())->method('getCouplesPaths')->will($this->returnValue(array('dir1/in1' => 'dir1/out1', 'dir1/in2' => 'dir1/out2')));
		// test 2
		$test2 = $this->getMock('\XSLTBenchmarking\TestsRunner\Test', array('getName', 'getTemplatePath', 'getCouplesPaths'), array(), '', FALSE);
		$test2->expects($this->once())->method('getName')->will($this->returnValue('Test name 2'));
		$test2->expects($this->once())->method('getTemplatePath')->will($this->returnValue('Test template path 2'));
		$test2->expects($this->once())->method('getCouplesPaths')->will($this->returnValue(array('dir2/in1' => 'dir2/out1', 'dir2/in2' => 'dir2/out2')));

		// factory
		$factory = \Mockery::mock('\XSLTBenchmarking\Factory');
		// -- test1
		$factory->shouldReceive('getReport')->once()->with('Test name 1', 'Test template path 1')->andReturnUsing(
			function ()
			{
				$report = \Mockery::mock('\XSLTBenchmarking\Reports\Report');
				$report->shouldReceive('addRecord')->once()->with(
					'processor1',
					'dir1/in1',
					'dir1/out1',
					'#^' . str_replace('\\', '\\\\', __DIR__ . DIRECTORY_SEPARATOR . 'out1') . '-[0-9]+-[0-9]+$#',
					'Error 11',
					FALSE,
					array(),
					array(),
					123
				);
				$report->shouldReceive('addRecord')->once()->with(
					'processor1',
					'dir1/in2',
					'dir1/out2',
					'#^' . str_replace('\\', '\\\\', __DIR__ . DIRECTORY_SEPARATOR . 'out2') . '-[0-9]+-[0-9]+$#',
					TRUE,
					FALSE,
					array('Spend times 12'),
					array('Memory usage 12'),
					123
				);
				$report->shouldReceive('addRecord')->once()->with(
					'processor2',
					'dir1/in1',
					'dir1/out1',
					'#^' . str_replace('\\', '\\\\', __DIR__ . DIRECTORY_SEPARATOR . 'out1') . '-[0-9]+-[0-9]+$#',
					TRUE,
					TRUE,
					array('Spend times 13'),
					array('Memory usage 13'),
					123
				);
				$report->shouldReceive('addRecord')->once()->with(
					'processor2',
					'dir1/in2',
					'dir1/out2',
					'#^' . str_replace('\\', '\\\\', __DIR__ . DIRECTORY_SEPARATOR . 'out2') . '-[0-9]+-[0-9]+$#',
					'Error 14',
					FALSE,
					array(),
					array(),
					123
				);
				return $report;
			}
		);
		// -- test2
		$factory->shouldReceive('getReport')->once()->with('Test name 2', 'Test template path 2')->andReturnUsing(
			function ()
			{
				$report = \Mockery::mock('\XSLTBenchmarking\Reports\Report');
				$report->shouldReceive('addRecord')->once()->with(
					'processor1',
					'dir2/in1',
					'dir2/out1',
					'#^' . str_replace('\\', '\\\\', __DIR__ . DIRECTORY_SEPARATOR . 'out1') . '-[0-9]+-[0-9]+$#',
					'Error 21',
					FALSE,
					array(),
					array(),
					123
				);
				$report->shouldReceive('addRecord')->once()->with(
					'processor1',
					'dir2/in2',
					'dir2/out2',
					'#^' . str_replace('\\', '\\\\', __DIR__ . DIRECTORY_SEPARATOR . 'out2') . '-[0-9]+-[0-9]+$#',
					'Error 22',
					FALSE,
					array(),
					array(),
					123
				);
				$report->shouldReceive('addRecord')->once()->with(
					'processor2',
					'dir2/in1',
					'dir2/out1',
					'#^' . str_replace('\\', '\\\\', __DIR__ . DIRECTORY_SEPARATOR . 'out1') . '-[0-9]+-[0-9]+$#',
					TRUE,
					TRUE,
					array('Spend times 23'),
					array('Memory usage 23'),
					123
				);
				$report->shouldReceive('addRecord')->once()->with(
					'processor2',
					'dir2/in2',
					'dir2/out2',
					'#^' . str_replace('\\', '\\\\', __DIR__ . DIRECTORY_SEPARATOR . 'out2') . '-[0-9]+-[0-9]+$#',
					TRUE,
					TRUE,
					array('Spend times 24'),
					array('Memory usage 24'),
					123
				);
				return $report;
			}
		);
		$this->setPropertyValue($runner, 'factory', $factory);

		// generated output path
		$path11 = $this->setDirSep(__DIR__ . '/out1');
		$path11 = $this->setDirSep(__DIR__ . '/??-test-name-1/out2');


		// processor
		$processor = \Mockery::mock('\XSLTBenchmarking\TestsRunner\Processor');
		// -- test1
		$out1Regexp = '#^' . str_replace('\\', '\\\\', $this->setDirSep(__DIR__ . '/out1')) . '-[0-9]+-[0-9]+$#';
		$out2Regexp = '#^' . str_replace('\\', '\\\\', $this->setDirSep(__DIR__ . '/out2')) . '-[0-9]+-[0-9]+$#';
		$processor->shouldReceive('run')->once()
			->with('processor1', 'Test template path 1', 'dir1/in1', $out1Regexp, 123)
			->andReturn('Error 11');
		$processor->shouldReceive('run')->once()
			->with('processor1', 'Test template path 1', 'dir1/in2', $out2Regexp, 123)
			->andReturn(array('times' => array('Spend times 12'), 'memory' => array('Memory usage 12')));
		$processor->shouldReceive('run')->once()
			->with('processor2', 'Test template path 1', 'dir1/in1', $out1Regexp, 123)
			->andReturn(array('times' => array('Spend times 13'), 'memory' => array('Memory usage 13')));
		$processor->shouldReceive('run')->once()
			->with('processor2', 'Test template path 1', 'dir1/in2', $out2Regexp, 123)
			->andReturn('Error 14');
		// -- test2
		$processor->shouldReceive('run')->once()
			->with('processor1', 'Test template path 2', 'dir2/in1', $out1Regexp, 123)
			->andReturn('Error 21');
		$processor->shouldReceive('run')->once()
			->with('processor1', 'Test template path 2', 'dir2/in2', $out2Regexp, 123)
			->andReturn('Error 22');
		$processor->shouldReceive('run')->once()
			->with('processor2', 'Test template path 2', 'dir2/in1', $out1Regexp, 123)
			->andReturn(array('times' => array('Spend times 23'), 'memory' => array('Memory usage 23')));
		$processor->shouldReceive('run')->once()
			->with('processor2', 'Test template path 2', 'dir2/in2', $out2Regexp, 123)
			->andReturn(array('times' => array('Spend times 24'), 'memory' => array('Memory usage 24')));
		$this->setPropertyValue($runner, 'processor', $processor);

		// controlor
		$controlor = \Mockery::mock('\XSLTBenchmarking\TestsRunner\Controlor');
		$controlor->shouldReceive('isSame')->twice()->with($out1Regexp, 'dir1/out1')->andReturn(TRUE);
		$controlor->shouldReceive('isSame')->twice()->with($out2Regexp, 'dir1/out2')->andReturn(FALSE);
		$controlor->shouldReceive('isSame')->twice()->with($out1Regexp, 'dir2/out1')->andReturn(TRUE);
		$controlor->shouldReceive('isSame')->twice()->with($out2Regexp, 'dir2/out2')->andReturn(TRUE);
		$this->setPropertyValue($runner, 'controlor', $controlor);

		$report1 = $runner->run($test1);
		$report2 = $runner->run($test2);
	}


}
