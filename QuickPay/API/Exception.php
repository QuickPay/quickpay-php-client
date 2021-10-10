<?php
namespace QuickPay\API;

/**
 * @class       QuickPay_Exception
 * @extends     Exception
 * @since       0.1.0
 * @package     QuickPay
 * @category    Class
 * @author      Patrick Tolvstein, Perfect Solution ApS
 * @docs        http://learn.quickpay.net/tech-talk/api//
 */
class Exception extends \Exception
{
    /**
     * __Construct function.
     *
     * Redefine the exception so message isn't optional
     *
     * @access public
     */
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        // Make sure everything is assigned properly
        parent::__construct($message, $code, $previous);
    }
}
