<?php

namespace PacerIT\BitBayPayAPI\Exceptions;

use Throwable;

/**
 * Class CredentialsNotSet.
 *
 * @author Wiktor Pacer <kontakt@pacerit.pl>
 *
 * @since 10/03/2020
 */
class CredentialsNotSet extends \Exception
{
    /**
     * CredentialsNotSet constructor.
     *
     * @param string         $message
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct(
        $message = '',
        $code = 0,
        Throwable $previous = null
    ) {
        $message = 'Credentials not set! Check credentials!';
        parent::__construct($message, $code, $previous);
    }
}
