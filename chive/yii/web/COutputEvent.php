<?php
/**
 * COutputEvent class file.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2008-2010 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

/**
 * COutputEvent represents the parameter for events related with output handling.
 *
 * An event handler may retrieve the captured {@link output} for further processing.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @version $Id: COutputEvent.php 1678 2010-01-07 21:02:00Z qiang.xue $
 * @package system.web
 * @since 1.0
 */
class COutputEvent extends CEvent
{
	/**
	 * @var string the output to be processed. The processed output should be stored back to this property.
	 */
	public $output;

	/**
	 * Constructor.
	 * @param mixed sender of the event
	 * @param string the output to be processed
	 */
	public function __construct($sender,$output)
	{
		parent::__construct($sender);
		$this->output=$output;
	}
}
