<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');

require_once($_SERVER['DOCUMENT_ROOT'] . '/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/fonctions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/fonctions-sql.php');

connected('cm');

add_log('exportation', 'Exportation du document #' . $_GET['id_document'], $_SESSION['id_utilisateur'], $db);

use Dompdf\Dompdf;
use Dompdf\Options;

use Knp\Snappy\Pdf;

$id_document = $_GET['id_document'];
$header_export = $_GET['header_export'];
$footer_export = $_GET['footer_export'];
$bg_export = $_GET['bg_export'];
// $filigrane = $_GET['filigrane'];
$mode_export = $_GET['mode_export'];

$query = "SELECT * FROM document WHERE id_document = $id_document";
$statement = $db->prepare($query);
$statement->execute();
$result = $statement->fetch();

$table_document = $result['table_document'];
$type_document = $result['type_document'];

$snappy = new Pdf($_SERVER['DOCUMENT_ROOT'] . '/assets/plugins/custom/wkhtmltopdf/bin/wkhtmltopdf');

$snappy->setOption('encoding', 'UTF-8');
$snappy->setOption('image-quality', 100);
$snappy->setOption('enable-local-file-access', true);

$snappy->setOption('title', $result['titre_document']);

if ($mode_export == 'portrait') {
  $snappy->setOption('orientation', 'Portrait');
} else if ($mode_export == 'paysage') {
  $snappy->setOption('orientation', 'Landscape');
}

if ($type_document == 'generate') {

  $query = "SELECT * FROM document, $table_document WHERE document.id_document = $table_document.id_document AND $table_document.id_document = $id_document";
  $statement = $db->prepare($query);
  $statement->execute();
  $result = $statement->fetch();

  if ($bg_export == 'non') {
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

  if ($header_export == 'oui') {
    $snappy->setOption('header-html', 'header.html');
  }
  if ($footer_export == 'oui') {
    $snappy->setOption('footer-html', 'footer.html');
  }


} else if ($type_document == 'write') {

  $query = "SELECT * FROM document, $table_document WHERE document.id_document = $table_document.id_document AND $table_document.id_document = $id_document";
  $statement = $db->prepare($query);
  $statement->execute();
  $result = $statement->fetch();

  if ($bg_export == 'non') {
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

  // $snappy->setOption('minimum-font-size', 15);

  if ($header_export == 'oui') {
    $snappy->setOption('header-html', 'header.html');
  }
  if ($footer_export == 'oui') {
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
