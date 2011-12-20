<?php

/**
 * XSLT Benchmarking
 * @link https://github.com/masicek/XSLT-Benchmarking
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace XSLTBenchmarking;

/**
 * List of exceptions used in XSLT Benchmarking.
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 */


/**
 * Exceptions made by wrong calling method.
 */
class InvalidArgumentException extends \Exception
{
}


/**
 * Exception generated after incorect copping file by 'copy' function
 */
class GenerteTemplateException extends \Exception
{
}


/**
 * Exception generated if unknown method is called in __call
 */
class UnknownMethodException extends \Exception
{
}