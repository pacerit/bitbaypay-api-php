<?php

namespace Tests\Unit;

use PacerIT\BitBayPayAPI\Exceptions\CallMethodError;
use PacerIT\BitBayPayAPI\Exceptions\CredentialsNotSet;
use PacerIT\BitBayPayAPI\Exceptions\MethodResponseFail;

/**
 * Class GetCurrenciesSettingsTest.
 *
 * @author Wiktor Pacer <kontakt@pacerit.pl>
 *
 * @since 11/03/2020
 */
class GetCurrenciesSettingsTest extends AbstractTest
{
    /**
     * Test call "stores/currenciesSettings" API method when credentials are not set properly.
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

        $this->client->getCurrenciesSettings();
    }

    /**
     * Test get currencies settings.
     *
     * @throws CallMethodError
     * @throws CredentialsNotSet
     * @throws MethodResponseFail
     *
     * @author Wiktor Pacer <kontakt@pacerit.pl>
     *
     * @since 11/03/2020
     */
    public function testGetCurrenciesSettings()
    {
        $response = $this->client
            ->setPublicKey($this->getTestPublicKey())
            ->setPrivateKey($this->getTestPrivateKey())
            ->getCurrenciesSettings();

        $firstValue = reset($response);

        $this->assertArrayHasKey('currency', $firstValue);
        $this->assertArrayHasKey('paymentMinValue', $firstValue);
        $this->assertArrayHasKey('paymentMaxValue', $firstValue);
        $this->assertArrayHasKey('outgoingPaymentMinValue', $firstValue);
        $this->assertArrayHasKey('outgoingPaymentMaxValue', $firstValue);
        $this->assertArrayHasKey('paymentEnable', $firstValue);
        $this->assertArrayHasKey('outgoingPaymentEnable', $firstValue);
    }
}
