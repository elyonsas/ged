<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');

require_once($_SERVER['DOCUMENT_ROOT'] . '/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/fonctions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/fonctions-sql.php');

connected('dd');

add_log('telechargement', 'Téléchargement du document #' . $_GET['id_document'], $_SESSION['id_utilisateur'], $db);

use Dompdf\Dompdf;
use Dompdf\Options;

use Knp\Snappy\Pdf;

$id_document = $_GET['id_document'];

$query = "SELECT * FROM document WHERE id_document = $id_document";
$statement = $db->prepare($query);
$statement->execute();
$result = $statement->fetch();

$table_document = $result['table_document'];
$titre_document = $result['titre_document'];

$snappy = new Pdf($_SERVER['DOCUMENT_ROOT'] . '/assets/plugins/custom/wkhtmltopdf/bin/wkhtmltopdf');

$snappy->setOption('encoding', 'UTF-8');
$snappy->setOption('image-quality', 100);
$snappy->setOption('enable-local-file-access', true);

$snappy->setOption('title', $titre_document);


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

// echo $htmlTemplate;
// die;

header('Content-Type: application/pdf');
header("Content-Disposition: attachment; filename=\"$titre_document.pdf\"");
echo $snappy->getOutputFromHtml($htmlTemplate);
