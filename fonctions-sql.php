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



function update_contenu_document_table_doc_8_fiche_id_client($id_document, PDO $db)
{
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

    $forme_juridique_1 = $result['forme_juridique_1'];
    $forme_juridique_2 = $result['forme_juridique_2'];
    $regime_fiscal_1 = $result['regime_fiscal_1'];
    $regime_fiscal_2 = $result['regime_fiscal_2'];
    $pays_siege_social_1 = $result['pays_siege_social_1'];
    $pays_siege_social_2 = $result['pays_siege_social_2'];
    $nbr_etablissement_in = $result['nbr_etablissement_in'];
    $nbr_etablissement_out = $result['nbr_etablissement_out'];
    $prem_annee_exercice_in = $result['prem_annee_exercice_in'];
    $controle_entite = $result['controle_entite'];
    if($controle_entite == 'public'){
        $controle_entite_public = 'X';
        $controle_entite_prive_national = '';
        $controle_entite_prive_etranger = '';
    }else if($controle_entite == 'prive_national'){
        $controle_entite_public = '';
        $controle_entite_prive_national = 'X';
        $controle_entite_prive_etranger = '';
    }else{
        $controle_entite_public = '';
        $controle_entite_prive_national = '';
        $controle_entite_prive_etranger = 'X';
    }

    $duree_vie_societe = $_POST['duree_vie_societe']; 
    $date_dissolution = si_funct1($result['date_dissolution'], date('d/m/Y', strtotime($result['date_dissolution'])), '');
    $capital_social = $_POST['capital_social']; 
    $siege_social = $_POST['siege_social']; 
    $site_internet = $_POST['site_internet']; 
    $nombre_de_salarie = $_POST['nombre_de_salarie']; 
    $ca_3_derniers_exercices_n_1 = $_POST['ca_3_derniers_exercices_n_1'];
    $ca_3_derniers_exercices_n_2 = $_POST['ca_3_derniers_exercices_n_2'];
    $ca_3_derniers_exercices_n_3 = $_POST['ca_3_derniers_exercices_n_3'];

    $date_ouverture_dossier = si_funct1($result['date_ouverture_dossier'], date('d/m/Y', strtotime($result['date_ouverture_dossier'])), '');
    $nom_cabinet_confrere = $result['nom_cabinet_confrere'];
    $dossier_herite_confrere = $result['dossier_herite_confrere'];

    // Sous-doc 8-1 (Partie 1)
    $contenu_document = <<<HTML
        <table dir="ltr"
            style="transform: scale(0.9); transform-origin: top left; table-layout: fixed; font-size: 11pt; font-family: Calibri; border-collapse: collapse; border-style: none; width: 100%;"
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
                <col width="35">
                <col width="18">
                <col width="18">
                <col width="9">
                <col width="56">
                <col width="19">
                <col width="18">
                <col width="25">
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
                    <td colspan="7" style="border-right: 1px solid transparent; overflow: visible; padding: 0px; vertical-align: middle; font-family: Arial; font-size: 14pt; font-weight: bold;"
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
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; vertical-align: middle; background-color: rgb(252, 243, 5);"
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
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; vertical-align: middle;"
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
        </table><br>
    HTML;

    // Sous-doc 8-1 (Partie 2)
    $contenu_document .= <<<HTML
        <table dir="ltr"
            style="table-layout: fixed; font-size: 11pt; font-family: Calibri; width: 0px; border-collapse: collapse; border-style: none; width: 100%;"
            border="0" cellspacing="0" cellpadding="0">
            <colgroup>
                <col width="18">
                <col width="18">
                <col width="18">
                <col width="18">
                <col width="18">
                <col width="18">
                <col width="18">
                <col width="18">
                <col width="18">
                <col width="18">
                <col width="18">
                <col width="18">
                <col width="18">
                <col width="18">
                <col width="18">
                <col width="88">
                <col width="19">
                <col width="16">
                <col width="16">
                <col width="16">
                <col width="16">
                <col width="24">
                <col width="24">
                <col width="24">
                <col width="24">
                <col width="24">
                <col width="24">
                <col width="24">
                <col width="24">
                <col width="24">
                <col width="24">
                <col width="24">
                <col width="24">
                <col width="24">
                <col width="24">
                <col width="24">
            </colgroup>
            <tbody>
                <tr style="height: 22px;">
                    <td colspan="2" style="border-right: 1px solid transparent; overflow: visible; padding: 0px; vertical-align: middle; font-family: Arial; font-size: 14pt; font-weight: bold;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Sous-doc N&deg;8-1 : Informations g&eacute;n&eacute;rales sur le client (Suite)&quot;}">
                        <div style="white-space: nowrap; overflow: hidden; position: relative; width: 537px; left: 3px;">
                            <div style="float: left;">Sous-doc N&deg;8-1 : Informations g&eacute;n&eacute;rales sur le client
                                (Suite)</div>
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
                </tr>
                <tr style="height: 21px;">
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
                </tr>
                <tr style="height: 21px;">
                    <td style="border-bottom: 1px solid rgb(0, 0, 0); border-left: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        data-sheets-numberformat="{&quot;1&quot;:2,&quot;2&quot;:&quot;0&quot;,&quot;3&quot;:1}">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        data-sheets-numberformat="{&quot;1&quot;:2,&quot;2&quot;:&quot;0&quot;,&quot;3&quot;:1}">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        data-sheets-numberformat="{&quot;1&quot;:2,&quot;2&quot;:&quot;0&quot;,&quot;3&quot;:1}">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        data-sheets-numberformat="{&quot;1&quot;:2,&quot;2&quot;:&quot;0&quot;,&quot;3&quot;:1}">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        data-sheets-numberformat="{&quot;1&quot;:2,&quot;2&quot;:&quot;0&quot;,&quot;3&quot;:1}">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        data-sheets-numberformat="{&quot;1&quot;:2,&quot;2&quot;:&quot;0&quot;,&quot;3&quot;:1}">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        data-sheets-numberformat="{&quot;1&quot;:2,&quot;2&quot;:&quot;0&quot;,&quot;3&quot;:1}">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        data-sheets-numberformat="{&quot;1&quot;:2,&quot;2&quot;:&quot;0&quot;,&quot;3&quot;:1}">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        data-sheets-numberformat="{&quot;1&quot;:2,&quot;2&quot;:&quot;0&quot;,&quot;3&quot;:1}">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        data-sheets-numberformat="{&quot;1&quot;:2,&quot;2&quot;:&quot;0&quot;,&quot;3&quot;:1}">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        data-sheets-numberformat="{&quot;1&quot;:2,&quot;2&quot;:&quot;0&quot;,&quot;3&quot;:1}">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        data-sheets-numberformat="{&quot;1&quot;:2,&quot;2&quot;:&quot;0&quot;,&quot;3&quot;:1}">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        data-sheets-numberformat="{&quot;1&quot;:2,&quot;2&quot;:&quot;0&quot;,&quot;3&quot;:1}">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        data-sheets-numberformat="{&quot;1&quot;:2,&quot;2&quot;:&quot;0&quot;,&quot;3&quot;:1}">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        data-sheets-numberformat="{&quot;1&quot;:2,&quot;2&quot;:&quot;0&quot;,&quot;3&quot;:1}">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        data-sheets-numberformat="{&quot;1&quot;:2,&quot;2&quot;:&quot;0&quot;,&quot;3&quot;:1}">&nbsp;</td>
                    <td style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        data-sheets-numberformat="{&quot;1&quot;:2,&quot;2&quot;:&quot;0&quot;,&quot;3&quot;:1}">&nbsp;</td>
                    <td style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        data-sheets-numberformat="{&quot;1&quot;:2,&quot;2&quot;:&quot;0&quot;,&quot;3&quot;:1}">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        data-sheets-numberformat="{&quot;1&quot;:2,&quot;2&quot;:&quot;0&quot;,&quot;3&quot;:1}">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;"
                        colspan="15" rowspan="1"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Contr&ocirc;le de l'entit&eacute; (cocher la case)&quot;}">
                        Contr&ocirc;le de l'entit&eacute; (cocher la case)</td>
                </tr>
                <tr style="height: 21px;">
                    <td style="border-right: 1px solid transparent; border-bottom: 1px solid rgb(0, 0, 0); border-left: 2px solid rgb(0, 0, 0); overflow: visible; padding: 0px; vertical-align: middle; background-color: rgb(192, 192, 192); font-family: Arial; font-size: 12pt; font-weight: bold;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;ZK&quot;}">
                        <div style="white-space: nowrap; overflow: hidden; position: relative; width: 51px; left: -16px;">
                            <div
                                style="margin-left: -100%; margin-right: -100%; text-align: center; position: relative; left: 0px;">
                                ZK</div>
                        </div>
                    </td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt;"
                        colspan="14" rowspan="1"
                        data-sheets-textstyleruns="{&quot;1&quot;:0}{&quot;1&quot;:16,&quot;2&quot;:{&quot;3&quot;:&quot;Arial&quot;,&quot;4&quot;:12}}"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Forme juridique  :&quot;}"><span
                            style="font-size: 12pt; font-family: Arial;">Forme juridique </span><span
                            style="font-size: 12pt; font-family: Arial;"> :</span></td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(252, 243, 5);"
                        data-sheets-numberformat="{&quot;1&quot;:1}">$forme_juridique_1</td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(252, 243, 5);"
                        data-sheets-numberformat="{&quot;1&quot;:1}">$forme_juridique_2</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px; vertical-align: middle; background-color: rgb(192, 192, 192); font-family: Arial; font-size: 12pt; font-weight: bold;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;ZQ&quot;}">ZQ</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;" colspan="11" rowspan="1"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot; Entit&eacute; sous contr&ocirc;le public&quot;}">
                        Entit&eacute; sous contr&ocirc;le public</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="text-align: center; font-weight: bold; border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        $controle_entite_public</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                </tr>
                <tr style="height: 21px;">
                    <td
                        style="border-bottom: 1px solid rgb(0, 0, 0); border-left: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
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
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
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
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                </tr>
                <tr style="height: 21px;">
                    <td style="border-right: 1px solid transparent; border-bottom: 1px solid rgb(0, 0, 0); border-left: 2px solid rgb(0, 0, 0); overflow: visible; padding: 0px; vertical-align: middle; background-color: rgb(192, 192, 192); font-family: Arial; font-size: 12pt; font-weight: bold;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;ZL&quot;}">
                        <div style="white-space: nowrap; overflow: hidden; position: relative; width: 51px; left: -16px;">
                            <div
                                style="margin-left: -100%; margin-right: -100%; text-align: center; position: relative; left: 0px;">
                                ZL</div>
                        </div>
                    </td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt;"
                        colspan="14" rowspan="1"
                        data-sheets-textstyleruns="{&quot;1&quot;:0}{&quot;1&quot;:14,&quot;2&quot;:{&quot;3&quot;:&quot;Arial&quot;,&quot;4&quot;:12}}"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;R&eacute;gime fiscal  :&quot;}"><span
                            style="font-size: 12pt; font-family: Arial;">R&eacute;gime fiscal </span><span
                            style="font-size: 12pt; font-family: Arial;"> :</span></td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(252, 243, 5);"
                        data-sheets-numberformat="{&quot;1&quot;:1}">$regime_fiscal_1</td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(252, 243, 5);"
                        data-sheets-numberformat="{&quot;1&quot;:1}">$regime_fiscal_2</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px; vertical-align: middle; background-color: rgb(192, 192, 192); font-family: Arial; font-size: 12pt; font-weight: bold;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;ZR&quot;}">ZR</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;" colspan="11" rowspan="1"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot; Entit&eacute; sous contr&ocirc;le priv&eacute; national&quot;}">
                        Entit&eacute; sous contr&ocirc;le priv&eacute; national</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="text-align: center; font-weight: bold; border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        $controle_entite_prive_national</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                </tr>
                <tr style="height: 21px;">
                    <td
                        style="border-bottom: 1px solid rgb(0, 0, 0); border-left: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
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
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
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
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                </tr>
                <tr style="height: 21px;">
                    <td style="border-right: 1px solid transparent; border-bottom: 1px solid rgb(0, 0, 0); border-left: 2px solid rgb(0, 0, 0); overflow: visible; padding: 0px; vertical-align: middle; background-color: rgb(192, 192, 192); font-family: Arial; font-size: 12pt; font-weight: bold;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;ZM&quot;}">
                        <div style="white-space: nowrap; overflow: hidden; position: relative; width: 51px; left: -16px;">
                            <div
                                style="margin-left: -100%; margin-right: -100%; text-align: center; position: relative; left: 0px;">
                                ZM</div>
                        </div>
                    </td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt;"
                        colspan="14" rowspan="1"
                        data-sheets-textstyleruns="{&quot;1&quot;:0}{&quot;1&quot;:21,&quot;2&quot;:{&quot;3&quot;:&quot;Arial&quot;,&quot;4&quot;:12}}"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Pays du si&egrave;ge social  :&quot;}"><span
                            style="font-size: 12pt; font-family: Arial;">Pays du si&egrave;ge social </span><span
                            style="font-size: 12pt; font-family: Arial;"> :</span></td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(252, 243, 5);"
                        data-sheets-numberformat="{&quot;1&quot;:1}">$pays_siege_social_1</td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(252, 243, 5);"
                        data-sheets-numberformat="{&quot;1&quot;:1}">$pays_siege_social_2</td>
                    <td
                        style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(255, 255, 255);">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px; vertical-align: middle; background-color: rgb(192, 192, 192); font-family: Arial; font-size: 12pt; font-weight: bold;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;ZS&quot;}">ZS</td>
                    <td style="border-right: 1px solid transparent; overflow: visible; padding: 0px 3px; vertical-align: middle;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot; Entit&eacute; sous contr&ocirc;le priv&eacute; &eacute;tranger&quot;}">
                        <div style="white-space: nowrap; overflow: hidden; position: relative; width: 269px; left: 3px;">
                            <div style="float: left;">Entit&eacute; sous contr&ocirc;le priv&eacute; &eacute;tranger</div>
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
                        style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="text-align: center; font-weight: bold;  border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        $controle_entite_prive_etranger</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                </tr>
                <tr style="height: 21px;">
                    <td
                        style="border-bottom: 1px solid rgb(0, 0, 0); border-left: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
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
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                </tr>
                <tr style="height: 21px;">
                    <td style="border-right: 1px solid transparent; border-bottom: 1px solid rgb(0, 0, 0); border-left: 2px solid rgb(0, 0, 0); overflow: visible; padding: 0px; vertical-align: middle; background-color: rgb(192, 192, 192); font-family: Arial; font-size: 12pt; font-weight: bold;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;ZN&quot;}">
                        <div style="white-space: nowrap; overflow: hidden; position: relative; width: 51px; left: -16px;">
                            <div
                                style="margin-left: -100%; margin-right: -100%; text-align: center; position: relative; left: 0px;">
                                ZN</div>
                        </div>
                    </td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt;"
                        colspan="14" rowspan="1"
                        data-sheets-numberformat="{&quot;1&quot;:2,&quot;2&quot;:&quot;0.00&quot;,&quot;3&quot;:1}"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Nombre d'&eacute;tablissements dans le pays :&quot;}">
                        Nombre d'&eacute;tablissements dans le pays :</td>
                    <td colspan="2" style="text-align: center; border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(252, 243, 5);"
                        data-sheets-numberformat="{&quot;1&quot;:1}">$nbr_etablissement_in</td>
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
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                </tr>
                <tr style="height: 21px;">
                    <td
                        style="border-bottom: 1px solid rgb(0, 0, 0); border-left: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
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
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
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
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                </tr>
                <tr style="height: 21px;">
                    <td style="border-right: 1px solid transparent; border-bottom: 1px solid rgb(0, 0, 0); border-left: 2px solid rgb(0, 0, 0); overflow: visible; padding: 0px; vertical-align: middle; background-color: rgb(192, 192, 192); font-family: Arial; font-size: 12pt; font-weight: bold;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;ZO&quot;}">
                        <div style="white-space: nowrap; overflow: hidden; position: relative; width: 51px; left: -16px;">
                            <div
                                style="margin-left: -100%; margin-right: -100%; text-align: center; position: relative; left: 0px;">
                                ZO</div>
                        </div>
                    </td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt;"
                        colspan="14" rowspan="2"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Nombre d'&eacute;tablissements hors du pays pour                                                                                                        \nlesquels une comptabilit&eacute; distincte est tenue :                                                                                                        &quot;}">
                        <div style="max-height: 42px;">Nombre d'&eacute;tablissements hors du pays pour <br>lesquels une
                            comptabilit&eacute; distincte est tenue :</div>
                    </td>
                    <td colspan="2" style="text-align: center; border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(252, 243, 5);"
                        data-sheets-numberformat="{&quot;1&quot;:1}">$nbr_etablissement_out</td>
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
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                </tr>
                <tr style="height: 21px;">
                    <td
                        style="border-left: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
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
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                </tr>
                <tr style="height: 21px;">
                    <td
                        style="border-bottom: 1px solid rgb(0, 0, 0); border-left: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
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
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
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
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                </tr>
                <tr style="height: 21px;">
                    <td style="border-right: 1px solid transparent; border-bottom: 1px solid rgb(0, 0, 0); border-left: 2px solid rgb(0, 0, 0); overflow: visible; padding: 0px; vertical-align: middle; background-color: rgb(192, 192, 192); font-family: Arial; font-size: 12pt; font-weight: bold;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;ZP&quot;}">
                        <div style="white-space: nowrap; overflow: hidden; position: relative; width: 51px; left: -16px;">
                            <div
                                style="margin-left: -100%; margin-right: -100%; text-align: center; position: relative; left: 0px;">
                                ZP</div>
                        </div>
                    </td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        colspan="14" rowspan="1"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Premi&egrave;re ann&eacute;e d'exercice dans le pays :&quot;}">
                        Premi&egrave;re ann&eacute;e d'exercice dans le pays :</td>
                    <td colspan="4" style="letter-spacing: 10px; border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(252, 243, 5);"
                        data-sheets-numberformat="{&quot;1&quot;:1}">$prem_annee_exercice_in</td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(255, 255, 255);">
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
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                </tr>
                <tr style="height: 21px;">
                    <td
                        style="border-bottom: 1px solid rgb(0, 0, 0); border-left: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
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
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
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
                </tr>
            </tbody>
        </table><br>
        <table dir="ltr"
            style="table-layout: fixed; font-size: 10pt; font-family: Arial; width: 0px; border-collapse: collapse; border-style: none; width: 100%;"
            border="0" cellspacing="0" cellpadding="0">
            <colgroup>
                <col width="280">
                <col width="171">
                <col width="178">
                <col width="156">
            </colgroup>
            <tbody>
                <tr style="height: 21px;">
                    <td style="border-width: 1px; border-style: solid; border-color: rgb(0, 0, 0); overflow: hidden; padding: 2px 3px; vertical-align: middle; text-align: center;"
                        colspan="4" rowspan="2"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;ACTIVITE DE L'ENTITE&quot;}">
                        <div style="max-height: 42px; font-weight: bold;">ACTIVITE DE L'ENTITE</div>
                    </td>
                </tr>
                <tr style="height: 21px;"></tr>
                <tr style="height: 58px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); border-left: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 2px 3px; vertical-align: middle; font-size: 12pt; text-align: center;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;D&eacute;signation de l'activit&eacute; (1)&quot;}">
                        D&eacute;signation de l'activit&eacute; (1)</td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 2px 3px; vertical-align: middle; font-size: 12pt; overflow-wrap: break-word; text-align: center;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Code nomenclature d'activit&eacute;&quot;}">Code
                        nomenclature d'activit&eacute;</td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 2px 3px; vertical-align: middle; font-size: 12pt; overflow-wrap: break-word; text-align: center;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Chiffre d'affaires HT (CA HT)&quot;}">Chiffre
                        d'affaires HT (CA HT)</td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 2px 3px; vertical-align: middle; font-size: 12pt; overflow-wrap: break-word; text-align: center;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;% activit&eacute; dans le CA HT&quot;}">%
                        activit&eacute; dans le CA HT</td>
                </tr>
    HTML;

    $query = "SELECT * FROM activite_client WHERE id_client = $id_client";
    $statement = $db->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();

    $total_ca = 0;
    $total_percent = 0;
    foreach ($result as $row) {

        $contenu_document .= <<<HTML
            <tr style="height: 33px;">
                <td
                    style="padding-left: 2px; font-weight: bold; border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); border-left: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 2px 3px; vertical-align: middle;">
                    {$row['designation_activite_client']}</td>
                <td
                    style="text-align: center; font-weight: bold; border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 2px 3px; vertical-align: middle;">
                    {$row['code_nomenclature_activite_client']}</td>
                <td
                    style="text-align: center; font-weight: bold; border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 2px 3px; vertical-align: middle;">
                    {$row['chiffre_affaires_ht_activite_client']}</td>
                <td style="text-align: center; font-weight: bold; border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 2px 3px; vertical-align: middle;">
                {$row['percent_activite_in_ca_activite_client']}</td>
            </tr>
        HTML;

        $total_ca += $row['chiffre_affaires_ht_activite_client'];
        $total_percent += $row['percent_activite_in_ca_activite_client'];
        
    }


    $contenu_document .= <<<HTML
                <tr style="height: 40px;">
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); border-left: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 2px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 2px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 2px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 2px 3px; vertical-align: middle;">
                        &nbsp;</td>
                </tr>
                <tr style="height: 33px;">
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); border-left: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 2px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 2px 3px; vertical-align: middle; background-color: rgb(204, 204, 204);">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 2px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 2px 3px; vertical-align: middle;">
                        &nbsp;</td>
                </tr>
                <tr style="height: 41px;">
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); border-left: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 2px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 2px 3px; vertical-align: middle; font-weight: bold; text-align: center;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;TOTAL&quot;}">TOTAL</td>
                    <td style="text-align: center; font-weight: bold; border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 2px 3px; vertical-align: middle;">
                        $total_ca</td>
                    <td style="text-align: center; font-weight: bold; border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 2px 3px; vertical-align: middle;">
                        $total_percent</td>
                </tr>
                <tr style="height: 21px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); border-left: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 2px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255); font-family: Roboto; font-size: 11pt;"
                        colspan="4" rowspan="3"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;(1) Lister de mani&egrave;re pr&eacute;cise les activit&eacute;s dans l'ordre d&eacute;croissant du C. A. HT, ou de la valeur ajout&eacute;e (V. A.).&quot;}">
                        <div style="max-height: 63px;">(1) Lister de mani&egrave;re pr&eacute;cise les activit&eacute;s dans
                            l'ordre d&eacute;croissant du C. A. HT, ou de la valeur ajout&eacute;e (V. A.).</div>
                    </td>
                </tr>
                <tr style="height: 21px;"></tr>
                <tr style="height: 21px;"></tr>
            </tbody>
        </table>
        <br><br><br><br><br>
    HTML;

    // Sous-doc 8-1 (Partie 3)
    $contenu_document .= <<<HTML
        <table dir="ltr"
            style="table-layout: fixed; font-size: 11pt; font-family: Calibri; width: 0px; border-collapse: collapse; border-style: none; width: 100%;"
            border="0" cellspacing="0" cellpadding="0">
            <colgroup>
                <col width="140">
                <col width="169">
                <col width="116">
                <col width="189">
                <col width="285">
            </colgroup>
            <tbody>
                <tr style="height: 22px;">
                    <td style="border-right: 1px solid transparent; overflow: visible; padding: 0px; vertical-align: middle; font-family: Arial; font-size: 14pt; font-weight: bold;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Sous-doc N&deg;8-1 : Informations g&eacute;n&eacute;rales sur le client (Suite)&quot;}">
                        <div style="white-space: nowrap; overflow: hidden; position: relative; width: 612px; left: 3px;">
                            <div style="float: left;">Sous-doc N&deg;8-1 : Informations g&eacute;n&eacute;rales sur le client
                                (Suite)</div>
                        </div>
                    </td>
                    <td
                        style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 21px;">
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
                </tr>
                <tr style="height: 21px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); border-left: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(180, 198, 231); font-family: Arial; font-size: 12pt; font-weight: bold; text-align: center;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Nom&quot;}">Nom</td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(180, 198, 231); font-family: Arial; font-size: 12pt; font-weight: bold; text-align: center;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Pr&eacute;noms&quot;}">Pr&eacute;noms</td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(180, 198, 231); font-family: Arial; font-size: 12pt; font-weight: bold; text-align: center;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Qualit&eacute;&quot;}">Qualit&eacute;</td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(180, 198, 231); font-family: Arial; font-size: 12pt; font-weight: bold; overflow-wrap: break-word; text-align: center;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;N&deg; identification fiscale&quot;}">N&deg;
                        identification fiscale</td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(180, 198, 231); font-family: Arial; font-size: 12pt; font-weight: bold; overflow-wrap: break-word; text-align: center;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Adresse (BP, ville, pays)&quot;}">Adresse (BP,
                        ville, pays)</td>
                </tr>
    HTML;

    $query = "SELECT * FROM dirigeant_client WHERE id_client = $id_client";
    $statement = $db->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();

    foreach ($result as $row) {

        $contenu_document .= <<<HTML

            <tr style="height: 20px;">
                <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); border-left: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(180, 198, 231); font-family: Arial; font-size: 11pt; font-weight: bold; text-align: center;"
                    colspan="1" rowspan="3">
                    <div style="max-height: 63px;">{$row['nom_dirigeant_client']}</div>
                </td>
                <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(180, 198, 231); font-family: Arial; font-size: 11pt; font-weight: bold; text-align: center;"
                    colspan="1" rowspan="3">
                    <div style="max-height: 63px;">{$row['prenom_dirigeant_client']}</div>
                </td>
                <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(180, 198, 231); font-family: Arial; font-size: 11pt; font-weight: bold; text-align: center;"
                    colspan="1" rowspan="3">
                    <div style="max-height: 63px;">{$row['qualite_dirigeant_client']}</div>
                </td>
                <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(180, 198, 231); font-family: Arial; font-size: 11pt; font-weight: bold; text-align: center;"
                    colspan="1" rowspan="3">
                    <div style="max-height: 63px;">{$row['id_fiscal_dirigeant_client']}</div>
                </td>
                <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(180, 198, 231); font-family: Arial; font-size: 11pt; font-weight: bold; overflow-wrap: break-word;"
                    data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Tel :&quot;}">Tel : {$row['tel_dirigeant_client']}</td>
            </tr>
            <tr style="height: 20px;">
                <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(180, 198, 231); font-family: Arial; font-size: 11pt; font-weight: bold; overflow-wrap: break-word;"
                    data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;mail:&quot;}">mail: {$row['mail_dirigeant_client']}</td>
            </tr>
            <tr style="height: 20px;">
                <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(180, 198, 231); font-family: Arial; font-size: 11pt; font-weight: bold; overflow-wrap: break-word;"
                    data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Adresse:&quot;}">Adresse: {$row['adresse_dirigeant_client']}</td>
            </tr>

        HTML;   
        
    }

    $contenu_document .= <<<HTML

                <tr style="height: 21px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); border-left: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(180, 198, 231); font-family: Arial; font-size: 12pt; font-weight: bold; text-align: center;"
                        colspan="1" rowspan="3">
                        <div style="max-height: 63px;">&nbsp;</div>
                    </td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(180, 198, 231); font-family: Arial; font-size: 12pt; font-weight: bold; text-align: center;"
                        colspan="1" rowspan="3">
                        <div style="max-height: 63px;">&nbsp;</div>
                    </td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(180, 198, 231); font-family: Arial; font-size: 12pt; font-weight: bold; text-align: center;"
                        colspan="1" rowspan="3">
                        <div style="max-height: 63px;">&nbsp;</div>
                    </td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(180, 198, 231); font-family: Arial; font-size: 12pt; font-weight: bold; text-align: center;"
                        colspan="1" rowspan="3">
                        <div style="max-height: 63px;">&nbsp;</div>
                    </td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(180, 198, 231); font-family: Arial; font-size: 12pt; font-weight: bold; overflow-wrap: break-word;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Tel :&quot;}">Tel :</td>
                </tr>
                <tr style="height: 21px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(180, 198, 231); font-family: Arial; font-size: 12pt; font-weight: bold; overflow-wrap: break-word;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;mail:&quot;}">mail:</td>
                </tr>
                <tr style="height: 21px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(180, 198, 231); font-family: Arial; font-size: 12pt; font-weight: bold; overflow-wrap: break-word;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Adresse:&quot;}">Adresse:</td>
                </tr>

                <tr style="height: 21px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); border-left: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(180, 198, 231); font-family: Arial; font-size: 12pt; font-weight: bold; text-align: center;"
                        colspan="1" rowspan="3">
                        <div style="max-height: 63px;">&nbsp;</div>
                    </td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(180, 198, 231); font-family: Arial; font-size: 12pt; font-weight: bold; text-align: center;"
                        colspan="1" rowspan="3">
                        <div style="max-height: 63px;">&nbsp;</div>
                    </td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(180, 198, 231); font-family: Arial; font-size: 12pt; font-weight: bold; text-align: center;"
                        colspan="1" rowspan="3">
                        <div style="max-height: 63px;">&nbsp;</div>
                    </td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(180, 198, 231); font-family: Arial; font-size: 12pt; font-weight: bold; text-align: center;"
                        colspan="1" rowspan="3">
                        <div style="max-height: 63px;">&nbsp;</div>
                    </td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(180, 198, 231); font-family: Arial; font-size: 12pt; font-weight: bold; overflow-wrap: break-word;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Tel :&quot;}">Tel :</td>
                </tr>
                <tr style="height: 21px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(180, 198, 231); font-family: Arial; font-size: 12pt; font-weight: bold; overflow-wrap: break-word;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;mail:&quot;}">mail:</td>
                </tr>
                <tr style="height: 21px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(180, 198, 231); font-family: Arial; font-size: 12pt; font-weight: bold; overflow-wrap: break-word;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Adresse:&quot;}">Adresse:</td>
                </tr>

                <tr style="height: 21px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); border-left: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(255, 255, 255); font-family: Arial; font-size: 12pt;"
                        colspan="5" rowspan="2"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;(1) Dirigeants = Pr&eacute;sident Directeur G&eacute;n&eacute;ral, Directeur G&eacute;n&eacute;ral, Administrateur G&eacute;n&eacute;ral, G&eacute;rant, Autres&quot;}">
                        <div style="max-height: 42px;">(1) Dirigeants = Pr&eacute;sident Directeur G&eacute;n&eacute;ral,
                            Directeur G&eacute;n&eacute;ral, Administrateur G&eacute;n&eacute;ral, G&eacute;rant, Autres</div>
                    </td>
                </tr>
                <tr style="height: 21px;"></tr>
            </tbody>
        </table><br>
        <table dir="ltr"
            style="table-layout: fixed; font-size: 10pt; font-family: Arial; width: 0px; border-collapse: collapse; border-style: none; width: 100%;"
            border="0" cellspacing="0" cellpadding="0">
            <colgroup>
                <col width="125">
                <col width="141">
                <col width="155">
                <col width="257">
                <col width="255">
            </colgroup>
            <tbody>
            <tr style="height: 22px;">
                <td style="border-width: 1px; border-style: solid; border-color: rgb(0, 0, 0); overflow: hidden; padding: 2px 3px; vertical-align: middle; background-color: rgb(255, 255, 255); font-size: 12pt; font-weight: bold; text-align: center;"
                    colspan="5" rowspan="2"
                    data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;MEMBRES DU CONSEIL D'ADMINISTRATION&quot;}">
                    <div style="max-height: 43px;">MEMBRES DU CONSEIL D'ADMINISTRATION</div>
                </td>
            </tr>
            <tr style="height: 21px;"></tr>
            <tr style="height: 21px;">
                <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); border-left: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 2px 3px; vertical-align: bottom; background-color: rgb(180, 198, 231); font-size: 12pt; font-weight: bold; text-align: center;"
                    data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Nom&quot;}">Nom</td>
                <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 2px 3px; vertical-align: bottom; background-color: rgb(180, 198, 231); font-size: 12pt; font-weight: bold; text-align: center;"
                    data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Pr&eacute;noms&quot;}">Pr&eacute;noms</td>
                <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 2px 3px; vertical-align: bottom; background-color: rgb(180, 198, 231); font-size: 12pt; font-weight: bold; text-align: center;"
                    data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Qualit&eacute;&quot;}">Qualit&eacute;</td>
                <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 2px 3px; vertical-align: bottom; background-color: rgb(180, 198, 231); font-size: 12pt; font-weight: bold; overflow-wrap: break-word; text-align: center;"
                    data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Adresse (BP, ville, pays)&quot;}">Adresse (BP,
                    ville, pays)</td>
                <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 2px 3px; vertical-align: bottom; background-color: rgb(180, 198, 231); font-size: 12pt; font-weight: bold; overflow-wrap: break-word; text-align: center;"
                    data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Observation&quot;}">Fonction</td>
            </tr>
    HTML;

    $query = "SELECT * FROM membre_conseil_client WHERE id_client = $id_client";
    $statement = $db->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();

    foreach ($result as $row) {

        $contenu_document .= <<<HTML

                <tr style="height: 20px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); border-left: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 2px 3px; vertical-align: middle; background-color: rgb(255, 255, 255); font-size: 11pt; font-weight: bold; text-align: center;"
                        colspan="1" rowspan="3" data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Adjovi&quot;}">
                        <div style="max-height: 60px;">{$row['nom_membre_conseil_client']}</div>
                    </td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 2px 3px; vertical-align: middle; background-color: rgb(255, 255, 255); font-size: 11pt; font-weight: bold; text-align: center;"
                        colspan="1" rowspan="3" data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Arnaud&quot;}">
                        <div style="max-height: 60px;">{$row['prenom_membre_conseil_client']}</div>
                    </td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 2px 3px; vertical-align: middle; background-color: rgb(255, 255, 255); font-size: 11pt; font-weight: bold; text-align: center;"
                        colspan="1" rowspan="3" data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;respo&quot;}">
                        <div style="max-height: 60px;">{$row['qualite_membre_conseil_client']}</div>
                    </td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 2px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255); font-size: 11pt; font-weight: bold; overflow-wrap: break-word;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Tel :&quot;}">Tel : {$row['tel_membre_conseil_client']}</td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 2px 3px; vertical-align: middle; background-color: rgb(255, 255, 255); font-size: 11pt; font-weight: bold; text-align: center;"
                        colspan="1" rowspan="3">
                        <div style="max-height: 60px;">{$row['fonction_membre_conseil_client']}</div>
                    </td>
                </tr>
                <tr style="height: 20px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 2px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255); font-size: 11pt; font-weight: bold; overflow-wrap: break-word;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;mail:&quot;}">mail: {$row['mail_membre_conseil_client']}</td>
                </tr>
                <tr style="height: 20px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 2px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255); font-size: 11pt; font-weight: bold; overflow-wrap: break-word;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Adresse:&quot;}">Adresse: {$row['adresse_membre_conseil_client']}</td>
                </tr>

        HTML;   
        
    }

    $contenu_document .= <<<HTML

                <tr style="height: 20px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); border-left: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 2px 3px; vertical-align: middle; background-color: rgb(255, 255, 255); font-size: 11pt; font-weight: bold; text-align: center;"
                        colspan="1" rowspan="3">
                        <div style="max-height: 63px;">&nbsp;</div>
                    </td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 2px 3px; vertical-align: middle; background-color: rgb(255, 255, 255); font-size: 11pt; font-weight: bold; text-align: center;"
                        colspan="1" rowspan="3">
                        <div style="max-height: 63px;">&nbsp;</div>
                    </td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 2px 3px; vertical-align: middle; background-color: rgb(255, 255, 255); font-size: 11pt; font-weight: bold; text-align: center;"
                        colspan="1" rowspan="3">
                        <div style="max-height: 63px;">&nbsp;</div>
                    </td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 2px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255); font-size: 12pt; font-weight: bold; overflow-wrap: break-word;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Tel :&quot;}">Tel :</td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 2px 3px; vertical-align: middle; background-color: rgb(255, 255, 255); font-size: 11pt; font-weight: bold; text-align: center;"
                        colspan="1" rowspan="3">
                        <div style="max-height: 63px;">&nbsp;</div>
                    </td>
                </tr>
                <tr style="height: 22px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 2px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255); font-size: 12pt; font-weight: bold; overflow-wrap: break-word;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;mail:&quot;}">mail:</td>
                </tr>
                <tr style="height: 21px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 2px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255); font-size: 12pt; font-weight: bold; overflow-wrap: break-word;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Adresse:&quot;}">Adresse:</td>
                </tr>

                <tr style="height: 21px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); border-left: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 2px 3px; vertical-align: middle; background-color: rgb(255, 255, 255); font-size: 11pt; font-weight: bold; text-align: center;"
                        colspan="1" rowspan="3">
                        <div style="max-height: 63px;">&nbsp;</div>
                    </td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 2px 3px; vertical-align: middle; background-color: rgb(255, 255, 255); font-size: 11pt; font-weight: bold; text-align: center;"
                        colspan="1" rowspan="3">
                        <div style="max-height: 63px;">&nbsp;</div>
                    </td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 2px 3px; vertical-align: middle; background-color: rgb(255, 255, 255); font-size: 11pt; font-weight: bold; text-align: center;"
                        colspan="1" rowspan="3">
                        <div style="max-height: 63px;">&nbsp;</div>
                    </td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 2px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255); font-size: 12pt; font-weight: bold; overflow-wrap: break-word;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Tel :&quot;}">Tel :</td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 2px 3px; vertical-align: middle; background-color: rgb(255, 255, 255); font-size: 11pt; font-weight: bold; text-align: center;"
                        colspan="1" rowspan="3">
                        <div style="max-height: 63px;">&nbsp;</div>
                    </td>
                </tr>
                <tr style="height: 21px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 2px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255); font-size: 12pt; font-weight: bold; overflow-wrap: break-word;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;mail:&quot;}">mail:</td>
                </tr>
                <tr style="height: 21px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 2px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255); font-size: 12pt; font-weight: bold; overflow-wrap: break-word;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Adresse:&quot;}">Adresse:</td>
                </tr>
            </tbody>
        </table>
        <br><br><br>
    HTML;

    // Sous-doc 8-2
    $query = "SELECT * FROM utilisateur, collaborateur, assoc_client_collabo WHERE utilisateur.id_utilisateur = collaborateur.id_utilisateur 
    AND collaborateur.id_collaborateur = assoc_client_collabo.id_collaborateur AND statut_assoc_client_collabo = 'actif' 
    AND  role_assoc_client_collabo = 'cm' AND assoc_client_collabo.id_client = $id_client";
    $statement = $db->prepare($query);
    $statement->execute();
    $result = $statement->fetch();

    $collaborateur = $result['prenom_utilisateur'] . ' ' . $result['nom_utilisateur'];
    $role_assoc_client_collabo = $result['role_assoc_client_collabo'];
    if ($role_assoc_client_collabo == 'cm') {
        $role_assoc_client_collabo = 'Chef de Mission';
    } else {
        $role_assoc_client_collabo = 'Collaborateur';
    }
    $mail_collaborateur = $result['email_utilisateur'];
    $tel_collaborateur = $result['tel_utilisateur'];
    $adresse_boite_postale = '';
    $date_debut_assoc_client_collabo = si_funct1($result['date_debut_assoc_client_collabo'], date('d/m/Y', strtotime($result['date_debut_assoc_client_collabo'])), '');
    $date_fin_assoc_client_collabo = si_funct1($result['date_fin_assoc_client_collabo'], date('d/m/Y', strtotime($result['date_fin_assoc_client_collabo'])), '');

    $contenu_document .= <<<HTML
        <table dir="ltr"
            style="table-layout: fixed; font-size: 11pt; font-family: Calibri; width: 0px; border-collapse: collapse; border-style: none; width: 100%;"
            border="0" cellspacing="0" cellpadding="0">
            <colgroup>
                <col width="140">
                <col width="169">
                <col width="200">
                <col width="200">
                <col width="250">
            </colgroup>
            <tbody>
                <tr style="height: 21px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 14pt; font-weight: bold;"
                        colspan="5" rowspan="3"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Sous-doc N&deg;8-2: Autres informations sur le client&quot;}">
                        <div style="max-height: 63px;">Sous-doc N&deg;8-2: Autres informations sur le client</div>
                    </td>
                </tr>
                <tr style="height: 21px;"></tr>
                <tr style="height: 21px;"></tr>
                <tr style="height: 21px;">
                    <td style="border: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); border-left: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; overflow-wrap: break-word;"
                        colspan="2" rowspan="1"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Dur&eacute;e de vie de la soci&eacute;t&eacute; :&quot;}">
                        Dur&eacute;e de vie de la soci&eacute;t&eacute; :</td>
                    <td style="text-align: center; font-weight: bold; border: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; overflow-wrap: break-word;"
                        colspan="3" rowspan="1">$duree_vie_societe ans</td>
                </tr>
                <tr style="height: 21px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); border-left: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; overflow-wrap: break-word;"
                        colspan="2" rowspan="1"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Date de dissolution pr&eacute;visible :&quot;}">
                        Date de dissolution pr&eacute;visible :</td>
                    <td style="text-align: center; font-weight: bold; border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; overflow-wrap: break-word;"
                        colspan="3" rowspan="1">$date_dissolution</td>
                </tr>
                <tr style="height: 21px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); border-left: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; overflow-wrap: break-word;"
                        colspan="2" rowspan="1"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Capital Social : &quot;}">Capital Social :</td>
                    <td style="text-align: center; font-weight: bold; border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; overflow-wrap: break-word;"
                        colspan="3" rowspan="1">$capital_social</td>
                </tr>
                <tr style="height: 21px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); border-left: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; overflow-wrap: break-word;"
                        colspan="2" rowspan="1" data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Siege Social : &quot;}">
                        Siege Social :</td>
                    <td style="text-align: center; font-weight: bold; border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; overflow-wrap: break-word;"
                        colspan="3" rowspan="1">$siege_social</td>
                </tr>
                <tr style="height: 21px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); border-left: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; overflow-wrap: break-word;"
                        colspan="2" rowspan="1"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Site internet : &quot;}">Site internet :</td>
                    <td style="text-align: center; font-weight: bold; border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; overflow-wrap: break-word;"
                        colspan="3" rowspan="1">$site_internet</td>
                </tr>
                <tr style="height: 21px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); border-left: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; overflow-wrap: break-word;"
                        colspan="2" rowspan="1"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Nombre de salari&eacute;s : &quot;}">Nombre de
                        salari&eacute;s :</td>
                    <td style="text-align: center; font-weight: bold; border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; overflow-wrap: break-word;"
                        colspan="3" rowspan="1">$nombre_de_salarie</td>
                </tr>
                <tr style="height: 27px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); border-left: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; overflow-wrap: break-word;"
                        colspan="1" rowspan="3"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Chiffre d'Affaires des 3 derniers Exercices : &quot;}">
                        <div style="max-height: 69px;">Chiffre d'Affaires des 3 derniers Exercices :</div>
                    </td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;N-1&quot;}">N-1</td>
                    <td style="text-align: center; font-weight: bold; border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; overflow-wrap: break-word;"
                        colspan="3" rowspan="1">$ca_3_derniers_exercices_n_1</td>
                </tr>
                <tr style="height: 21px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;N-2&quot;}">N-2</td>
                    <td style="text-align: center; font-weight: bold; border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; overflow-wrap: break-word;"
                        colspan="3" rowspan="1">$ca_3_derniers_exercices_n_2</td>
                </tr>
                <tr style="height: 21px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;N-3&quot;}">N-3</td>
                    <td style="text-align: center; font-weight: bold; border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; overflow-wrap: break-word;"
                        colspan="3" rowspan="1">$ca_3_derniers_exercices_n_3</td>
                </tr>
                <tr style="height: 28px;">
                    <td style="border-width: 1px; border-style: solid; border-color: rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; font-weight: bold; overflow-wrap: break-word; text-align: center;"
                        colspan="5" rowspan="1"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;INFORMATIONS SUR LES INTERLOCUTEURS SUCCESSIFS DU CABINET AUPRES DU CLIENT&quot;}">
                        INFORMATIONS SUR LES INTERLOCUTEURS SUCCESSIFS DU CABINET AUPRES DU CLIENT</td>
                </tr>
                <tr style="height: 21px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); border-left: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; font-weight: bold; overflow-wrap: break-word; text-align: center;"
                        colspan="2" rowspan="1">&nbsp;</td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; font-weight: bold; overflow-wrap: break-word;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;1er Inter.&quot;}">1er Inter.</td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; font-weight: bold; overflow-wrap: break-word;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;2e Inter.&quot;}">2e Inter.</td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; font-weight: bold; overflow-wrap: break-word;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;3e Inter.&quot;}">3e Inter.</td>
                </tr>
                <tr style="height: 21px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); border-left: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; font-weight: bold; overflow-wrap: break-word;"
                        colspan="2" rowspan="1"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Nom Pr&eacute;noms :&quot;}">Nom Pr&eacute;noms
                        :</td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; font-weight: bold; overflow-wrap: break-word;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;M. GBEHINTO&quot;}">M. GBEHINTO</td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; font-weight: bold; overflow-wrap: break-word;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;M. Armand&quot;}">M. Armand</td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; font-weight: bold; overflow-wrap: break-word;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;M. S&eacute;v&eacute;rin&quot;}">$collaborateur</td>
                </tr>
                <tr style="height: 21px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); border-left: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; font-weight: bold; overflow-wrap: break-word;"
                        colspan="2" rowspan="1"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Fonction au sein de l'entreprise&quot;}">
                        Fonction au sein de l'entreprise</td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; font-weight: bold; overflow-wrap: break-word;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Associ&eacute;-G&eacute;rant&quot;}">
                        Associ&eacute;-G&eacute;rant</td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; font-weight: bold; overflow-wrap: break-word;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Responsable DEC&quot;}">Responsable DEC</td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; font-weight: bold; overflow-wrap: break-word;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Chef de mission&quot;}">$role_assoc_client_collabo</td>
                </tr>
                <tr style="height: 21px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); border-left: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; overflow-wrap: break-word;"
                        colspan="2" rowspan="1"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;T&eacute;l&eacute;phone : &quot;}">
                        T&eacute;l&eacute;phone :</td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; overflow-wrap: break-word;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;97 22 19 85&quot;}">97 22 19 85</td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; overflow-wrap: break-word;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;95 96 86 11&quot;}">95 96 86 11</td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; overflow-wrap: break-word;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;97 15 36 29 &quot;}">$tel_collaborateur</td>
                </tr>
                <tr style="height: 21px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); border-left: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; overflow-wrap: break-word;"
                        colspan="2" rowspan="1" data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Adresse mail : &quot;}">
                        Adresse mail :</td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 10pt; overflow-wrap: break-word;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;g_eustache@yahoo.fr&quot;}">g_eustache@yahoo.fr
                    </td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 10pt; overflow-wrap: break-word;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;mamavi.armand@elyonsas.com&quot;}">
                        mamavi.armand@elyonsas.com</td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 10pt; overflow-wrap: break-word;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;ssewade9@gmail.com&quot;}">$mail_collaborateur</td>
                </tr>
                <tr style="height: 21px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); border-left: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; overflow-wrap: break-word;"
                        colspan="2" rowspan="1"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Adresse boite postale :&quot;}">Adresse boite
                        postale :</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; overflow-wrap: break-word;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; overflow-wrap: break-word;">
                        &nbsp;</td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; overflow-wrap: break-word;">
                        $adresse_boite_postale</td>
                </tr>
                <tr style="height: 21px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); border-left: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; overflow-wrap: break-word;"
                        colspan="2" rowspan="1"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Date de prise d'interlocution&quot;}">Date de
                        prise d'interlocution</td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; overflow-wrap: break-word;"
                        data-sheets-numberformat="{&quot;1&quot;:5,&quot;2&quot;:&quot;dd/mm/yyyy&quot;,&quot;3&quot;:1}"
                        data-sheets-value="{&quot;1&quot;:3,&quot;3&quot;:44706}">$date_debut_assoc_client_collabo</td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; overflow-wrap: break-word;"
                        data-sheets-numberformat="{&quot;1&quot;:5,&quot;2&quot;:&quot;dd/mm/yyyy&quot;,&quot;3&quot;:1}"
                        data-sheets-value="{&quot;1&quot;:3,&quot;3&quot;:44706}">$date_debut_assoc_client_collabo</td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; overflow-wrap: break-word;"
                        data-sheets-numberformat="{&quot;1&quot;:5,&quot;2&quot;:&quot;dd/mm/yyyy&quot;,&quot;3&quot;:1}"
                        data-sheets-value="{&quot;1&quot;:3,&quot;3&quot;:44706}">$date_debut_assoc_client_collabo</td>
                </tr>
                <tr style="height: 21px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); border-left: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; overflow-wrap: break-word;"
                        colspan="2" rowspan="1"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Fin de prise d'interlocution :&quot;}">Fin de
                        prise d'interlocution :</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        $date_fin_assoc_client_collabo</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        $date_fin_assoc_client_collabo</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        $date_fin_assoc_client_collabo</td>
                </tr>
            </tbody>
        </table>
        <br><br><br><br><br>
    HTML;

    // Sous-doc 8-3
    $contenu_document .= <<<HTML
        <table dir="ltr"
            style="table-layout: fixed; font-size: 11pt; font-family: Calibri; width: 0px; border-collapse: collapse; border-style: none; width: 100%;"
            border="0" cellspacing="0" cellpadding="0">
            <colgroup>
                <col width="394">
                <col width="52">
                <col width="112">
                <col width="105">
                <col width="160">
            </colgroup>
            <tbody>
                <tr style="height: 21px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 14pt; font-weight: bold; text-align: left;"
                        colspan="5" rowspan="1"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Sous-doc N&deg;8-3: Autres informations au niveau du cabinet &amp; documents re&ccedil;us du client&quot;}">
                        Sous-doc N&deg;8-3: Autres informations au niveau du cabinet &amp; documents re&ccedil;us du client</td>
                </tr>
                <tr style="height: 21px;">
                    <td
                        style="border-bottom: 1px solid rgb(0, 0, 0); border-left: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 14pt; font-weight: bold; text-align: center;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 14pt; font-weight: bold; text-align: center;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 14pt; font-weight: bold; text-align: center;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 14pt; font-weight: bold; text-align: center;">
                        &nbsp;</td>
                    <td
                        style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 14pt; font-weight: bold; text-align: center;">
                        &nbsp;</td>
                </tr>
                
                <tr style="height: 21px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); border-left: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; overflow-wrap: break-word;"
                        colspan="2" rowspan="1"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Date ouverture du dossier du client :&quot;}">
                        Date ouverture du dossier du client :</td>
                    <td colspan="3" style="text-align: center; font-weight: bold; border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; overflow-wrap: break-word;">
                    $date_ouverture_dossier</td>
                </tr>
                <tr style="height: 21px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); border-left: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; overflow-wrap: break-word;"
                        colspan="2" rowspan="1"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Dossier h&eacute;rit&eacute; du confr&egrave;re :&quot;}">
                        Dossier h&eacute;rit&eacute; du confr&egrave;re :</td>
                    <td colspan="3" style="text-align: center; font-weight: bold; border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                    $dossier_herite_confrere</td>
                </tr>
                <tr style="height: 21px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); border-left: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; overflow-wrap: break-word;"
                        colspan="2" rowspan="1"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Nom du Cabinet du confr&egrave;re et de l'Expert :&quot;}">
                        Nom du Cabinet du confr&egrave;re et de l'Expert :</td>
                    <td colspan="3" style="text-align: center; font-weight: bold; border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                    $nom_cabinet_confrere</td>
                </tr>

                <tr style="height: 21px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); border-left: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; font-weight: bold; overflow-wrap: break-word; text-align: center;"
                        colspan="5" rowspan="1"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;INFORMATIONS SUR LES GESTIONNAIRES SUCCESSIFS DU CLIENT AU CABINET&quot;}">
                        INFORMATIONS SUR LES GESTIONNAIRES SUCCESSIFS DU CLIENT AU CABINET</td>
                </tr>
                <tr style="height: 21px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); border-left: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; font-weight: bold; overflow-wrap: break-word; text-align: center;"
                        colspan="2" rowspan="1">&nbsp;</td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; font-weight: bold; overflow-wrap: break-word;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;1er Gest.&quot;}">1er Gest.</td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; font-weight: bold; overflow-wrap: break-word;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;2e Gest.&quot;}">2e Gest.</td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; font-weight: bold; overflow-wrap: break-word;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;3e Gest.&quot;}">3e Gest.</td>
                </tr>
                <tr style="height: 21px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); border-left: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; font-weight: bold; overflow-wrap: break-word;"
                        colspan="2" rowspan="1"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Nom &amp; Pr&eacute;nom :&quot;}">Nom &amp;
                        Pr&eacute;nom :</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                </tr>
                <tr style="height: 21px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); border-left: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; font-weight: bold; overflow-wrap: break-word;"
                        colspan="2" rowspan="1"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Fonction au sein du cabinet&quot;}">Fonction au
                        sein du cabinet</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                </tr>
                <tr style="height: 21px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); border-left: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; overflow-wrap: break-word;"
                        colspan="2" rowspan="1"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;T&eacute;l&eacute;phone : &quot;}">
                        T&eacute;l&eacute;phone :</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                </tr>
                <tr style="height: 21px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); border-left: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; overflow-wrap: break-word;"
                        colspan="2" rowspan="1" data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Adresse mail : &quot;}">
                        Adresse mail :</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                </tr>
                <tr style="height: 21px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); border-left: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; overflow-wrap: break-word;"
                        colspan="2" rowspan="1"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Adresse boite postale :&quot;}">Adresse boite
                        postale :</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                </tr>
                <tr style="height: 21px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); border-left: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; overflow-wrap: break-word;"
                        colspan="2" rowspan="1"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Date de prise de service : &quot;}">Date de
                        prise de service :</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                </tr>
                <tr style="height: 21px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); border-left: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; overflow-wrap: break-word;"
                        colspan="2" rowspan="1"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Fin de prise de service :&quot;}">Fin de prise
                        de service :</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                </tr>
                <tr style="height: 18px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); border-left: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; font-weight: bold; overflow-wrap: break-word; text-align: center;"
                        colspan="2" rowspan="1" data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Documents&quot;}">
                        Documents</td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; font-weight: bold;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Re&ccedil;us&quot;}">Re&ccedil;us</td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; font-weight: bold;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Non re&ccedil;us&quot;}">Non re&ccedil;us</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 21px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); border-left: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: bottom; font-family: Arial; font-size: 12pt; overflow-wrap: break-word;"
                        colspan="2" rowspan="1"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Exemplaire de lettre de mission Agr&eacute;e&quot;}">
                        Exemplaire de lettre de mission Agr&eacute;e</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: bottom; font-family: Arial; font-size: 12pt; overflow-wrap: break-word;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 21px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); border-left: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: bottom; font-family: Arial; font-size: 12pt; overflow-wrap: break-word;"
                        colspan="2" rowspan="1"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Exemplaire d'avenant sign&eacute;e &agrave; la lettre de mission&quot;}">
                        Exemplaire d'avenant sign&eacute;e &agrave; la lettre de mission</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: bottom;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 17px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); border-left: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: bottom; font-family: Arial; font-size: 12pt; overflow-wrap: break-word;"
                        colspan="2" rowspan="1"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Exemplaire des statuts :&quot;}">Exemplaire des
                        statuts :</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: bottom;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 17px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); border-left: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: bottom; font-family: Arial; font-size: 12pt; overflow-wrap: break-word;"
                        colspan="2" rowspan="1"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Journal Officiel&quot;}">Journal Officiel</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: bottom;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 17px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); border-left: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: bottom; font-family: Arial; font-size: 12pt; overflow-wrap: break-word;"
                        colspan="2" rowspan="1"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Annonce L&eacute;gale &quot;}">Annonce
                        L&eacute;gale</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: bottom;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 21px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); border-left: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: bottom; font-family: Arial; font-size: 12pt; overflow-wrap: break-word;"
                        colspan="2" rowspan="1" data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Copie du RCCM&quot;}">
                        Copie du RCCM</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: bottom;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 21px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); border-left: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: bottom; font-family: Arial; font-size: 12pt; overflow-wrap: break-word;"
                        colspan="2" rowspan="1"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Copie de l'IFU de la Soci&eacute;t&eacute;&quot;}">
                        Copie de l'IFU de la Soci&eacute;t&eacute;</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 21px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); border-left: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: bottom; font-family: Arial; font-size: 12pt; overflow-wrap: break-word;"
                        colspan="2" rowspan="1"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Copies de l'IFU des Associ&eacute;s&quot;}">
                        Copies de l'IFU des Associ&eacute;s</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 21px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); border-left: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: bottom; font-family: Arial; font-size: 12pt; overflow-wrap: break-word;"
                        colspan="2" rowspan="1"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Copie de la CNSS&quot;}">Copie de la CNSS</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 21px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); border-left: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: bottom; font-family: Arial; font-size: 12pt; overflow-wrap: break-word;"
                        colspan="2" rowspan="1"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Copie de la carte importateur&quot;}">Copie de
                        la carte importateur</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 21px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); border-left: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: bottom; font-family: Arial; font-size: 12pt; overflow-wrap: break-word;"
                        colspan="2" rowspan="1"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Agr&eacute;&eacute;ment d'activit&eacute;s ou autorisation d'exercice&quot;}">
                        Agr&eacute;&eacute;ment d'activit&eacute;s ou autorisation d'exercice</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 21px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); border-left: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: bottom; font-family: Arial; font-size: 12pt; overflow-wrap: break-word;"
                        colspan="2" rowspan="1"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Pi&egrave;ces d'Identit&eacute;s des dirigeants&quot;}">
                        Pi&egrave;ces d'Identit&eacute;s des dirigeants</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 21px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); border-left: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: bottom; font-family: Arial; font-size: 12pt; overflow-wrap: break-word;"
                        colspan="2" rowspan="1"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Papier ent&ecirc;te &eacute;lectronique&quot;}">
                        Papier ent&ecirc;te &eacute;lectronique</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 21px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); border-left: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: bottom; font-family: Arial; font-size: 12pt; overflow-wrap: break-word;"
                        colspan="2" rowspan="1"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Autres (Procuration ou pourvoir, RIB, etc. )&quot;}">
                        Autres (Procuration ou pourvoir, RIB, etc. )</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 21px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); border-left: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: bottom; font-family: Arial; font-size: 12pt; overflow-wrap: break-word;"
                        colspan="2" rowspan="1"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Copie de la derni&egrave;re attestation fiscale&quot;}">
                        Copie de la derni&egrave;re attestation fiscale</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 21px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); border-left: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: bottom; font-family: Arial; font-size: 12pt; overflow-wrap: break-word;"
                        colspan="2" rowspan="1"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;Copie de la derni&egrave;re attestation CNSS&quot;}">
                        Copie de la derni&egrave;re attestation CNSS</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 21px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); border-left: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; overflow-wrap: break-word;"
                        colspan="1" rowspan="4"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot; Copie des &eacute;tats financiers des 3 derni&egrave;res ann&eacute;es :&quot;}">
                        <div style="max-height: 84px;">Copie des &eacute;tats financiers des 3 derni&egrave;res ann&eacute;es :
                        </div>
                    </td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;"
                        colspan="1" rowspan="2" data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;N-1&quot;}">
                        <div style="max-height: 42px;">N-1</div>
                    </td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        colspan="1" rowspan="2">
                        <div style="max-height: 42px;">&nbsp;</div>
                    </td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;"
                        colspan="1" rowspan="2">
                        <div style="max-height: 42px;">&nbsp;</div>
                    </td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 21px;">
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 21px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;N-2&quot;}">N-2</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 21px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;N-3&quot;}">N-3</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 21px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); border-left: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; overflow-wrap: break-word;"
                        colspan="1" rowspan="3"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot; Copie des Balances des 3 derni&egrave;res ann&eacute;es :&quot;}">
                        <div style="max-height: 63px;">Copie des Balances des 3 derni&egrave;res ann&eacute;es :</div>
                    </td>
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;N-1&quot;}">N-1</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 21px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;N-2&quot;}">N-2</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
                <tr style="height: 21px;">
                    <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;"
                        data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;N-3&quot;}">N-3</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
            </tbody>
        </table>
    HTML;

    $update1 = update(
        'doc_8_fiche_id_client',
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

function update_contenu_document_table_doc_3_accept_mission($id_document, PDO $db)
{
    $query = "SELECT * FROM document WHERE id_document = $id_document";
    $statement = $db->prepare($query);
    $statement->execute();
    $result = $statement->fetch();

    $id_client = $result['id_client'];
    $table_document = $result['table_document'];

    $query = "SELECT * FROM document, $table_document WHERE document.id_document = $table_document.id_document AND $table_document.id_document = $id_document";
    $statement = $db->prepare($query);
    $statement->execute();
    $result = $statement->fetch();

    $quiz1 = $result['quiz1'];
    if ($quiz1 == 'oui') {
        $quiz1_oui = 'X';
        $quiz1_non = '';
    } else if($quiz1 == 'non') {
        $quiz1_oui = '';
        $quiz1_non = 'X';
    } else {
        $quiz1_oui = '';
        $quiz1_non = '';
    }
    $observ1 = $result['observ1'];
    $quiz2 = $result['quiz2'];
    if ($quiz2 == 'e') {
        $quiz2_e = 'X';
        $quiz2_m = '';
        $quiz2_f = '';
    } else if($quiz2 == 'm') {
        $quiz2_e = '';
        $quiz2_m = 'X';
        $quiz2_f = '';
    } else if($quiz2 == 'f') {
        $quiz2_e = '';
        $quiz2_m = '';
        $quiz2_f = 'X';
    } else {
        $quiz2_e = '';
        $quiz2_m = '';
        $quiz2_f = '';
    }
    $quiz3 = $result['quiz3'];
    if ($quiz3 == 'e') {
        $quiz3_e = 'X';
        $quiz3_m = '';
        $quiz3_f = '';
    } else if($quiz3 == 'm') {
        $quiz3_e = '';
        $quiz3_m = 'X';
        $quiz3_f = '';
    } else if($quiz3 == 'f') {
        $quiz3_e = '';
        $quiz3_m = '';
        $quiz3_f = 'X';
    } else {
        $quiz3_e = '';
        $quiz3_m = '';
        $quiz3_f = '';
    }
    $quiz4 = $result['quiz4'];
    if ($quiz4 == 'e') {
        $quiz4_e = 'X';
        $quiz4_m = '';
        $quiz4_f = '';
    } else if($quiz4 == 'm') {
        $quiz4_e = '';
        $quiz4_m = 'X';
        $quiz4_f = '';
    } else if($quiz4 == 'f') {
        $quiz4_e = '';
        $quiz4_m = '';
        $quiz4_f = 'X';
    } else {
        $quiz4_e = '';
        $quiz4_m = '';
        $quiz4_f = '';
    }
    $quiz5 = $result['quiz5'];
    if ($quiz5 == 'e') {
        $quiz5_e = 'X';
        $quiz5_m = '';
        $quiz5_f = '';
    } else if($quiz5 == 'm') {
        $quiz5_e = '';
        $quiz5_m = 'X';
        $quiz5_f = '';
    } else if($quiz5 == 'f') {
        $quiz5_e = '';
        $quiz5_m = '';
        $quiz5_f = 'X';
    } else {
        $quiz5_e = '';
        $quiz5_m = '';
        $quiz5_f = '';
    }
    $quiz6 = $result['quiz6'];
    if ($quiz6 == 'e') {
        $quiz6_e = 'X';
        $quiz6_m = '';
        $quiz6_f = '';
    } else if($quiz6 == 'm') {
        $quiz6_e = '';
        $quiz6_m = 'X';
        $quiz6_f = '';
    } else if($quiz6 == 'f') {
        $quiz6_e = '';
        $quiz6_m = '';
        $quiz6_f = 'X';
    } else {
        $quiz6_e = '';
        $quiz6_m = '';
        $quiz6_f = '';
    }
    $quiz7 = $result['quiz7'];
    if ($quiz7 == 'e') {
        $quiz7_e = 'X';
        $quiz7_m = '';
        $quiz7_f = '';
    } else if($quiz7 == 'm') {
        $quiz7_e = '';
        $quiz7_m = 'X';
        $quiz7_f = '';
    } else if($quiz7 == 'f') {
        $quiz7_e = '';
        $quiz7_m = '';
        $quiz7_f = 'X';
    } else {
        $quiz7_e = '';
        $quiz7_m = '';
        $quiz7_f = '';
    }
    $quiz8 = $result['quiz8'];
    if ($quiz8 == 'e') {
        $quiz8_e = 'X';
        $quiz8_m = '';
        $quiz8_f = '';
    } else if($quiz8 == 'm') {
        $quiz8_e = '';
        $quiz8_m = 'X';
        $quiz8_f = '';
    } else if($quiz8 == 'f') {
        $quiz8_e = '';
        $quiz8_m = '';
        $quiz8_f = 'X';
    } else {
        $quiz8_e = '';
        $quiz8_m = '';
        $quiz8_f = '';
    }
    $quiz9 = $result['quiz9'];
    if ($quiz9 == 'e') {
        $quiz9_e = 'X';
        $quiz9_m = '';
        $quiz9_f = '';
    } else if($quiz9 == 'm') {
        $quiz9_e = '';
        $quiz9_m = 'X';
        $quiz9_f = '';
    } else if($quiz9 == 'f') {
        $quiz9_e = '';
        $quiz9_m = '';
        $quiz9_f = 'X';
    } else {
        $quiz9_e = '';
        $quiz9_m = '';
        $quiz9_f = '';
    }
    $quiz10 = $result['quiz10'];
    if ($quiz10 == 'oui') {
        $quiz10_oui = 'X';
        $quiz10_non = '';
    } else if($quiz10 == 'non') {
        $quiz10_oui = '';
        $quiz10_non = 'X';
    } else {
        $quiz10_oui = '';
        $quiz10_non = '';
    }
    $observ10 = $result['observ10'];
    $quiz11 = $result['quiz11'];
    if ($quiz11 == 'oui') {
        $quiz11_oui = 'X';
        $quiz11_non = '';
    } else if($quiz11 == 'non') {
        $quiz11_oui = '';
        $quiz11_non = 'X';
    } else {
        $quiz11_oui = '';
        $quiz11_non = '';
    }
    $observ11 = $result['observ11'];
    $quiz12 = $result['quiz12'];
    if ($quiz12 == 'oui') {
        $quiz12_oui = 'X';
        $quiz12_non = '';
    } else if($quiz12 == 'non') {
        $quiz12_oui = '';
        $quiz12_non = 'X';
    } else {
        $quiz12_oui = '';
        $quiz12_non = '';
    }
    $observ12 = $result['observ12'];
    $quiz13 = $result['quiz13'];
    if ($quiz13 == 'oui') {
        $quiz13_oui = 'X';
        $quiz13_non = '';
    } else if($quiz13 == 'non') {
        $quiz13_oui = '';
        $quiz13_non = 'X';
    } else {
        $quiz13_oui = '';
        $quiz13_non = '';
    }
    $observ13 = $result['observ13'];
    $quiz14 = $result['quiz14'];
    if ($quiz14 == 'oui') {
        $quiz14_oui = 'X';
        $quiz14_non = '';
    } else if($quiz14 == 'non') {
        $quiz14_oui = '';
        $quiz14_non = 'X';
    } else {
        $quiz14_oui = '';
        $quiz14_non = '';
    }
    $observ14 = $result['observ14'];
    $quiz15 = $result['quiz15'];
    if ($quiz15 == 'oui') {
        $quiz15_oui = 'X';
        $quiz15_non = '';
    } else if($quiz15 == 'non') {
        $quiz15_oui = '';
        $quiz15_non = 'X';
    } else {
        $quiz15_oui = '';
        $quiz15_non = '';
    }
    $observ15 = $result['observ15'];
    $quiz16 = $result['quiz16'];
    if ($quiz16 == 'oui') {
        $quiz16_oui = 'X';
        $quiz16_non = '';
    } else if($quiz16 == 'non') {
        $quiz16_oui = '';
        $quiz16_non = 'X';
    } else {
        $quiz16_oui = '';
        $quiz16_non = '';
    }
    $observ16 = $result['observ16'];
    $quiz17 = $result['quiz17'];
    if ($quiz17 == 'oui') {
        $quiz17_oui = 'X';
        $quiz17_non = '';
    } else if($quiz17 == 'non') {
        $quiz17_oui = '';
        $quiz17_non = 'X';
    } else {
        $quiz17_oui = '';
        $quiz17_non = '';
    }
    $observ17 = $result['observ17'];
    $quiz18 = $result['quiz18'];
    if ($quiz18 == 'oui') {
        $quiz18_oui = 'X';
        $quiz18_non = '';
    } else if($quiz18 == 'non') {
        $quiz18_oui = '';
        $quiz18_non = 'X';
    } else {
        $quiz18_oui = '';
        $quiz18_non = '';
    }
    $observ18 = $result['observ18'];
    $quiz19 = $result['quiz19'];
    if ($quiz19 == 'oui') {
        $quiz19_oui = 'X';
        $quiz19_non = '';
    } else if($quiz19 == 'non') {
        $quiz19_oui = '';
        $quiz19_non = 'X';
    } else {
        $quiz19_oui = '';
        $quiz19_non = '';
    }
    $observ19 = $result['observ19'];
    $quiz20 = $result['quiz20'];
    if ($quiz20 == 'oui') {
        $quiz20_oui = 'X';
        $quiz20_non = '';
    } else if($quiz20 == 'non') {
        $quiz20_oui = '';
        $quiz20_non = 'X';
    } else {
        $quiz20_oui = '';
        $quiz20_non = '';
    }
    $observ20 = $result['observ20'];
    $accept_mission = $result['accept_mission'];
    if ($accept_mission == 'oui') {
        $accept_mission_oui = 'X';
        $accept_mission_non = '';
    } else if($accept_mission == 'non') {
        $accept_mission_oui = '';
        $accept_mission_non = 'X';
    } else {
        $accept_mission_oui = '';
        $accept_mission_non = '';
    }
    $signature_responsable = $result['signature_responsable'];
    $observation = $result['observation'];

    $contenu_document = <<<HTML
        <table dir="ltr" style="table-layout: fixed; font-size: 11pt; font-family: Calibri; width: 0px; margin: auto;" cellspacing="0"
            cellpadding="0">
            <colgroup>
                <col width="18">
                <col width="423">
                <col width="5">
                <col width="32">
                <col width="18">
                <col width="34">
                <col width="5">
                <col width="25">
                <col width="18">
                <col width="25">
                <col width="5">
                <col width="25">
                <col width="18">
                <col width="26">
                <col width="5">
                <col width="6">
                <col width="25">
                <col width="6">
                <col width="89">
                <col width="18">
            </colgroup>
            <tbody>
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
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
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
                    <td style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; border-left: 1px solid transparent; overflow: visible; padding: 0px; vertical-align: bottom; background-color: rgb(255, 255, 255); font-family: 'Times New Roman'; font-size: 12pt; font-weight: bold; text-decoration-line: underline; color: rgb(255, 0, 0);"
                        >
                        <div style="white-space: nowrap; overflow: hidden; position: relative; width: 437px; left: 3px;">
                            <div style="float: left;">Objectifs du DOC N&deg;3</div>
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
                    <td style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; border-left: 1px solid transparent; overflow: visible; padding: 0px; vertical-align: bottom; background-color: rgb(255, 255, 255); font-family: 'Times New Roman'; font-size: 12pt; font-weight: bold; text-decoration-line: underline; color: rgb(255, 0, 0);"
                        >
                        <div style="white-space: nowrap; overflow: hidden; position: relative; width: 437px; left: 3px;">
                            <div style="float: left;">Organisation et utilisation du fichier</div>
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
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
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
                    <td style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; border-left: 1px solid transparent; overflow: visible; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255);"
                        >
                        <div style="white-space: nowrap; overflow: hidden; position: relative; width: 685px; left: 3px;">
                            <div style="float: left;">Les questions &agrave; se poser (conf&egrave;re ci-dessous) avant
                                d'accepter ou de se maintenir sur une mission du DEC.</div>
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
                        style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: bottom;">
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
                        style="font-weight: bold; text-align: center; font-size: 15px; border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        $quiz1_oui</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="font-weight: bold; text-align: center; font-size: 15px; border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        $quiz1_non</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="font-size: 11px; border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        colspan="12" rowspan="1">$observ1</td>
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
                        style="font-weight: bold; text-align: center; font-size: 15px; border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        $quiz2_e</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        >E</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="font-weight: bold; text-align: center; font-size: 15px; border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        $quiz2_m</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        >M</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="font-weight: bold; text-align: center; font-size: 15px; border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        $quiz2_f</td>
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
                        style="font-weight: bold; text-align: center; font-size: 15px; border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        $quiz3_e</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        >E</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="font-weight: bold; text-align: center; font-size: 15px; border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        $quiz3_m</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        >M</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="font-weight: bold; text-align: center; font-size: 15px; border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        $quiz3_f</td>
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
                        style="font-weight: bold; text-align: center; font-size: 15px; border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        $quiz4_e</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        >E</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="font-weight: bold; text-align: center; font-size: 15px; border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        $quiz4_m</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        >M</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="font-weight: bold; text-align: center; font-size: 15px; border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        $quiz4_f</td>
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
                        style="font-weight: bold; text-align: center; font-size: 15px; border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        $quiz5_e</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        >E</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="font-weight: bold; text-align: center; font-size: 15px; border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        $quiz5_m</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        >M</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="font-weight: bold; text-align: center; font-size: 15px; border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        $quiz5_f</td>
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
                        style="font-weight: bold; text-align: center; font-size: 15px; border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        $quiz6_e</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        >E</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="font-weight: bold; text-align: center; font-size: 15px; border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        $quiz6_m</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        >M</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="font-weight: bold; text-align: center; font-size: 15px; border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        $quiz6_f</td>
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
                        style="font-weight: bold; text-align: center; font-size: 15px; border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        $quiz7_e</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        >E</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="font-weight: bold; text-align: center; font-size: 15px; border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        $quiz7_m</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        >M</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="font-weight: bold; text-align: center; font-size: 15px; border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        $quiz7_f</td>
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
                        style="font-weight: bold; text-align: center; font-size: 15px; border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        $quiz8_e</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        >E</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="font-weight: bold; text-align: center; font-size: 15px; border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        $quiz8_m</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        >M</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="font-weight: bold; text-align: center; font-size: 15px; border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        $quiz8_f</td>
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
                        style="font-weight: bold; text-align: center; font-size: 15px; border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        $quiz9_e</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        >E</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="font-weight: bold; text-align: center; font-size: 15px; border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        $quiz9_m</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        >M</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="font-weight: bold; text-align: center; font-size: 15px; border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        $quiz9_f</td>
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
                        style="font-weight: bold; text-align: center; font-size: 15px; border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        $quiz10_oui</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="font-weight: bold; text-align: center; font-size: 15px; border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        $quiz10_non</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="font-size: 11px; border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        colspan="12" rowspan="1">$observ10</td>
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
                        style="font-weight: bold; text-align: center; font-size: 15px; border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        $quiz11_oui</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="font-weight: bold; text-align: center; font-size: 15px; border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        $quiz11_non</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="font-size: 11px; border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        colspan="12" rowspan="1">$observ11</td>
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
                        style="font-weight: bold; text-align: center; font-size: 15px; border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        $quiz12_oui</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="font-weight: bold; text-align: center; font-size: 15px; border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        $quiz12_non</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="font-size: 11px; border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        colspan="12" rowspan="1">$observ12</td>
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
                        style="font-weight: bold; text-align: center; font-size: 15px; border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        $quiz13_oui</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="font-weight: bold; text-align: center; font-size: 15px; border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        $quiz13_non</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="font-size: 11px; border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        colspan="12" rowspan="1">$observ13</td>
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
                        style="font-weight: bold; text-align: center; font-size: 15px; border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        $quiz14_oui</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="font-weight: bold; text-align: center; font-size: 15px; border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        $quiz14_non</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="font-size: 11px; border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        colspan="12" rowspan="1">$observ14</td>
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
                        style="font-weight: bold; text-align: center; font-size: 15px; border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        $quiz15_oui</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="font-weight: bold; text-align: center; font-size: 15px; border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        $quiz15_non</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="font-size: 11px; border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        colspan="12" rowspan="1">$observ15</td>
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
                        style="font-weight: bold; text-align: center; font-size: 15px; border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        $quiz16_oui</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="font-weight: bold; text-align: center; font-size: 15px; border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        $quiz16_non</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="font-size: 11px; border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        colspan="12" rowspan="1">$observ16</td>
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
                        style="font-weight: bold; text-align: center; font-size: 15px; border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        $quiz17_oui</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="font-weight: bold; text-align: center; font-size: 15px; border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        $quiz17_non</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="font-size: 11px; border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        colspan="12" rowspan="1">$observ17</td>
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
                        style="font-weight: bold; text-align: center; font-size: 15px; border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        $quiz18_oui</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="font-weight: bold; text-align: center; font-size: 15px; border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        $quiz18_non</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="font-size: 11px; border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        colspan="12" rowspan="1">$observ18</td>
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
                        style="font-weight: bold; text-align: center; font-size: 15px; border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        $quiz19_oui</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="font-weight: bold; text-align: center; font-size: 15px; border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        $quiz19_non</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="font-size: 11px; border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        colspan="12" rowspan="1">$observ19</td>
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
                        style="font-weight: bold; text-align: center; font-size: 15px; border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        $quiz20_oui</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="font-weight: bold; text-align: center; font-size: 15px; border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        $quiz20_non</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="font-size: 11px; border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                        colspan="12" rowspan="1">$observ20</td>
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
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: 'Times New Roman'; text-align: right;"
                        >
                        Nous d&eacute;cidons d&rsquo;accepter la mission de pr&eacute;sentation</td>
                    <td
                        style="border-right: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        &nbsp;</td>
                    <td
                        style="font-weight: bold; text-align: center; font-size: 15px; border-top: 1px dotted rgb(0, 0, 0); border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        $accept_mission_oui</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
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
                        style="font-weight: bold; text-align: center; font-size: 15px; border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                        $accept_mission_non</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
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
                        <div style="max-height: 38px;">$signature_responsable</div>
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
                    <td style="font-size: 11px; border-right: 1px dotted rgb(0, 0, 0); border-bottom: 1px dotted rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: top;"
                        colspan="18" rowspan="1">$observation</td>
                    <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                </tr>
            </tbody>
        </table>
    HTML;

    $update1 = update(
        'doc_3_accept_mission',
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
