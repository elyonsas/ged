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

if ($type_document == 'generate') {
 
} else if ($type_document == 'write') {

}