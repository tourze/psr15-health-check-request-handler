# PSR-15 Health Check Request Handler

[![Latest Version](https://img.shields.io/packagist/v/tourze/psr15-health-check-request-handler.svg)](https://packagist.org/packages/tourze/psr15-health-check-request-handler)
[![License](https://img.shields.io/github/license/tourze/psr15-health-check-request-handler.svg)](./LICENSE)

A simple and lightweight PSR-15 Request Handler for health check endpoints, designed for easy integration into any HTTP service or middleware pipeline.

## Features

- Implements PSR-15 `RequestHandlerInterface`
- Provides a basic health check endpoint, returning HTTP 200 with a customizable response
- Supports custom health check paths
- Customizable response body for healthy status
- Returns HTTP 404 for non-health-check paths

## Installation

**Requirements:**

- PHP >= 8.1
- `psr/http-message`, `psr/http-server-handler`, `nyholm/psr7`

Install via Composer:

```bash
composer require tourze/psr15-health-check-request-handler
```

## Quick Start

### Basic Usage

```php
use Tourze\PSR15HealthCheckRequestHandler\HealthCheckRequestHandler;

$handler = new HealthCheckRequestHandler();
$response = $handler->handle($request); // $request must implement ServerRequestInterface
```

### Default Behavior

By default, the handler responds with status 200 and body `ok` for the following paths:

- `/health`
- `/health.php`
- `/health.html`
- `/health.asp`

All other paths will receive a 404 Not Found response.

### Customization

You can customize the health check paths and healthy response text (using reflection):

```php
use ReflectionProperty;
use Tourze\PSR15HealthCheckRequestHandler\HealthCheckRequestHandler;

$handler = new HealthCheckRequestHandler();

// Change health check paths
$pathsProperty = new ReflectionProperty(HealthCheckRequestHandler::class, 'healthCheckPaths');
$pathsProperty->setAccessible(true);
$pathsProperty->setValue($handler, ['/custom-health']);

// Change healthy response text
$okTextProperty = new ReflectionProperty(HealthCheckRequestHandler::class, 'okText');
$okTextProperty->setAccessible(true);
$okTextProperty->setValue($handler, 'service is healthy');
```

## Documentation

- [PSR-15: HTTP Server Request Handlers](https://www.php-fig.org/psr/psr-15/)
- The handler only checks the request path and does not implement any advanced health logic.

## Contributing

- Issues and pull requests are welcome.
- Please follow PSR coding standards.
- Run tests with PHPUnit before submitting PRs.

## License

This project is licensed under the MIT License. See the [LICENSE](./LICENSE) file for details.

## Changelog

See [Releases](https://github.com/tourze/psr15-health-check-request-handler/releases) for version history and upgrade notes.
