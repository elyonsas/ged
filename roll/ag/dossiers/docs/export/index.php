<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/vendor/autoload.php');

require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions-sql.php');

connected('ag');

use Dompdf\Dompdf;
use Dompdf\Options;

$id_document = $_GET['id_document'];

$query = "SELECT * FROM document WHERE id_document = $id_document";
$statement = $db->prepare($query);
$statement->execute();
$result = $statement->fetch();

$table_document = $result['table_document'];
$type_document = $result['type_document'];

if($type_document == 'generate'){

  $query = "SELECT * FROM document, $table_document WHERE document.id_document = $table_document.id_document AND $table_document.id_document = $id_document";
  $statement = $db->prepare($query);
  $statement->execute();
  $result = $statement->fetch();

  $htmlTemplate = $result['contenu_document'];

  $htmlTemplate .= <<<HTML

            <!-- <style>
              /* colgroup with width in % */

              .col-1 {
                width: 2.8%;
              }

              .col-2 {
                width: 53.8%;
              }

              .col-3 {
                width: 0.6%;
              }

              .col-4 {
                width: 4.2%;
              }

              .col-5 {
                width: 2.8%;
              }

              .col-6 {
                width: 4.6%;
              }

              .col-7 {
                width: 0.6%;
              }

              .col-8 {
                width: 3.4%;
              }

              .col-9 {
                width: 2.8%;
              }

              .col-10 {
                width: 3.4%;
              }

              .col-11 {
                width: 0.6%;
              }

              .col-12 {
                width: 3.4%;
              }

              .col-13 {
                width: 2.8%;
              }

              .col-14 {
                width: 3.6%;
              }

              .col-15 {
                width: 0.6%;
              }

              .col-16 {
                width: 0.8%;
              }

              .col-17 {
                width: 3.4%;
              }

              .col-18 {
                width: 0.8%;
              }

              .col-19 {
                width: 11.8%;
              }

              .col-20 {
                width: 2.8%;
              }


              td, td > * {
                max-height: 100% !important;
              }
              
              
            </style>
        
        <table style="table-layout: fixed; width: 100%;">
            <tbody>
                <tr style="">
                    <td class="col-1" style=""></td>
                    <td class="col-2" style=""></td>
                    <td class="col-3" style=""></td>
                    <td class="col-4" style=""></td>
                    <td class="col-5" style=""></td>
                    <td class="col-6" style=""></td>
                    <td class="col-7" style=""></td>
                    <td class="col-8" style=""></td>
                    <td class="col-9" style=""></td>
                    <td class="col-10" style=""></td>
                    <td class="col-11" style=""></td>
                    <td class="col-12" style=""></td>
                    <td class="col-13" style=""></td>
                    <td class="col-14" style=""></td>
                    <td class="col-15" style=""></td>
                    <td class="col-16" style=""></td>
                    <td class="col-17" style=""></td>
                    <td class="col-18" style=""></td>
                    <td class="col-19" style=""></td>
                    <td class="col-20" style=""></td>
                </tr>

                <tr style="height: 19px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 19px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-size: 16pt; font-weight: bold; text-align: center;"
                        colspan="18" rowspan="1" >DOC
                        N&deg;3</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 19px;">
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 20px;">
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; border-left: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);">
                        &nbsp;</td>
                    <td style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(255, 255, 255); font-family: 'Times New Roman'; font-size: 16pt; font-weight: bold; overflow-wrap: break-word; color: rgb(255, 192, 0); text-align: center;"
                        colspan="18" rowspan="3"
                        >
                        <div style="max-height: 60px;">Questionnaire d'acceptation et de maintien d'une mission au
                            D&eacute;partement d'Expertise Comptable</div>
                    </td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 20px;">
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; border-left: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 20px;">
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; border-left: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 20px;">
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; border-left: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: bottom;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 19px;">
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; border-left: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 19px;">
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; border-left: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);">
                        &nbsp;</td>
                    <td style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255); font-family: 'Times New Roman'; font-size: 12pt; font-weight: bold; font-style: italic; color: rgb(109, 170, 45); text-align: center;"
                        colspan="18" rowspan="1"
                        data-sheets-textstyleruns="{&quot;1&quot;:0,&quot;2&quot;:{&quot;2&quot;:{&quot;1&quot;:2,&quot;2&quot;:7186989},&quot;3&quot;:&quot;Calibri&quot;,&quot;4&quot;:12,&quot;5&quot;:1,&quot;6&quot;:1}}{&quot;1&quot;:1,&quot;2&quot;:{&quot;2&quot;:{&quot;1&quot;:2,&quot;2&quot;:7186989},&quot;3&quot;:&quot;Times New Roman&quot;,&quot;4&quot;:12,&quot;5&quot;:1,&quot;6&quot;:1}}{&quot;1&quot;:25,&quot;2&quot;:{&quot;2&quot;:{&quot;1&quot;:2,&quot;2&quot;:7186989},&quot;3&quot;:&quot;Calibri&quot;,&quot;4&quot;:12,&quot;5&quot;:1,&quot;6&quot;:1}}"
                        ><span
                            style="font-size: 12pt; font-family: Calibri, Arial; font-weight: bold; font-style: italic; color: rgb(109, 170, 45);">[</span><span
                            style="font-size: 12pt; font-family: 'Times New Roman'; font-weight: bold; font-style: italic; color: rgb(109, 170, 45);">Mode
                            d'emploi du DOC N&deg;3</span><span
                            style="font-size: 12pt; font-family: Calibri, Arial; font-weight: bold; font-style: italic; color: rgb(109, 170, 45);">]</span>
                    </td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 19px;">
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; border-left: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: bottom;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 19px;">
                    <td colspan="2" style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; border-left: 1px solid transparent; overflow: visible; padding: 0px; vertical-align: bottom; background-color: rgb(255, 255, 255); font-family: 'Times New Roman'; font-size: 12pt; font-weight: bold; text-decoration-line: underline; color: rgb(255, 0, 0);">
                      Objectifs du DOC N&deg;3
                    </td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                </tr>
                <tr style="height: 19px;">
                    <td style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; border-left: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255); font-family: 'Times New Roman'; font-size: 12pt; overflow-wrap: break-word;"
                        colspan="20" rowspan="3"
                        >
                        <div style="max-height: 58px;">Ce questionnaire, applicable &agrave; toutes les missions que rend le
                            D&eacute;partement d'Expertise Comptable du Cabinet ELYON, doit permettre d'appprecier la
                            possibilit&eacute; d'accepter la mission ou de se maintenir s'il s'agit d'un ancien client.</div>
                    </td>
                </tr>
                <tr style="height: 19px;"></tr>
                <tr style="height: 20px;"></tr>
                <tr style="height: 19px;">
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; border-left: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255); font-family: 'Times New Roman'; font-size: 12pt; overflow-wrap: break-word;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255); font-family: 'Times New Roman'; font-size: 12pt; overflow-wrap: break-word;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255); font-family: 'Times New Roman'; font-size: 12pt; overflow-wrap: break-word;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255); font-family: 'Times New Roman'; font-size: 12pt; overflow-wrap: break-word;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255); font-family: 'Times New Roman'; font-size: 12pt; overflow-wrap: break-word;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255); font-family: 'Times New Roman'; font-size: 12pt; overflow-wrap: break-word;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255); font-family: 'Times New Roman'; font-size: 12pt; overflow-wrap: break-word;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255); font-family: 'Times New Roman'; font-size: 12pt; overflow-wrap: break-word;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: bottom;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 19px;">
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; border-left: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255); font-family: 'Times New Roman'; font-size: 12pt; overflow-wrap: break-word;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255); font-family: 'Times New Roman'; font-size: 12pt; overflow-wrap: break-word;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255); font-family: 'Times New Roman'; font-size: 12pt; overflow-wrap: break-word;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255); font-family: 'Times New Roman'; font-size: 12pt; overflow-wrap: break-word;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255); font-family: 'Times New Roman'; font-size: 12pt; overflow-wrap: break-word;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255); font-family: 'Times New Roman'; font-size: 12pt; overflow-wrap: break-word;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255); font-family: 'Times New Roman'; font-size: 12pt; overflow-wrap: break-word;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255); font-family: 'Times New Roman'; font-size: 12pt; overflow-wrap: break-word;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: bottom;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 19px;">
                    <td colspan="2" style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; border-left: 1px solid transparent; overflow: visible; padding: 0px; vertical-align: bottom; background-color: rgb(255, 255, 255); font-family: 'Times New Roman'; font-size: 12pt; font-weight: bold; text-decoration-line: underline; color: rgb(255, 0, 0);">
                        Organisation et utilisation du fichier
                    </td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 19px;">
                    <td colspan="20" style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; border-left: 1px solid transparent; overflow: visible; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);">
                        Les questions &agrave; se poser (conf&egrave;re ci-dessous) avant d'accepter ou de se maintenir sur une mission du DEC.
                    </td>
                </tr>
                <tr style="height: 19px;">
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; border-left: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 20px;">
                    <td style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; border-left: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: top; background-color: rgb(255, 255, 255); font-family: 'Times New Roman'; font-size: 12pt;"
                        colspan="19" rowspan="2"
                        >
                        <div style="max-height: 40px;">Cette feuille comporte la liste des principales questions &agrave; se
                            poser avant d'accepter ou de se maintenir sur un dossier.</div>
                    </td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 20px;">
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                </tr>
                <tr style="height: 20px;">
                    <td style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; border-left: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255); font-family: 'Times New Roman'; font-size: 12pt; overflow-wrap: break-word;"
                        colspan="20" rowspan="2"
                        data-sheets-textstyleruns="{&quot;1&quot;:0}{&quot;1&quot;:220,&quot;2&quot;:{&quot;2&quot;:{&quot;1&quot;:3,&quot;3&quot;:1},&quot;3&quot;:&quot;Times New Roman&quot;,&quot;4&quot;:12,&quot;5&quot;:1}}{&quot;1&quot;:237,&quot;2&quot;:{&quot;2&quot;:{&quot;1&quot;:3,&quot;3&quot;:1},&quot;3&quot;:&quot;Times New Roman&quot;,&quot;4&quot;:12}}"
                        >
                        <div style="max-height: 40px;"><span
                                style="font-size: 12pt; font-family: 'Times New Roman'; color: rgb(0, 0, 0);">Pour chaque
                                question pos&eacute;e, il faut y r&eacute;pondre en inscrivant une croix "x". Une colonne
                                "Observation" est laiss&eacute;e pour es compl&eacute;ments d'informations ou des renvois aux
                                feuilles de travail utilis&eacute;es et regroup&eacute;es dans le </span><span
                                style="font-size: 12pt; font-family: 'Times New Roman'; font-weight: bold; color: rgb(0, 0, 0);">dossier
                                permanent</span><span
                                style="font-size: 12pt; font-family: 'Times New Roman'; color: rgb(0, 0, 0);"> du Client.</span>
                        </div>
                    </td>
                </tr>
                <tr style="height: 20px;"></tr>
                <tr style="height: 19px;">
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; border-left: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255); font-family: 'Times New Roman'; font-size: 12pt; overflow-wrap: break-word;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255); font-family: 'Times New Roman'; font-size: 12pt; overflow-wrap: break-word;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255); font-family: 'Times New Roman'; font-size: 12pt; overflow-wrap: break-word;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255); font-family: 'Times New Roman'; font-size: 12pt; overflow-wrap: break-word;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255); font-family: 'Times New Roman'; font-size: 12pt; overflow-wrap: break-word;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255); font-family: 'Times New Roman'; font-size: 12pt; overflow-wrap: break-word;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255); font-family: 'Times New Roman'; font-size: 12pt; overflow-wrap: break-word;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255); font-family: 'Times New Roman'; font-size: 12pt; overflow-wrap: break-word;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                </tr>
                <tr style="height: 20px;">
                    <td style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; border-left: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: top; background-color: rgb(255, 255, 255); font-family: 'Times New Roman'; font-size: 12pt; overflow-wrap: break-word;"
                        colspan="20" rowspan="2"
                        >
                        <div style="max-height: 40px;">Cette liste n'est pas exhaustive et doit &ecirc;tre au besoin
                            compl&egrave;t&eacute;e avec une feuille Word identifi&eacute;e comme compl&eacute;ment du document
                            N&deg;3.</div>
                    </td>
                </tr>
                <tr style="height: 20px;"></tr>
                <tr style="height: 19px;">
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; border-left: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 19px;">
                    <td style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; border-left: 1px solid transparent; overflow: visible; padding: 0px; vertical-align: bottom; background-color: rgb(255, 255, 255); font-family: 'Times New Roman'; font-size: 12pt; font-weight: bold; text-decoration-line: underline; color: rgb(255, 0, 0);"
                        >
                        <div style="white-space: nowrap; overflow: hidden; position: relative; width: 437px; left: 3px;">
                            <div style="float: left;">Protection du fichier et modification</div>
                        </div>
                    </td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                </tr>
                <tr style="height: 20px;">
                    <td style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; border-left: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: top; background-color: rgb(255, 255, 255); font-family: 'Times New Roman'; font-size: 12pt; overflow-wrap: break-word;"
                        colspan="20" rowspan="2"
                        >
                        <div style="max-height: 40px;">La feuille Excel est, par d&eacute;faut, prot&eacute;g&eacute;e afin que
                            les formules automatiques ne soient pas supprim&eacute;es par erreur.</div>
                    </td>
                </tr>
                <tr style="height: 20px;"></tr>
                <tr style="height: 19px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 19px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 19px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 19px;">
                    <td
                        style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(106, 107, 109); font-family: 'Times New Roman'; font-size: 14pt; font-weight: bold; color: rgb(255, 192, 0); text-align: center;"
                        colspan="18" rowspan="1"
                        >
                        Acceptation et maintien de la mission</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 19px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 19px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 19px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 19px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: 'Times New Roman'; font-weight: bold;"
                        data-sheets-textstyleruns="{&quot;1&quot;:0,&quot;2&quot;:{&quot;3&quot;:&quot;Times New Roman&quot;,&quot;4&quot;:11,&quot;5&quot;:1,&quot;9&quot;:1}}{&quot;1&quot;:6,&quot;2&quot;:{&quot;3&quot;:&quot;Times New Roman&quot;,&quot;4&quot;:11,&quot;5&quot;:1}}"
                        ><span
                            style="font-size: 11pt; font-family: 'Times New Roman'; font-weight: bold; text-decoration-line: underline; text-decoration-skip-ink: none;">Client</span><span
                            style="font-size: 11pt; font-family: 'Times New Roman'; font-weight: bold;"> : </span></td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 19px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 46px;">
                    <td
                        style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(220, 41, 30); font-family: 'Times New Roman'; font-weight: bold; color: rgb(255, 255, 255);"
                        >
                        Prise de connaissance (conf&egrave;re DOC N&deg;2)</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: 'Times New Roman'; font-weight: bold; text-align: center;"
                        >Oui</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: 'Times New Roman'; font-weight: bold; text-align: center;"
                        >Non</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: 'Times New Roman'; font-weight: bold; overflow-wrap: break-word; text-align: center;"
                        colspan="12" rowspan="1"
                        >
                        Observations<br>ou renvoyer sur feuille de travail</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 9px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 20px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: 'Times New Roman'; overflow-wrap: break-word;"
                        colspan="1" rowspan="3"
                        >
                        <div style="max-height: 62px;">Le cabinet a-t-il rencontr&eacute; le client pour prendre connaissance de
                            ses besoins et d&eacute;couvrir l'entreprise ?</div>
                    </td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 22px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        XZ</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        XZ</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        colspan="12" rowspan="1">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 20px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 20px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: 'Times New Roman'; overflow-wrap: break-word;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 19px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: 'Times New Roman'; overflow-wrap: break-word;"
                        data-sheets-textstyleruns="{&quot;1&quot;:0,&quot;2&quot;:{&quot;2&quot;:{&quot;1&quot;:3,&quot;3&quot;:1},&quot;3&quot;:&quot;Times New Roman&quot;,&quot;4&quot;:11,&quot;5&quot;:1,&quot;9&quot;:1}}{&quot;1&quot;:9,&quot;2&quot;:{&quot;2&quot;:{&quot;1&quot;:3,&quot;3&quot;:1},&quot;3&quot;:&quot;Times New Roman&quot;,&quot;4&quot;:11}}"
                        >
                        <span
                            style="font-size: 11pt; font-family: 'Times New Roman'; font-weight: bold; text-decoration-line: underline; text-decoration-skip-ink: none; color: rgb(0, 0, 0);">Nota
                            Bene</span><span style="font-size: 11pt; font-family: 'Times New Roman'; color: rgb(0, 0, 0);">:
                            Joindre au dossier permanent une pr&eacute;sentation de l'entit&eacute; (plaquette, les notes prises
                            lors de l'entretien avec le client, budgets ou tableaux de bord&hellip;)</span></td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 9px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 46px;">
                    <td
                        style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(220, 41, 30); font-family: 'Times New Roman'; font-weight: bold; color: rgb(255, 255, 255);"
                        >
                        Analyse des risques du client (conf&egrave;re DOC N&deg;9)</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: 'Times New Roman'; font-weight: bold; overflow-wrap: break-word; text-align: center;"
                        colspan="15" rowspan="1"
                        >
                        Niveau de risque<br>E : &eacute;lev&eacute; &ndash; M : moyen &ndash; F : faible</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 9px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 20px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: 'Times New Roman'; overflow-wrap: break-word;"
                        colspan="1" rowspan="3"
                        >
                        <div style="max-height: 62px;">Activit&eacute;</div>
                    </td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 22px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        XZ</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        >E</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        XZ</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        >M</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        XZ</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        >F</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 20px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 20px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: 'Times New Roman'; overflow-wrap: break-word;"
                        colspan="1" rowspan="3"
                        >
                        <div style="max-height: 62px;">Caract&eacute;ristiques juridiques (Structure juridique,
                            d&eacute;tenteurs du capital, dirigeants de l'entit&eacute;&hellip;)</div>
                    </td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 22px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        XZ</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        >E</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        XZ</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        >M</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        XZ</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        >F</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 20px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 20px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: 'Times New Roman'; overflow-wrap: break-word;"
                        colspan="1" rowspan="3"
                        >
                        <div style="max-height: 62px;">Syst&egrave;me d&rsquo;information (Fiabilit&eacute;, conformit&eacute;
                            par rapport &agrave; la l&eacute;gislation, s&eacute;curit&eacute;&hellip;)</div>
                    </td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 22px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        XZ</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        >E</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        XZ</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        >M</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        XZ</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        >F</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 20px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 20px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: 'Times New Roman'; overflow-wrap: break-word;"
                        colspan="1" rowspan="3"
                        >
                        <div style="max-height: 62px;">Organisation comptable (Existence et importance de la fonction comptable
                            &ndash; qualification du personnel comptable - nature et qualit&eacute; des travaux pris en
                            charge&hellip;)</div>
                    </td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 22px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        XZ</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        >E</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        XZ</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        >M</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        XZ</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        >F</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 20px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 20px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: 'Times New Roman'; overflow-wrap: break-word;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 20px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: top; font-family: 'Times New Roman'; overflow-wrap: break-word;"
                        >
                        Clients (les clients les plus importants, d&eacute;lais de r&egrave;glement des clients&hellip;)</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        XZ</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        >E</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        XZ</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        >M</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        XZ</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        >F</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 20px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: 'Times New Roman'; overflow-wrap: break-word;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 20px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: 'Times New Roman'; overflow-wrap: break-word;"
                        colspan="1" rowspan="2"
                        >
                        <div style="max-height: 40px;">Fournisseurs (les fournisseurs les plus importants, d&eacute;lais de
                            r&egrave;glement des fournisseurs)</div>
                    </td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        XZ</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        >E</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        XZ</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        >M</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        XZ</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        >F</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 20px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 20px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: 'Times New Roman'; overflow-wrap: break-word;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 20px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: 'Times New Roman'; overflow-wrap: break-word;"
                        colspan="1" rowspan="2"
                        >
                        <div style="max-height: 40px;">Tr&eacute;sorerie (Existence de syst&egrave;me de contr&ocirc;le interne
                            autour de la tr&eacute;sorerie, inventaire p&eacute;riodique de la banque et de la caisse,&hellip;)
                        </div>
                    </td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        XZ</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        >E</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        XZ</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        >M</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        XZ</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        >F</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 20px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        >&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 20px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: 'Times New Roman'; overflow-wrap: break-word;"
                        colspan="1" rowspan="3"
                        >
                        <div style="max-height: 62px;">Historique fiscal et social du client (Contr&ocirc;les fiscaux,
                            contr&ocirc;les CNSS&hellip;)</div>
                    </td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 22px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        XZ</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        >E</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        XZ</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        >M</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        XZ</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        >F</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 20px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 9px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 46px;">
                    <td
                        style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(220, 41, 30); font-family: 'Times New Roman'; font-weight: bold; color: rgb(255, 255, 255);"
                        >Analyse
                        des besoins du client</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: 'Times New Roman'; font-weight: bold; text-align: center;"
                        >Oui</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: 'Times New Roman'; font-weight: bold; text-align: center;"
                        >Non</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: 'Times New Roman'; font-weight: bold; overflow-wrap: break-word; text-align: center;"
                        colspan="12" rowspan="1"
                        >
                        Observations<br>ou renvoyer sur feuille de travail</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 9px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 46px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: 'Times New Roman'; font-weight: bold; overflow-wrap: break-word;"
                        >
                        Les informations suivantes ont-elles &eacute;t&eacute; collect&eacute;es ?</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 9px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 20px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 22px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        >
                        La r&eacute;partition des travaux comptables entre le client et le cabinet</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        XZ</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        XZ</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        colspan="12" rowspan="1">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 20px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 20px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: 'Times New Roman'; overflow-wrap: break-word;"
                        colspan="1" rowspan="3"
                        >
                        <div style="max-height: 62px;">Le volume d'&eacute;critures comptables</div>
                    </td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 22px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        XZ</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        XZ</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        colspan="12" rowspan="1">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 20px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 20px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;" colspan="1" rowspan="2">
                        <div style="max-height: 42px;">&nbsp;</div>
                    </td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: 'Times New Roman'; overflow-wrap: break-word;"
                        colspan="1" rowspan="4"
                        >
                        <div style="max-height: 82px;">Les sp&eacute;cificit&eacute;s comptables, fiscales et sociales relatives
                            &agrave; l'activit&eacute; et pouvant n&eacute;cessiter des travaux approfondis ou
                            sp&eacute;cifiques : valorisation, d&eacute;termination de provisions, etc(conf&egrave;re la partie
                            Organisation comptable dans le logiciel GED-ELYON)</div>
                    </td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 22px;">
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        XZ</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        XZ</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        colspan="12" rowspan="1">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 20px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 20px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 20px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: 'Times New Roman'; overflow-wrap: break-word;"
                        colspan="1" rowspan="3"
                        >
                        <div style="max-height: 62px;">Les d&eacute;lais sp&eacute;cifiques &agrave; respecter (Demande
                            particuli&egrave;re du client&hellip;)</div>
                    </td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 22px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        XZ</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        XZ</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        colspan="12" rowspan="1">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 20px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 9px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 20px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 46px;">
                    <td
                        style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(220, 41, 30); font-family: 'Times New Roman'; font-weight: bold; color: rgb(255, 255, 255);"
                        >
                        Analyse de la faisabilit&eacute; de la mission</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: 'Times New Roman'; font-weight: bold; text-align: center;"
                        >Oui</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: 'Times New Roman'; font-weight: bold; text-align: center;"
                        >Non</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: 'Times New Roman'; font-weight: bold; overflow-wrap: break-word; text-align: center;"
                        colspan="12" rowspan="1"
                        >
                        Observations<br>ou renvoyer sur feuille de travail</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 9px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 20px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 22px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        >
                        Le cabinet est-il ind&eacute;pendant vis-&agrave;-vis du client ?</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        XZ</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        XZ</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        colspan="12" rowspan="1">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 20px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 20px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: 'Times New Roman'; overflow-wrap: break-word;"
                        colspan="1" rowspan="3"
                        >
                        <div style="max-height: 62px;">Le cabinet a-t-il la comp&eacute;tence pour r&eacute;aliser cette mission
                            ?</div>
                    </td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 22px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        XZ</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        XZ</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        colspan="12" rowspan="1">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 20px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 20px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: 'Times New Roman'; overflow-wrap: break-word;"
                        colspan="1" rowspan="3"
                        >
                        <div style="max-height: 62px;">Le cabinet dispose-t-il des moyens ad&eacute;quats pour assurer cette
                            mission dans de bonnes conditions (notamment de d&eacute;lai) ?</div>
                    </td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 22px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        XZ</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        XZ</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        colspan="12" rowspan="1">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 20px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 9px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 9px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 46px;">
                    <td
                        style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(220, 41, 30); font-family: 'Times New Roman'; font-weight: bold; color: rgb(255, 255, 255);"
                        >
                        Analyse des dispositions de la loi anti blanchiment</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: 'Times New Roman'; font-weight: bold; text-align: center;"
                        >Oui</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: 'Times New Roman'; font-weight: bold; text-align: center;"
                        >Non</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: 'Times New Roman'; font-weight: bold; overflow-wrap: break-word; text-align: center;"
                        colspan="12" rowspan="1"
                        >
                        Observations<br>ou renvoyer sur feuille de travail</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 9px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 20px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 22px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        >
                        Le questionnaire sur la lutte anti blanchiment a-t-il &eacute;t&eacute; compl&eacute;t&eacute; ?</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        XZ</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        XZ</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        colspan="12" rowspan="1">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 20px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 9px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 46px;">
                    <td
                        style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(220, 41, 30); font-family: 'Times New Roman'; font-weight: bold; color: rgb(255, 255, 255);"
                        >
                        Lettre au confr&egrave;re (conf&egrave;re DOC N&deg;4)</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: 'Times New Roman'; font-weight: bold; text-align: center;"
                        >Oui</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: 'Times New Roman'; font-weight: bold; text-align: center;"
                        >Non</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: 'Times New Roman'; font-weight: bold; overflow-wrap: break-word; text-align: center;"
                        colspan="12" rowspan="1"
                        >
                        Observations<br>ou renvoyer sur feuille de travail</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 9px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 9px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: 'Times New Roman'; overflow-wrap: break-word;"
                        colspan="1" rowspan="3"
                        >
                        <div style="max-height: 49px;">Le client fait-il d&eacute;j&agrave; appel aux services d'un
                            professionnel de l'expertise comptable ?</div>
                    </td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 20px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        XZ</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        XZ</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        colspan="12" rowspan="1">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 20px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 20px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        >Si oui&hellip;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 26px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: 'Times New Roman'; overflow-wrap: break-word;"
                        colspan="1" rowspan="3"
                        >
                        <div style="max-height: 74px;">&hellip;la lettre au confr&egrave;re (pr&eacute;vue au Code de
                            d&eacute;ontologie de la profession d'expertise comptable) a-t-elle &eacute;t&eacute; envoy&eacute;e
                            ?</div>
                    </td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 22px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        XZ</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        XZ</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        colspan="12" rowspan="1">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 26px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 8px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 26px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: 'Times New Roman'; overflow-wrap: break-word;"
                        colspan="1" rowspan="2"
                        >
                        <div style="max-height: 48px;">&hellip;existe-t-il une opposition &agrave; notre entr&eacute;e en
                            fonction ou des remarques ont-elles &eacute;t&eacute; formul&eacute;es par le confr&egrave;re ?
                        </div>
                    </td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 22px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        XZ</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        XZ</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        colspan="12" rowspan="1">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 9px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 19px;">
                    <td
                        style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(220, 41, 30); font-family: 'Times New Roman'; font-weight: bold; color: rgb(255, 255, 255); text-align: center;"
                        colspan="18" rowspan="1"
                        >
                        D&eacute;cision d&rsquo;acception de la mission (partie r&eacute;serv&eacute;e au responsable du DEC)
                    </td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 9px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 69px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: 'Times New Roman'; overflow-wrap: break-word;"
                        colspan="7" rowspan="1"
                        >
                        Apr&egrave;s avoir pris connaissance des r&eacute;ponses formul&eacute;es sur cette page, compte tenu de
                        la connaissance que nous avons acquise de l'entit&eacute; et notamment des zones et des niveaux de
                        risque identifi&eacute;s dans le cadre de la prise de connaissance,</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 19px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: 'Times New Roman'; overflow-wrap: break-word;">
                        &nbsp;</td>
                    <td
                        style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: 'Times New Roman'; overflow-wrap: break-word;">
                        &nbsp;</td>
                    <td
                        style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: 'Times New Roman'; overflow-wrap: break-word;">
                        &nbsp;</td>
                    <td
                        style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: 'Times New Roman'; overflow-wrap: break-word;">
                        &nbsp;</td>
                    <td
                        style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: 'Times New Roman'; overflow-wrap: break-word;">
                        &nbsp;</td>
                    <td
                        style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: 'Times New Roman'; overflow-wrap: break-word;">
                        &nbsp;</td>
                    <td
                        style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: 'Times New Roman'; overflow-wrap: break-word;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 19px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: 'Times New Roman'; font-weight: bold; text-align: center;"
                        >Nouveau client</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 19px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: 'Times New Roman'; text-align: right;"
                        >
                        Nous d&eacute;cidons d&rsquo;accepter la mission de pr&eacute;sentation</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        XZ</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 19px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: 'Times New Roman'; text-align: right;"
                        >
                        Nous d&eacute;cidons de refuser la mission de pr&eacute;sentation</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        XZ</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 19px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: 'Times New Roman'; text-align: right;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 19px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: 'Times New Roman'; font-weight: bold; text-align: center;"
                        >Ancien client</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 19px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: 'Times New Roman'; text-align: right;"
                        >
                        Nous d&eacute;cidons de maintenir la mission de pr&eacute;sentation</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        XZ</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 19px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: 'Times New Roman'; text-align: right;"
                        >
                        Nous d&eacute;cidons de ne pas maintenir la mission de pr&eacute;sentation</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        XZ</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 19px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 19px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: 'Times New Roman'; font-weight: bold; text-align: center;"
                        colspan="12" rowspan="1"
                        >Signature
                        du Responsable DEC</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 19px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        colspan="12" rowspan="2">
                        <div style="max-height: 38px;">XZ</div>
                    </td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 19px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 28px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 19px;">
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(143, 144, 146); font-family: 'Times New Roman'; font-weight: bold; color: rgb(255, 255, 255); text-align: center;"
                        colspan="18" rowspan="1"
                        >
                        Observations g&eacute;n&eacute;rales</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 97px;">
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: top;"
                        colspan="18" rowspan="1">XZ</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
            </tbody>
        </table> -->
        
  HTML;
}









// echo $htmlTemplate;
// die;

$dompdf = new Dompdf();
$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);
$dompdf->loadHtml($htmlTemplate);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

$canvas = $dompdf->getCanvas();
// chemin relatif de l'image
$img_filigrane_path = $_SERVER['DOCUMENT_ROOT'] . '/ged/assets/media/logos/logo_elyon1.png';

$head1_page = $_SERVER['DOCUMENT_ROOT'] . '/ged/assets/media/logos/logo_elyon.png';
$head2_page = $_SERVER['DOCUMENT_ROOT'] . '/ged/assets/media/logos/logo_elyon_texte.png';

$foot1_page = $_SERVER['DOCUMENT_ROOT'] . '/ged/assets/media/logos/logo_elyon1.png';
$foot2_page = $_SERVER['DOCUMENT_ROOT'] . '/ged/assets/media/logos/logo_elyon1.png';
$canvas->page_script('
  $pdf->image("' . $img_filigrane_path . '", 50, 100, 500, 500);
  $pdf->image("' . $head1_page . '", 15, -10, 100, 100);
  $pdf->image("' . $head2_page . '", 200, 0, 300, 36);
');

$dompdf->stream('Facture', array("Attachment" => false));
