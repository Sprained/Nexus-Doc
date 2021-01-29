<?php
include_once __DIR__ . '/vendor/autoload.php';

use Dompdf\Dompdf;

session_start();

$_SESSION['titulo'] = 'teste';

$ch = curl_init("http://localhost/dev/Nexus%20Doc/docs/abnt.php");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// curl_setopt ($ch, CURLOPT_COOKIEJAR, COOKIE_FILE);
// curl_setopt ($ch, CURLOPT_COOKIEFILE, COOKIE_FILE);
// $content = curl_exec($ch);
// curl_close($ch);

// $dompdf = new Dompdf();
// $dompdf->loadHtml($content);

// $dompdf->render();
// $dompdf->stream();