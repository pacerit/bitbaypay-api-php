<?php

namespace PacerIT\BitBayPayAPI\Interfaces;

use PacerIT\BitBayPayAPI\Exceptions\CallMethodError;
use PacerIT\BitBayPayAPI\Exceptions\CallPaymentsMethodError;
use PacerIT\BitBayPayAPI\Exceptions\CredentialsNotSet;
use PacerIT\BitBayPayAPI\Exceptions\MethodResponseFail;
use Psr\Http\Message\ResponseInterface;

/**
 * Interface BitBayTradingInterface.
 *
 * @author Wiktor Pacer <kontakt@pacerit.pl>
 *
 * @since 10/03/2020
 */
interface BitBayPayInterface
{
    const BASE_URL = 'https://api.bitbaypay.com/rest/bitbaypay/';
    const PUBLIC_KEY = 'public_key';
    const PRIVATE_KEY = 'private_key';
    const STATUS = 'status';
    const ERRORS = 'errors';
    const REASON = 'reason';
    const DATA = 'data';

    // Available statuses.
    const STATUS_OK = 'Ok';
    const STATUS_FAIL = 'Fail';

    // Available methods.
    const METHOD_PAYMENTS = 'payments';
    const METHOD_PAYMENTS_SEARCH = 'payments/search';
    const METHOD_STORES_CURRENCIES_SETTINGS = 'stores/currenciesSettings';
    const METHOD_STORES_MARKETS = 'stores/markets';

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
     * @param array  $parameters
     * @param string $type
     *
     * @throws CallMethodError
     * @throws CredentialsNotSet
     *
     * @return ResponseInterface
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
     * @throws CallMethodError
     * @throws CallPaymentsMethodError
     * @throws CredentialsNotSet
     * @throws MethodResponseFail
     *
     * @return array
     *
     * @since 10/03/2020
     *
     * @author Wiktor Pacer <kontakt@pacerit.pl>
     */
    public function createPayment(array $parameters): array;

    /**
     * Call "payments/{paymentId}" API method.
     *
     * @param string $paymentID
     *
     * @throws CallMethodError
     * @throws CredentialsNotSet
     * @throws MethodResponseFail
     *
     * @return array
     *
     * @author Wiktor Pacer <kontakt@pacerit.pl>
     *
     * @since 11/03/2020
     */
    public function getPayment(string $paymentID): array;

    /**
     * Call "stores/currenciesSettings" API method.
     *
     * @throws CallMethodError
     * @throws CredentialsNotSet
     * @throws MethodResponseFail
     *
     * @return array
     *
     * @author Wiktor Pacer <kontakt@pacerit.pl>
     *
     * @since 11/03/2020
     */
    public function getCurrenciesSettings(): array;

    /**
     * Call "stores/markets" API method.
     *
     * @throws CallMethodError
     * @throws CredentialsNotSet
     * @throws MethodResponseFail
     *
     * @return array
     *
     * @author Wiktor Pacer <kontakt@pacerit.pl>
     *
     * @since 11/03/2020
     */
    public function getMarkets(): array;

    /**
     * Call "payments/search" API function.
     *
     * @param array $parameters
     *
     * @throws CallMethodError
     * @throws CredentialsNotSet
     * @throws MethodResponseFail
     *
     * @return array
     *
     * @author Wiktor Pacer <kontakt@pacerit.pl>
     *
     * @since 11/03/2020
     */
    public function searchPayments(array $parameters): array;
}
