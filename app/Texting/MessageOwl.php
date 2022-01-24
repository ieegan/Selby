<?php

namespace App\Texting;

use GuzzleHttp\Client;

class MessageOwl
{
	protected $config;

	public function __construct($config)
	{
		$this->sender_id = $config['sender_id'];
		$this->authorization = $config['authorization'];
		$this->otp_key = $config['otp_key'];
	}

	public function send($recipients,$body)
	{
		$client = new Client([
			'base_uri' => 'https://rest.msgowl.com',
			'headers' => ['Authorization' => $this->authorization],
			'http_errors' => false
		]);

		$response = $client->post('/messages', [
			'form_params' => [
				'sender_id' => $this->sender_id,
				'recipients' => $recipients,
				'body' => $body
			]
		]);

		return $response;
    }

    public function otp($phone_number)
	{
		$client = new Client([
			'base_uri' => 'https://otp.msgowl.com',
			'headers' => ['Authorization' => $this->otp_key],
		]);

		$response = $client->post('/send', [
            'body' => '{"phone_number": "'.$phone_number.'"}'
		]);

		return $response;
    }

    public function verify($phone_number, $code)
	{
		$client = new Client([
			'base_uri' => 'https://otp.msgowl.com',
			'headers' => ['Authorization' => $this->otp_key],
		]);

		$response = $client->post('/verify', [
            'body' => '{"phone_number": "'.$phone_number.'","code": "'.$code.'"}'
		]);

		return json_decode($response->getBody(), true);
	}
}
