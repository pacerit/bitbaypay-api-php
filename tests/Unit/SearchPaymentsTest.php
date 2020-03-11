<?php

namespace Tests\Unit;

use PacerIT\BitBayPayAPI\Exceptions\CallMethodError;
use PacerIT\BitBayPayAPI\Exceptions\CredentialsNotSet;
use PacerIT\BitBayPayAPI\Exceptions\MethodResponseFail;

/**
 * Class SearchPaymentsTest
 *
 * @author Wiktor Pacer <kontakt@pacerit.pl>
 *
 * @since 11/03/2020
 */
class SearchPaymentsTest extends AbstractTest
{
    /**
     * Test call "payments/search" API method when credentials are not set properly.
     *
     * @throws CredentialsNotSet
     * @throws CallMethodError
     * @throws MethodResponseFail
     * @author Wiktor Pacer <kontakt@pacerit.pl>
     *
     * @since 11/03/2020
     */
    public function testCredentialsNotSet()
    {
        $this->expectException(CredentialsNotSet::class);

        $this->client->searchPayments([]);
    }

    /**
     * Test search payments.
     *
     * @throws CallMethodError
     * @throws CredentialsNotSet
     * @throws MethodResponseFail
     * @author Wiktor Pacer <kontakt@pacerit.pl>
     *
     * @since 11/03/2020
     */
    public function testSearch()
    {
        $response = $this->client
            ->setPublicKey($this->getTestPublicKey())
            ->setPrivateKey($this->getTestPrivateKey())
            ->searchPayments([]);

        $this->assertArrayHasKey('page', $response);
        $this->assertArrayHasKey('pageNumber', $response);
        $this->assertArrayHasKey('hasNextPage', $response);
        $this->assertArrayHasKey('totalPages', $response);
    }
}
