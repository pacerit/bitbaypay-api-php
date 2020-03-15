<?php

namespace Tests\Unit;

use PacerIT\BitBayPayAPI\BitBayPay;
use PHPUnit\Framework\TestCase;

/**
 * Class AbstractTest.
 *
 * @author Wiktor Pacer <kontakt@pacerit.pl>
 *
 * @since 11/03/2020
 */
abstract class AbstractTest extends TestCase
{
    /**
     * @var BitBayPay
     */
    protected $client;

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
     * Get public key to use in test.
     *
     * @return string|null
     *
     * @author Wiktor Pacer <kontakt@pacerit.pl>
     *
     * @since 11/03/2020
     */
    public function getTestPublicKey(): ?string
    {
        return env('BITBAYPAY_TEST_PUBLIC_KEY');
    }

    /**
     * Get private key to use in test.
     *
     * @return string|null
     *
     * @author Wiktor Pacer <kontakt@pacerit.pl>
     *
     * @since 11/03/2020
     */
    public function getTestPrivateKey(): ?string
    {
        return env('BITBAYPAY_TEST_PRIVATE_KEY');
    }
}
