<?php

namespace PacerIT\BitBayPayAPI\Interfaces;

use PacerIT\Exceptions\CallMethodError;
use Psr\Http\Message\ResponseInterface;

/**
 * Interface BitBayTradingInterface
 *
 * @author Wiktor Pacer <kontakt@pacerit.pl>
 *
 * @since 10/03/2020
 */
interface BitBayPayInterface
{
    const BASE_URL = 'https://api.bitbaypay.com/rest/bitbaypay/';

    // Available methods.
    const METHOD_PAYMENTS = 'payments';

    // Function parameters.
    const PARAMETER_DESTINATION_CURRENCY = 'destinationCurrency';
    const PARAMETER_PRICE = 'price';
    const PARAMETER_ORDER_ID = 'orderId';
    const PARAMETER_SOURCE_CURRENCY = 'sourceCurrency';
    const PARAMETER_COVERED_BY = 'coveredBy';
    const PARAMETER_KEEP_SOURCE_CURRENCY = 'keep_source_currency';
    const PARAMETER_SUCCESS_CALLBACK_URL = 'successCallbackUrl';
    const PARAMETER_FAILURE_CALLBACK_URL = 'failureCallbackUrl';
    const PARAMETER_NOTIFICATIONS_URL = 'notificationsUrl';

    /**
     * Set public key.
     *
     * @param string|null $publicKey
     *
     * @return $this
     *
     * @author Wiktor Pacer <kontakt@pacerit.pl>
     *
     * @since 10/03/2020
     */
    public function setPublicKey(?string $publicKey): self;

    /**
     * Set private key.
     *
     * @param string|null $privateKey
     *
     * @return $this
     *
     * @author Wiktor Pacer <kontakt@pacerit.pl>
     *
     * @since 10/03/2020
     */
    public function setPrivateKey(?string $privateKey): self;

    /**
     * Call API method.
     *
     * @param string $method
     * @param array $parameters
     * @param string $type
     *
     * @return ResponseInterface
     *
     * @throws CallMethodError
     *
     * @author Wiktor Pacer <kontakt@pacerit.pl>
     *
     * @since 10/03/2020
     */
    public function callMethod(string $method, array $parameters = [], string $type = 'GET');

    /**
     * Call "payments" API method.
     *
     * @param array $parameters
     *
     * @return array
     *
     * @throws CallMethodError
     *
     * @since 10/03/2020
     *
     * @author Wiktor Pacer <kontakt@pacerit.pl>
     */
    public function payments(array $parameters): array;
}
