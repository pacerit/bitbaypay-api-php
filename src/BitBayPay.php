<?php

namespace PacerIT\BitBayPayAPI;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use PacerIT\BitBayPayAPI\Interfaces\BitBayPayInterface;
use PacerIT\Exceptions\CallMethodError;
use PacerIT\Exceptions\CallPaymentsMethodError;
use Psr\Http\Message\ResponseInterface;

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
     *
     * @author Wiktor Pacer <kontakt@pacerit.pl>
     *
     * @since 10/03/2020
     */
    public function callMethod(string $method, array $parameters = [], string $type = 'GET'): ResponseInterface
    {
        $client = new Client();

        // Generate sign key.
        $time = time();
        $sign = hash_hmac("sha512", $this->publicKey . $time . json_encode($parameters), $this->privateKey);

        try {
            $response = $client->request(
                $type,
                BitBayPayInterface::BASE_URL.$method,
                [
                    'form_params' => $parameters,
                    'headers'     => [
                        'API-Key: ' . $this->publicKey,
                        'API-Hash: ' . $sign,
                        'operation-id: ' . Str::uuid(),
                        'Request-Timestamp: ' . $time,
                        'Content-Type: application/json'
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
     *
     * @since 10/03/2020
     *
     * @author Wiktor Pacer <kontakt@pacerit.pl>
     */
    public function payments(array $parameters): array
    {
        $validator = Validator::make(
            $parameters,
            [
                BitBayPayInterface::PARAMETER_DESTINATION_CURRENCY => 'required|string',
                BitBayPayInterface::PARAMETER_PRICE                => 'required|numeric',
                BitBayPayInterface::PARAMETER_ORDER_ID             => 'required|string',
                BitBayPayInterface::PARAMETER_SOURCE_CURRENCY      => 'nullable|string',
                BitBayPayInterface::PARAMETER_COVERED_BY           => 'nullable|string',
                BitBayPayInterface::PARAMETER_KEEP_SOURCE_CURRENCY => 'nullable|boolean',
                BitBayPayInterface::PARAMETER_SUCCESS_CALLBACK_URL => 'nullable|string',
                BitBayPayInterface::PARAMETER_FAILURE_CALLBACK_URL => 'nullable|string',
                BitBayPayInterface::PARAMETER_NOTIFICATIONS_URL    => 'nullable|string',
            ]
        );

        if ($validator->fails()) {
            throw new CallPaymentsMethodError($validator->errors()->toJson());
        }

        $response = $this->callMethod(
            BitBayPayInterface::METHOD_PAYMENTS,
            $parameters,
            'POST'
        );

        return json_decode($response->getBody(), true);
    }
}
