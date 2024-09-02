<?php

namespace App\Integrations;
use App\Models\Bank\BankAccount;
use App\Traits\V1\PaystackPaymentTrait;
use Exception;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
  public static function payment()
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
    $query = ['country' => 'nigeria', 'perPage' => 100, 'currency' => 'NGN'];
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

  /**
   * @param BankAccount $account
   * @return mixed
   */
  public function createRecipient(BankAccount $bank_account)
  {
    $fields = [
      "type" => "nuban",
      "name" => $bank_account->account_name,
      "account_number" => $bank_account->account_number,
      "bank_code" => $bank_account->bank_code,
      "currency" => "NGN"
    ];

    $endpoint = "$this->base_url/transferrecipient";
    $response = $this->http->post($endpoint, $fields);
    return $response->json();
  }

  /**
   * @param string $account_number
   * @param int $bank_code
   * @return mixed
   */
  public function resolveAccountNumber($account_number, $bank_code)
  {
    $params = "account_number=$account_number&bank_code=$bank_code";
    $endpoint = "$this->base_url/bank/resolve?$params";
    Log::info($endpoint);
    $response = $this->http->get($endpoint);
    return $response->json();
  }

  /**
   * @param string $reference
   * @return mixed
   */
  public function webhook(string $reference)
  {
    $endpoint = "$this->base_url/transfer/verify/$reference";
    $response = $this->http->get($endpoint);
    return $response->json();
  }

  /**
   * @param array $fields,
   * @return mixed
   */
  public function initiateTransfer(array $fields)
  {
    $constants = ['source' => 'balance', 'reason' => 'Order payment'];
    $endpoint = "$this->base_url/transfer";
    $response = $this->http->post($endpoint, [...$fields, ...$constants]);
    return $response->json();
  }

  /**
   * @param array $transfers,
   * @return mixed
   */
  public function initiateBultTransfer(array $transfers)
  {
    [
      "amount" => 30000,
      "reference" => "YunoTReF35e0r4J",
      "reason" => "Because I can",
      "recipient" => "RCP_1a25w1h3n0xctjg"
    ];
    $constants = ['source' => 'balance', 'reason' => 'Order payment'];
    $endpoint = "$this->base_url/transfer/bulk";
    $response = $this->http->post($endpoint, [...$constants, ...$transfers]);
    return $response->json();
  }

  /**
   * @param string $reference
   * @return mixed
   */
  public function verifyTransfer(string $reference)
  {
    $endpoint = "$this->base_url/transfer/verify/$reference";
    $response = $this->http->get($endpoint);
    return $response->json();
  }

}
