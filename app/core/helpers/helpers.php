<?php 

function render(string $page, bool $base_page = true, array $params = null)
{
    $params;

    if($base_page)
    {          
        if(isset($_SESSION)) {$header = COMPONENTS_PATH.'logged-navbar.php';}
        else {$header = COMPONENTS_PATH.'unlogged-navbar.php';}     
        
        $main_content = BASE_VIEW_PATH.$page;
        require_once \BASE_VIEW_TEMPLATE;
    }
    else
    {
        require_once \BASE_VIEW_PATH.$page;
    }

    echo $_SERVER['REQUEST_METHOD'];
}

function redirect(string $route)
{
    $root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].'/';
    header("Location: $root.$route");
}
