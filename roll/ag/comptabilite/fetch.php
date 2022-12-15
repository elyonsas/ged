<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/vendor/autoload.php');

require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions-sql.php');

use Ramsey\Uuid\Uuid;

connected('ag');

$output = '';

if (isset($_POST['datatable'])) {

    if ($_POST['datatable'] == 'all_factures') {

        $output = array();
        $query = '';

        $query .= "SELECT * FROM utilisateur, compte, client, facture WHERE utilisateur.id_utilisateur = compte.id_utilisateur 
        AND utilisateur.id_utilisateur = client.id_utilisateur AND facture.id_client = client.id_client AND statut_compte <> 'supprime' ORDER BY updated_at_facture DESC";


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
                    <a href="" class="fs-6 text-gray-800 text-hover-primary">$n_facture</a>
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
                                        <a href="" class="emettre_facture menu-link px-3" data-bs-toggle="modal" data-bs-target="#emettre_facture_modal" data-id_facture="{$id_facture}">Émettre la facture</a>
                                    </div>
                                    <!--end::Menu item-->

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="" class="modifier_facture menu-link px-3" data-id_facture="{$id_facture}">Modifier facture</a>
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
                                        <a href="" class="modifier_facture menu-link px-3" data-id_facture="{$id_facture}">Modifier facture</a>
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
                                        <a href="" class="modifier_facture menu-link px-3" data-id_facture="{$id_facture}">Modifier facture</a>
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
                                        <a href="" class="modifier_facture menu-link px-3" data-id_facture="{$id_facture}">Modifier facture</a>
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
        $date_emission_facture = date('Y-m-d H:i:s');
        $echeance_facture = $_POST['echeance_facture'];
        $date_echeance_facture = date('Y-m-d H:i:s', strtotime("+ $echeance_facture days") );
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
                'message' => "La facture $n_facture a été ajoutée !"
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

}

echo json_encode($output);
