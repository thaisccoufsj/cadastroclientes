<?php

namespace App\Apis\CustomerApi;

use App\Client\Client;
use App\Client\ClientResponse;

class CustomerClient extends Client
{
    /**
     * Base URI
     */
    protected const BASE_URI = 'http://localhost/api/customer';

    /**
     * {@inheritDoc}
     */
    protected function request(
        string $method,
        string $endpoint,
        array $headers = [],
        ?array $query = null,
        ?string $data = null,
        ?array $formParams = null
    ): ClientResponse {
        $headers['Content-Type'] = 'application/json';

        return parent::request($method, $endpoint, $headers, $query, $data, $formParams);
    }

    /**
     * Insere novo cliente
     *
     * @param array $data
     * @return ClientResponse
     */
    public function insertCustomer(array $data): ClientResponse
    {
        $data = json_encode($data);
        return $this->request('POST', self::BASE_URI, $headers = [], $query = [], $data);
    }

    /**
     * Obtém clientes
     *
     * @param array $data
     * @return ClientResponse
     */
    public function getCustomers(array $data): ClientResponse
    {
        return $this->request('GET', self::BASE_URI, $headers = [], $data);
    }
    /**
     * Altera cliente
     *
     * @param array $data
     * @return ClientResponse
     */
    public function editCustomer(array $data): ClientResponse
    {
        $data = json_encode($data);
        return $this->request('PUT', self::BASE_URI, $headers = [], $query = [], $data);
    }

    /**
     * Exclui um cliente
     *
     * @param int $id
     * @return ClientResponse
     */
    public function deleteCustomer(int $id): ClientResponse
    {
        return $this->request('DELETE', self::BASE_URI . "/{$id}");
    }
}
