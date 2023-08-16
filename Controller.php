<?php 
namespace Vlgeto\PhpMvc;

use Vlgeto\PhpMvc\Middlewares\BaseMiddleware;

/**
 * Class Controller
 * 
 * @package Vlgeto\PhpMvc
 */

class Controller 
{
    public string $layout = 'main';
    public string $action = '';

    /**
     * @var \Vlgeto\PhpMvc\Middlewares\BaseMiddleware[]
     */
    protected array $middlewares = [];

    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }
    
    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    public function render($view, $params = [])
    {
        return Application::$app->view->renderView($view, $params);
    }

    public function registerMiddleware(BaseMiddleware $middleware)
    {
        $this->middlewares[] = $middleware;
    }
}

?>