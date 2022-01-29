<?php

/**
 * Carga las vistas y les pasa los argumentos
 *
 * @param string $page
 * @param bool $base_page
 * @param array $params
 */
function render(string $page, bool $base_page = true, ...$params) {

    if (isset($params)) {
        foreach ($params as $key => $value) {
            $$key = $value;
        }
    }

    if ($base_page) {
        if (isset($_SESSION['user']) && 0 != $_SESSION['user']['role']) {
            $header = \COMPONENTS_PATH . 'navbars/logged-navbar.php';
        } else {
            $header = \COMPONENTS_PATH . 'navbars/unlogged-navbar.php';
        }

        $main_content = \BASE_VIEW_PATH . $page;
        $footer = \COMPONENTS_PATH . 'footer/footer.php';

        require_once \BASE_VIEW_TEMPLATE;

    } else {
        require_once \BASE_VIEW_PATH . $page;
    }

}

/**
 * Hace una redirección a la ruta indicada
 *
 * @param string $route
 */
function redirect(string $route) {
    $root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
    header("Location: $root" . "$route");
}

/**
 * Impide el acceso a usuarios sin autenticación, redirigiéndolos
 * a la ruta pasada como argumento
 *
 * @param string $route
 */
function authRequired(string $route = "") {

    if (!isset($_SESSION['user'])) {
        redirect($route);
    }
}

/**
 * @param $user
 */
function formatUserData($user) {

    if (!is_object($user)) {
        return $user;
    }
    $user_data = [
        'id'       => $user->getId(),
        'username' => $user->getUsername(),
        'email'    => $user->getEmail(),
        'role'     => $user->getRole(),
    ];

    return $user_data;
}
