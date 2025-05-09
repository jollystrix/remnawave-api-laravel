# Remnawave API Laravel Package

This package provides a straightforward API client for integrating your Laravel application with the Remnawave API, enabling seamless communication with the Remnawave platform. For full API documentation, visit the official [Remnawave API documentation](https://remna.st/api).

## 📦 Installation

1. **Install the package via Composer:**

```bash
composer require jollystrix/remnawave-api-laravel
```

2. **Add the service provider to your bootstrap/providers.php file:**

```bash
Jollystrix\RemnawaveApi\RemnawaveServiceProvider::class,
```

3. **Publish the configuration file:**

```bash
php artisan vendor:publish --tag="remnawave"
```

4. **Configure your `.env` file:**

Add the required environment variables to your `.env` file:

```env
REMNAWAVE_API_KEY=your-api-key
REMNAWAVE_API_BASE_URL=https://remna.st
REMNAWAVE_API_MODE=https
```

## 🚀 Usage

### Creating an API Client Instance

To begin using the Remnawave API client, create a new instance of the `Remnawave` class:

```php
use Jollystrix\RemnawaveApi\RemnawaveClient;
Route::get('/inbounds', function (RemnawaveClient $remnawave): mixed {
    $response = $remnawave->get("inbounds");

    $entry = collect($response['response']);
    return $entry;
});
```

### Basic API Requests

The are the available methods for making requests to the Remnawave API:

```php
$remnawave->get(string $endpoint, array $data = [], array $headers = []);
$remnawave->post(string $endpoint, array $data = [], array $headers = []);
$remnawave->put(string $endpoint, array $data = [], array $headers = []);
$remnawave->delete(string $endpoint, array $data = [], array $headers = []);
$remnawave->patch(string $endpoint, array $data = [], array $headers = []
```

Explanation of Parameters:
`string $endpoint:` The API endpoint to send the request to (e.g., `users`, `inbounds`).
`array $data (optional)` Data to be sent with the request. For `POST`, `PUT`, and `PATCH` requests, this would typically contain the data to be updated or created.
`array $headers (optional):` Custom headers to be included with the request. You can merge them with default headers as needed.

## 📄 License

This package is open-source and available under the MIT license. Feel free to use and modify it as needed.
