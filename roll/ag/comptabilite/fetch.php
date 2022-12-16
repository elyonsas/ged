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
        AND utilisateur.id_utilisateur = client.id_utilisateur AND facture.id_client = client.id_client AND statut_facture <> 'supprime' ORDER BY updated_at_facture DESC";


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

    // espace facture
    if ($_POST['action'] == 'fetch_page_facture') {

        $id_client = $_SESSION['id_view_client'];

        // Récupérer les informations de la base de données
        $query = "SELECT * FROM utilisateur, compte, client, facture WHERE utilisateur.id_utilisateur = compte.id_utilisateur
        AND utilisateur.id_utilisateur = client.id_utilisateur AND client.id_client = facture.id_client AND id_client = $id_client ";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();

        foreach ($result as $row) {

            $query = "SELECT * FROM document, doc_8_fiche_id_client, client WHERE document.id_document = doc_8_fiche_id_client.id_document
            AND document.id_client = client.id_client AND document.id_client = $id_client";
            $statement = $db->prepare($query);
            $statement->execute();
            $result = $statement->fetch();

            $id_utilisateur = $row['id_utilisateur'];
            $avatar_client = <<<HTML
                <img src="assets/media/avatars/{$row['avatar_utilisateur']}" alt="image">
            HTML;
            $nom_client = $row['nom_utilisateur'];
            $email_client = $row['email_utilisateur'];
            $matricule_client = $row['matricule_client'];
            $date_naiss_client = si_funct1($row['date_naiss_utilisateur'], date('d/m/Y', strtotime($row['date_naiss_utilisateur'])), '--');
            $tel_client = $row['tel_utilisateur'];
            $adresse_client = $row['adresse_utilisateur'];

            $designation_entite = $result['designation_entite'] ?? $nom_client;
            $ifu_entite = $result['id_fiscale_client'] ?? '--';
            $boite_postal = isset($result['boite_postal']) ? $result['num_code'] . ' ' . $result['code'] . ' ' . $result['boite_postal'] : '--';
            $designation_activite_principale = $result['designation_activite_principale'] ?? '--';
            $adresse_geo_complete = $result['adresse_geo_complete'] ?? '--';

            $statut_client = $row['statut_compte'];
            switch ($statut_client) {
                case 'actif':
                    $statut_client_html = <<<HTML
                        <span class="badge badge-light-success">Actif</span>
                    HTML;
                    break;
                case 'inactif':
                    $statut_client_html = <<<HTML
                        <span class="badge badge-light-danger">Inactif</span>
                    HTML;
                    break;
            }

            $prise_en_charge_client = $row['prise_en_charge_client'];
            $attribuer_a = '';
            switch ($prise_en_charge_client) {
                case 'oui':
                    $prise_en_charge_client = '<span class="badge badge-success">Oui</span>';
                    $attribuer_a = '';
                    break;

                case 'non':
                    $prise_en_charge_client = '<span class="badge badge-danger">Non</span>';
                    $attribuer_a = <<<HTML
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="" class="attribuer_collabo menu-link px-3" data-bs-toggle="modal" data-bs-target="#attribuer_modal" data-id_client="{$id_client}">Attribuer à</a>
                        </div>
                        <!--end::Menu item-->
                    HTML;
                    break;
            }

            $action_client = '';
            switch ($statut_client) {
                case 'actif':
                    $action_client = <<<HTML

                        <td>
                            <div class="d-flex justify-content-end flex-shrink-0">
                                
                                <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <i class="bi bi-three-dots fs-3"></i>
                                </button>
                                <!--begin::Menu 3-->
                                <div class="drop_action menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="" class="view_detail_dossier menu-link px-3" data-bs-toggle="modal" data-bs-target="#detail_dossier_modal" data-id_client="{$id_client}">Détails</a>
                                    </div>
                                    <!--end::Menu item-->

                                    $attribuer_a

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="" class="desactiver_compte menu-link px-3" data-id_client="{$id_client}">Désactiver ce compte</a>
                                    </div>
                                    <!--end::Menu item-->

                                    <!--begin::Menu separator-->
                                    <!-- <div class="separator mt-3 opacity-75"></div> -->
                                    <!--end::Menu separator-->

                                    <!--begin::Menu item-->
                                    <!-- <div class="menu-item">
                                        <div class="menu-content px-3 py-3">
                                            <a href="" class="supprimer_definitivement btn btn-light-danger px-4 w-100" data-id_client="{$id_client}">Supprimer définitivement</a>
                                        </div>
                                    </div> -->
                                    <!--end::Menu item-->
                                </div>
                                <!--end::Menu 3-->
                            </div>
                        </td>

                    HTML;
                    break;
                case 'inactif':
                    $action_client = <<<HTML

                        <td>
                            <div class="d-flex justify-content-end flex-shrink-0">
                                
                                <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <i class="bi bi-three-dots fs-3"></i>
                                </button>
                                <!--begin::Menu 3-->
                                <div class="drop_action menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="" class="view_detail_dossier menu-link px-3" data-bs-toggle="modal" data-bs-target="#detail_dossier_modal" data-id_client="{$id_client}">Détails</a>
                                    </div>
                                    <!--end::Menu item-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="" class="activer_compte menu-link px-3" data-id_client="{$id_client}">Activer ce compte</a>
                                    </div>
                                    <!--end::Menu item-->

                                    <!--begin::Menu separator-->
                                    <!-- <div class="separator mt-3 opacity-75"></div> -->
                                    <!--end::Menu separator-->

                                    <!--begin::Menu item-->
                                    <!-- <div class="menu-item">
                                        <div class="menu-content px-3 py-3">
                                            <a href="" class="supprimer_definitivement btn btn-light-danger px-4 w-100" data-id_client="{$id_client}">Supprimer définitivement</a>
                                        </div>
                                    </div> -->
                                    <!--end::Menu item-->
                                </div>
                                <!--end::Menu 3-->
                            </div>
                        </td>

                    HTML;
                    break;
            }


            $output = array(
                'avatar_client' => $avatar_client,
                'nom_client' => $nom_client,
                'email_client' => $email_client,
                'matricule_client' => $matricule_client,
                'date_naiss_client' => $date_naiss_client,
                'tel_client' => $tel_client,
                'adresse_client' => $adresse_client,

                'designation_entite' => $designation_entite,
                'ifu_entite' => $ifu_entite,
                'boite_postal' => $boite_postal,
                'designation_activite_principale' => $designation_activite_principale,
                'adresse_geo_complete' => $adresse_geo_complete,

                'statut_client' => $statut_client_html,
                'prise_en_charge_client' => $prise_en_charge_client,
                'action_client' => $action_client,
            );
        }

    }
    

}

echo json_encode($output);
