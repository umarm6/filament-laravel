<?php

namespace Tests\Unit\Services;

use App\Services\VocusApiService;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use Illuminate\Http\Client\ConnectionException;

class VocusApiServiceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Fake login response for all tests
        Http::fake([
            'https://extranet.asmorphic.com/api/login' => Http::response([
                'success' => true,
                'result' => ['token' => 'fake-token'],
            ], 200),
        ]);
    }

    public function test_authenticate_sets_token()
    {
        $service = new VocusApiService();
        $this->assertEquals('fake-token', $this->getPrivateProperty($service, 'token'));
    }

    public function test_fetch_api_unique_number_returns_unique_identifier()
    {
        // Fake findAddress API call response
        Http::fake([
            'https://extranet.asmorphic.com/api/orders/findaddress' => Http::response([
                'data' => ['unique_identifier' => 'abc123'],
            ], 200),
        ]);

        $service = new VocusApiService();
        $uniqueId = $service->fetchApiUniqueNumber();

        $this->assertEquals('abc123', $uniqueId);
    }

    public function test_fetch_api_unique_number_handles_connection_exception()
    {
        Http::fake([
            'https://extranet.asmorphic.com/api/orders/findaddress' => fn () => throw new ConnectionException('timeout'),
        ]);

        $service = new VocusApiService();
        $uniqueId = $service->fetchApiUniqueNumber();

        $this->assertStringStartsWith('SIMULATED_ID_', $uniqueId);
    }

    public function test_find_address_returns_expected_response()
    {
        $sampleAddress = [
            'company_id' => 17,
            'street_name' => 'Collins',
            'street_type' => 'Street',
            'street_number' => '254',
            'suburb' => 'Melbourne',
            'postcode' => '3000',
            'state' => 'VIC',
        ];

        Http::fake([
            'https://extranet.asmorphic.com/api/orders/findaddress' => Http::response([
                'status' => 'success',
                'data' => $sampleAddress,
            ], 200),
        ]);

        $service = new VocusApiService();
        $response = $service->findAddress($sampleAddress);

        $this->assertArrayHasKey('status', $response);
        $this->assertEquals('success', $response['status']);
    }

    public function test_qualify_address_returns_expected_response()
    {
        Http::fake([
            'https://extranet.asmorphic.com/api/orders/qualify' => Http::response([
                'status' => 'qualified',
                'qualification_id' => 'qual-123',
            ], 200),
        ]);

        $service = new VocusApiService();
        $response = $service->qualifyAddress('qual-123');

        $this->assertArrayHasKey('status', $response);
        $this->assertEquals('qualified', $response['status']);
    }

    /**
     * Helper to access protected/private properties for testing.
     */
    protected function getPrivateProperty(object $object, string $property)
    {
        $reflection = new \ReflectionClass($object);
        $prop = $reflection->getProperty($property);
        $prop->setAccessible(true);
        return $prop->getValue($object);
    }
}
