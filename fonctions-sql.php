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
        </table><br><br>
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
        <br><br><br><br><br><br><br><br><br>
        <br><br><br><br><br><br><br><br><br>
        <br><br><br><br><br><br><br><br><br>
        <br><br><br><br><br><br><br><br><br>
        <br><br><br><br>
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
        <br><br><br><br><br><br>
        <br><br><br><br><br><br>
        <br><br><br><br><br><br>
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
