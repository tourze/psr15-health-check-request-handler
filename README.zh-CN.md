# PSR-15 健康检查请求处理器

[![最新版本](https://img.shields.io/packagist/v/tourze/psr15-health-check-request-handler.svg)](https://packagist.org/packages/tourze/psr15-health-check-request-handler)
[![许可证](https://img.shields.io/github/license/tourze/psr15-health-check-request-handler.svg)](./LICENSE)

一个简单轻量的 PSR-15 健康检查请求处理器，可便捷集成到任何 HTTP 服务或中间件栈。

## 功能特性

- 实现 PSR-15 `RequestHandlerInterface`
- 提供基础健康检查端点，返回可自定义内容的 HTTP 200 响应
- 支持自定义健康检查路径
- 支持自定义健康响应内容
- 非健康检查路径返回 HTTP 404

## 安装说明

**环境要求：**

- PHP >= 8.1
- 依赖 `psr/http-message`、`psr/http-server-handler`、`nyholm/psr7`

通过 Composer 安装：

```bash
composer require tourze/psr15-health-check-request-handler
```

## 快速开始

### 基本用法

```php
use Tourze\PSR15HealthCheckRequestHandler\HealthCheckRequestHandler;

$handler = new HealthCheckRequestHandler();
$response = $handler->handle($request); // $request 必须实现 ServerRequestInterface
```

### 默认行为

默认情况下，以下路径会返回 200 状态码和 `ok` 响应体：

- `/health`
- `/health.php`
- `/health.html`
- `/health.asp`

其他路径均返回 404 Not Found。

### 自定义配置

可以通过反射自定义健康检查路径和响应内容：

```php
use ReflectionProperty;
use Tourze\PSR15HealthCheckRequestHandler\HealthCheckRequestHandler;

$handler = new HealthCheckRequestHandler();

// 修改健康检查路径
$pathsProperty = new ReflectionProperty(HealthCheckRequestHandler::class, 'healthCheckPaths');
$pathsProperty->setAccessible(true);
$pathsProperty->setValue($handler, ['/custom-health']);

// 修改健康响应内容
$okTextProperty = new ReflectionProperty(HealthCheckRequestHandler::class, 'okText');
$okTextProperty->setAccessible(true);
$okTextProperty->setValue($handler, '服务正常');
```

## 详细文档

- [PSR-15: HTTP 服务器请求处理器](https://www.php-fig.org/psr/psr-15/)
- 本处理器仅检测请求路径，不包含高级健康检查逻辑。

## 贡献指南

- 欢迎提交 Issue 和 PR
- 请遵循 PSR 代码规范
- 提交 PR 前请先通过 PHPUnit 进行测试

## 版权和许可

本项目基于 MIT 协议开源，详见 [LICENSE](./LICENSE) 文件。

## 更新日志

历史版本与升级说明请见 [Releases](https://github.com/tourze/psr15-health-check-request-handler/releases)
