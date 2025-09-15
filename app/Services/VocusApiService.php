<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class VocusApiService
{
    protected string $baseUrl;
    protected string $token;

    public function __construct()
    {
        $this->baseUrl = config('vocus_api.base_url');
        $this->authenticate();
    }

    protected function authenticate(): void
    {
        try {
            $response = Http::post($this->baseUrl . 'login', [
                'email' => config('vocus_api.username'),
                'password' => config('vocus_api.password'),
             ])->throw()->json();

            if (empty($response['success']) || $response['success'] !== true) {
                Log::error('API login failed', ['response' => $response]);
                throw new \Exception('API_AUTHENTICATION_FAILED');
            }

            $this->token = $response['result']['token'];
        } catch (\Throwable $e) {
            Log::error('API login error', ['exception' => $e]);
            throw $e;
        }
    }

    /**
     * Fetch unique identifier from the API for a sample address.
     *
     * @return string
     */
    public function fetchApiUniqueNumber(): string
    {
        $sampleAddress = [
            'company_id' => 17,
            'street_name' => 'Swanston',
            'street_type' => 'Street',
            'street_number' => '120',
            'suburb' => 'Melbourne',
            'postcode' => '3000',
            'state' => 'VIC',
        ];

        try {
            $addressResponse = $this->findAddress($sampleAddress);

            if (!$addressResponse['success']) {
                throw new \Exception('Address not found');
            }

            $qualifyAddress =  $this->qualifyAddress($addressResponse['data'][0]['DirectoryIdentifier']);
            if (!$qualifyAddress['success']) {
                throw new \Exception('Address qulifing faild');
            }


            if (!empty($qualifyAddress['data']) && !$qualifyAddress['data']['api_unique_number']){

                throw new \Exception('api_unique_number attribute not found from API');

            }

            $uniqueIdentifier = !empty($qualifyAddress['data']) ? $qualifyAddress['data']['api_unique_number'] : '';

            Log::info('Fetched API Unique Identifier', ['api_unique_number' => $uniqueIdentifier]);

            return $uniqueIdentifier;
        } catch (ConnectionException $e) {
            Log::warning('API connection timeout', ['exception' => $e]);
            return "Something went wrong while connecting to the API.";
        } catch (\Throwable $e) {

            Log::error('API fetch unique number failed', ['exception' => $e]);
            return $e->getMessage();
        }
    }

    /**
     * Find address using API.
     *
     * @param  array  $addressData
     * @return array
     */
    public function findAddress(array $addressData): array
    {
        Log::info('Sending findAddress request', ['address' => $addressData]);

        return Http::timeout(10)
            ->withHeaders($this->getAuthHeaders())
            ->post($this->baseUrl . 'orders/findaddress', array_merge(['company_id' => 17], $addressData))
            ->throw()
            ->json();
    }

    /**
     * Qualify address using qualification identifier.
     *
     * @param  string  $qualificationIdentifier
     * @return array
     */
    public function qualifyAddress(string $qualificationIdentifier): array
    {
        return Http::withHeaders($this->getAuthHeaders())
            ->post($this->baseUrl . 'orders/qualify', [
                'company_id' => 17,
                'qualification_identifier' => $qualificationIdentifier,
                'service_type_id' => 3,
            ])
            ->throw()
            ->json();
    }

    /**
     * Get common authorization headers.
     *
     * @return array<string, string>
     */
    protected function getAuthHeaders(): array
    {
        return [
            'Authorization' => "Bearer {$this->token}",
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }


}
