<?php

namespace App\Client;

/**
 * Client de requisições
 */
class Client
{
    /**
     * Do http request
     *
     * @param string $method
     * @param string $endpoint
     * @param array $headers
     * @param array|null $query
     * @param string|null $data
     * @param array|null $formParams
     * @return ClientResponse
     */
    protected function request(
        string $method,
        string $endpoint,
        array $headers = [],
        ?array $query = null,
        ?string $data = null,
        ?array $formParams = null
    ): ClientResponse {
        $options['body'] = $data ?: null;
        $options['headers'] =  $headers;

        if ($query) {
            $options['query'] = $query;
        }

        if ($formParams) {
            $options['form_params'] = $formParams;
        }

        $response = new ClientResponse();

        try {
            $client = new \GuzzleHttp\Client();
            $clientResponse = $client->request($method, $endpoint, $options);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            return $response->fail($e->getResponse()->getBody()->getContents(), $e->getCode());
        } catch (\Exception $e) {
            return $response->fail($e->getMessage(), $e->getCode());
        }

        $clientResponse = (string) $clientResponse->getBody();
        $data = json_decode($clientResponse, true);

        if (!$data || !is_array($data)) {
            return $response->fail('Json decode failure' . json_last_error());
        }

        return $response->succeed($data);
    }
}
