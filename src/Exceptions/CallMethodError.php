<?php

namespace PacerIT\BitBayPayAPI\Exceptions;

use Throwable;

/**
 * Class CallMethodError.
 *
 * @author Wiktor Pacer <kontakt@pacerit.pl>
 *
 * @since 10/03/2020
 */
class CallMethodError extends \Exception
{
    /**
     * CallMethodError constructor.
     *
     * @param string|null    $method
     * @param string|null    $details
     * @param string         $message
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct(
        ?string $method,
        ?string $details,
        $message = '',
        $code = 0,
        Throwable $previous = null
    ) {
        $message = "Call API method {$method} error! Details - {$details}";
        parent::__construct($message, $code, $previous);
    }
}
