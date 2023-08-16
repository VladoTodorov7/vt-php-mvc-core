<?php 
namespace App\Core;

class View 
{
    public string $title = '';

    public function renderView($view, $params = [])
    {
        $viewContent = $this->renderViewOnly($view, $params);
        $layoutContent = $this->layoutContent();

        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    protected function layoutContent(): string
    {
        $layout = Application::$app->layout;
        
        if (Application::$app->controller) {
            $layout = Application::$app->controller->layout;
        }
        
        ob_start();
        include_once Application::$ROOT_DIR."/app/Views/layouts/$layout.php";
        return ob_get_clean();
    }

    protected function renderViewOnly($view, $params = []): string
    {
        extract($params, EXTR_SKIP);

        ob_start();
        include_once Application::$ROOT_DIR."/app/Views/$view.php";
        return ob_get_clean();
    }
}
?>