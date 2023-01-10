<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/vendor/autoload.php');

require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions-sql.php');

connected('ag');

use Dompdf\Dompdf;
use Dompdf\Options;

use Knp\Snappy\Pdf;

$id_document = $_GET['id_document'];
$header_html = $_GET['header_html'];
$footer_html = $_GET['footer_html'];
$bg_graphique = $_GET['bg_graphique'];
$filigrane = $_GET['filigrane'];
$mode = $_GET['mode'];

$query = "SELECT * FROM document WHERE id_document = $id_document";
$statement = $db->prepare($query);
$statement->execute();
$result = $statement->fetch();

$table_document = $result['table_document'];
$type_document = $result['type_document'];

$snappy = new Pdf($_SERVER['DOCUMENT_ROOT'] . '/ged/assets/plugins/custom/wkhtmltopdf/bin/wkhtmltopdf');

$snappy->setOption('encoding', 'UTF-8');
$snappy->setOption('image-quality', 100);
$snappy->setOption('enable-local-file-access', true);

$snappy->setOption('title', $result['titre_document']);

if ($mode == 'portrait') {
  $snappy->setOption('orientation', 'Portrait');
} else if ($mode == 'paysage') {
  $snappy->setOption('orientation', 'Landscape');
}

if ($type_document == 'generate') {

  $query = "SELECT * FROM document, $table_document WHERE document.id_document = $table_document.id_document AND $table_document.id_document = $id_document";
  $statement = $db->prepare($query);
  $statement->execute();
  $result = $statement->fetch();

  if ($bg_graphique == 'non') {
    $css = 'background-color: #fff !important;';
  }

  // html style
  $htmlTemplate = <<<HTML
      <style>
        *{
          max-height: 100% !important;
          white-space: normal !important;
          {$css}
        }
        body{
          color: #000;
        }

      </style>
  HTML;

  // html content
  $htmlTemplate .= $result['contenu_document'];

  if ($header_html == 'oui') {
    $snappy->setOption('header-html', 'header.html');
  }
  if ($footer_html == 'oui') {
    $snappy->setOption('footer-html', 'footer.html');
  }


} else if ($type_document == 'write') {

  $query = "SELECT * FROM document, $table_document WHERE document.id_document = $table_document.id_document AND $table_document.id_document = $id_document";
  $statement = $db->prepare($query);
  $statement->execute();
  $result = $statement->fetch();

  if ($bg_graphique == 'non') {
    $css = 'background-color: #fff !important;';
  }

  // html style
  $htmlTemplate = <<<HTML
    <style>
      body{
        color: #000;
        padding: 0px 15px;
        {$css}
      }
      li{
        white-space: nowrap !important;
      }
    </style>
  HTML;

  // html content
  $htmlTemplate .= $result['contenu_document'];

  $snappy->setOption('minimum-font-size', 20);

  if ($header_html == 'oui') {
    $snappy->setOption('header-html', 'header.html');
  }
  if ($footer_html == 'oui') {
    $snappy->setOption('footer-html', 'footer.html');
  }
}

// echo $htmlTemplate;
// die;

header('Content-Type: application/pdf');
echo $snappy->getOutputFromHtml($htmlTemplate);


/* Les paramètres qu'on pourrait mettre avant l'esportation */

/* 

- En-tête et pied de page
- Le titre du document
- Le graphique d'arrière plan
- filigrane ou pas
- Mode de visualisation (portrait ou paysage)

*/
