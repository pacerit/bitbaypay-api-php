<?php

namespace PacerIT\BitBayPayAPI\Exceptions;

use Throwable;

/**
 * Class CallPaymentsMethodError
 *
 * @author Wiktor Pacer <kontakt@pacerit.pl>
 *
 * @since 10/03/2020
 */
class CallPaymentsMethodError extends \Exception
{
    /**
     * CallPaymentsMethodError constructor.
     *
     * @param string|null $details
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(
        ?string $details,
        $message = "",
        $code = 0,
        Throwable $previous = null
    ) {
        $message = "Call payments API method error! Check given parameters! Details - {$details}";
        parent::__construct($message, $code, $previous);
    }
}
