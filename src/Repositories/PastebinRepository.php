<?php
declare(strict_types = 1);

namespace OrangeShadow\PastebinApi\Repositories;

use OrangeShadow\PastebinApi\Exceptions;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\ClientException;

class PastebinRepository
{

    private $pastebin_host = "https://pastebin.com/";

    private $api_dev_key;

    private $client;

    /**
     * PastebinApi constructor.
     *
     * @param $api_dev_key
     *
     */
    public function __construct(string $api_dev_key)
    {
        $this->api_dev_key = $api_dev_key;
        $this->client = new Client();
    }

    /**
     * Create Paste
     *
     * @param $attributes
     * @return string
     *
     */
    public function createPaste(array $attributes):string
    {
        $attributes['api_option'] = 'paste';

        return $this->sendRequest('POST', 'api/api_post.php', $attributes);
    }


    /**
     * Get paste list
     *
     * @param $attributes
     * @return string
     */
    public function getPasteList(array $attributes):string
    {
        $attributes['api_option'] = 'list';

        return $this->sendRequest('POST', 'api/api_post.php', $attributes);
    }

    /**
     * Get paste list
     *
     * @param $attributes
     * @return string
     */
    public function deletePaste(array $attributes):string
    {
        $attributes['api_option'] = 'delete';

        return $this->sendRequest('POST', 'api/api_post.php', $attributes);
    }

    /**
     * Get paste list
     *
     * @param $attributes
     * @return string
     */
    public function getPasteRaw(array $attributes):string
    {
        $attributes['api_option'] = 'show_paste';

        return $this->sendRequest('POST', 'api/api_raw.php', $attributes);
    }

    /**
     * Send request to the server through Guzzle Client
     *
     * @param $method
     * @param $path
     * @param $attributes
     * @return string
     *
     * @throws Exceptions\InvalidResponseException
     */
    private function sendRequest(string $method, string $path, array $attributes): string
    {

        $attributes['api_dev_key'] = $this->api_dev_key;

        $request = new Request($method, $this->pastebin_host . $path, ['Content-Type' => 'application/x-www-form-urlencoded'], http_build_query($attributes, '', '&'));

        try {
            $response = $this->client->send($request);
        } catch (ClientException $e) {
            throw new Exceptions\InvalidResponseException($e->getMessage(), $e->getCode(), $e);
        }

        return $response->getBody()->getContents();
    }

}