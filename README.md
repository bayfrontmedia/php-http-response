## PHP HTTP response

Easily send HTTP responses.

- [License](#license)
- [Author](#author)
- [Requirements](#requirements)
- [Installation](#installation)
- [Usage](#usage)

## License

This project is open source and available under the [MIT License](LICENSE).

## Author

<img src="https://cdn1.onbayfront.com/bfm/brand/bfm-logo.svg" alt="Bayfront Media" width="250" />

- [Bayfront Media homepage](https://www.bayfrontmedia.com?utm_source=github&amp;utm_medium=direct)
- [Bayfront Media GitHub](https://github.com/bayfrontmedia)

## Requirements

- PHP >= 7.1.0
- JSON PHP extension

## Installation

```
composer require bayfrontmedia/php-http-response
```

## Usage

- [reset](#reset)
- [setStatusCode](#setstatuscode)
- [getStatusCode](#getstatuscode)
- [removeHeaders](#removeheaders)
- [setHeaders](#setheaders)
- [getHeaders](#getheaders)
- [setBody](#setbody)
- [getBody](#getbody)
- [send](#send)
- [sendJson](#sendjson)
- [redirect](#redirect)

<hr />

### reset

**Description:**

Resets all headers (including status code) and body.

**Parameters:**

- None

**Returns:**

- (self)

**Example:**

```
$response->reset();
```

<hr />

### setStatusCode

**Description:**

Sets status code to be sent with response.

**Parameters:**

- `$status` (int)

**Returns:**

- (self)

**Throws:**

- `Bayfront\HttpResponse\InvalidStatusCodeException`

**Example:**

```
use Bayfront\HttpResponse\InvalidStatusCodeException;
use Bayfront\HttpResponse\Response;

$response = new Response();

try {
    
    $response->setStatusCode(429);
    
} catch (InvalidStatusCodeException $e) {
    die($e->getMessage());
}
```

<hr />

### getStatusCode

**Description:**

Returns the status code and associated phrase to be sent with response.

**Parameters:**

- None

**Returns:**

- (array)

**Example:**

```
print_r($response->getStatusCode());
```

<hr />

### removeHeaders

**Description:**

Sets header values to be removed with the response.

**Parameters:**

- `$headers` (array)

**Returns:**

- (self)

**Example:**

```
$response->removeHeaders([
    'X-Powered-By'
]);
```

<hr />

### setHeaders

**Description:**

Sets header values to be sent with the response.

**Parameters:**

- `$headers` (array)

**Returns:**

- (self)

**Example:**

```
$response->setHeaders([
    'X-Rate-Limit-Limit' => 100,
    'X-Rate-Limit-Remaining' => 99
]);
```

<hr />

### getHeaders

**Description:**

Returns array of headers to be sent with the response.

**Parameters:**

- None

**Returns:**

- (array)

**Example:**

```
print_r($response->getHeaders());
```

<hr />

### setBody

**Description:**

Sets body to be sent with the response.

**Parameters:**

- `$body` (string)

**Returns:**

- (self)

**Example:**

```
$response->setBody('This is the response body.');
```

<hr />

### getBody

**Description:**

Returns body to be sent with the response, or `null` if body has not been set.

**Parameters:**

- None

**Returns:**

- (string|null)

**Example:**

```
echo $response->getBody();
```

<hr />

### send

**Description:**

Sends response.

**Parameters:**

- None

**Returns:**

- (void)

**Example:**

```
$response->send();
```

<hr />

### sendJson

**Description:**

Sets Content-Type as `application/vnd.api+json`, and converts the given array to the JSON encoded body.

**Parameters:**

- `$array` (array)

**Returns:**

- (void)

**Example:**

```
$response->sendJson([
    'results' => [
        'user_id' => 5,
        'username' => 'some_username'
    ],
    'status' => 'OK'
]);
```

<hr />

### redirect

**Description:**

Redirects to a given URL using a given status code.

**Parameters:**

- `$url` (string)
- `$status = 302` (int): HTTP status code to return

**Returns:**

- (void)

**Throws:**

- `Bayfront\HttpResponse\InvalidStatusCodeException`

**Example:**

```
use Bayfront\HttpResponse\InvalidStatusCodeException;
use Bayfront\HttpResponse\Response;

$response = new Response();

try {

    $response->redirect('https://www.google.com', 301);

} catch (InvalidStatusCodeException $e) {
    die($e->getMessage());
}
```