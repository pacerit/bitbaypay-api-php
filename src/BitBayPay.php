<?php

namespace PacerIT\BitBayPayAPI;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use PacerIT\BitBayPayAPI\Exceptions\CallMethodError;
use PacerIT\BitBayPayAPI\Exceptions\CallPaymentsMethodError;
use PacerIT\BitBayPayAPI\Exceptions\CredentialsNotSet;
use PacerIT\BitBayPayAPI\Exceptions\MethodResponseFail;
use PacerIT\BitBayPayAPI\Interfaces\BitBayPayInterface;
use Psr\Http\Message\ResponseInterface;
use Rakit\Validation\Validator;

/**
 * Class BitBayPay
 *
 * @author Wiktor Pacer <kontakt@pacerit.pl>
 *
 * @since 10/03/2020
 */
class BitBayPay implements BitBayPayInterface
{
    /**
     * Public key.
     *
     * @var null
     */
    private $publicKey = null;

    /**
     * Private key.
     *
     * @var null
     */
    private $privateKey = null;

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
    public function setPublicKey(?string $publicKey): BitBayPayInterface
    {
        $this->publicKey = $publicKey;

        return $this;
    }

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
    public function setPrivateKey(?string $privateKey): BitBayPayInterface
    {
        $this->privateKey = $privateKey;

        return $this;
    }

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
     * @throws CredentialsNotSet
     *
     * @author Wiktor Pacer <kontakt@pacerit.pl>
     *
     * @since 10/03/2020
     */
    public function callMethod(string $method, array $parameters = [], string $type = 'GET'): ResponseInterface
    {
        $this->checkCredentials();

        $client = new Client();

        // Generate sign key.
        $time = time();
        $post = null;
        if ($type !== 'GET') {
            $post = json_encode($parameters);
        }
        $sign = hash_hmac("sha512", $this->publicKey . $time . $post, $this->privateKey);

        try {
            $response = $client->request(
                $type,
                BitBayPayInterface::BASE_URL.$method,
                [
                    'form_params' => $parameters,
                    'headers'     => [
                        'API-Key'           => $this->publicKey,
                        'API-Hash'          => $sign,
                        'operation-id'      => (string)Str::uuid(),
                        'Request-Timestamp' => $time,
                        'Content-Type'      => 'application/json'
                    ]
                ]
            );
        } catch (ClientException $exception) {
            throw new CallMethodError($method, $exception->getMessage());
        }

        return $response;
    }

    /**
     * Call "payments" API method.
     *
     * @param array $parameters
     *
     * @return array
     *
     * @throws CallMethodError
     * @throws CallPaymentsMethodError
     * @throws CredentialsNotSet
     * @throws MethodResponseFail
     *
     * @since 10/03/2020
     *
     * @author Wiktor Pacer <kontakt@pacerit.pl>
     */
    public function createPayment(array $parameters): array
    {
        $validator = new Validator;
        $validation = $validator->make(
            $parameters,
            [
                BitBayPayInterface::PARAMETER_DESTINATION_CURRENCY => 'required',
                BitBayPayInterface::PARAMETER_PRICE                => 'required|numeric',
                BitBayPayInterface::PARAMETER_ORDER_ID             => 'required',
            ]
        );

        $validation->validate();

        if ($validation->fails()) {
            throw new CallPaymentsMethodError(json_encode($validation->errors()->toArray()));
        }

        $response = $this->callMethod(
            BitBayPayInterface::METHOD_PAYMENTS,
            $parameters,
            'POST'
        );

        return $this->parseResponse(json_decode($response->getBody(), true));
    }

    /**
     * Call "payments/{paymentId}" API method.
     *
     * @param string $paymentID
     *
     * @return array
     *
     * @throws CallMethodError
     * @throws CredentialsNotSet
     * @throws MethodResponseFail
     *
     * @author Wiktor Pacer <kontakt@pacerit.pl>
     *
     * @since 11/03/2020
     */
    public function getPayment(string $paymentID): array
    {
        $response = $this->callMethod(
            BitBayPayInterface::METHOD_PAYMENTS.'/'.$paymentID,
            [],
            'GET'
        );

        return $this->parseResponse(json_decode($response->getBody(), true));
    }

    /**
     * Call "stores/currenciesSettings" API method.
     *
     * @return array
     *
     * @throws CallMethodError
     * @throws CredentialsNotSet
     * @throws MethodResponseFail
     *
     * @author Wiktor Pacer <kontakt@pacerit.pl>
     *
     * @since 11/03/2020
     */
    public function getCurrenciesSettings(): array
    {
        $response = $this->callMethod(
            BitBayPayInterface::METHOD_STORES_CURRENCIES_SETTINGS,
            [],
            'GET'
        );

        return $this->parseResponse(json_decode($response->getBody(), true));
    }

    /**
     * Call "stores/markets" API method.
     *
     * @return array
     *
     * @throws CallMethodError
     * @throws CredentialsNotSet
     * @throws MethodResponseFail
     *
     * @author Wiktor Pacer <kontakt@pacerit.pl>
     *
     * @since 11/03/2020
     */
    public function getMarkets(): array
    {
        $response = $this->callMethod(
            BitBayPayInterface::METHOD_STORES_MARKETS,
            [],
            'GET'
        );

        return $this->parseResponse(json_decode($response->getBody(), true));
    }

    /**
     * Call "payments/search" API function.
     *
     * @param array $parameters
     *
     * @return array
     * @throws CallMethodError
     * @throws CredentialsNotSet
     * @throws MethodResponseFail
     *
     * @author Wiktor Pacer <kontakt@pacerit.pl>
     *
     * @since 11/03/2020
     */
    public function searchPayments(array $parameters): array
    {
        $response = $this->callMethod(
            BitBayPayInterface::METHOD_PAYMENTS_SEARCH,
            $parameters,
            'GET'
        );

        return $this->parseResponse(json_decode($response->getBody(), true));
    }

    /**
     * Parse response.
     *
     * @param array $response
     *
     * @return mixed
     * @throws MethodResponseFail
     * @author Wiktor Pacer <kontakt@pacerit.pl>
     *
     * @since 10/03/2020
     */
    private function parseResponse(array $response)
    {
        // Checking response status.
        switch (Arr::get($response, BitBayPayInterface::STATUS)) {
            case BitBayPayInterface::STATUS_OK:
                return Arr::get($response, BitBayPayInterface::DATA, []);

            case BitBayPayInterface::STATUS_FAIL:
                $errors = Arr::get($response, BitBayPayInterface::ERRORS, []);
                $reason = Arr::get($errors, BitBayPayInterface::REASON, 'UNKNOWN_REASON');
                throw new MethodResponseFail($reason);

            default:
                throw new MethodResponseFail('UNKNOWN_STATUS');
        }
    }

    /**
     * Check credentials are set properly.
     *
     * @throws CredentialsNotSet
     *
     * @author Wiktor Pacer <kontakt@pacerit.pl>
     *
     * @since 10/03/2020
     */
    private function checkCredentials()
    {
        if ($this->privateKey === null || $this->publicKey === null) {
            throw new CredentialsNotSet();
        }
    }
}
