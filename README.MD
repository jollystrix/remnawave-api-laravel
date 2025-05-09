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
use Jollystrix\RemnawaveApi\Remnawave;

$remnawave = new Remnawave();
```

### Basic API Requests

The API client supports all standard HTTP methods:

**GET Request:**

```php
$response = $remnawave->get('inbounds');
```

**POST Request:**

```php
$response = $remnawave->post('users', [
	'username' => '',
	'status' => 'ACTIVE',
	'subscriptionUuid' => '',
	'shortUuid' => '',
	'trojanPassword' => '',
	'vlessUuid' => '',
	'ssPassword' => '',
	'trafficLimitBytes' => 1,
	'trafficLimitStrategy' => 'NO_RESET',
	'activeUserInbounds' => [
		'',
	],
	'expireAt' => '',
	'createdAt' => '',
	'lastTrafficResetAt' => '',
	'description' => '',
	'telegramId' => 1,
	'email' => '',
	'hwidDeviceLimit' => 1,
	'activateAllInbounds' => true,
]);
```

**DELETE Request:**

```php
$response = $remnawave->delete('users/delete/{uuid}');
```

### Handling Responses

Responses from the API client are returned as arrays, allowing for straightforward access to the underlying data. For example:

```php
if ($response['status'] === 200) {
    echo "User retrieved successfully.";
    print_r($response['data']);
}
```

## 🛠 Configuration

The configuration file (`remnawave.php`) will be published to the `config` directory of your Laravel application. It includes the following settings:

```php
return [
    'api_key' => env('REMNAWAVE_API_KEY', 'your-api-key'),
    'base_url' => env('REMNAWAVE_API_BASE_URL', 'https://remna.st'),
    'mode' => env('REMNAWAVE_API_MODE', 'https'),
];
```

Ensure your `.env` file is correctly configured to match these settings.

## 📄 License

This package is open-source and available under the MIT license. Feel free to use and modify it as needed.
