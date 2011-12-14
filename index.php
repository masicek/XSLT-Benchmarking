<?php

/**
 * XSLT Benchmarking
 *
 * Main script for runnig XSLT Benchmarking.
 * Detect Web/Console and run relevant class.
 *
 * @link https://github.com/masicek/XSLT-Benchmarking
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

// run XSLT Benchmarking
if (isset($_SERVER['HTTP_USER_AGENT']))
{
	echo 'Using from web is not supported now.';
}
else
{
	require_once __DIR__ . '/RunnerConsole/Runner.php';
	$runner = new \XSLTBenchmark\RunnerConsole\Runner(__DIR__);
	$runner->run();
}
