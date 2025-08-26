<?php
namespace App\Core;

class Router {
    private Request $req;
    private Response $res;
    private array $routes = [];

    public function __construct(Request $req, Response $res){
        $this->req = $req;
        $this->res = $res;
    }

    public function add(string $method, string $path, callable $handler): void {
        $this->routes[strtolower($method)][] = [$this->pattern($path), $handler];
    }

    private function pattern(string $path): array {
        // تحويل {id} إلى regex
        $regex = preg_replace(
            '#\{([a-zA-Z_][a-zA-Z0-9_]*)\}#',
            '(?P<$1>[^/]+)',
            rtrim($path,'/')
        );
        return ['#^'.($regex ?: '/').'$#', $path];
    }

    public function resolve(): void {
        $method = $this->req->method();
        $path   = $this->req->path();

        foreach ($this->routes[$method] ?? [] as [$pat, $handler]) {
            if (preg_match($pat[0], $path, $m)) {
                $params = array_filter($m, 'is_string', ARRAY_FILTER_USE_KEY);
                call_user_func($handler, $this->req, $this->res, $params);
                return;
            }
        }

        $this->res->json(['success' => false, 'error' => 'Not Found'], 404);
    }
}
