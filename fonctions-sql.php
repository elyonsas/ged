<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions.php');

// Insert
function insert($table, $data, PDO $db)
{
    $sql = "INSERT INTO $table (";
    $sql .= implode(", ", array_keys($data));
    $sql .= ") VALUES (";
    $sql .= ":" . implode(", :", array_keys($data));
    $sql .= ")";
    $stmt = $db->prepare($sql);
    if ($stmt->execute($data)) {
        return true;
    } else {
        return false;
    }
}

function insert1($table, $data, PDO $db)
{

    $values = [];
    foreach ($data as $value) {
        $values[] = "'$value'";
    }
    $sql = "INSERT INTO $table (";
    $sql .= implode(", ", array_keys($data));
    $sql .= ") VALUES (";
    $sql .= implode(", ", $values);
    $sql .= ")";
    return $sql;
}

// Update
function update($table, $data, $where, PDO $db)
{
    $sql = "UPDATE $table SET ";
    $sql .= implode(" = ?, ", array_keys($data));
    $sql .= " = ? WHERE $where";
    $stmt = $db->prepare($sql);
    if ($stmt->execute(array_values($data))) {
        return true;
    } else {
        return false;
    }
}

// function update1 with array_values and without ? in the query
function update1($table, $data, $where, PDO $db)
{
    $data_req = [];
    foreach ($data as $key => $value) {
        $date_req[] = "$key = '$value'";
    }
    $sql = "UPDATE $table SET ";
    $sql .= implode(", ", $data_req);
    $sql .= " WHERE $where";
    return $sql;
}

// Delete
function delete($table, $where, PDO $db)
{
    $sql = "DELETE FROM $table WHERE $where";
    $stmt = $db->prepare($sql);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

function delete1($table, $where, PDO $db)
{
    $sql = "DELETE FROM $table WHERE $where";
    return $sql;
}



function select_all_actifs_dossiers_collabo($id_collabo, PDO $db)
{
    $query = "SELECT COUNT(*) as dossiers FROM client, collaborateur, assoc_client_collabo WHERE client.id_client = assoc_client_collabo.id_client 
        AND collaborateur.id_collaborateur = assoc_client_collabo.id_collaborateur AND statut_assoc_client_collabo = 'actif' AND collaborateur.id_collaborateur = :id_collabo";
    $statement = $db->prepare($query);
    $statement->execute([
        'id_collabo' => $id_collabo
    ]);
    $result = $statement->fetch();

    return $result['dossiers'];
}

function find_info_utilisateur($info, $id_utilisateur, PDO $db)
{

    $query = "SELECT $info FROM utilisateur WHERE id_utilisateur = :id_utilisateur";
    $statement = $db->prepare($query);
    $statement->execute([
        ':id_utilisateur' => $id_utilisateur
    ]);
    $result = $statement->fetch();

    return $result["$info"];
}

function find_info_client($info, $id_client, PDO $db)
{

    $query = "SELECT $info FROM client, utilisateur, compte WHERE utilisateur.id_utilisateur = compte.id_utilisateur 
    AND utilisateur.id_utilisateur = client.id_utilisateur AND client.id_client = :id_client";
    $statement = $db->prepare($query);
    $statement->execute([
        ':id_client' => $id_client
    ]);
    $result = $statement->fetch();

    return $result["$info"];
}

function compte_exists($email, PDO $db)
{
    $query = "SELECT * FROM compte WHERE email_compte = :email_compte";
    $statement = $db->prepare($query);
    $statement->execute([
        ':email_compte' => $email
    ]);
    $result = $statement->fetch();
    if ($result) {
        return true;
    } else {
        return false;
    }
}



function update_contenu_document_table_doc_fiche_id_client($id_document, PDO $db)
{
    $id_document = $_POST['id_document'];

    $query = "SELECT * FROM document WHERE id_document = $id_document";
    $statement = $db->prepare($query);
    $statement->execute();
    $result = $statement->fetch();

    $id_client = $result['id_client'];
    $matricule_client = find_info_client('matricule_client', $id_client, $db);
    $table_document = $result['table_document'];

    $query = "SELECT * FROM document, $table_document WHERE document.id_document = $table_document.id_document AND $table_document.id_document = $id_document";
    $statement = $db->prepare($query);
    $statement->execute();
    $result = $statement->fetch();

    $adresse = $result['adresse'];
    $id_fiscale_client = $result['id_fiscale_client'];
    $exercice_clos_le = si_funct1($result['exercice_clos_le'], date('d/m/Y', strtotime($result['exercice_clos_le'])), '');
    $duree_en_mois = $result['duree_en_mois'];
    $exercice_compta_du = si_funct1($result['exercice_compta_du'], date('d/m/Y', strtotime($result['exercice_compta_du'])), '');
    $exercice_compta_au = si_funct1($result['exercice_compta_au'], date('d/m/Y', strtotime($result['exercice_compta_au'])), '');
    $date_arret_compta = si_funct1($result['date_arret_compta'], date('d/m/Y', strtotime($result['date_arret_compta'])), '');
    $exercice_prev_clos_le = si_funct1($result['exercice_prev_clos_le'], date('d/m/Y', strtotime($result['exercice_prev_clos_le'])), '');
    $duree_exercice_prev_en_mois = $result['duree_exercice_prev_en_mois'];
    $greffe = $result['greffe'];
    $num_registre_commerce = $result['num_registre_commerce'];
    $num_repertoire_entite = $result['num_repertoire_entite'];
    $num_caisse_sociale = $result['num_caisse_sociale'];
    $num_code_importateur = $result['num_code_importateur'];
    $code_activite_principale = $result['code_activite_principale'];
    $designation_entite = $result['designation_entite'];
    $sigle = $result['sigle'];
    $telephone = $result['telephone'];
    $email = $result['email'];
    $code = $result['code'];
    $num_code = $result['num_code'];
    $boite_postal = $result['boite_postal'];
    $ville = $result['ville'];
    $adresse_geo_complete = $result['adresse_geo_complete'];
    $designation_activite_principale = $result['designation_activite_principale'];
    $personne_a_contacter = $result['personne_a_contacter'];
    $professionnel_salarie_ou_cabinet = $result['professionnel_salarie_ou_cabinet'];
    $visa_expert = 'CABINET ELYON';
    $etats_financiers_approuves = $result['etats_financiers_approuves'];
    if ($etats_financiers_approuves == 'oui') {
        $etats_financiers_approuves_oui = 'X';
        $etats_financiers_approuves_non = '';
    } else {
        $etats_financiers_approuves_oui = '';
        $etats_financiers_approuves_non = 'X';
    }


    $contenu_document = <<<HTML
            <table dir="ltr"
                style="transform: scale(0.9); transform-origin: top left; table-layout: fixed; font-size: 11pt; font-family: Calibri; width: 0px; border-collapse: collapse; border-style: none;"
                border="0" cellspacing="0" cellpadding="0">
                <colgroup>
                    <col width="13">
                    <col width="39">
                    <col width="6">
                    <col width="6">
                    <col width="6">
                    <col width="6">
                    <col width="29">
                    <col width="29">
                    <col width="18">
                    <col width="57">
                    <col width="29">
                    <col width="18">
                    <col width="18">
                    <col width="18">
                    <col width="18">
                    <col width="51">
                    <col width="9">
                    <col width="18">
                    <col width="18">
                    <col width="18">
                    <col width="9">
                    <col width="56">
                    <col width="19">
                    <col width="18">
                    <col width="18">
                    <col width="19">
                    <col width="21">
                    <col width="45">
                    <col width="15">
                    <col width="18">
                    <col width="8">
                    <col width="7">
                    <col width="42">
                    <col width="8">
                    <col width="8">
                    <col width="23">
                    <col width="23">
                    <col width="23">
                    <col width="47">
                    <col width="46">
                    <col width="29">
                    <col width="57">
                    <col width="59">
                    <col width="18">
                </colgroup>
                <tbody>
                    <tr style="height: 22px;">
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 16pt; font-weight: bold; text-align: center;"
                            colspan="43" rowspan="1"
                            >
                            DOC N&deg;8 FICHE D&rsquo;INDENTIFICATION CLIENT</td>
                    </tr>
                    <tr style="height: 22px;">
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 16pt; font-weight: bold; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 16pt; font-weight: bold; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 16pt; font-weight: bold; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 16pt; font-weight: bold; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 16pt; font-weight: bold; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 16pt; font-weight: bold; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 16pt; font-weight: bold; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 16pt; font-weight: bold; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 16pt; font-weight: bold; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 16pt; font-weight: bold; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 16pt; font-weight: bold; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 16pt; font-weight: bold; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 16pt; font-weight: bold; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 16pt; font-weight: bold; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 16pt; font-weight: bold; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 16pt; font-weight: bold; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 16pt; font-weight: bold; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 16pt; font-weight: bold; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 16pt; font-weight: bold; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 16pt; font-weight: bold; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 16pt; font-weight: bold; text-align: center;">
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
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    </tr>
                    <tr style="height: 22px;">
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="border-right: 1px solid transparent; overflow: visible; padding: 0px; vertical-align: middle; font-family: Arial; font-size: 14pt; font-weight: bold;"
                            >
                            <div style="white-space: nowrap; overflow: hidden; position: relative; width: 481px; left: 3px;">
                                <div style="float: left;">Sous-doc N&deg;8-1 : Informations g&eacute;n&eacute;rales sur le client
                                </div>
                            </div>
                        </td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
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
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            colspan="32" rowspan="1" data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; font-weight: bold;"
                            colspan="43" rowspan="1"
                            data-sheets-numberformat="{&quot;1&quot;:2,&quot;2&quot;:&quot;#,##0&quot;,&quot;3&quot;:1}"
                            >
                            N&deg; MATRICULE DU CLIENT AU CABINET : $matricule_client</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt;"
                            colspan="6" rowspan="1" >
                            Adresse :</td>
                        <td style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(252, 243, 5);"
                            colspan="13" rowspan="1" data-sheets-numberformat="{&quot;1&quot;:1}"><div style="font-weight: bold; text-align: center;">$adresse</div></td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
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
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;"> 
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt;"
                            colspan="9" rowspan="1"
                            >N&deg;
                            d'identification fiscale :</td>
                        <td style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(252, 243, 5);"
                            colspan="10" rowspan="1" data-sheets-numberformat="{&quot;1&quot;:1}"><div style="font-weight: bold; text-align: center;">$id_fiscale_client</div></td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:2,&quot;2&quot;:&quot;0&quot;,&quot;3&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:2,&quot;2&quot;:&quot;0&quot;,&quot;3&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;"
                            colspan="6" rowspan="1"
                            >Exercice clos le :
                        </td>
                        <td style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(252, 243, 5);"
                            colspan="9" rowspan="1" data-sheets-numberformat="{&quot;1&quot;:1}"><div style="font-weight: bold; text-align: center;">$exercice_clos_le</div></td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt;"
                            colspan="3" rowspan="1"
                            >Dur&eacute;e
                            (en mois) :</td>
                        <td style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(252, 243, 5);"
                            data-sheets-numberformat="{&quot;1&quot;:1}"><div style="font-weight: bold; text-align: center;">$duree_en_mois</div></td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:5,&quot;2&quot;:&quot;D/M/YYYY&quot;,&quot;3&quot;:1}">&nbsp;
                        </td>
                        <td style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:5,&quot;2&quot;:&quot;D/M/YYYY&quot;,&quot;3&quot;:1}">&nbsp;
                        </td>
                        <td style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:5,&quot;2&quot;:&quot;D/M/YYYY&quot;,&quot;3&quot;:1}">&nbsp;
                        </td>
                        <td style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:5,&quot;2&quot;:&quot;D/M/YYYY&quot;,&quot;3&quot;:1}">&nbsp;
                        </td>
                        <td style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:5,&quot;2&quot;:&quot;D/M/YYYY&quot;,&quot;3&quot;:1}">&nbsp;
                        </td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(192, 192, 192); font-family: Arial; font-size: 12pt; font-weight: bold; text-align: center;"
                            >ZA</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt;"
                            colspan="8" rowspan="1"
                            >EXERCICE COMPTABLE
                            :</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;"
                            colspan="3" rowspan="1" >DU:</td>
                        <td style="border-right: 1px solid transparent; border-bottom: 1px dashed rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(252, 243, 5);"
                            colspan="6" rowspan="1" data-sheets-numberformat="{&quot;1&quot;:1}"><div style="font-weight: bold; text-align: center;">$exercice_compta_du</div></td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;"
                            colspan="4" rowspan="1" >AU :</td>
                        <td style="border-right: 1px solid transparent; border-bottom: 1px dashed rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(252, 243, 5);"
                            colspan="4" rowspan="1" data-sheets-numberformat="{&quot;1&quot;:1}"><div style="font-weight: bold; text-align: center;">$exercice_compta_au</div></td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
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
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(192, 192, 192); font-family: Arial; font-size: 12pt; font-weight: bold; text-align: center;"
                            >ZB</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt;"
                            colspan="16" rowspan="1"
                            >
                            DATE D'ARRETE EFFECTIF DES COMPTES :</td>
                        <td style="border-left: 1px solid rgb(0, 0, 0); border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(252, 243, 5);"
                            colspan="5" rowspan="1" data-sheets-numberformat="{&quot;1&quot;:1}"><div style="font-weight: bold; text-align: center;">$date_arret_compta</div></td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
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
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(255, 255, 255);">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(255, 255, 255);">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
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
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(192, 192, 192); font-family: Arial; font-size: 12pt; font-weight: bold; text-align: center;"
                            >ZC</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt;"
                            colspan="16" rowspan="1"
                            >EXERCICE
                            PRECEDENT CLOS LE :</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(252, 243, 5);"
                            colspan="4" rowspan="1" data-sheets-numberformat="{&quot;1&quot;:1}"><div style="font-weight: bold; text-align: center;">$exercice_prev_clos_le</div></td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt;"
                            colspan="15" rowspan="1"
                            >DUREE
                            EXERCICE PRECEDENT EN MOIS:</td>
                        <td style="border-right: 1px solid transparent; border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(252, 243, 5);"
                            data-sheets-numberformat="{&quot;1&quot;:1}"><div style="font-weight: bold; text-align: center;">$duree_exercice_prev_en_mois</div></td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
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
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(255, 255, 255);">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(255, 255, 255);">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
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
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(192, 192, 192); font-family: Arial; font-size: 12pt; font-weight: bold; text-align: center;"
                            >ZD</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            colspan="5" rowspan="1" data-sheets-numberformat="{&quot;1&quot;:1}"><div style="font-weight: bold; text-align: center;">$greffe</div></td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(252, 243, 5);"
                            colspan="7" rowspan="1" data-sheets-numberformat="{&quot;1&quot;:1}"><div style="font-weight: bold; text-align: center;">$num_registre_commerce</div></td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(255, 255, 255);">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(252, 243, 5);"
                            colspan="13" rowspan="1" data-sheets-numberformat="{&quot;1&quot;:1}"><div style="font-weight: bold; text-align: center;">$num_repertoire_entite</div></td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;"
                            colspan="5" rowspan="1" >Greffe
                        </td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;"
                            colspan="7" rowspan="1"
                            >N&deg;
                            Registre du commerce</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(255, 255, 255);">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(255, 255, 255);">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;"
                            colspan="13" rowspan="1"
                            >
                            N&deg; R&eacute;pertoire des entit&eacute;s</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
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
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(255, 255, 255);">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(255, 255, 255);">
                            &nbsp;</td>
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
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(192, 192, 192); font-family: Arial; font-size: 12pt; font-weight: bold; text-align: center;"
                            >ZE</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(252, 243, 5);"
                            colspan="5" rowspan="1" data-sheets-numberformat="{&quot;1&quot;:1}"><div style="font-weight: bold; text-align: center;">$num_caisse_sociale</div></td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            colspan="7" rowspan="1" data-sheets-numberformat="{&quot;1&quot;:1}"><div style="font-weight: bold; text-align: center;">$num_code_importateur</div></td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(255, 255, 255);">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(252, 243, 5);"
                            colspan="7" rowspan="1" data-sheets-numberformat="{&quot;1&quot;:1}"><div style="font-weight: bold; text-align: center;">$code_activite_principale</div></td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt;"
                            colspan="5" rowspan="1"
                            >N&deg; de
                            caisse sociale</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt;"
                            colspan="7" rowspan="1"
                            >N&deg; Code
                            Importateur</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt;"
                            colspan="7" rowspan="1"
                            >Code
                            activit&eacute; principale</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 18px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
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
                        <td style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
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
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(192, 192, 192); font-family: Arial; font-size: 12pt; font-weight: bold; text-align: center;"
                            >ZF</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(252, 243, 5);"
                            colspan="31" rowspan="1" data-sheets-numberformat="{&quot;1&quot;:1}"><div style="font-weight: bold; text-align: center;">$designation_entite</div></td>
                        <td style="border-right: 2px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            colspan="7" rowspan="1" data-sheets-numberformat="{&quot;1&quot;:1}"><div style="font-weight: bold; text-align: center;">$sigle</div></td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;"
                            colspan="31" rowspan="1"
                            >
                            D&eacute;signation de l'entit&eacute;</td>
                        <td style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;"
                            colspan="7" rowspan="1" >Sigle</td>
                    </tr>
                    <tr style="height: 17px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
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
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(255, 255, 255);">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(255, 255, 255);">
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
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 17px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
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
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(255, 255, 255);">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(255, 255, 255);">
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
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 17px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
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
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(255, 255, 255);">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(255, 255, 255);">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
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
                            style="border-right: 2px solid rgb(0, 0, 0); border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(192, 192, 192); font-family: Arial; font-size: 12pt; font-weight: bold; text-align: center;"
                            >ZG</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(252, 243, 5);"
                            colspan="6" rowspan="1" data-sheets-numberformat="{&quot;1&quot;:1}"><div style="font-weight: bold; text-align: center;">$telephone</div></td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            colspan="7" rowspan="1"><div style="font-weight: bold; text-align: center;">$email</div></td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            colspan="4" rowspan="1" data-sheets-numberformat="{&quot;1&quot;:1}"><div style="font-weight: bold; text-align: center;">$num_code</div></td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            colspan="6" rowspan="1" data-sheets-numberformat="{&quot;1&quot;:1}"><div style="font-weight: bold; text-align: center;">$code</div></td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(252, 243, 5);"
                            colspan="7" rowspan="1" data-sheets-numberformat="{&quot;1&quot;:1}"><div style="font-weight: bold; text-align: center;">$boite_postal</div></td>
                        <td style="border-right: 2px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(252, 243, 5);"
                            colspan="5" rowspan="1" data-sheets-numberformat="{&quot;1&quot;:1}"><div style="font-weight: bold; text-align: center;">$ville</div></td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;"
                            colspan="6" rowspan="1"
                            >N&deg;
                            de t&eacute;l&eacute;phone</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-decoration-line: underline; color: rgb(5, 99, 193); text-align: center;"
                            colspan="7" rowspan="1" data-sheets-hyperlink="mailto:er@tgur.ji"
                            
                                target="_blank" rel="noopener">email</a></td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;"
                            colspan="6" rowspan="1" >Code</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255); font-family: Arial; font-size: 12pt; text-align: center;"
                            colspan="7" rowspan="1" >
                            Bote postale</td>
                        <td style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;"
                            colspan="5" rowspan="1" >Ville</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt;">
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
                            style="border-right: 2px solid rgb(0, 0, 0); border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(192, 192, 192); font-family: Arial; font-size: 12pt; font-weight: bold; text-align: center;"
                            >ZH</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="border-right: 2px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(252, 243, 5);"
                            colspan="38" rowspan="2" data-sheets-numberformat="{&quot;1&quot;:1}">
                            <div style="max-height: 42px; font-weight: bold; text-align: center;">$adresse_geo_complete</div>
                        </td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="border-right: 2px solid rgb(0, 0, 0); border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; text-align: center;"
                            colspan="38" rowspan="1"
                            >
                            Adresse g&eacute;ographique compl&egrave;te (Immeuble, rue, quartier, ville, pays)</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="border-right: 2px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(252, 243, 5);"
                            colspan="38" rowspan="2" data-sheets-numberformat="{&quot;1&quot;:1}">
                            <div style="max-height: 42px; font-weight: bold; text-align: center;">$designation_activite_principale</div>
                        </td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(192, 192, 192); font-family: Arial; font-size: 12pt; font-weight: bold; text-align: center;"
                            >ZI</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; text-align: center;"
                            colspan="38" rowspan="1"
                            >
                            D&eacute;signation pr&eacute;cise de l'activit&eacute; principale exerc&eacute;e par l'entit&eacute;
                        </td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
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
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="border-right: 2px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(252, 243, 5);"
                            colspan="38" rowspan="1" data-sheets-numberformat="{&quot;1&quot;:1}"><div style="font-weight: bold; text-align: center;">$personne_a_contacter</div></td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; text-align: center;"
                            colspan="38" rowspan="1"
                            >
                            Nom, adresse et qualit&eacute; de la personne &agrave; contacter en cas de demande d'informations
                            compl&eacute;mentaires</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
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
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="border-right: 2px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(252, 243, 5);"
                            colspan="38" rowspan="1" data-sheets-numberformat="{&quot;1&quot;:1}"><div style="font-weight: bold; text-align: center;">$professionnel_salarie_ou_cabinet</div></td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="border-right: 2px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; text-align: center;"
                            colspan="38" rowspan="1"
                            >
                            Nom du professionnel salari&eacute; de l'entit&eacute; ou</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; text-align: center;"
                            colspan="38" rowspan="1"
                            >
                            Nom, adresse et t&eacute;l&eacute;phone du cabinet comptable ou du professionnel INSCRIT A L'ORDRE
                            NATIONAL</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; text-align: center;"
                            colspan="38" rowspan="1"
                            >
                            DES EXPERTS COMPTABLES ET DES COMPTABLES AGREES ayant &eacute;tabli les &eacute;tats financiers</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="border-right: 2px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            colspan="38" rowspan="1" data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt;">
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
                            style="border-right: 2px solid rgb(0, 0, 0); border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="border-right: 2px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(252, 243, 5);"
                            colspan="38" rowspan="1" data-sheets-numberformat="{&quot;1&quot;:1}"><div style="font-weight: bold; text-align: center;">$visa_expert</div></td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;"
                            colspan="38" rowspan="1"
                            >
                            Visa de l'Expert comptable agr&eacute;e</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
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
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
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
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="font-size: 20px; text-align: center; border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}"><b>$etats_financiers_approuves_non</b></td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="font-size: 20px; text-align: center; border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}"><b>$etats_financiers_approuves_oui</b></td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
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
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;"
                            >Non</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;"
                            >Oui</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
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
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="border-right: 1px solid transparent; overflow: visible; padding: 0px; vertical-align: middle; font-family: Arial; font-size: 8pt;"
                            >
                            <div style="white-space: nowrap; overflow: hidden; position: relative; width: 350px; left: 3px;">
                                <div style="float: left;">Etats financiers approuv&eacute;s par l'Assembl&eacute;e
                                    G&eacute;n&eacute;rale (cocher la case)</div>
                            </div>
                        </td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
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
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 27px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(252, 243, 5);"
                            colspan="17" rowspan="1" data-sheets-numberformat="{&quot;1&quot;:1}"><!--Lorem--></td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; font-weight: bold; text-align: center;"
                            colspan="16" rowspan="1"
                            >Domiciliations
                            bancaires:</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="border-right: 1px solid transparent; overflow: visible; padding: 0px; vertical-align: middle; font-family: Arial; font-size: 12pt;"
                            >
                            <div style="white-space: nowrap; overflow: hidden; position: relative; width: 275px; left: 3px;">
                                <div style="float: left;">Nom du signataire des &eacute;tats financiers</div>
                            </div>
                        </td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px; vertical-align: middle; font-family: Arial; font-size: 12pt;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px; vertical-align: middle; font-family: Arial; font-size: 12pt;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px; vertical-align: middle; font-family: Arial; font-size: 12pt;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px; vertical-align: middle; font-family: Arial; font-size: 12pt;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px; vertical-align: middle; font-family: Arial; font-size: 12pt;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px; vertical-align: middle; font-family: Arial; font-size: 12pt;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px; vertical-align: middle; font-family: Arial; font-size: 12pt;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px; vertical-align: middle; font-family: Arial; font-size: 12pt;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px; vertical-align: middle; font-family: Arial; font-size: 12pt;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px; vertical-align: middle; font-family: Arial; font-size: 12pt;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; font-weight: bold;"
                            colspan="9" rowspan="1" >Banque
                        </td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; font-weight: bold;"
                            colspan="7" rowspan="1"
                            >Num&eacute;ro de
                            compte</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
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
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(252, 243, 5);"
                            colspan="9" rowspan="2" data-sheets-numberformat="{&quot;1&quot;:1}">
                            <div style="max-height: 49px;"><!--Lorem--></div>
                        </td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(252, 243, 5);"
                            colspan="7" rowspan="2" data-sheets-numberformat="{&quot;1&quot;:1}">
                            <div style="max-height: 49px;"><!--Lorem--></div>
                        </td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 28px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(252, 243, 5);"
                            colspan="17" rowspan="1" data-sheets-numberformat="{&quot;1&quot;:1}"><!--Lorem--></td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="border-right: 1px solid transparent; overflow: visible; padding: 0px; vertical-align: middle; font-family: Arial; font-size: 12pt;"
                            >
                            <div style="white-space: nowrap; overflow: hidden; position: relative; width: 275px; left: 3px;">
                                <div style="float: left;">Nom du signataire des &eacute;tats financiers</div>
                            </div>
                        </td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px; vertical-align: middle; font-family: Arial; font-size: 12pt;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px; vertical-align: middle; font-family: Arial; font-size: 12pt;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px; vertical-align: middle; font-family: Arial; font-size: 12pt;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px; vertical-align: middle; font-family: Arial; font-size: 12pt;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px; vertical-align: middle; font-family: Arial; font-size: 12pt;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px; vertical-align: middle; font-family: Arial; font-size: 12pt;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px; vertical-align: middle; font-family: Arial; font-size: 12pt;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px; vertical-align: middle; font-family: Arial; font-size: 12pt;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px; vertical-align: middle; font-family: Arial; font-size: 12pt;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px; vertical-align: middle; font-family: Arial; font-size: 12pt;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
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
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
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
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
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
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
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
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
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
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
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
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
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
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
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
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
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
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                </tbody>
            </table>
    HTML;

    $update1 = update(
        'doc_fiche_id_client',
        [
            'contenu_document' => $contenu_document
        ],
        "id_document = $id_document",
        $db
    );

    $update2 = update(
        'document',
        [
            'updated_at_document' => date('Y-m-d H:i:s'),
            'updated_by_document' => $_SESSION['id_utilisateur']
        ],
        "id_document = $id_document",
        $db
    );

    if ($update1 && $update2) {
        return true;
    } else {
        return false;
    }
}
