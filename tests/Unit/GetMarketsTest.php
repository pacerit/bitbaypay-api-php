<?php

namespace Tests\Unit;

use Illuminate\Support\Arr;
use PacerIT\BitBayPayAPI\Exceptions\CallMethodError;
use PacerIT\BitBayPayAPI\Exceptions\CredentialsNotSet;
use PacerIT\BitBayPayAPI\Exceptions\MethodResponseFail;

/**
 * Class GetMarketsTest.
 *
 * @author Wiktor Pacer <kontakt@pacerit.pl>
 *
 * @since 11/03/2020
 */
class GetMarketsTest extends AbstractTest
{
    /**
     * Test call "stores/markets" API method when credentials are not set properly.
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

        $this->client->getMarkets();
    }

    /**
     * Test get markets.
     *
     * @throws CallMethodError
     * @throws CredentialsNotSet
     * @throws MethodResponseFail
     *
     * @author Wiktor Pacer <kontakt@pacerit.pl>
     *
     * @since 11/03/2020
     */
    public function testGetMarkets()
    {
        $response = $this->client
            ->setPublicKey($this->getTestPublicKey())
            ->setPrivateKey($this->getTestPrivateKey())
            ->getMarkets();

        $firstValue = Arr::first($response, null, []);

        $this->assertArrayHasKey('firstCurrency', $firstValue);
        $this->assertArrayHasKey('secondCurrency', $firstValue);
    }
}
