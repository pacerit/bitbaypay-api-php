<?php

namespace PacerIT\BitBayPayAPI\Tests\Unit;

use PacerIT\BitBayPayAPI\BitBayPay;
use PacerIT\BitBayPayAPI\Exceptions\MethodResponseFail;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionMethod;

/**
 * Class ParseResponseTest.
 *
 * @author Wiktor Pacer <kontakt@pacerit.pl>
 *
 * @since 27/03/2020
 */
class ParseResponseTest extends TestCase
{
    /**
     * @var ReflectionMethod
     */
    private $method;

    /**
     * Set up test.
     *
     * @author Wiktor Pacer <kontakt@pacerit.pl>
     *
     * @since 27/03/2020
     */
    protected function setUp(): void
    {
        parent::setUp();
        $class = new ReflectionClass(BitBayPay::class);
        $this->method = $class->getMethod('parseResponse');
        $this->method->setAccessible(true);
    }

    /**
     * Test when fail response has no reason key.
     *
     * @author Wiktor Pacer <kontakt@pacerit.pl>
     *
     * @since 27/03/2020
     */
    public function testWhenFailResponseHasNoReasonKey()
    {
        $this->expectException(MethodResponseFail::class);

        $response = [
            'status' => 'Fail',
            'errors' => ['UNDER_MAINTENANCE'],
        ];

        $class = new BitBayPay();
        $this->method->invokeArgs($class, [$response]);

        $message = $this->getExpectedExceptionMessage();
        $this->assertStringContainsString('UNDER_MAINTENANCE', $message);
    }

    /**
     * Test when fail response has reason key.
     *
     * @author Wiktor Pacer <kontakt@pacerit.pl>
     *
     * @since 27/03/2020
     */
    public function testWhenFailResponseHasReasonKey()
    {
        $this->expectException(MethodResponseFail::class);

        $response = [
            'status' => 'Fail',
            'errors' => [
                'reason' => 'AUTHENTICATION_FAILED',
            ],
        ];

        $class = new BitBayPay();
        $this->method->invokeArgs($class, [$response]);

        $message = $this->getExpectedExceptionMessage();
        $this->assertStringContainsString('AUTHENTICATION_FAILED', $message);
    }

    /**
     * Test when fail response has no errors key.
     *
     * @author Wiktor Pacer <kontakt@pacerit.pl>
     *
     * @since 27/03/2020
     */
    public function testWhenFailResponseHasNoErrorsKey()
    {
        $this->expectException(MethodResponseFail::class);

        $response = [
            'status' => 'Fail',
        ];

        $class = new BitBayPay();
        $this->method->invokeArgs($class, [$response]);

        $message = $this->getExpectedExceptionMessage();
        $this->assertStringContainsString('UNKNOWN_REASON', $message);
    }

    /**
     * Test when response has no status key.
     *
     * @author Wiktor Pacer <kontakt@pacerit.pl>
     *
     * @since 27/03/2020
     */
    public function testWhenResponseHasNoStatusKey()
    {
        $this->expectException(MethodResponseFail::class);

        $response = [
            'what' => 'is this?',
        ];

        $class = new BitBayPay();
        $this->method->invokeArgs($class, [$response]);

        $message = $this->getExpectedExceptionMessage();
        $this->assertStringContainsString('UNKNOWN_STATUS', $message);
    }

    /**
     * Test when ok response has no data key.
     *
     * @author Wiktor Pacer <kontakt@pacerit.pl>
     *
     * @since 27/03/2020
     */
    public function testWhenOkResponseHasNoDataKey()
    {
        $response = [
            'status' => 'Ok',
        ];

        $class = new BitBayPay();
        $results = $this->method->invokeArgs($class, [$response]);

        $this->assertIsArray($results);
        $this->assertEmpty($results);
    }

    /**
     * Test when ok response has data key.
     *
     * @author Wiktor Pacer <kontakt@pacerit.pl>
     *
     * @since 27/03/2020
     */
    public function testWhenOkResponseHasDataKey()
    {
        $data = ['success' => true];

        $response = [
            'status' => 'Ok',
            'data'   => $data,
        ];

        $class = new BitBayPay();
        $results = $this->method->invokeArgs($class, [$response]);

        $this->assertIsArray($results);
        $this->assertArrayHasKey('success', $results);
    }
}
