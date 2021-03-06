<?php

/*
 * XSLT Benchmarking
 * @link https://github.com/masicek/XSLT-Benchmarking
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace XSLTBenchmarking\TestsRunner;

require_once ROOT . '/Exceptions.php';

/**
 * Abstract class for coleting information about one processor
 * and making command template for their running
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 */
abstract class AProcessorDriver
{

	/**
	 * Saxon kernel names
	 */
	const KERNEL_SAXON = 'Saxon';
	const KERNEL_LIBXSLT = 'libxslt';
	const KERNEL_SABLOTRON = 'Sablotron';
	const KERNEL_XALAN = 'Xalan';
	const KERNEL_XT = 'XT';
	const KERNEL_MSXML = 'MSXML';

	/**
	 * Value of PHP_OS for Windows
	 */
	const OS_WIN = 'WINNT';

	/**
	 * Value of PHP_OS for Linux
	 */
	const OS_LINUX = 'Linux';


	/**
	 * Short name of the processor
	 *
	 * @return string
	 */
	public function getName()
	{
		$className = get_class($this);
		$start = strrpos($className, '\\') + 1;
		$name = substr($className, $start, -15);
		return strtolower($name);
	}


	/**
	 * Return information about processor
	 *
	 * @return array
	 */
	public function getInformations()
	{
		return array(
			'fullName' => $this->getFullName(),
			'kernel' => $this->getKernel(),
		);
	}


	/**
	 * Preparing command template for transformation, that are not include in measured time.
	 *
	 * Templates substitutions:
	 * [XSLT] = path of XSLT template for transformation
	 * [INPUT] = path of input XML file
	 * [OUTPUT] = path of generated output XML file
	 * [ERROR] = path of file for eventual generated error message
	 * [PROCESSORS] = path of directory containing XSLT processors (libraries, command-line program etc.)
	 * [LIBS] = path of Libs directory
	 *
	 * @return string
	 */
	public function getBeforeCommandTemplate()
	{
		return '';
	}


	/**
	 * Concluding command template for transformation, that are not include in measured time.
	 *
	 * Templates substitutions:
	 * [XSLT] = path of XSLT template for transformation
	 * [INPUT] = path of input XML file
	 * [OUTPUT] = path of generated output XML file
	 * [ERROR] = path of file for eventual generated error message
	 * [PROCESSORS] = path of directory containing XSLT processors (libraries, command-line program etc.)
	 * [LIBS] = path of Libs directory
	 *
	 * @return string
	 */
	public function getAfterCommandTemplate()
	{
		return '';
	}


	/**
	 * Flag, if template for transformating has to be set in input XML
	 * by directive "<?xml-stylesheet href="[XSLT]" type="text/xml" ..."
	 *
	 * @return bool
	 */
	public function isTemplateSetInInput()
	{
		return FALSE;
	}


	/**
	 * Return flag, if the driver is available.
	 * For example, it can be used for distinguish OS.
	 *
	 * @return bool
	 */
	abstract public function isAvailable();


	/**
	 * Return template of command
	 *
	 * Templates substitutions:
	 * [XSLT] = path of XSLT template for transformation
	 * [INPUT] = path of input XML file
	 * [OUTPUT] = path of generated output XML file
	 * [ERROR] = path of file for eventual generated error message
	 * [PROCESSORS] = path of directory containing XSLT processors (libraries, command-line program etc.)
	 * [LIBS] = path of Libs directory
	 *
	 * @return string
	 */
	abstract public function getCommandTemplate();


	/**
	 * Full name of processor (with version)
	 *
	 * @return string
	 */
	abstract public function getFullName();


	/**
	 * Return name of processor kernel.
	 * Available kernels are const of this class with prefix "KERNEL_"
	 *
	 * Examples:
	 * Saxon 6.5.5 -> Saxon
	 * xsltproc -> libxslt
	 *
	 * @return string
	 */
	abstract public function getKernel();


}
