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

$query = "SELECT * FROM document WHERE id_document = $id_document";
$statement = $db->prepare($query);
$statement->execute();
$result = $statement->fetch();

$table_document = $result['table_document'];
$type_document = $result['type_document'];

$snappy = new Pdf($_SERVER['DOCUMENT_ROOT'] . '/ged/assets/plugins/custom/wkhtmltopdf/bin/wkhtmltopdf');
// $snappy = new Pdf($_SERVER['DOCUMENT_ROOT'] . '/ged/vendor/h4cc/wkhtmltopdf-amd64/bin/wkhtmltopdf-amd64');

$snappy->setOption('encoding', 'UTF-8');
$snappy->setOption('image-quality', 100);
$snappy->setOption('enable-local-file-access', true);

$snappy->setOption('title', $result['titre_document']);
$snappy->setOption('minimum-font-size', 15);

if ($type_document == 'generate') {

  $query = "SELECT * FROM document, $table_document WHERE document.id_document = $table_document.id_document AND $table_document.id_document = $id_document";
  $statement = $db->prepare($query);
  $statement->execute();
  $result = $statement->fetch();
  // html style
  $htmlTemplate = <<<HTML
      <style>
        *{
          max-height: 100% !important;
        }
        body{
          color: #000;
        }

      </style>
  HTML;

  // html content
  $htmlTemplate .= $result['contenu_document'];


  // $snappy->setOption('margin-top', '25mm');
  // $snappy->setOption('margin-right', '15mm');
  // $snappy->setOption('margin-bottom', '25mm');
  // $snappy->setOption('margin-left', '15mm');

  $snappy->setOption('footer-font-size', 10);

  $snappy->setOption('footer-html', 'footer.html');
  $snappy->setOption('header-html', 'header.html');
} else if ($type_document == 'write') {

  $query = "SELECT * FROM document, $table_document WHERE document.id_document = $table_document.id_document AND $table_document.id_document = $id_document";
  $statement = $db->prepare($query);
  $statement->execute();
  $result = $statement->fetch();
  // html style
  $htmlTemplate = <<<HTML
    <style>
      body{
        color: #000;
        padding: 0px 15px;
      }
      li{
          white-space: nowrap !important;
      }
    </style>
  HTML;

  // html content
  $htmlTemplate .= $result['contenu_document'];

  // $snappy->setOption('margin-top', '25mm');
  // $snappy->setOption('margin-right', '15mm');
  // $snappy->setOption('margin-bottom', '25mm');
  // $snappy->setOption('margin-left', '15mm');

  $snappy->setOption('footer-font-size', 10);

  $snappy->setOption('footer-html', 'footer.html');
  $snappy->setOption('header-html', 'header.html');
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
