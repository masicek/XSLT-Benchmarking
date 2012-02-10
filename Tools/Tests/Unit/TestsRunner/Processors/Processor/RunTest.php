<?php

/**
 * XSLT Benchmarking
 * @link https://github.com/masicek/XSLT-Benchmarking
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\XSLTBenchmarking\TestsRunner\Processor;

use \Tests\XSLTBenchmarking\TestCase;
use \XSLTBenchmarking\TestsRunner\Processor;

require_once ROOT_TOOLS . '/TestsRunner/Processors/Processor.php';

/**
 * ProcessorTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers \XSLTBenchmarking\TestsRunner\Processor::run
 * @covers \XSLTBenchmarking\TestsRunner\Processor::getCommand
 * @covers \XSLTBenchmarking\TestsRunner\Processor::makeInputWithTemplatePath
 */
class RunTest extends TestCase
{


	private $processor;


	public function setUp()
	{
		$this->processor = new Processor(
			__DIR__,
			__DIR__ . '/FixtureDrivers',
			'\Tests\XSLTBenchmarking\TestsRunner\Processor\\'
		);
	}


	public function tearDown()
	{
		if (is_file($this->setDirSep(__DIR__ . '/transformation.err')))
		{
			unlink($this->setDirSep(__DIR__ . '/transformation.err'));
		}
	}


	public function testUnknownProcessor()
	{
		$this->setExpectedException('\XSLTBenchmarking\InvalidArgumentException');
		$this->processor->run('unknown', __FILE__, __FILE__, 'output', 111);
	}


	public function testBadTemplatePath()
	{
		$processorOK = $this->getMock('\XSLTBenchmarking\TestsRunner\AProcessorDriver', array('getCommandTemplate', 'getFullName', 'getKernel', 'isTemplateSetInInput', 'getBeforeCommandTemplate', 'getAfterCommandTemplate', 'isAvailable'), array(), '', FALSE);
		$processorOK->expects($this->never())->method('getCommandTemplate')->will($this->returnValue('php -r "sleep(1);"'));
		$processorOK->expects($this->never())->method('getFullName')->will($this->returnValue(''));
		$processorOK->expects($this->never())->method('getKernel')->will($this->returnValue(''));
		$processorOK->expects($this->never())->method('isTemplateSetInInput')->will($this->returnValue(FALSE));
		$processorOK->expects($this->never())->method('getBeforeCommandTemplate')->will($this->returnValue(''));
		$processorOK->expects($this->never())->method('getAfterCommandTemplate')->will($this->returnValue(''));
		$processorOK->expects($this->never())->method('isAvailable')->will($this->returnValue(TRUE));

		$processorError = $this->getMock('\XSLTBenchmarking\TestsRunner\AProcessorDriver', array('getCommandTemplate', 'getFullName', 'getKernel', 'isTemplateSetInInput', 'getBeforeCommandTemplate', 'getAfterCommandTemplate', 'isAvailable'), array(), '', FALSE);
		$processorError->expects($this->never())->method('getCommandTemplate')->will($this->returnValue('php -r "echo \'Test error\';" > [ERROR]'));
		$processorError->expects($this->never())->method('getFullName')->will($this->returnValue(''));
		$processorError->expects($this->never())->method('getKernel')->will($this->returnValue(''));
		$processorError->expects($this->never())->method('isTemplateSetInInput')->will($this->returnValue(FALSE));
		$processorError->expects($this->never())->method('getBeforeCommandTemplate')->will($this->returnValue(''));
		$processorError->expects($this->never())->method('getAfterCommandTemplate')->will($this->returnValue(''));
		$processorError->expects($this->never())->method('isAvailable')->will($this->returnValue(TRUE));

		$available = array(
			'processorOK' => $processorOK,
			'processorError' => $processorError,
		);

		$this->setPropertyValue($this->processor, 'available', $available);

		$this->setExpectedException('\PhpPath\NotExistsPathException');
		$this->processor->run('processorOK', 'unknown', __FILE__, 'output', 111);
	}


	public function testBadXmlInputPath()
	{
		$processorOK = $this->getMock('\XSLTBenchmarking\TestsRunner\AProcessorDriver', array('getCommandTemplate', 'getFullName', 'getKernel', 'isTemplateSetInInput', 'getBeforeCommandTemplate', 'getAfterCommandTemplate', 'isAvailable'), array(), '', FALSE);
		$processorOK->expects($this->never())->method('getCommandTemplate')->will($this->returnValue('php -r "sleep(1);"'));
		$processorOK->expects($this->never())->method('getFullName')->will($this->returnValue(''));
		$processorOK->expects($this->never())->method('getKernel')->will($this->returnValue(''));
		$processorOK->expects($this->never())->method('isTemplateSetInInput')->will($this->returnValue(FALSE));
		$processorOK->expects($this->never())->method('getBeforeCommandTemplate')->will($this->returnValue(''));
		$processorOK->expects($this->never())->method('getAfterCommandTemplate')->will($this->returnValue(''));
		$processorOK->expects($this->never())->method('isAvailable')->will($this->returnValue(TRUE));

		$processorError = $this->getMock('\XSLTBenchmarking\TestsRunner\AProcessorDriver', array('getCommandTemplate', 'getFullName', 'getKernel', 'isTemplateSetInInput', 'getBeforeCommandTemplate', 'getAfterCommandTemplate', 'isAvailable'), array(), '', FALSE);
		$processorError->expects($this->never())->method('getCommandTemplate')->will($this->returnValue('php -r "echo \'Test error\';" > [ERROR]'));
		$processorError->expects($this->never())->method('getFullName')->will($this->returnValue(''));
		$processorError->expects($this->never())->method('getKernel')->will($this->returnValue(''));
		$processorError->expects($this->never())->method('isTemplateSetInInput')->will($this->returnValue(FALSE));
		$processorError->expects($this->never())->method('getBeforeCommandTemplate')->will($this->returnValue(''));
		$processorError->expects($this->never())->method('getAfterCommandTemplate')->will($this->returnValue(''));
		$processorError->expects($this->never())->method('isAvailable')->will($this->returnValue(TRUE));

		$available = array(
			'processorOK' => $processorOK,
			'processorError' => $processorError,
		);

		$this->setPropertyValue($this->processor, 'available', $available);

		$this->setExpectedException('\PhpPath\NotExistsPathException');
		$this->processor->run('processorOK', __FILE__, 'unknown', 'output', 111);
	}


	public function testErrorFileExist()
	{
		$processorOK = $this->getMock('\XSLTBenchmarking\TestsRunner\AProcessorDriver', array('getCommandTemplate', 'getFullName', 'getKernel', 'isTemplateSetInInput', 'getBeforeCommandTemplate', 'getAfterCommandTemplate', 'isAvailable'), array(), '', FALSE);
		$processorOK->expects($this->never())->method('getCommandTemplate')->will($this->returnValue('php -r "sleep(1);"'));
		$processorOK->expects($this->never())->method('getFullName')->will($this->returnValue(''));
		$processorOK->expects($this->never())->method('getKernel')->will($this->returnValue(''));
		$processorOK->expects($this->never())->method('isTemplateSetInInput')->will($this->returnValue(FALSE));
		$processorOK->expects($this->never())->method('getBeforeCommandTemplate')->will($this->returnValue(''));
		$processorOK->expects($this->never())->method('getAfterCommandTemplate')->will($this->returnValue(''));
		$processorOK->expects($this->never())->method('isAvailable')->will($this->returnValue(TRUE));

		$processorError = $this->getMock('\XSLTBenchmarking\TestsRunner\AProcessorDriver', array('getCommandTemplate', 'getFullName', 'getKernel', 'isTemplateSetInInput', 'getBeforeCommandTemplate', 'getAfterCommandTemplate', 'isAvailable'), array(), '', FALSE);
		$processorError->expects($this->once())->method('getCommandTemplate')->will($this->returnValue('php -r "echo \'Test error\';" > [ERROR]'));
		$processorError->expects($this->never())->method('getFullName')->will($this->returnValue(''));
		$processorError->expects($this->never())->method('getKernel')->will($this->returnValue(''));
		$processorError->expects($this->once())->method('isTemplateSetInInput')->will($this->returnValue(FALSE));
		$processorError->expects($this->once())->method('getBeforeCommandTemplate')->will($this->returnValue(''));
		$processorError->expects($this->once())->method('getAfterCommandTemplate')->will($this->returnValue(''));
		$processorError->expects($this->never())->method('isAvailable')->will($this->returnValue(TRUE));

		$available = array(
			'processorOK' => $processorOK,
			'processorError' => $processorError,
		);

		$this->setPropertyValue($this->processor, 'available', $available);

		file_put_contents($this->setDirSep(__DIR__ . '/transformation.err'), '');
		$this->setExpectedException('\XSLTBenchmarking\InvalidStateException');
		$return = $this->processor->run('processorError', __FILE__, __FILE__, 'output', 111);
	}


	public function testError()
	{
		$processorOK = $this->getMock('\XSLTBenchmarking\TestsRunner\AProcessorDriver', array('getCommandTemplate', 'getFullName', 'getKernel', 'isTemplateSetInInput', 'getBeforeCommandTemplate', 'getAfterCommandTemplate', 'isAvailable'), array(), '', FALSE);
		$processorOK->expects($this->never())->method('getCommandTemplate')->will($this->returnValue('php -r "sleep(1);"'));
		$processorOK->expects($this->never())->method('getFullName')->will($this->returnValue(''));
		$processorOK->expects($this->never())->method('getKernel')->will($this->returnValue(''));
		$processorOK->expects($this->never())->method('isTemplateSetInInput')->will($this->returnValue(FALSE));
		$processorOK->expects($this->never())->method('getBeforeCommandTemplate')->will($this->returnValue(''));
		$processorOK->expects($this->never())->method('getAfterCommandTemplate')->will($this->returnValue(''));
		$processorOK->expects($this->never())->method('isAvailable')->will($this->returnValue(TRUE));

		$processorError = $this->getMock('\XSLTBenchmarking\TestsRunner\AProcessorDriver', array('getCommandTemplate', 'getFullName', 'getKernel', 'isTemplateSetInInput', 'getBeforeCommandTemplate', 'getAfterCommandTemplate', 'isAvailable'), array(), '', FALSE);
		$processorError->expects($this->once())->method('getCommandTemplate')->will($this->returnValue('php -r "echo \'Test error\';" > [ERROR]'));
		$processorError->expects($this->never())->method('getFullName')->will($this->returnValue(''));
		$processorError->expects($this->never())->method('getKernel')->will($this->returnValue(''));
		$processorError->expects($this->once())->method('isTemplateSetInInput')->will($this->returnValue(FALSE));
		$processorError->expects($this->once())->method('getBeforeCommandTemplate')->will($this->returnValue(''));
		$processorError->expects($this->once())->method('getAfterCommandTemplate')->will($this->returnValue(''));
		$processorError->expects($this->never())->method('isAvailable')->will($this->returnValue(TRUE));

		$available = array(
			'processorOK' => $processorOK,
			'processorError' => $processorError,
		);

		$this->setPropertyValue($this->processor, 'available', $available);

		$filesBefore = scandir(__DIR__);
		$return = $this->processor->run('processorError', __FILE__, __FILE__, 'output', 111);
		$filesAfter = scandir(__DIR__);

		$this->assertEquals($filesBefore, $filesAfter);
		$this->assertEquals('Test error', $return);
	}


	public function testXmlAndXsltSeparately()
	{
		$processorOK = $this->getMock('\XSLTBenchmarking\TestsRunner\AProcessorDriver', array('getCommandTemplate', 'getFullName', 'getKernel', 'isTemplateSetInInput', 'getBeforeCommandTemplate', 'getAfterCommandTemplate', 'isAvailable'), array(), '', FALSE);
		$processorOK->expects($this->once())->method('getCommandTemplate')->will($this->returnValue('php -r "sleep(1);"'));
		$processorOK->expects($this->never())->method('getFullName')->will($this->returnValue(''));
		$processorOK->expects($this->never())->method('getKernel')->will($this->returnValue(''));
		$processorOK->expects($this->once())->method('isTemplateSetInInput')->will($this->returnValue(FALSE));
		$processorOK->expects($this->once())->method('getBeforeCommandTemplate')->will($this->returnValue(''));
		$processorOK->expects($this->once())->method('getAfterCommandTemplate')->will($this->returnValue(''));
		$processorOK->expects($this->never())->method('isAvailable')->will($this->returnValue(TRUE));

		$processorError = $this->getMock('\XSLTBenchmarking\TestsRunner\AProcessorDriver', array('getCommandTemplate', 'getFullName', 'getKernel', 'isTemplateSetInInput', 'getBeforeCommandTemplate', 'getAfterCommandTemplate', 'isAvailable'), array(), '', FALSE);
		$processorError->expects($this->never())->method('getCommandTemplate')->will($this->returnValue('php -r "echo \'Test error\';" > [ERROR]'));
		$processorError->expects($this->never())->method('getFullName')->will($this->returnValue(''));
		$processorError->expects($this->never())->method('getKernel')->will($this->returnValue(''));
		$processorError->expects($this->never())->method('isTemplateSetInInput')->will($this->returnValue(FALSE));
		$processorError->expects($this->never())->method('getBeforeCommandTemplate')->will($this->returnValue(''));
		$processorError->expects($this->never())->method('getAfterCommandTemplate')->will($this->returnValue(''));
		$processorError->expects($this->never())->method('isAvailable')->will($this->returnValue(TRUE));

		$available = array(
			'processorOK' => $processorOK,
			'processorError' => $processorError,
		);

		$this->setPropertyValue($this->processor, 'available', $available);

		$filesBefore = scandir(__DIR__);
		$returnTimes = $this->processor->run('processorOK', __FILE__, $this->setDirSep(__DIR__ . '/FixtureRun/input.xml'), 'output', 3);
		$filesAfter = scandir(__DIR__);

		$this->assertEquals($filesBefore, $filesAfter);

		$this->assertTrue(is_array($returnTimes));
		$this->assertEquals(3, count($returnTimes));

		// all times are greated then one second
		$this->assertGreaterOneSecondInMicrotime($returnTimes[0]);
		$this->assertGreaterOneSecondInMicrotime($returnTimes[1]);
		$this->assertGreaterOneSecondInMicrotime($returnTimes[2]);
	}


	public function testXsltInXml()
	{
		$processorOK = $this->getMock('\XSLTBenchmarking\TestsRunner\AProcessorDriver', array('getCommandTemplate', 'getFullName', 'getKernel', 'isTemplateSetInInput', 'getBeforeCommandTemplate', 'getAfterCommandTemplate', 'isAvailable'), array(), '', FALSE);
		$processorOK->expects($this->once())->method('getCommandTemplate')->will($this->returnValue('php -r "sleep(1);"'));
		$processorOK->expects($this->never())->method('getFullName')->will($this->returnValue(''));
		$processorOK->expects($this->never())->method('getKernel')->will($this->returnValue(''));
		$processorOK->expects($this->once())->method('isTemplateSetInInput')->will($this->returnValue(TRUE));
		$processorOK->expects($this->once())->method('getBeforeCommandTemplate')->will($this->returnValue(''));
		$processorOK->expects($this->once())->method('getAfterCommandTemplate')->will($this->returnValue(''));
		$processorOK->expects($this->never())->method('isAvailable')->will($this->returnValue(TRUE));

		$processorError = $this->getMock('\XSLTBenchmarking\TestsRunner\AProcessorDriver', array('getCommandTemplate', 'getFullName', 'getKernel', 'isTemplateSetInInput', 'getBeforeCommandTemplate', 'getAfterCommandTemplate', 'isAvailable'), array(), '', FALSE);
		$processorError->expects($this->never())->method('getCommandTemplate')->will($this->returnValue('php -r "echo \'Test error\';" > [ERROR]'));
		$processorError->expects($this->never())->method('getFullName')->will($this->returnValue(''));
		$processorError->expects($this->never())->method('getKernel')->will($this->returnValue(''));
		$processorError->expects($this->never())->method('isTemplateSetInInput')->will($this->returnValue(TRUE));
		$processorError->expects($this->never())->method('getBeforeCommandTemplate')->will($this->returnValue(''));
		$processorError->expects($this->never())->method('getAfterCommandTemplate')->will($this->returnValue(''));
		$processorError->expects($this->never())->method('isAvailable')->will($this->returnValue(TRUE));

		$available = array(
			'processorOK' => $processorOK,
			'processorError' => $processorError,
		);

		$this->setPropertyValue($this->processor, 'available', $available);

		$filesBefore = scandir(__DIR__);
		$returnTimes = $this->processor->run('processorOK', __FILE__, $this->setDirSep(__DIR__ . '/FixtureRun/input.xml'), 'output', 3);
		$filesAfter = scandir(__DIR__);

		$this->assertNotEquals($filesBefore, $filesAfter);

		// check content of generated file
		$generatedFiles = array_values(array_diff($filesAfter, $filesBefore));
		$this->assertEquals(1, count($generatedFiles));
		$generatedPath = $this->setDirSep(__DIR__ . '/' . $generatedFiles[0]);
		$this->assertXmlFileEqualsXmlFile($generatedPath, $this->setDirSep(__DIR__ . '/FixtureRun/inputWithTemplatePath.xml'));

		// delete generated file
		unlink($generatedPath);

		$filesAfter2 = scandir(__DIR__);
		$this->assertEquals($filesBefore, $filesAfter2);
		$this->assertTrue(is_array($returnTimes));
		$this->assertEquals(3, count($returnTimes));

		// all times are greated then one second
		$this->assertGreaterOneSecondInMicrotime($returnTimes[0]);
		$this->assertGreaterOneSecondInMicrotime($returnTimes[1]);
		$this->assertGreaterOneSecondInMicrotime($returnTimes[2]);
	}


	public function testBeforeAndAfterCommand()
	{
		$controleOutputPath = $this->setDirSep(__DIR__ . '/controleOutput');
		file_put_contents($controleOutputPath, '');

		$processorOK = $this->getMock('\XSLTBenchmarking\TestsRunner\AProcessorDriver', array('getCommandTemplate', 'getFullName', 'getKernel', 'isTemplateSetInInput', 'getBeforeCommandTemplate', 'getAfterCommandTemplate', 'isAvailable'), array(), '', FALSE);
		$processorOK->expects($this->once())->method('getCommandTemplate')->will($this->returnValue(
			'php -r "file_put_contents(\'' . $controleOutputPath . '\', file_get_contents(\'' . $controleOutputPath . '\') . \'Test command;\');"'
		));
		$processorOK->expects($this->never())->method('getFullName')->will($this->returnValue(''));
		$processorOK->expects($this->never())->method('getKernel')->will($this->returnValue(''));
		$processorOK->expects($this->once())->method('isTemplateSetInInput')->will($this->returnValue(FALSE));
		$processorOK->expects($this->once())->method('getBeforeCommandTemplate')->will($this->returnValue(
			'php -r "file_put_contents(\'' . $controleOutputPath . '\', file_get_contents(\'' . $controleOutputPath . '\') . \'Test of before command;\');"'
		));
		$processorOK->expects($this->once())->method('getAfterCommandTemplate')->will($this->returnValue(
			'php -r "file_put_contents(\'' . $controleOutputPath . '\', file_get_contents(\'' . $controleOutputPath . '\') . \'Test of after command;\');"'
		));
		$processorOK->expects($this->never())->method('isAvailable')->will($this->returnValue(TRUE));

		$processorError = $this->getMock('\XSLTBenchmarking\TestsRunner\AProcessorDriver', array('getCommandTemplate', 'getFullName', 'getKernel', 'isTemplateSetInInput', 'getBeforeCommandTemplate', 'getAfterCommandTemplate', 'isAvailable'), array(), '', FALSE);
		$processorError->expects($this->never())->method('getCommandTemplate')->will($this->returnValue(''));
		$processorError->expects($this->never())->method('getFullName')->will($this->returnValue(''));
		$processorError->expects($this->never())->method('getKernel')->will($this->returnValue(''));
		$processorError->expects($this->never())->method('isTemplateSetInInput')->will($this->returnValue(FALSE));
		$processorError->expects($this->never())->method('getBeforeCommandTemplate')->will($this->returnValue(''));
		$processorError->expects($this->never())->method('getAfterCommandTemplate')->will($this->returnValue(''));
		$processorError->expects($this->never())->method('isAvailable')->will($this->returnValue(TRUE));

		$available = array(
			'processorOK' => $processorOK,
			'processorError' => $processorError,
		);

		$this->setPropertyValue($this->processor, 'available', $available);

		$returnTimes = $this->processor->run('processorOK', __FILE__, $this->setDirSep(__DIR__ . '/FixtureRun/input.xml'), 'output', 3);

		$this->assertStringEqualsFile($controleOutputPath,
			'Test of before command;Test command;Test of after command;' .
			'Test of before command;Test command;Test of after command;' .
			'Test of before command;Test command;Test of after command;'
		);

		unlink($controleOutputPath);
	}


	private function assertGreaterOneSecondInMicrotime($time)
	{
		$compare = bccomp($time, '1.000000', 6);
		$this->assertEquals(1, $compare);
	}

}
