<?php

/**
 * XSLT Benchmarking
 * @link https://github.com/masicek/XSLT-Benchmarking
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace XSLTBenchmarking\TestsRunner;

require_once LIBS . '/PhpPath/PhpPath.min.php';

use PhpPath\P;


/**
 * Different OS interface for class for geting maximum memory usage of command excuteb by 'exec'.
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 */
abstract class AMemoryUsageDriver
{


	/**
	 * Path of temporary directory
	 *
	 * @var string
	 */
	protected $tmpDir;


	/**
	 * Set temporary directory for possible using in drivers
	 *
	 * @param string $tmpDir Path of temporary directory
	 */
	public function __construct($tmpDir)
	{
		$this->tmpDir = P::mcd($tmpDir);
	}


	/**
	 * Prepare checking memory usage of set command.
	 * Drivers can return modified commad for better checking.
	 *
	 * @param string $command Checked command
	 *
	 * @return string
	 */
	abstract public function run($command);


	/**
	 * Return maximum memory usage (in bytes) last checked command by self::run().
	 *
	 * @return integer
	 */
	abstract public function get();


}
