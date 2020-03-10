<?php

namespace Tests\Unit;

use Illuminate\Support\Str;
use PacerIT\BitBayPayAPI\BitBayPay;
use PacerIT\BitBayPayAPI\Exceptions\CallMethodError;
use PacerIT\BitBayPayAPI\Exceptions\CallPaymentsMethodError;
use PacerIT\BitBayPayAPI\Exceptions\CredentialsNotSet;
use PacerIT\BitBayPayAPI\Exceptions\MethodResponseFail;
use PacerIT\BitBayPayAPI\Interfaces\BitBayPayInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class PaymentsMethodTest
 *
 * @author Wiktor Pacer <kontakt@pacerit.pl>
 *
 * @since 10/03/2020
 */
class PaymentsMethodTest extends TestCase
{
    /**
     * @var BitBayPay
     */
    private $client;

    /**
     * Set up test.
     *
     * @author Wiktor Pacer <kontakt@pacerit.pl>
     *
     * @since 10/03/2020
     */
    public function setUp()
    {
        parent::setUp();
        $this->client = new BitBayPay();
    }

    /**
     * Tear down test.
     *
     * @author Wiktor Pacer <kontakt@pacerit.pl>
     *
     * @since 10/03/2020
     */
    public function tearDown()
    {
        parent::tearDown();
        $this->client = null;
    }

    /**
     * Test call "payments" API method when credentials are not set properly.
     *
     * @throws CallMethodError
     * @throws CallPaymentsMethodError
     * @throws CredentialsNotSet
     * @throws MethodResponseFail
     * @author Wiktor Pacer <kontakt@pacerit.pl>
     *
     * @since 10/03/2020
     */
    public function testCredentialsNotSet()
    {
        $this->expectException(CredentialsNotSet::class);

        $this->client->payments(
            [
                BitBayPayInterface::PARAMETER_DESTINATION_CURRENCY => 'PLN',
                BitBayPayInterface::PARAMETER_PRICE                => '1000',
                BitBayPayInterface::PARAMETER_ORDER_ID             => Str::random(16),
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
            ->payments([]);
    }
}
