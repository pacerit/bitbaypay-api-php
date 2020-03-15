<?php

namespace PacerIT\BitBayPayAPI\Exceptions;

use Throwable;

/**
 * Class MethodResponseFail.
 *
 * @author Wiktor Pacer <kontakt@pacerit.pl>
 *
 * @since 10/03/2020
 */
class MethodResponseFail extends \Exception
{
    /**
     * MethodResponseFail constructor.
     *
     * @param string|null    $reason
     * @param string         $message
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct(
        ?string $reason,
        $message = '',
        $code = 0,
        Throwable $previous = null
    ) {
        $message = "Method return status fail!. Reason - {$reason}";
        parent::__construct($message, $code, $previous);
    }
}
