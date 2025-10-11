<?php

namespace App\Core;

use App\Core\Middleware;
use App\Core\Exceptions\NotFoundException;
use App\Core\Exceptions\ForbiddenException;

class App
{
    public static string $ROOT_DIR;
    public string $userClass;
    
    public Router $router;
    public Request $request;
    public Response $response;
    public Session $session;
    public Database $db;
    
    public static App $app;
    public ?Controller $controller = null;
    public ?DbModel $user;
    
    protected array $globalMiddlewares = [];

    public function __construct($rootPath, array $config)
    {
        $this->userClass = $config['userClass'];
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;

        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->router = new Router($this->request, $this->response);

        $dbConfig = $config['database'] ?? $config['db'] ?? [];
        
        if (isset($dbConfig['host'])) {
            $dbConfig = [
                'dsn' => sprintf(
                    'mysql:host=%s;port=%s;dbname=%s;charset=%s',
                    $dbConfig['host'],
                    $dbConfig['port'] ?? '3306',
                    $dbConfig['name'] ?? 'library_booking_app',
                    $dbConfig['charset'] ?? 'utf8mb4'
                ),
                'user' => $dbConfig['user'] ?? 'root',
                'password' => $dbConfig['pass'] ?? '',
            ];
        }
        
        $this->db = new Database($dbConfig);

        $primaryValue = $this->session->get('user');
        
        if (!$primaryValue && isset($_COOKIE['remember_user'])) {
            $primaryValue = $_COOKIE['remember_user'];
            if ($primaryValue) {
                $this->session->set('user', $primaryValue);
            }
        }
        
        if ($primaryValue) {
            $primaryKey = $this->userClass::primaryKey();
            $this->user = $this->userClass::findOne([$primaryKey => $primaryValue]);
        } else {
            $this->user = null;
        }
    }

    public function login(DbModel $user, bool $remember = false): bool
    {
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};
        $this->session->set('user', $primaryValue);

        if ($remember) {
            setcookie('remember_user', $primaryValue, time() + (30 * 24 * 60 * 60), '/', '', false, true);
        }

        return true;
    }

    public function logout(): void
    {
        $this->user = null;
        $this->session->remove('user');
        
        if (isset($_COOKIE['remember_user'])) {
            setcookie('remember_user', '', time() - 3600, '/');
        }
    }

    public static function isGuest(): bool
    {
        return !self::$app->user;
    }

    public function addGlobalMiddleware(Middleware $middleware): void
    {
        $this->globalMiddlewares[] = $middleware;
    }

    public function getTitle(): string
    {
        if ($this->controller && method_exists($this->controller, 'getTitle')) {
            $title = $this->controller->getTitle();
            if (!empty($title)) {
                return $title;
            }
        }

        return match ($this->response->getStatusCode()) {
            403 => '403 Forbidden | Library Booking App',
            404 => '404 Not Found | Library Booking App',
            default => 'Library Booking App',
        };
    }

    public function run(): void
    {
        try {
            foreach ($this->globalMiddlewares as $middleware) {
                $middleware->execute();
            }

            echo $this->router->resolve();

        } catch (NotFoundException $e) {
            $this->response->setStatusCode(404);
            echo $this->router->renderView('errors/404', ['exception' => $e]);
            
        } catch (ForbiddenException $e) {
            $this->response->setStatusCode(403);
            echo $this->router->renderView('errors/403', ['exception' => $e]);
            
        } catch (\Exception $e) {
            $code = (int)($e->getCode() ?: 500);
            $this->response->setStatusCode($code);
            
            $errorView = match ($code) {
                403 => 'errors/403',
                404 => 'errors/404',
                default => 'errors/500'
            };
            
            echo $this->router->renderView($errorView, ['exception' => $e]);
        }
    }
}
