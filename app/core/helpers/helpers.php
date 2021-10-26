<?php

/**
 * Carga lasvistas y les pasa los argumentos
 *
 * @param string $page
 * @param bool $base_page
 * @param array $params
 */
function render(string $page, bool $base_page = true, ?array $params = null) {
    $params;

    if ($base_page) {

        if (isset($_SESSION)) {
            $header = COMPONENTS_PATH . 'logged-navbar.php';

        } else {
            $header = COMPONENTS_PATH . 'unlogged-navbar.php';
        }

        $main_content = BASE_VIEW_PATH . $page;
        require_once \BASE_VIEW_TEMPLATE;

    } else {
        require_once \BASE_VIEW_PATH . $page;
    }

    echo $_SERVER['REQUEST_METHOD'];
}

/**
 * Hace una redirección a la ruta indicada
 *
 * @param string $route
 */
function redirect(string $route) {
    $root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
    header("Location: $root.$route");
}
