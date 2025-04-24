<?php

declare(strict_types=1);

namespace Tourze\PSR15HealthCheckRequestHandler;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * 健康检查请求处理器
 */
class HealthCheckRequestHandler implements RequestHandlerInterface
{
    private array $healthCheckPaths = [
        '/health',
        '/health.php',
        '/health.html',
        '/health.asp',
    ];

    private string $okText = 'ok';

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $path = $request->getUri()->getPath();

        // 处理健康检查请求
        if (in_array($path, $this->healthCheckPaths, true)) {
            return new Response(200, body: $this->okText);
        }

        // 如果没有下一个处理器，则返回404
        return new Response(404, body: 'Not Found');
    }
}
