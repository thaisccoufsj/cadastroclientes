<?php

namespace App\Client;

class ClientResponse
{
    /**
     * Http response code
     *
     * @var integer|null
     */
    private $code;

    /**
     * Success response
     *
     * @var boolean
     */
    private $success = false;

    /**
     * Response data
     *
     * @var array
     */
    private $data = [];

    /**
     * Error message
     *
     * @var string|null
     */
    private $message;

    /**
     * Define success
     *
     * @param array $data
     * @return self
     */
    public function succeed(array $data = []): self
    {
        $this->success = true;
        $this->data = $data;
        return $this;
    }

    /**
     * Return response success
     *
     * @return boolean
     */
    public function succeeded(): bool
    {
        return $this->success === true;
    }

    /**
     * Define error
     *
     * @param string|null $message
     * @param integer|null $code
     * @return self
     */
    public function fail(?string $message = null, ?int $code = null): self
    {
        $this->success = false;
        $this->message = $message;
        $this->code = $code;
        return $this;
    }

    /**
     * Return response fail
     *
     * @return boolean
     */
    public function failed(): bool
    {
        return $this->success === false;
    }

    /**
     * Return error message
     *
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * Define Http response code
     *
     * @param integer $code
     * @return self
     */
    public function setCode(int $code): self
    {
        $this->code = $code;
        return $this;
    }

    /**
     * Return Http response code
     *
     * @return int|null
     */
    public function getCode(): ?int
    {
        return $this->code;
    }

    /**
     * Define response content
     *
     * @param array $data
     * @return self
     */
    public function setData(array $data): self
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Return response content
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }
}
