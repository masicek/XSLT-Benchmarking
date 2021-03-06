<?php

/**
 * XSLT Benchmarking
 * @link https://github.com/masicek/XSLT-Benchmarking
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\XSLTBenchmarking\Reports\Printer;

use \Tests\XSLTBenchmarking\TestCase;
use \XSLTBenchmarking\Reports\Printer;

require_once ROOT_TOOLS . '/Reports/Printer.php';

/**
 * PrintAllTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers \XSLTBenchmarking\Reports\Printer::printAll
 */
class PrintAllTest extends TestCase
{


	public function test()
	{
		mkdir(__DIR__ . '/reports');

		$processors = array(
			'processor1' => array('firstInformation' => 'First information 1', 'secondInformation' => 'Second information 1', 'thirdInformation' => 'Third information 1'),
			'processor2' => array('firstInformation' => 'First information 2'),
			'processor3' => array('firstInformation' => 'First information 3', 'secondInformation' => 'Second information 3'),
		);
		$printer = new Printer(__DIR__ . '/reports', $processors);

		// report 1
		$report1 = \Mockery::mock('\XSLTBenchmarking\Reports\Report');
		$report1->shouldReceive('getTestName')->andReturn('First test');
		$report1->shouldReceive('getTemplatePath')->andReturn('template 1');
		$report1->shouldReceive('getProcessors')->andReturn(array('processor1', 'processor2', 'processor3'));
		$report1->shouldReceive('getInputs')->with('processor1')->andReturn(array(
			array('input' => 'input 1', 'expectedOutput' => 'expected 1', 'output' => 'output 1', 'success' => 'OK', 'correctness' => TRUE, 'sumTime' => '123.456', 'avgTime' => '444.555', 'sumMemory' => '123456789', 'avgMemory' => '987654321', 'repeating' => '111'),
			array('input' => 'input 2', 'expectedOutput' => 'expected 2', 'output' => 'output 1', 'success' => 'Error 1', 'correctness' => '', 'sumTime' => '', 'avgTime' => '', 'sumMemory' => '', 'avgMemory' => '', 'repeating' => '111'),
			array('input' => 'input 3', 'expectedOutput' => 'expected 3', 'output' => 'output 1', 'success' => 'OK', 'correctness' => FALSE, 'sumTime' => '333.666', 'avgTime' => '1.2', 'sumMemory' => '123456789', 'avgMemory' => '987654321', 'repeating' => '111'),
			array('input' => 'input 4', 'expectedOutput' => 'expected 1', 'output' => 'output 1', 'success' => 'OK', 'correctness' => TRUE, 'sumTime' => '111.222', 'avgTime' => '333.444', 'sumMemory' => '123456789', 'avgMemory' => '987654321', 'repeating' => '111'),
		));
		$report1->shouldReceive('getInputs')->with('processor2')->andReturn(array(
			array('input' => 'input 1', 'expectedOutput' => 'expected 1', 'output' => 'output 1', 'success' => 'Error 2.1', 'correctness' => '', 'sumTime' => '', 'avgTime' => '', 'sumMemory' => '', 'avgMemory' => '', 'repeating' => '111'),
			array('input' => 'input 2', 'expectedOutput' => 'expected 1', 'output' => 'output 1', 'success' => 'Error 2.2', 'correctness' => '', 'sumTime' => '', 'avgTime' => '', 'sumMemory' => '', 'avgMemory' => '', 'repeating' => '111'),
			array('input' => 'input 3', 'expectedOutput' => 'expected 1', 'output' => 'output 1', 'success' => 'Error 2.3', 'correctness' => '', 'sumTime' => '', 'avgTime' => '', 'sumMemory' => '', 'avgMemory' => '', 'repeating' => '111'),
			array('input' => 'input 4', 'expectedOutput' => 'expected 1', 'output' => 'output 1', 'success' => 'Error 2.4', 'correctness' => '', 'sumTime' => '', 'avgTime' => '', 'sumMemory' => '', 'avgMemory' => '', 'repeating' => '111'),
		));
		$report1->shouldReceive('getInputs')->with('processor3')->andReturn(array(
			array('input' => 'input 1', 'expectedOutput' => 'expected 1', 'output' => 'output 1', 'success' => 'OK', 'correctness' => TRUE, 'sumTime' => '101', 'avgTime' => '201', 'sumMemory' => '123456789', 'avgMemory' => '987654321', 'repeating' => '111'),
			array('input' => 'input 2', 'expectedOutput' => 'expected 2', 'output' => 'output 1', 'success' => 'OK', 'correctness' => FALSE, 'sumTime' => '102', 'avgTime' => '202', 'sumMemory' => '123456789', 'avgMemory' => '987654321', 'repeating' => '111'),
			array('input' => 'input 3', 'expectedOutput' => 'expected 3', 'output' => 'output 1', 'success' => 'OK', 'correctness' => TRUE, 'sumTime' => '103', 'avgTime' => '203', 'sumMemory' => '123456789', 'avgMemory' => '987654321', 'repeating' => '111'),
			array('input' => 'input 4', 'expectedOutput' => 'expected 4', 'output' => 'output 1', 'success' => 'OK', 'correctness' => FALSE, 'sumTime' => '104', 'avgTime' => '204', 'sumMemory' => '123456789', 'avgMemory' => '987654321', 'repeating' => '111'),
		));

		// report 2
		$report2 = \Mockery::mock('\XSLTBenchmarking\Reports\Report');
		$report2->shouldReceive('getTestName')->andReturn('Second test');
		$report2->shouldReceive('getTemplatePath')->andReturn('template 2');
		$report2->shouldReceive('getProcessors')->andReturn(array('processor1', 'processor2', 'processor3'));
		$report2->shouldReceive('getInputs')->with('processor1')->andReturn(array(
			array('input' => 'input 10', 'expectedOutput' => 'expected 10', 'output' => 'output 1', 'success' => 'OK', 'correctness' => TRUE, 'sumTime' => '9123.456', 'avgTime' => '9444.555', 'sumMemory' => '123456789', 'avgMemory' => '987654321', 'repeating' => '111'),
			array('input' => 'input 20', 'expectedOutput' => 'expected 20', 'output' => 'output 1', 'success' => 'Error 10', 'correctness' => '', 'sumTime' => '', 'avgTime' => '', 'sumMemory' => '', 'avgMemory' => '', 'repeating' => '111'),
			array('input' => 'input 30', 'expectedOutput' => 'expected 30', 'output' => 'output 1', 'success' => 'OK', 'correctness' => FALSE, 'sumTime' => '9333.666', 'avgTime' => '91.2', 'sumMemory' => '123456789', 'avgMemory' => '987654321', 'repeating' => '111'),
			array('input' => 'input 40', 'expectedOutput' => 'expected 10', 'output' => 'output 1', 'success' => 'OK', 'correctness' => TRUE, 'sumTime' => '9111.222', 'avgTime' => '9333.444', 'sumMemory' => '123456789', 'avgMemory' => '987654321', 'repeating' => '111'),
		));
		$report2->shouldReceive('getInputs')->with('processor2')->andReturn(array(
			array('input' => 'input 10', 'expectedOutput' => 'expected 10', 'output' => 'output 1', 'success' => 'OK', 'correctness' => TRUE, 'sumTime' => '1001', 'avgTime' => '2001', 'sumMemory' => '123456789', 'avgMemory' => '987654321', 'repeating' => '111'),
			array('input' => 'input 20', 'expectedOutput' => 'expected 20', 'output' => 'output 1', 'success' => 'OK', 'correctness' => FALSE, 'sumTime' => '1002', 'avgTime' => '2002', 'sumMemory' => '123456789', 'avgMemory' => '987654321', 'repeating' => '111'),
			array('input' => 'input 30', 'expectedOutput' => 'expected 30', 'output' => 'output 1', 'success' => 'OK', 'correctness' => TRUE, 'sumTime' => '1003', 'avgTime' => '2003', 'sumMemory' => '123456789', 'avgMemory' => '987654321', 'repeating' => '111'),
			array('input' => 'input 40', 'expectedOutput' => 'expected 40', 'output' => 'output 1', 'success' => 'OK', 'correctness' => FALSE, 'sumTime' => '1004', 'avgTime' => '2004', 'sumMemory' => '123456789', 'avgMemory' => '987654321', 'repeating' => '111'),
		));
		$report2->shouldReceive('getInputs')->with('processor3')->andReturn(array(
			array('input' => 'input 10', 'expectedOutput' => 'expected 10', 'output' => 'output 1', 'success' => 'Error 3.1', 'correctness' => '', 'sumTime' => '', 'avgTime' => '', 'sumMemory' => '', 'avgMemory' => '', 'repeating' => '111'),
			array('input' => 'input 20', 'expectedOutput' => 'expected 10', 'output' => 'output 1', 'success' => 'Error 3.2', 'correctness' => '', 'sumTime' => '', 'avgTime' => '', 'sumMemory' => '', 'avgMemory' => '', 'repeating' => '111'),
			array('input' => 'input 30', 'expectedOutput' => 'expected 10', 'output' => 'output 1', 'success' => 'Error 3.3', 'correctness' => '', 'sumTime' => '', 'avgTime' => '', 'sumMemory' => '', 'avgMemory' => '', 'repeating' => '111'),
			array('input' => 'input 40', 'expectedOutput' => 'expected 10', 'output' => 'output 1', 'success' => 'Error 3.4', 'correctness' => '', 'sumTime' => '', 'avgTime' => '', 'sumMemory' => '', 'avgMemory' => '', 'repeating' => '111'),
		));

		$this->setPropertyValue($printer, 'reports', array($report1, $report2));

		$reportFilePath1 = $printer->printAll();
		sleep(1);
		$reportFilePath2 = $printer->printAll();

		$this->assertNotEquals($reportFilePath1, $reportFilePath2);

		$this->assertXmlFileEqualsXmlFile(__DIR__ . '/expectedReport.xml', $reportFilePath1);
		$this->assertXmlFileEqualsXmlFile(__DIR__ . '/expectedReport.xml', $reportFilePath2);

		unlink($reportFilePath1);
		unlink($reportFilePath2);
		rmdir(__DIR__ . '/reports');
	}


}
