<?php

/**
 * @package php-http-response
 * @link https://github.com/bayfrontmedia/php-http-response
 * @author John Robinson <john@bayfrontmedia.com>
 * @copyright 2020 Bayfront Media
 */

namespace Bayfront\HttpResponse;

class Response
{

    /**
     * Resets all headers (including status code) and body.
     *
     * @return self
     */

    public function reset(): self
    {

        $this->status_code = 200;
        $this->headers = [];
        $this->body = NULL;

        return $this;

    }

    /*
     * ############################################################
     * Status code
     * ############################################################
     */

    private $status_code = 200;

    /*
     * See: https://en.wikipedia.org/wiki/List_of_HTTP_status_codes
     *
     * 1xx: Informational - Request received, continuing process
     * 2xx: Success - The action was successfully received, understood, and accepted
     * 3xx: Redirection - Further action must be taken in order to complete the request
     * 4xx: Client Error - The request contains bad syntax or cannot be fulfilled
     * 5xx: Server Error - The server failed to fulfill an apparently valid request
     */

    private $valid_status_codes = [
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',
        103 => 'Early Hints',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Partial Content',
        207 => 'Multi-Status',
        208 => 'Already Reported',
        226 => 'IM Used',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        306 => 'Switch Proxy',
        307 => 'Temporary Redirect',
        308 => 'Permanent Redirect',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Payload Too Large',
        414 => 'URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Range Not Satisfiable',
        417 => 'Expectation Failed',
        418 => 'I\'m a teapot',
        421 => 'Misdirected Request',
        422 => 'Unprocessable Entity',
        423 => 'Locked',
        424 => 'Failed Dependency',
        426 => 'Upgrade Required',
        428 => 'Precondition Required',
        429 => 'Too Many Requests',
        431 => 'Request Header Fields Too Large',
        451 => 'Unavailable For Legal Reasons',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        506 => 'Variant Also Negotiates',
        507 => 'Insufficient Storage',
        508 => 'Loop Detected',
        510 => 'Not Extended',
        511 => 'Network Authentication Required'
    ];

    /**
     * Checks if a given status code is valid.
     *
     * @param $status int
     *
     * @return bool
     */

    private function _isValidStatusCode(int $status): bool
    {
        return isset($this->valid_status_codes[$status]);
    }

    /**
     * Sets status code to be sent with response.
     *
     * @param int $code
     *
     * @return self
     *
     * @throws InvalidStatusCodeException
     */

    public function setStatusCode(int $code): self
    {

        if ($this->_isValidStatusCode($code)) {

            $this->status_code = $code;

            return $this;

        }

        throw new InvalidStatusCodeException('Unable to set status code: invalid status code');

    }

    /**
     * Returns the status code and associated phrase to be sent with response.
     *
     * @return array
     */

    public function getStatusCode(): array
    {

        return [
            'code' => $this->status_code,
            'phrase' => $this->valid_status_codes[$this->status_code]
        ];

    }

    /*
     * ############################################################
     * Headers
     * ############################################################
     */

    private $remove_headers = [];

    /**
     * Sets header value(s) to be removed with the response.
     *
     * @param array $headers
     *
     * @return self
     */

    public function removeHeaders(array $headers): self
    {

        foreach ($headers as $header => $value) {

            $this->remove_headers[$header] = $value;

        }

        return $this;

    }

    private $headers = [];

    /**
     * Sets header value(s) to be sent with the response.
     *
     * @param $headers array
     *
     * @return self
     */

    public function setHeaders(array $headers): self
    {

        foreach ($headers as $header => $value) {

            $this->headers[$header] = $value;

        }

        return $this;

    }

    /**
     * Returns array of headers to be sent with the response.
     *
     * @return array
     */

    public function getHeaders(): array
    {
        return $this->headers;
    }

    /*
     * ############################################################
     * Body
     * ############################################################
     */

    private $body;

    /**
     * Sets body to be sent with the response.
     *
     * @param $body string
     *
     * @return self
     */

    public function setBody(string $body): self
    {

        $this->body = $body;

        return $this;

    }

    /**
     * Returns body to be sent with the response, or null if body has not been set.
     *
     * @return string|null
     */

    public function getBody(): ?string
    {
        return $this->body;
    }

    /*
     * ############################################################
     * Response
     * ############################################################
     */

    /**
     * Sends response.
     *
     * @return void
     */

    public function send(): void
    {

        // -------------------- Status code --------------------

        if (isset($_SERVER['SERVER_PROTOCOL'])) {

            $protocol = $_SERVER['SERVER_PROTOCOL'];

        } else {

            $protocol = 'HTTP/1.1';

        }

        $status = $this->getStatusCode();

        header(trim($protocol . ' ' . $status['code'] . ' ' . $status['phrase']), true);

        // -------------------- Headers --------------------

        // Remove

        foreach ($this->remove_headers as $remove) {

            header_remove($remove);

        }

        // Set

        foreach ($this->getHeaders() as $k => $v) {

            header($k . ': ' . $v);

        }

        // -------------------- Body --------------------

        if (NULL !== $this->getBody()) {
            echo $this->getBody();
        }

        // -------------------- Reset --------------------

        $this->reset();

        exit; // Ensure nothing else loads, just to be safe

    }

    /**
     * Sets Content-Type as application/vnd.api+json, and converts the given array to the JSON encoded body.
     *
     * @param $array array
     *
     * @return void
     */

    public function sendJson(array $array): void
    {

        $this->setHeaders([
            'Content-Type' => 'application/vnd.api+json'
        ])->setBody(json_encode($array))->send();

    }

    /**
     * Is given status code valid a valid redirect.
     *
     * @param $status int
     *
     * @return bool
     */

    private function _isValidRedirect(int $status): bool
    {
        return $status >= 300 && $status < 400;
    }

    /**
     * Redirects to a given URL using a given status code.
     *
     * @param string $url
     * @param int $status (HTTP status code to return)
     *
     * @return void
     *
     * @throws InvalidStatusCodeException
     */

    public function redirect(string $url, int $status = 302): void
    {

        if (!$this->_isValidRedirect($status)) {
            throw new InvalidStatusCodeException('Unable to redirect: invalid status code');
        }

        $this->reset(); // Reset anything that may be set

        $this->setHeaders([
            'Location' => $url
        ])->send();

        exit; // Ensure nothing else loads, just to be safe

    }


}