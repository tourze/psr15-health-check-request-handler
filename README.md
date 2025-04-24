# PSR-15 Health Check Request Handler

一个简单的PSR-15健康检查请求处理器，用于在HTTP服务中快速集成健康检查端点。

## 安装

```bash
composer require tourze/psr15-health-check-request-handler
```

## 功能

- 实现PSR-15 RequestHandlerInterface
- 提供基础的健康检查接口，返回HTTP 200状态码
- 支持自定义健康检查路径
- 支持自定义响应文本

## 使用方法

### 基本使用

```php
use Tourze\PSR15HealthCheckRequestHandler\HealthCheckRequestHandler;

// 创建处理器实例
$handler = new HealthCheckRequestHandler();

// 处理请求
$response = $handler->handle($request);
```

### 默认配置

默认情况下，请求以下路径时会返回状态码200和响应体"ok"：

- `/health`
- `/health.php`
- `/health.html`

对于其他路径，会返回状态码404和响应体"Not Found"。

### 自定义配置

如果需要自定义，可以使用反射来修改默认路径和响应文本：

```php
use ReflectionProperty;
use Tourze\PSR15HealthCheckRequestHandler\HealthCheckRequestHandler;

$handler = new HealthCheckRequestHandler();

// 自定义健康检查路径
$pathsProperty = new ReflectionProperty(HealthCheckRequestHandler::class, 'healthCheckPaths');
$pathsProperty->setAccessible(true);
$pathsProperty->setValue($handler, ['/custom-health-path']);

// 自定义响应文本
$okTextProperty = new ReflectionProperty(HealthCheckRequestHandler::class, 'okText');
$okTextProperty->setAccessible(true);
$okTextProperty->setValue($handler, 'service is healthy');
```

## 在中间件栈中使用

此处理器可以作为PSR-15中间件栈的最后一个处理器：

```php
// 使用任何PSR-15兼容的应用或中间件调度器
$app->pipe($someMiddleware);
$app->pipe($anotherMiddleware);
$app->pipe(new HealthCheckRequestHandler()); // 最后添加健康检查处理器
```

## 测试

可以使用PHPUnit运行测试：

```bash
./vendor/bin/phpunit packages/psr15-health-check-request-handler/tests
```

## 许可证

MIT
