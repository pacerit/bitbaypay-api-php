<?php

namespace Tests\Unit;

use Illuminate\Support\Str;
use PacerIT\BitBayPayAPI\Exceptions\CallMethodError;
use PacerIT\BitBayPayAPI\Exceptions\CredentialsNotSet;
use PacerIT\BitBayPayAPI\Exceptions\MethodResponseFail;

/**
 * Class GetPaymentTest.
 *
 * @author Wiktor Pacer <kontakt@pacerit.pl>
 *
 * @since 11/03/2020
 */
class GetPaymentTest extends AbstractTest
{
    /**
     * Test call "payments/{paymentId}" API method when credentials are not set properly.
     *
     * @throws CredentialsNotSet
     * @throws CallMethodError
     * @throws MethodResponseFail
     *
     * @author Wiktor Pacer <kontakt@pacerit.pl>
     *
     * @since 11/03/2020
     */
    public function testCredentialsNotSet()
    {
        $this->expectException(CredentialsNotSet::class);

        $this->client->getPayment(Str::uuid());
    }

    /**
     * Test get payment.
     *
     * @throws CallMethodError
     * @throws CredentialsNotSet
     * @throws MethodResponseFail
     *
     * @author Wiktor Pacer <kontakt@pacerit.pl>
     *
     * @since 11/03/2020
     */
    public function testGetNotExistingPayment()
    {
        $this->expectException(CallMethodError::class);

        $this->client
            ->setPublicKey($this->getTestPublicKey())
            ->setPrivateKey($this->getTestPrivateKey())
            ->getPayment(Str::uuid());
    }
}
