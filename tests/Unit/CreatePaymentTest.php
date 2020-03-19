<?php

namespace Tests\Unit;

use PacerIT\BitBayPayAPI\Exceptions\CallMethodError;
use PacerIT\BitBayPayAPI\Exceptions\CallPaymentsMethodError;
use PacerIT\BitBayPayAPI\Exceptions\CredentialsNotSet;
use PacerIT\BitBayPayAPI\Exceptions\MethodResponseFail;
use PacerIT\BitBayPayAPI\Interfaces\BitBayPayInterface;

/**
 * Class CreatePaymentTest.
 *
 * @author Wiktor Pacer <kontakt@pacerit.pl>
 *
 * @since 10/03/2020
 */
class CreatePaymentTest extends AbstractTest
{
    /**
     * Test call "payments" API method when credentials are not set properly.
     *
     * @throws CallMethodError
     * @throws CallPaymentsMethodError
     * @throws CredentialsNotSet
     * @throws MethodResponseFail
     *
     * @author Wiktor Pacer <kontakt@pacerit.pl>
     *
     * @since 10/03/2020
     */
    public function testCredentialsNotSet()
    {
        $this->expectException(CredentialsNotSet::class);

        $this->client->createPayment(
            [
                BitBayPayInterface::PARAMETER_DESTINATION_CURRENCY => 'PLN',
                BitBayPayInterface::PARAMETER_PRICE                => '1000',
                BitBayPayInterface::PARAMETER_ORDER_ID             => 'randomstring',
            ]
        );
    }

    /**
     * Test call "payments" API method without required parameters.
     *
     * @throws CallMethodError
     * @throws CallPaymentsMethodError
     * @throws CredentialsNotSet
     * @throws MethodResponseFail
     *
     * @author Wiktor Pacer <kontakt@pacerit.pl>
     *
     * @since 10/03/2020
     */
    public function testNoParameters()
    {
        $this->expectException(CallPaymentsMethodError::class);

        $this->client
            ->setPublicKey('example')
            ->setPrivateKey('example')
            ->createPayment([]);
    }

    /**
     * Test create payment.
     *
     * @throws CallMethodError
     * @throws CallPaymentsMethodError
     * @throws CredentialsNotSet
     * @throws MethodResponseFail
     *
     * @author Wiktor Pacer <kontakt@pacerit.pl>
     *
     * @since 11/03/2020
     */
    public function testCreate()
    {
        $response = $this->client
            ->setPublicKey($this->getTestPublicKey())
            ->setPrivateKey($this->getTestPrivateKey())
            ->createPayment(
                [
                    BitBayPayInterface::PARAMETER_DESTINATION_CURRENCY => 'PLN',
                    BitBayPayInterface::PARAMETER_PRICE                => 100,
                    BitBayPayInterface::PARAMETER_ORDER_ID             => 'randomstring',
                ]
            );

        $this->assertArrayHasKey('paymentId', $response);
        $this->assertArrayHasKey('url', $response);
    }
}
