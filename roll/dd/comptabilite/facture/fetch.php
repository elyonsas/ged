<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/vendor/autoload.php');

require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions-sql.php');

use Ramsey\Uuid\Uuid;

connected('dd');

$output = '';

if (isset($_POST['datatable'])) {

    if ($_POST['datatable'] == 'all_factures') {

        $output = array();

        // Vérification de relance client
        $query = "SELECT * FROM facture WHERE statut_facture <> 'en attente' AND statut_facture <> 'supprime'";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();

        foreach ($result as $row) {
            if ($row['statut_facture'] == 'en cour' && $row['date_echeance_facture'] < date('Y-m-d H:i:s')) {
                $id_facture = $row['id_facture'];

                $update = update(
                    'facture',
                    [
                        'statut_facture' => 'relance',
                    ],
                    "id_facture = '$id_facture'",
                    $db
                );
            }

            if ($row['statut_facture'] == 'relance' && $row['date_echeance_facture'] > date('Y-m-d H:i:s')) {
                $id_facture = $row['id_facture'];

                $update = update(
                    'facture',
                    [
                        'statut_facture' => 'en cour',
                    ],
                    "id_facture = '$id_facture'",
                    $db
                );
            }
        }

        // Récupération des factures
        if ($_POST['query'] != '') {
            $query = $_POST['query'];
        } else {
            $query = "SELECT * FROM utilisateur, compte, client, facture WHERE utilisateur.id_utilisateur = compte.id_utilisateur 
            AND utilisateur.id_utilisateur = client.id_utilisateur AND facture.id_client = client.id_client AND statut_facture <> 'supprime' ORDER BY updated_at_facture DESC";
        }
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();

        $data = array();
        foreach ($result as $row) {

            $sub_array = array();

            $id_client = $row['id_client'];
            $id_facture = $row['id_facture'];
            $nom_client = $row['nom_utilisateur'];
            $n_facture = $row['n_facture'];
            $date_emission_facture = si_funct1($row['date_emission_facture'], date('d/m/Y', strtotime($row['date_emission_facture'])), '--');
            $echeance_facture = $row['echeance_facture'];
            $date_echeance_facture = date('d/m/Y', strtotime($row['date_echeance_facture']));
            $montant_ht_facture = format_am($row['montant_ht_facture']);
            $tva_facture = format_am($row['tva_facture']);
            $montant_ttc_facture = format_am($row['montant_ttc_facture']);
            $montant_regle_facture = format_am($row['montant_regle_facture']);
            $solde_facture = format_am($row['solde_facture']);
            $statut_facture = $row['statut_facture'];
            $created_at_facture = date('d/m/Y', strtotime($row['created_at_facture']));
            $updated_at_facture = date('d/m/Y', strtotime($row['updated_at_facture']));


            $statut_facture = $row['statut_facture'];
            switch ($statut_facture) {
                case 'en attente':
                    $statut_facture_html = <<<HTML
                        <span class="badge badge-light-dark">En attente</span>
                    HTML;
                    break;
                case 'en cour':
                    $statut_facture_html = <<<HTML
                        <span class="badge badge-light-primary">En cours</span>
                    HTML;
                    break;
                case 'paye':
                    $statut_facture_html = <<<HTML
                        <span class="badge badge-light-success">Payé</span>
                    HTML;
                    break;

                case 'relance':
                    $statut_facture_html = <<<HTML
                        <span class="badge badge-light-danger">Relance</span>
                    HTML;
                    break;
            }

            // N° facture
            $sub_array[] = <<<HTML
                <div class="d-flex flex-column justify-content-center">
                    <a href="roll/dd/view_redirect/?action=view_facture&id_view_facture={$id_facture}" class="fs-6 text-gray-800 text-hover-primary">$n_facture</a>
                </div>
            HTML;

            // Date de création
            $sub_array[] = <<<HTML
                <div style="font-size: 11px;">$created_at_facture</div>
            HTML;

            // Date d'émission
            // $sub_array[] = <<<HTML
            //     <div style="font-size: 11px;">$date_emission_facture</div>
            // HTML;

            // Client
            $sub_array[] = <<<HTML
                <div style="font-size: 11px;">$nom_client</div>
            HTML;

            // Echéance
            $sub_array[] = <<<HTML
                <div style="font-size: 11px;">$echeance_facture jours</div>
            HTML;

            // Date d'échéance
            // $sub_array[] = <<<HTML
            //     <div style="font-size: 11px;">$date_echeance_facture</div>
            // HTML;

            // Montant HT
            // $sub_array[] = <<<HTML
            //     <div style="font-size: 11px;">$montant_ht_facture</div>
            // HTML;

            // TVA
            // $sub_array[] = <<<HTML
            //     <div style="font-size: 11px;">$tva_facture</div>
            // HTML;

            // Montant TTC
            $sub_array[] = <<<HTML
                <div style="font-size: 11px;">$montant_ttc_facture</div>
            HTML;

            // Montant réglé
            $sub_array[] = <<<HTML
                <div style="font-size: 11px;">$montant_regle_facture</div>
            HTML;

            // Solde
            // $sub_array[] = <<<HTML
            //     <div style="font-size: 11px;">$solde_facture</div>
            // HTML;

            // Statut
            $sub_array[] = <<<HTML
               $statut_facture_html
            HTML;


            // Action
            switch ($statut_facture) {
                case 'en attente':
                    $action = <<<HTML

                        <td>
                            <div class="d-flex justify-content-end flex-shrink-0">                            
                                <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <i class="bi bi-three-dots fs-3"></i>
                                </button>
                                <!--begin::Menu 3-->
                                <div class="drop_action menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="" class="view_detail_facture menu-link px-3" data-bs-toggle="modal" data-bs-target="#detail_facture_modal" data-id_facture="{$id_facture}">Détails</a>
                                    </div>
                                    <!--end::Menu item-->

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="" class="emettre_facture menu-link px-3" data-id_facture="{$id_facture}">Émettre la facture</a>
                                    </div>
                                    <!--end::Menu item-->

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="" class="modifier_facture menu-link px-3" data-bs-toggle="modal" data-bs-target="#modifier_facture_modal" data-id_facture="{$id_facture}">Modifier facture</a>
                                    </div>
                                    <!--end::Menu item-->

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="" class="supprimer_facture text-hover-danger menu-link px-3" data-id_facture="{$id_facture}">Supprimer la facture</a>
                                    </div>
                                    <!--end::Menu item-->
                                </div>
                                <!--end::Menu 3-->
                            </div>
                        </td>

                    HTML;
                    break;
                case 'en cour':
                    $action = <<<HTML

                        <td>
                            <div class="d-flex justify-content-end flex-shrink-0">                            
                                <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <i class="bi bi-three-dots fs-3"></i>
                                </button>
                                <!--begin::Menu 3-->
                                <div class="drop_action menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="" class="view_detail_facture menu-link px-3" data-bs-toggle="modal" data-bs-target="#detail_facture_modal" data-id_facture="{$id_facture}">Détails</a>
                                    </div>
                                    <!--end::Menu item-->

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="" class="modifier_facture menu-link px-3" data-bs-toggle="modal" data-bs-target="#modifier_facture_modal" data-id_facture="{$id_facture}">Modifier facture</a>
                                    </div>
                                    <!--end::Menu item-->

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="" class="encaisser_facture menu-link px-3" data-bs-toggle="modal" data-bs-target="#encaisser_facture_modal" data-id_facture="{$id_facture}">Encaisser facture</a>
                                    </div>
                                    <!--end::Menu item-->

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="" class="supprimer_facture text-hover-danger menu-link px-3" data-id_facture="{$id_facture}">Supprimer la facture</a>
                                    </div>
                                    <!--end::Menu item-->
                                </div>
                                <!--end::Menu 3-->
                            </div>
                        </td>

                    HTML;
                    break;
                case 'paye':
                    $action = <<<HTML

                        <td>
                            <div class="d-flex justify-content-end flex-shrink-0">
                                <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <i class="bi bi-three-dots fs-3"></i>
                                </button>
                                <!--begin::Menu 3-->
                                <div class="drop_action menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="" class="view_detail_facture menu-link px-3" data-bs-toggle="modal" data-bs-target="#detail_facture_modal" data-id_facture="{$id_facture}">Détails</a>
                                    </div>
                                    <!--end::Menu item-->

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="" class="supprimer_facture text-hover-danger menu-link px-3" data-id_facture="{$id_facture}">Supprimer la facture</a>
                                    </div>
                                    <!--end::Menu item-->
                                </div>
                                <!--end::Menu 3-->
                            </div>
                        </td>

                    HTML;
                    break;
                case 'relance':
                    $action = <<<HTML

                        <td>
                            <div class="d-flex justify-content-end flex-shrink-0">
                                <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <i class="bi bi-three-dots fs-3"></i>
                                </button>
                                <!--begin::Menu 3-->
                                <div class="drop_action menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="" class="view_detail_facture menu-link px-3" data-bs-toggle="modal" data-bs-target="#detail_facture_modal" data-id_facture="{$id_facture}">Détails</a>
                                    </div>
                                    <!--end::Menu item-->

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="" class="modifier_facture menu-link px-3" data-bs-toggle="modal" data-bs-target="#modifier_facture_modal" data-id_facture="{$id_facture}">Modifier facture</a>
                                    </div>
                                    <!--end::Menu item-->

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="" class="encaisser_facture menu-link px-3" data-bs-toggle="modal" data-bs-target="#encaisser_facture_modal" data-id_facture="{$id_facture}">Encaisser facture</a>
                                    </div>
                                    <!--end::Menu item-->

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="" class="supprimer_facture text-hover-danger menu-link px-3" data-id_facture="{$id_facture}">Supprimer la facture</a>
                                    </div>
                                    <!--end::Menu item-->
                                </div>
                                <!--end::Menu 3-->
                            </div>
                        </td>

                    HTML;
                    break;
            }

            $sub_array[] = $action;

            $data[] = $sub_array;
        }

        $output = array(
            "data" => $data
        );
    }
}

if (isset($_POST['action'])) {

    // espace datatables

    if ($_POST['action'] == 'add_facture') {

        $n_facture = '';
        $type_facture = $_POST['type_facture'];
        $objet_facture = $_POST['objet_facture'];
        $date_emission_facture = date('Y-m-d H:i:s');
        $echeance_facture = $_POST['echeance_facture'];
        $date_echeance_facture = date('Y-m-d H:i:s', strtotime($date_emission_facture . " + $echeance_facture days"));
        $montant_ht_facture = $_POST['montant_ht_facture'];
        $tva_facture = $_POST['tva_facture'];
        $montant_ttc_facture = $_POST['montant_ttc_facture'];
        $montant_regle_facture = 0;
        $solde_facture = $_POST['montant_ttc_facture'];
        $statut_facture = 'en attente';
        $created_at_facture = date('Y-m-d H:i:s');
        $updated_at_facture = date('Y-m-d H:i:s');
        $created_by_facture = $_SESSION['id_utilisateur'];
        $updated_by_facture = $_SESSION['id_utilisateur'];
        $id_client = $_POST['id_client'];

        $insert = insert(
            'facture',
            [
                'type_facture' => $type_facture,
                'objet_facture' => $objet_facture,
                'date_emission_facture' => $date_emission_facture,
                'echeance_facture' => $echeance_facture,
                'date_echeance_facture' => $date_echeance_facture,
                'montant_ht_facture' => $montant_ht_facture,
                'tva_facture' => $tva_facture,
                'montant_ttc_facture' => $montant_ttc_facture,
                'montant_regle_facture' => $montant_regle_facture,
                'solde_facture' => $solde_facture,
                'statut_facture' => $statut_facture,
                'created_at_facture' => $created_at_facture,
                'updated_at_facture' => $updated_at_facture,
                'created_by_facture' => $created_by_facture,
                'updated_by_facture' => $updated_by_facture,
                'id_client' => $id_client
            ],
            $db
        );

        $id = $db->lastInsertId();
        $DEP = find_dep_client($id_client, $db);
        $AN = date('Y');

        $n_facture = "CLI{$DEP}{$AN}/{$id}";

        $update = update(
            'facture',
            [
                'n_facture' => $n_facture
            ],
            "id_facture = $id",
            $db
        );

        if ($insert && $update) {
            $output = array(
                'success' => true,
                'id_facture' => $id,
                'message' => "La facture $n_facture a été ajoutée !"
            );
        } else {
            $output = array(
                'success' => false,
                'message' => 'Une erreur s\'est produite !'
            );
        }
    }

    if ($_POST['action'] == 'emettre_facture') {

        $id_facture = $_POST['id_facture'];
        $date_emission_facture = date('Y-m-d H:i:s');
        $statut_facture = 'en cour';

        $update = update(
            'facture',
            [
                'date_emission_facture' => $date_emission_facture,
                'statut_facture' => $statut_facture,
                'updated_at_facture' => date('Y-m-d H:i:s'),
                'updated_by_facture' => $_SESSION['id_utilisateur']
            ],
            "id_facture = $id_facture",
            $db
        );

        if ($update) {
            $output = array(
                'success' => true,
                'message' => 'La facture a été émise !'
            );
        } else {
            $output = array(
                'success' => false,
                'message' => 'Une erreur s\'est produite !'
            );
        }
    }

    if ($_POST['action'] == 'fetch_client') {

        $query = "SELECT * FROM utilisateur, compte, client WHERE utilisateur.id_utilisateur = compte.id_utilisateur
        AND utilisateur.id_utilisateur = client.id_utilisateur AND prise_en_charge_client = 'oui' AND statut_compte = 'actif'";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();

        $output = '<option></option>';
        foreach ($result as $row) {
            $output .= <<<HTML
                <option value="{$row['id_client']}">Client {$row['matricule_client']} : {$row['nom_utilisateur']}</option>
            HTML;
        }
    }

    if ($_POST['action'] == 'view_detail_facture') {
        $id_facture = $_POST['id_facture'];

        $query = "SELECT * FROM utilisateur, client, facture WHERE utilisateur.id_utilisateur = client.id_utilisateur AND client.id_client = facture.id_client AND id_facture = $id_facture";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        $output = $result;

        $created_by_facture = find_info_utilisateur('prenom_utilisateur', $result['created_by_facture'], $db) . ' ' . find_info_utilisateur('nom_utilisateur', $result['created_by_facture'], $db);
        $updated_by_facture = find_info_utilisateur('prenom_utilisateur', $result['updated_by_facture'], $db) . ' ' . find_info_utilisateur('nom_utilisateur', $result['updated_by_facture'], $db);

        $output['created_by_user'] = $created_by_facture;
        $output['updated_by_user'] = $updated_by_facture;
    }

    if ($_POST['action'] == 'fetch_modifier_facture') {
        $id_facture = $_POST['id_facture'];

        $query = "SELECT * FROM utilisateur, client, facture WHERE utilisateur.id_utilisateur = client.id_utilisateur AND client.id_client = facture.id_client AND id_facture = $id_facture";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        $output = $result;
    }

    if ($_POST['action'] == 'modifier_facture') {

        $query = "SELECT * FROM facture WHERE id_facture = :id_facture";
        $statement = $db->prepare($query);
        $statement->execute([':id_facture' => $_POST['id_facture']]);
        $result = $statement->fetch();

        $id_facture = $_POST['id_facture'];
        $type_facture = $_POST['type_facture'];
        $objet_facture = $_POST['objet_facture'];
        $echeance_facture = $_POST['echeance_facture'];
        $date_echeance_facture = date('Y-m-d H:i:s', strtotime($result['date_emission_facture'] . " + $echeance_facture days"));
        $montant_ht_facture = $_POST['montant_ht_facture'];
        $tva_facture = $_POST['tva_facture'];
        $montant_ttc_facture = $_POST['montant_ttc_facture'];
        $solde_facture = $_POST['montant_ttc_facture'] - $result['montant_regle_facture'];
        $updated_at_facture = date('Y-m-d H:i:s');
        $updated_by_facture = $_SESSION['id_utilisateur'];

        $update = update(
            'facture',
            [
                'type_facture' => $type_facture,
                'objet_facture' => $objet_facture,
                'echeance_facture' => $echeance_facture,
                'date_echeance_facture' => $date_echeance_facture,
                'montant_ht_facture' => $montant_ht_facture,
                'tva_facture' => $tva_facture,
                'montant_ttc_facture' => $montant_ttc_facture,
                'solde_facture' => $solde_facture,
                'updated_at_facture' => $updated_at_facture,
                'updated_by_facture' => $updated_by_facture
            ],
            "id_facture = $id_facture",
            $db
        );

        if ($update) {
            $output = array(
                'success' => true,
                'message' => 'La facture a été modifiée !'
            );
        } else {
            $output = array(
                'success' => false,
                'message' => 'Une erreur s\'est produite !'
            );
        }
    }

    if ($_POST['action'] == 'fetch_n_facture') {

        $id_facture = $_POST['id_facture'];

        $query = "SELECT * FROM facture";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();

        $output = '<option></option>';
        foreach ($result as $row) {
            if ($row['id_facture'] == $id_facture) {
                $output .= <<<HTML
                    <option value="{$row['id_facture']}" selected>{$row['n_facture']}</option>
                HTML;
            } else {
                $output .= <<<HTML
                    <option value="{$row['id_facture']}">{$row['n_facture']}</option>
                HTML;
            }
        }
    }

    if ($_POST['action'] == 'encaisser_facture') {

        $id_facture = $_POST['id_facture'];
        $reference_paiement = $_POST['reference_paiement'];
        $mode_paiement = $_POST['mode_paiement'];
        $montant_ttc_paiement = $_POST['montant_ttc_paiement'];

        $query = "SELECT * FROM facture WHERE id_facture = $id_facture";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        $n_facture = $result['n_facture'];
        $montant_regle_facture = $result['montant_regle_facture'] + $montant_ttc_paiement;
        $solde_facture = $result['montant_ttc_facture'] - $montant_regle_facture;
        $updated_at_facture = date('Y-m-d H:i:s');
        $updated_by_facture = $_SESSION['id_utilisateur'];

        $insert = insert(
            'paiement',
            [
                'mode_paiement' => $mode_paiement,
                'reference_paiement' => $reference_paiement,
                'montant_ttc_paiement' => $montant_ttc_paiement,
                'id_facture' => $id_facture
            ],
            $db
        );

        if ($solde_facture == 0) {
            $update = update(
                'facture',
                [
                    'montant_regle_facture' => $montant_regle_facture,
                    'statut_facture' => 'paye',
                    'solde_facture' => $solde_facture,
                    'updated_at_facture' => $updated_at_facture,
                    'updated_by_facture' => $updated_by_facture
                ],
                "id_facture = $id_facture",
                $db
            );
        } else {
            $update = update(
                'facture',
                [
                    'montant_regle_facture' => $montant_regle_facture,
                    'solde_facture' => $solde_facture,
                    'updated_at_facture' => $updated_at_facture,
                    'updated_by_facture' => $updated_by_facture
                ],
                "id_facture = $id_facture",
                $db
            );
        }

        if ($insert && $update) {
            $output = array(
                'success' => true,
                'message' => 'Paiement ajouté !'
            );
        } else {
            $output = array(
                'success' => false,
                'message' => 'Une erreur s\'est produite !'
            );
        }
    }

    if ($_POST['action'] == 'supprimer_facture') {
        $id_facture = $_POST['id_facture'];

        $update = update(
            'facture',
            [
                'statut_facture' => 'supprime'
            ],
            "id_facture = $id_facture",
            $db
        );

        if ($update) {
            $output = array(
                'success' => true,
                'id_facture' => $id_facture,
                'message' => 'La facture a été supprimée !'
            );
        } else {
            $output = array(
                'success' => false,
                'message' => 'Une erreur s\'est produite !'
            );
        }
    }

    // espace facture

    if ($_POST['action'] == 'send_mail') {

        if ($_POST['option'] == 'add_facture') {

            // Send email
            $query = "SELECT * FROM facture WHERE id_facture = {$_POST['id_facture']}";
            $statement = $db->prepare($query);
            $statement->execute();
            $result = $statement->fetch();

            $n_facture = $result['n_facture'];
            $matricule_client = find_info_client('matricule_client', $result['id_client'], $db);
            $nom_client = find_info_client('nom_utilisateur', $result['id_client'], $db);
            $add_by = $_SESSION['prenom_utilisateur'] . ' ' . $_SESSION['nom_utilisateur'];
            $url = "";

            $to = [
                'to' => [],
            ];

            // Ajouter les AG
            $ag = find_ag_cabinet($db);
            foreach ($ag as $row) {
                $to['to'][] = [$row['email_utilisateur'], $row['prenom_utilisateur'] . ' ' . $row['nom_utilisateur']];
            }

            // Ajouter le DD DEC
            $dd = find_dd_dec($db);
            $to['to'][] = [$dd['email_utilisateur'], $dd['prenom_utilisateur'] . ' ' . $dd['nom_utilisateur']];

            $from = ['c_elyon@yahoo.fr', 'Cabinet Elyon'];

            $subject = 'Ajout d\'une facture dans GED-ELYON';

            $message = <<<HTML
            
                <!DOCTYPE html>
                <html lang="fr" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
                    xmlns:o="urn:schemas-microsoft-com:office:office">
            
                <head>
                    <meta charset="utf-8"> <!-- utf-8 works for most cases -->
                    <meta name="viewport" content="width=device-width"> <!-- Forcing initial-scale shouldn't be necessary -->
                    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine -->
                    <meta name="x-apple-disable-message-reformatting"> <!-- Disable auto-scale in iOS 10 Mail entirely -->
                    <title></title> <!-- The title tag shows in email notifications, like Android 4.4. -->
            
                    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet">
            
                    <style>
                        /* What it does: Remove spaces around the email design added by some email clients. */
                        /* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */
                        html,
                        body {
                            margin: 0 auto !important;
                            padding: 0 !important;
                            height: 100% !important;
                            width: 100% !important;
                            background: #f1f1f1;
                        }
            
                        /* What it does: Stops email clients resizing small text. */
                        * {
                            -ms-text-size-adjust: 100%;
                            -webkit-text-size-adjust: 100%;
                        }
            
                        /* What it does: Centers email on Android 4.4 */
                        div[style*="margin: 16px 0"] {
                            margin: 0 !important;
                        }
            
                        /* What it does: Fixes webkit padding issue. */
                        table {
                            border-spacing: 0 !important;
                            border-collapse: collapse !important;
                            table-layout: fixed !important;
                            margin: 0 auto !important;
                        }
            
                        /* What it does: Uses a better rendering method when resizing images in IE. */
                        img {
                            -ms-interpolation-mode: bicubic;
                        }
            
                        /* What it does: Prevents Windows 10 Mail from underlining links despite inline CSS. Styles for underlined links should be inline. */
                        a {
                            text-decoration: none;
                        }
            
                        /* What it does: A work-around for email clients meddling in triggered links. */
                        *[x-apple-data-detectors],
                        /* iOS */
                        .unstyle-auto-detected-links *,
                        .aBn {
                            border-bottom: 0 !important;
                            cursor: default !important;
                            color: inherit !important;
                            text-decoration: none !important;
                            font-size: inherit !important;
                            font-family: inherit !important;
                            font-weight: inherit !important;
                            line-height: inherit !important;
                        }
            
                        /* What it does: Prevents Gmail from displaying a download button on large, non-linked images. */
                        .a6S {
                            display: none !important;
                            opacity: 0.01 !important;
                        }
            
                        /* What it does: Prevents Gmail from changing the text color in conversation threads. */
                        .im {
                            color: inherit !important;
                        }
            
                        /* If the above doesn't work, add a .g-img class to any image in question. */
                        img.g-img+div {
                            display: none !important;
                        }
            
                        /* What it does: Removes right gutter in Gmail iOS app: https://github.com/TedGoas/Cerberus/issues/89  */
                        /* Create one of these media queries for each additional viewport size you'd like to fix */
            
                        /* iPhone 4, 4S, 5, 5S, 5C, and 5SE */
                        @media only screen and (min-device-width: 320px) and (max-device-width: 374px) {
                            u~div .email-container {
                                min-width: 320px !important;
                            }
                        }
            
                        /* iPhone 6, 6S, 7, 8, and X */
                        @media only screen and (min-device-width: 375px) and (max-device-width: 413px) {
                            u~div .email-container {
                                min-width: 375px !important;
                            }
                        }
            
                        /* iPhone 6+, 7+, and 8+ */
                        @media only screen and (min-device-width: 414px) {
                            u~div .email-container {
                                min-width: 414px !important;
                            }
                        }
                    </style>
            
                    <style>
                        .primary {
                            background: #0078D4;
                        }
            
                        .bg_white {
                            background: #ffffff;
                        }
            
                        .bg_light {
                            background: #fafafa;
                        }
            
                        .bg_black {
                            background: #000000;
                        }
            
                        .bg_dark {
                            background: rgba(0, 0, 0, .8);
                        }
            
                        .email-section {
                            padding: 20px 15px;
                        }
            
                        /*BUTTON*/
                        .btn {
                            padding: 10px 15px;
                            cursor: pointer;
                            display: inline-block;
                        }
            
                        .btn.btn-primary {
                            border-radius: 5px;
                            background: #0078D4;
                            color: #ffffff;
                        }
            
                        .btn.btn-white {
                            border-radius: 5px;
                            background: #ffffff;
                            color: #000000;
                        }
            
                        .btn.btn-white-outline {
                            border-radius: 5px;
                            background: transparent;
                            border: 1px solid #fff;
                            color: #fff;
                        }
            
                        .btn.btn-black-outline {
                            border-radius: 0px;
                            background: transparent;
                            border: 2px solid #000;
                            color: #000;
                            font-weight: 700;
                        }
            
                        h1,
                        h2,
                        h3,
                        h4,
                        h5,
                        h6 {
                            font-family: 'Lato', sans-serif;
                            color: #000000;
                            margin-top: 0;
                            font-weight: 400;
                        }
            
                        body {
                            font-family: 'Lato', sans-serif;
                            font-weight: 400;
                            font-size: 15px;
                            line-height: 1.8;
                            color: rgba(0, 0, 0, .4);
                        }
            
                        a {
                            color: #0078D4;
                        }
            
                        .logo h1 {
                            margin: 0;
                        }
            
                        .logo h1 a {
                            color: #0078D4;
                            font-size: 24px;
                            font-weight: 700;
                            font-family: 'Lato', sans-serif;
                        }
            
                        .hero {
                            position: relative;
                            z-index: 0;
                        }
            
                        .hero .text {
                            color: rgba(0, 0, 0, .3);
                        }
            
                        .hero .text h2 {
                            color: #000;
                            font-size: 25px;
                            margin-bottom: 0;
                            font-weight: 400;
                            line-height: 1.4;
                        }
            
                        .hero .text h3 {
                            font-size: 20px;
                            font-weight: 300;
                        }
            
                        .hero .text h2 span {
                            font-weight: 600;
                            color: #0078D4;
                        }
            
                        .heading-section h2 {
                            color: #000000;
                            font-size: 28px;
                            margin-top: 0;
                            line-height: 1.4;
                            font-weight: 400;
                        }
            
                        .heading-section .subheading {
                            margin-bottom: 20px !important;
                            display: inline-block;
                            font-size: 13px;
                            text-transform: uppercase;
                            letter-spacing: 2px;
                            color: rgba(0, 0, 0, .4);
                            position: relative;
                        }
            
                        .heading-section .subheading::after {
                            position: absolute;
                            left: 0;
                            right: 0;
                            bottom: -10px;
                            content: '';
                            width: 100%;
                            height: 2px;
                            background: #0078D4;
                            margin: 0 auto;
                        }
            
                        .heading-section-white {
                            color: rgba(255, 255, 255, .8);
                        }
            
                        .heading-section-white h2 {
                            color: #ffffff;
                        }
            
                        .heading-section-white .subheading {
                            margin-bottom: 0;
                            display: inline-block;
                            font-size: 13px;
                            text-transform: uppercase;
                            letter-spacing: 2px;
                            color: rgba(255, 255, 255, .4);
                        }
            
            
                        ul.social {
                            padding: 0;
                        }
            
                        ul.social li {
                            display: inline-block;
                            margin-right: 10px;
                        }
            
                        .footer {
                            border-top: 1px solid rgba(0, 0, 0, .05);
                            color: rgba(0, 0, 0, .6);
                        }
            
                        .footer .heading {
                            color: #000;
                            font-size: 20px;
                        }
            
                        .footer ul {
                            margin: 0;
                            padding: 0;
                        }
            
                        .footer ul li {
                            list-style: none;
                            margin-bottom: 10px;
                        }
            
                        .footer ul li a {
                            color: rgba(0, 0, 0, 1);
                        }
            
            
                        @media screen and (max-width: 500px) {}
                    </style>
            
            
                </head>
            
                <body width="100%" style="margin: 0; padding: 0 !important; background-color: #f1f1f1;">
                    <div style="width: 100%; background-color: #f1f1f1;">
                        <div style="max-width: 600px; margin: 0 auto;" class="email-container">
                            <table width="100%" style="margin: auto;">
                                <tr>
                                    <td valign="top" class="bg_white" style="padding: 1em 2.5em 0 2.5em;">
                                        <table role="presentation" cellpadding="0" cellspacing="0" width="100%">
                                            <tr>
                                                <td class="logo" style="text-align: center;">
                                                    <h1>Facture Ajouter</h1>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="middle" class="hero bg_white" style="padding: 2em 0 1em 0;">
                                        <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2022-11-29-094551/core/html/src/media/icons/duotune/files/fil007.svg-->
                                        <img style="width: 200px; max-width: 600px; height: auto; margin: auto; display: block; opacity: 0.3;" src="https://elyonsas.github.io/ged-assets/assets/media/ged-mail/add-doc.png" alt="add-icon">
                                        <!--end::Svg Icon-->
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="middle" class="hero bg_white" style="padding: 2em 0 4em 0;">
                                        <table>
                                            <tr>
                                                <td>
                                                    <div class="text" style="padding: 0 2.5em; text-align: center;">
                                                        <h3>La facture #<b>$n_facture</b> à été ajouté au dossier client #<b>$matricule_client</b> <strong>$nom_client</strong> par <b><u>$add_by</u></b></h3>
                                                        <p><a href="{$url}" class="btn btn-primary">Cliquez pour consulter</a></p>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <table width="100%" style="margin: auto;">
                                <tr>
                                    <td valign="middle" class="bg_light footer">
                                        <table>
                                            <tr>
                                                <td width="25%"
                                                    class="padding-bottom-20 padding-left-20 padding-right-20 padding-top-20">
                                                    <img width="130" height="130" src="https://elyonsas.github.io/ged-assets/assets/media/ged-mail/logo_elyon.png" alt="elyon-icon">
                                                </td>
                                                <td width="75%" style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 13px; text-align: left; line-height: 1.5;">
                                                    CABINET ÉLYÔN
                                                    Audit, Expertise comptable, Commissariat aux comptes, Conseils
                                                    09 BP 290 Saint Michel - Cotonou
                                                    Tél: (+229) 21 32 77 78 / 21 03 35 32 / 97 22 19 85 / 90 94 07 99
                                                    Email: c_elyon@yahoo.fr, contact@elyonsas.com
                                                    Cotonou-Bénin
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="margin: 0px auto; border-collapse: collapse; border-top: 1px solid rgba(0, 0, 0, .05); font-size: 0px; padding: 16px 0px 8px; word-break: break-word;">
                                                    <div style="font-family: system-ui, 'Segoe UI', sans-serif; font-size: 11px; line-height: 1.6; text-align: center; color: rgb(147, 149, 152);">
                                                        Cet email à été automatiquement générer par le logiciel GED-ELYON.
                                                        <a href="https://ged-elyon.com" style="color: rgb(0, 0, 0); text-decoration: none; background-color: transparent;">https://ged-elyon.com</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </body>
            
                </html>
            
            HTML;

            $send_mail = send_mail($to, $from, $subject, $message);

            if ($send_mail) {
                $output = [
                    'success' => true,
                    'message' => 'Mail envoyé !',
                ];

                // Ajouter une notification pour les AG
                foreach ($ag as $row) {
                    add_notif(
                        'Ajout de facture',
                        "La facture #$n_facture à été ajouté au dossier client #$matricule_client",
                        'alert',
                        'important',
                        'roll/dd/dossiers/',
                        $row['id_utilisateur'],
                        $db
                    );
                }

                // Ajouter une notification pour DD
                add_notif(
                    'Ajout de facture',
                    "La facture #$n_facture à été ajouté au dossier client #$matricule_client",
                    'alert',
                    'important',
                    'roll/dd/dossiers/',
                    $dd['id_utilisateur'],
                    $db
                );

            } else {
                $output = [
                    'success' => false,
                    'message' => 'Une erreur s\'est produite ! !',
                ];
            }
        }
        if ($_POST['option'] == "supprimer_facture") {

            // Send email
            $query = "SELECT * FROM facture WHERE id_facture = {$_POST['id_facture']}";
            $statement = $db->prepare($query);
            $statement->execute();
            $result = $statement->fetch();

            $n_facture = $result['n_facture'];
            $matricule_client = find_info_client('matricule_client', $result['id_client'], $db);
            $nom_client = find_info_client('nom_utilisateur', $result['id_client'], $db);
            $delete_by = $_SESSION['prenom_utilisateur'] . ' ' . $_SESSION['nom_utilisateur'];
            $url = "";

            $to = [
                'to' => [],
            ];

            // Ajouter les AG
            $ag = find_ag_cabinet($db);
            foreach ($ag as $row) {
                $to['to'][] = [$row['email_utilisateur'], $row['prenom_utilisateur'] . ' ' . $row['nom_utilisateur']];
            }

            // Ajouter le DD DEC
            $dd = find_dd_dec($db);
            $to['to'][] = [$dd['email_utilisateur'], $dd['prenom_utilisateur'] . ' ' . $dd['nom_utilisateur']];

            $from = ['c_elyon@yahoo.fr', 'Cabinet Elyon'];

            $subject = 'Suppression d\'une facture dans GED-ELYON';

            $message = <<<HTML
            
                <!DOCTYPE html>
                <html lang="fr" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
                    xmlns:o="urn:schemas-microsoft-com:office:office">
            
                <head>
                    <meta charset="utf-8"> <!-- utf-8 works for most cases -->
                    <meta name="viewport" content="width=device-width"> <!-- Forcing initial-scale shouldn't be necessary -->
                    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine -->
                    <meta name="x-apple-disable-message-reformatting"> <!-- Disable auto-scale in iOS 10 Mail entirely -->
                    <title></title> <!-- The title tag shows in email notifications, like Android 4.4. -->
            
                    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet">
            
                    <style>
                        /* What it does: Remove spaces around the email design added by some email clients. */
                        /* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */
                        html,
                        body {
                            margin: 0 auto !important;
                            padding: 0 !important;
                            height: 100% !important;
                            width: 100% !important;
                            background: #f1f1f1;
                        }
            
                        /* What it does: Stops email clients resizing small text. */
                        * {
                            -ms-text-size-adjust: 100%;
                            -webkit-text-size-adjust: 100%;
                        }
            
                        /* What it does: Centers email on Android 4.4 */
                        div[style*="margin: 16px 0"] {
                            margin: 0 !important;
                        }
            
                        /* What it does: Fixes webkit padding issue. */
                        table {
                            border-spacing: 0 !important;
                            border-collapse: collapse !important;
                            table-layout: fixed !important;
                            margin: 0 auto !important;
                        }
            
                        /* What it does: Uses a better rendering method when resizing images in IE. */
                        img {
                            -ms-interpolation-mode: bicubic;
                        }
            
                        /* What it does: Prevents Windows 10 Mail from underlining links despite inline CSS. Styles for underlined links should be inline. */
                        a {
                            text-decoration: none;
                        }
            
                        /* What it does: A work-around for email clients meddling in triggered links. */
                        *[x-apple-data-detectors],
                        /* iOS */
                        .unstyle-auto-detected-links *,
                        .aBn {
                            border-bottom: 0 !important;
                            cursor: default !important;
                            color: inherit !important;
                            text-decoration: none !important;
                            font-size: inherit !important;
                            font-family: inherit !important;
                            font-weight: inherit !important;
                            line-height: inherit !important;
                        }
            
                        /* What it does: Prevents Gmail from displaying a download button on large, non-linked images. */
                        .a6S {
                            display: none !important;
                            opacity: 0.01 !important;
                        }
            
                        /* What it does: Prevents Gmail from changing the text color in conversation threads. */
                        .im {
                            color: inherit !important;
                        }
            
                        /* If the above doesn't work, add a .g-img class to any image in question. */
                        img.g-img+div {
                            display: none !important;
                        }
            
                        /* What it does: Removes right gutter in Gmail iOS app: https://github.com/TedGoas/Cerberus/issues/89  */
                        /* Create one of these media queries for each additional viewport size you'd like to fix */
            
                        /* iPhone 4, 4S, 5, 5S, 5C, and 5SE */
                        @media only screen and (min-device-width: 320px) and (max-device-width: 374px) {
                            u~div .email-container {
                                min-width: 320px !important;
                            }
                        }
            
                        /* iPhone 6, 6S, 7, 8, and X */
                        @media only screen and (min-device-width: 375px) and (max-device-width: 413px) {
                            u~div .email-container {
                                min-width: 375px !important;
                            }
                        }
            
                        /* iPhone 6+, 7+, and 8+ */
                        @media only screen and (min-device-width: 414px) {
                            u~div .email-container {
                                min-width: 414px !important;
                            }
                        }
                    </style>
            
                    <style>
                        .primary {
                            background: #0078D4;
                        }
            
                        .bg_white {
                            background: #ffffff;
                        }
            
                        .bg_light {
                            background: #fafafa;
                        }
            
                        .bg_black {
                            background: #000000;
                        }
            
                        .bg_dark {
                            background: rgba(0, 0, 0, .8);
                        }
            
                        .email-section {
                            padding: 20px 15px;
                        }
            
                        /*BUTTON*/
                        .btn {
                            padding: 10px 15px;
                            cursor: pointer;
                            display: inline-block;
                        }
            
                        .btn.btn-primary {
                            border-radius: 5px;
                            background: #0078D4;
                            color: #ffffff;
                        }
            
                        .btn.btn-white {
                            border-radius: 5px;
                            background: #ffffff;
                            color: #000000;
                        }
            
                        .btn.btn-white-outline {
                            border-radius: 5px;
                            background: transparent;
                            border: 1px solid #fff;
                            color: #fff;
                        }
            
                        .btn.btn-black-outline {
                            border-radius: 0px;
                            background: transparent;
                            border: 2px solid #000;
                            color: #000;
                            font-weight: 700;
                        }
            
                        h1,
                        h2,
                        h3,
                        h4,
                        h5,
                        h6 {
                            font-family: 'Lato', sans-serif;
                            color: #000000;
                            margin-top: 0;
                            font-weight: 400;
                        }
            
                        body {
                            font-family: 'Lato', sans-serif;
                            font-weight: 400;
                            font-size: 15px;
                            line-height: 1.8;
                            color: rgba(0, 0, 0, .4);
                        }
            
                        a {
                            color: #0078D4;
                        }
            
                        .logo h1 {
                            margin: 0;
                        }
            
                        .logo h1 a {
                            color: #0078D4;
                            font-size: 24px;
                            font-weight: 700;
                            font-family: 'Lato', sans-serif;
                        }
            
                        .hero {
                            position: relative;
                            z-index: 0;
                        }
            
                        .hero .text {
                            color: rgba(0, 0, 0, .3);
                        }
            
                        .hero .text h2 {
                            color: #000;
                            font-size: 25px;
                            margin-bottom: 0;
                            font-weight: 400;
                            line-height: 1.4;
                        }
            
                        .hero .text h3 {
                            font-size: 20px;
                            font-weight: 300;
                        }
            
                        .hero .text h2 span {
                            font-weight: 600;
                            color: #0078D4;
                        }
            
                        .heading-section h2 {
                            color: #000000;
                            font-size: 28px;
                            margin-top: 0;
                            line-height: 1.4;
                            font-weight: 400;
                        }
            
                        .heading-section .subheading {
                            margin-bottom: 20px !important;
                            display: inline-block;
                            font-size: 13px;
                            text-transform: uppercase;
                            letter-spacing: 2px;
                            color: rgba(0, 0, 0, .4);
                            position: relative;
                        }
            
                        .heading-section .subheading::after {
                            position: absolute;
                            left: 0;
                            right: 0;
                            bottom: -10px;
                            content: '';
                            width: 100%;
                            height: 2px;
                            background: #0078D4;
                            margin: 0 auto;
                        }
            
                        .heading-section-white {
                            color: rgba(255, 255, 255, .8);
                        }
            
                        .heading-section-white h2 {
                            color: #ffffff;
                        }
            
                        .heading-section-white .subheading {
                            margin-bottom: 0;
                            display: inline-block;
                            font-size: 13px;
                            text-transform: uppercase;
                            letter-spacing: 2px;
                            color: rgba(255, 255, 255, .4);
                        }
            
            
                        ul.social {
                            padding: 0;
                        }
            
                        ul.social li {
                            display: inline-block;
                            margin-right: 10px;
                        }
            
                        .footer {
                            border-top: 1px solid rgba(0, 0, 0, .05);
                            color: rgba(0, 0, 0, .6);
                        }
            
                        .footer .heading {
                            color: #000;
                            font-size: 20px;
                        }
            
                        .footer ul {
                            margin: 0;
                            padding: 0;
                        }
            
                        .footer ul li {
                            list-style: none;
                            margin-bottom: 10px;
                        }
            
                        .footer ul li a {
                            color: rgba(0, 0, 0, 1);
                        }
            
            
                        @media screen and (max-width: 500px) {}
                    </style>
            
            
                </head>
            
                <body width="100%" style="margin: 0; padding: 0 !important; background-color: #f1f1f1;">
                    <div style="width: 100%; background-color: #f1f1f1;">
                        <div style="max-width: 600px; margin: 0 auto;" class="email-container">
                            <table width="100%" style="margin: auto;">
                                <tr>
                                    <td valign="top" class="bg_white" style="padding: 1em 2.5em 0 2.5em;">
                                        <table role="presentation" cellpadding="0" cellspacing="0" width="100%">
                                            <tr>
                                                <td class="logo" style="text-align: center;">
                                                    <h1>Facture Supprimer</h1>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="middle" class="hero bg_white" style="padding: 2em 0 1em 0;">
                                        <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2022-11-29-094551/core/html/src/media/icons/duotune/files/fil007.svg-->
                                        <img style="width: 200px; max-width: 600px; height: auto; margin: auto; display: block; opacity: 0.3;" src="https://elyonsas.github.io/ged-assets/assets/media/ged-mail/delete-doc.png" alt="delete-icon">
                                        <!--end::Svg Icon-->
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="middle" class="hero bg_white" style="padding: 2em 0 4em 0;">
                                        <table>
                                            <tr>
                                                <td>
                                                    <div class="text" style="padding: 0 2.5em; text-align: center;">
                                                        <h3>La facture #<b>$n_facture</b> à été supprimé du dossier client #<b>$matricule_client</b> <strong>$nom_client</strong> par <b><u>$delete_by</u></b></h3>
                                                        <p><a href="{$url}" class="btn btn-primary">Cliquez pour consulter</a></p>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <table width="100%" style="margin: auto;">
                                <tr>
                                    <td valign="middle" class="bg_light footer">
                                        <table>
                                            <tr>
                                                <td width="25%"
                                                    class="padding-bottom-20 padding-left-20 padding-right-20 padding-top-20">
                                                    <img width="130" height="130" src="https://elyonsas.github.io/ged-assets/assets/media/ged-mail/logo_elyon.png" alt="elyon-icon">
                                                </td>
                                                <td width="75%" style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 13px; text-align: left; line-height: 1.5;">
                                                    CABINET ÉLYÔN
                                                    Audit, Expertise comptable, Commissariat aux comptes, Conseils
                                                    09 BP 290 Saint Michel - Cotonou
                                                    Tél: (+229) 21 32 77 78 / 21 03 35 32 / 97 22 19 85 / 90 94 07 99
                                                    Email: c_elyon@yahoo.fr, contact@elyonsas.com
                                                    Cotonou-Bénin
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="margin: 0px auto; border-collapse: collapse; border-top: 1px solid rgba(0, 0, 0, .05); font-size: 0px; padding: 16px 0px 8px; word-break: break-word;">
                                                    <div style="font-family: system-ui, 'Segoe UI', sans-serif; font-size: 11px; line-height: 1.6; text-align: center; color: rgb(147, 149, 152);">
                                                        Cet email à été automatiquement générer par le logiciel GED-ELYON.
                                                        <a href="https://ged-elyon.com" style="color: rgb(0, 0, 0); text-decoration: none; background-color: transparent;">https://ged-elyon.com</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </body>
            
                </html>
            
            HTML;

            $send_mail = send_mail($to, $from, $subject, $message);

            if ($send_mail) {
                $output = [
                    'success' => true,
                    'message' => 'Mail envoyé !',
                ];

                // Ajouter une notification pour les AG
                foreach ($ag as $row) {
                    add_notif(
                        'Suppression de facture',
                        "La facture #$n_facture à été supprimé du dossier client #$matricule_client",
                        'alert',
                        'danger',
                        'roll/dd/dossiers/',
                        $row['id_utilisateur'],
                        $db
                    );
                }

                // Ajouter une notification pour DD
                add_notif(
                    'Suppression de facture',
                    "La facture #$n_facture à été supprimé du dossier client #$matricule_client",
                    'alert',
                    'danger',
                    'roll/dd/dossiers/',
                    $dd['id_utilisateur'],
                    $db
                );
            } else {
                $output = [
                    'success' => false,
                    'message' => 'Une erreur s\'est produite ! !',
                ];
            }
        }
    }

    if ($_POST['action'] == 'fetch_page_facture') {

        $id_facture = $_SESSION['id_view_facture'];
        $id_client = select_info('id_client', 'facture', "id_facture = $id_facture", $db);

        // Récupérer les informations de la base de données
        $query = "SELECT * FROM utilisateur, compte, client, facture WHERE utilisateur.id_utilisateur = compte.id_utilisateur 
        AND utilisateur.id_utilisateur = client.id_utilisateur AND facture.id_client = client.id_client AND facture.id_facture = $id_facture ";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        $output = $result;

        // Récupérer les informations de la base de données
        $query = "SELECT SUM(montant_ttc_facture) as total_facture,  SUM(montant_regle_facture) as total_regle
        FROM facture WHERE id_client = $id_client AND statut_facture <> 'en attente' AND statut_facture <> 'supprime'";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        $output['total_facture'] = $result['total_facture'];
        $output['total_regle'] = $result['total_regle'];
        $output['taux_recouvrement'] = round(($result['total_regle'] / $result['total_facture']) * 100, 2);

        // Récupérer les informations de la base de données
        $query = "SELECT SUM(montant_ttc_facture) as total_echue, COUNT(*) as nb_facture_echue 
        FROM facture WHERE id_client = $id_client AND statut_facture = 'relance'";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        $output['total_echue'] = $result['total_echue'] ?? '--';
        $output['nb_facture_echue'] = $result['nb_facture_echue'];

        // Récupérer les informations de la base de données
        $query = "SELECT SUM(montant_ttc_facture) as total_en_cour, COUNT(*) as nb_facture_en_cour 
        FROM facture WHERE id_client = $id_client AND statut_facture = 'en cour'";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        $output['total_en_cour'] = $result['total_en_cour'] ?? '--';
        $output['nb_facture_en_cour'] = $result['nb_facture_en_cour'];

        // Récupérer les informations de la base de données
        $query = "SELECT SUM(montant_ttc_facture) as total_solde, COUNT(*) as nb_facture_solde 
        FROM facture WHERE id_client = $id_client AND statut_facture = 'paye'";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        $output['total_solde'] = $result['total_solde'] ?? '--';
        $output['nb_facture_solde'] = $result['nb_facture_solde'];
    }
}

echo json_encode($output);
