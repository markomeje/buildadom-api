<?php

namespace App\Integrations;
use App\Traits\PaystackPaymentTrait;
use Exception;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class Paystack
{
  use PaystackPaymentTrait;

  /**
   * @var string
   */
  private $base_url;

  /**
   * @var PendingRequest
   */
  private $http;

  /**
   * @param $http
   * @param string $base_url
   */
  public function __construct($http, string $base_url)
  {
    $this->http = $http;
    $this->base_url = $base_url;
  }

  /**
   * @return self
   */
  public static function payment(): self
  {
    $http = Http::withToken(config('services.paystack.secret_key'));
    $base_url = config('services.paystack.base_url');
    return new self($http, $base_url);
  }

  /**
   * @return mixed
   */
  public function banks()
  {
    $endpoint = "$this->base_url/bank";
    $query = ['country' => 'nigeria', 'perPage' => 100, 'currency' => 'NG'];
    $response = $this->http->get($endpoint, $query);
    return $response->json();
  }

  /**
   * @param array $payload
   * @return mixed
   */
  public function initialize(array $payload)
  {
    $endpoint = "$this->base_url/transaction/initialize";
    $result = $this->http->post($endpoint, $payload);
    $response = $result->json();
    $this->validateResponse($response);

    return $response;
  }

  /**
   * @param string $reference
   * @return mixed
   */
  public function verify(string $reference)
  {
    $endpoint = "$this->base_url/transaction/verify/$reference";
    $response = $this->http->get($endpoint);
    return $response->json();
  }

}
