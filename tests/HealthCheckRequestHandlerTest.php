<?php

declare(strict_types=1);

namespace Tourze\PSR15HealthCheckRequestHandler\Tests;

use Nyholm\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;
use ReflectionProperty;
use Tourze\PSR15HealthCheckRequestHandler\HealthCheckRequestHandler;

/**
 * 健康检查请求处理器测试类
 */
class HealthCheckRequestHandlerTest extends TestCase
{
    /**
     * 测试默认健康检查路径 /health 返回200
     */
    public function testHealthPathReturns200(): void
    {
        $handler = new HealthCheckRequestHandler();
        $request = new ServerRequest('GET', '/health');

        $response = $handler->handle($request);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('ok', (string)$response->getBody());
    }

    /**
     * 测试默认健康检查路径 /health.php 返回200
     */
    public function testHealthPhpPathReturns200(): void
    {
        $handler = new HealthCheckRequestHandler();
        $request = new ServerRequest('GET', '/health.php');

        $response = $handler->handle($request);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('ok', (string)$response->getBody());
    }

    /**
     * 测试默认健康检查路径 /health.html 返回200
     */
    public function testHealthHtmlPathReturns200(): void
    {
        $handler = new HealthCheckRequestHandler();
        $request = new ServerRequest('GET', '/health.html');

        $response = $handler->handle($request);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('ok', (string)$response->getBody());
    }

    /**
     * 测试非健康检查路径返回404
     */
    public function testNonHealthPathReturns404(): void
    {
        $handler = new HealthCheckRequestHandler();
        $request = new ServerRequest('GET', '/some-other-path');

        $response = $handler->handle($request);

        $this->assertSame(404, $response->getStatusCode());
        $this->assertSame('Not Found', (string)$response->getBody());
    }

    /**
     * 测试自定义健康检查路径
     */
    public function testCustomHealthPath(): void
    {
        $handler = new HealthCheckRequestHandler();

        // 使用反射设置自定义健康检查路径
        $pathsProperty = new ReflectionProperty(HealthCheckRequestHandler::class, 'healthCheckPaths');
        $pathsProperty->setAccessible(true);
        $pathsProperty->setValue($handler, ['/custom-health']);

        // 测试自定义路径
        $request = new ServerRequest('GET', '/custom-health');
        $response = $handler->handle($request);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('ok', (string)$response->getBody());

        // 确认原始路径不再被识别为健康检查路径
        $request = new ServerRequest('GET', '/health');
        $response = $handler->handle($request);

        $this->assertSame(404, $response->getStatusCode());
    }

    /**
     * 测试自定义响应文本
     */
    public function testCustomOkText(): void
    {
        $handler = new HealthCheckRequestHandler();
        $customText = 'service is healthy';

        // 使用反射设置自定义响应文本
        $okTextProperty = new ReflectionProperty(HealthCheckRequestHandler::class, 'okText');
        $okTextProperty->setAccessible(true);
        $okTextProperty->setValue($handler, $customText);

        // 测试自定义响应文本
        $request = new ServerRequest('GET', '/health');
        $response = $handler->handle($request);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame($customText, (string)$response->getBody());
    }

    /**
     * 测试请求方法无关紧要
     */
    public function testHttpMethodDoesNotMatter(): void
    {
        $handler = new HealthCheckRequestHandler();

        // 测试POST请求
        $request = new ServerRequest('POST', '/health');
        $response = $handler->handle($request);

        $this->assertSame(200, $response->getStatusCode());

        // 测试PUT请求
        $request = new ServerRequest('PUT', '/health');
        $response = $handler->handle($request);

        $this->assertSame(200, $response->getStatusCode());
    }
}
