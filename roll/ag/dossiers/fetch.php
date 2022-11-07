<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions-sql.php');

connected('ag');

$output = '';

if (isset($_POST['datatable'])) {

    if ($_POST['datatable'] == 'all_dossiers') {

        $output = array();
        $query = '';

        $query .= "SELECT * FROM utilisateur, compte, client WHERE utilisateur.id_utilisateur = compte.id_utilisateur 
        AND utilisateur.id_utilisateur = client.id_utilisateur AND statut_compte <> 'supprime' ORDER BY statut_compte ASC";


        // // pour la recherche
        // if (isset($_POST["search"]["value"])) {
        //     $query .= 'AND (nom_utilisateur LIKE "%' . $_POST["search"]["value"] . '%" ';
        //     $query .= 'OR prenom_utilisateur LIKE "%'. $_POST["search"]["value"] .'%" ';
        //     $query .= 'OR titre_client LIKE "%' . $_POST["search"]["value"] . '%" ';
        //     $query .= 'OR created_at_client LIKE "%' . $_POST["search"]["value"] . '%" ';
        //     $query .= 'OR date_valide_client LIKE "%' . $_POST["search"]["value"] . '%" ';
        //     $query .= 'OR statut_compte LIKE "%' . $_POST["search"]["value"] . '%" ) ';
        // }

        // // Filtrage dans le tableau
        // if (isset($_POST['order'])) {
        //     $query .= 'ORDER BY ' . $colonne[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
        // }
        // if ($_POST['length'] != -1) {
        //     $query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
        // }


        $statement = $db->prepare($query);

        $statement->execute();

        $result = $statement->fetchAll();

        $data = array();

        $filtered_rows = $statement->rowCount();


        foreach ($result as $row) {

            $sub_array = array();

            $id_client = $row['id_client'];
            $nom_client = $row['nom_utilisateur'];   
            $matricule_client = $row['matricule_client'];

            $prise_en_charge_client = $row['prise_en_charge_client'];
            switch ($prise_en_charge_client) {
                case 'oui':
                    $prise_en_charge_client = '<span class="badge badge-success">Oui</span>';
                    break;
                
                case 'non':
                    $prise_en_charge_client = '<span class="badge badge-danger">Non</span>';
                    break;
            }

            $statut_compte = $row['statut_compte'];
            switch ($statut_compte) {
                case 'actif':
                    $statut_compte_html = <<<HTML
                        <span class="badge badge-light-success">Actif</span>
                    HTML;
                    break;
                case 'inactif':
                    $statut_compte_html = <<<HTML
                        <span class="badge badge-light-danger">Inactif</span>
                    HTML;
                    break;
            }

            // Client
            $sub_array[] = <<<HTML
                <div class="d-flex flex-column justify-content-center">
                    <a href="roll/ag/view_redirect/?action=view_client&id_view_client={$id_client}" 
                    class="fs-6 text-gray-800 text-hover-primary">$nom_client</a>
                </div>
            HTML;

            // Matricule
            $sub_array[] = <<<HTML
                $matricule_client
            HTML;

            // Prise en charge
            $sub_array[] = <<<HTML
                $prise_en_charge_client
            HTML;

            // Statut
            $sub_array[] = <<<HTML
                $statut_compte_html
            HTML;

            // Action
            switch ($statut_compte) {
                case 'actif':
                    $action = <<<HTML

                        <td>
                            <div class="d-flex justify-content-end flex-shrink-0">
                                
                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="voir" href="" data-id_client="{$id_client}" class="view_client btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                    <i class="bi bi-eye-fill fs-3"></i>
                                </a>
                                <!-- <a href="" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                <i class="bi bi-clipboard2-plus-fill fs-3"></i>
                                </a> -->
                                <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <i class="bi bi-three-dots fs-3"></i>
                                </button>
                                <!--begin::Menu 3-->
                                <div class="drop_action menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="" class="detail_dossier menu-link px-3" data-bs-toggle="modal" data-bs-target="#detail_dossier_modal" data-id_client="{$id_client}">Détails</a>
                                    </div>
                                    <!--end::Menu item-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="" class="attribuer_collabo menu-link px-3" data-bs-toggle="modal" data-bs-target="#attribuer_modal" data-id_client="{$id_client}">Attribuer à</a>
                                    </div>
                                    <!--end::Menu item-->
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
                    $action = <<<HTML

                        <td>
                            <div class="d-flex justify-content-end flex-shrink-0">

                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="voir" href="" data-id_client="{$id_client}" class="view_client btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                    <i class="bi bi-eye-fill fs-3"></i>
                                </a>
                                <!-- <a href="" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                <i class="bi bi-clipboard2-plus-fill fs-3"></i>
                                </a> -->
                                <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <i class="bi bi-three-dots fs-3"></i>
                                </button>
                                <!--begin::Menu 3-->
                                <div class="drop_action menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="" class="detail_dossier menu-link px-3" data-bs-toggle="modal" data-bs-target="#detail_dossier_modal" data-id_client="{$id_client}">Détails</a>
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

            $sub_array[] = $action;

            $data[] = $sub_array;
        }

        function get_total_all_records($db)
        {
            $statement = $db->prepare("SELECT * FROM utilisateur, compte, client WHERE utilisateur.id_utilisateur = compte.id_utilisateur 
            AND utilisateur.id_utilisateur = client.id_utilisateur ORDER BY statut_compte ASC"); // same query as above
            $statement->execute();
            return $statement->rowCount();
        }


        $output = array(
            "recordsTotal"      =>  $filtered_rows,
            "recordsFiltered"     =>     get_total_all_records($db),
            "data"                =>    $data
        );
    }

}

if (isset($_POST['action'])) {

    // espace datatables
    if ($_POST['action'] == 'activer_compte') {
        $id_client = $_POST['id_client'];

        $query = "SELECT * FROM utilisateur, compte, client WHERE utilisateur.id_utilisateur = compte.id_utilisateur 
        AND utilisateur.id_utilisateur = client.id_utilisateur AND client.id_client = '$id_client'";

        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        $id_utilisateur = $result['id_utilisateur'];
        $statut_compte = $result['statut_compte'];

        $update = update(
            'compte',
            ['statut_compte' => 'actif'],
            "id_utilisateur = '$id_utilisateur'",
            $db
        );

        if ($update) {
            $output = array(
                'success' => true,
                'message' => 'Compte activé !'
            );
        } else {
            $output = array(
                'success' => false,
                'message' => 'Une erreur s\'est produite !'
            );
        }
    }

    if ($_POST['action'] == 'desactiver_compte') {
        $id_client = $_POST['id_client'];

        $query = "SELECT * FROM utilisateur, compte, client WHERE utilisateur.id_utilisateur = compte.id_utilisateur 
        AND utilisateur.id_utilisateur = client.id_utilisateur AND client.id_client = '$id_client'";

        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        $id_utilisateur = $result['id_utilisateur'];
        $statut_compte = $result['statut_compte'];

        $update1 = update(
            'compte',
            ['statut_compte' => 'inactif'],
            "id_utilisateur = '$id_utilisateur'",
            $db
        );

        $update2 = update(
            'assoc_client_collabo',
            [
                'statut_assoc_client_collabo' => 'inactif',
                'date_fin_assoc_client_collabo' => date('Y-m-d H:i:s'),
                'updated_at_assoc_client_collabo' => date('Y-m-d H:i:s')
            ],
            "id_client = $id_client",
            $db
        );


        if ($update1 && $update2) {
            $output = array(
                'success' => true,
                'message' => 'Compte désactivé !'
            );
        } else {
            $output = array(
                'success' => false,
                'message' => 'Une erreur s\'est produite !'
            );
        }
    }

    if ($_POST['action'] == 'fetch_attribuer_collabo') {

        $id_client = $_POST['id_client'];

        // Récupérer les infos du client
        $query = "SELECT * FROM utilisateur, compte, client WHERE utilisateur.id_utilisateur = compte.id_utilisateur 
        AND utilisateur.id_utilisateur = client.id_utilisateur AND client.id_client = '$id_client'";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        $output = [
            'success' => true,
            'id_client' => $result['id_client'],
            'nom_client' => $result['nom_utilisateur'],
            'dossier_html' => ''
        ];

        if ($result) {
            $query = "SELECT * FROM utilisateur, compte, collaborateur WHERE utilisateur.id_utilisateur = compte.id_utilisateur
            AND utilisateur.id_utilisateur = collaborateur.id_utilisateur AND compte.statut_compte = 'actif'";
            $statement = $db->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll();

            $output['dossier_html'] .= '<option></option>';
            foreach ($result as $row) {
                $output['dossier_html'] .= <<<HTML
                    <option value="{$row['id_collaborateur']}">collaborateur {$row['code_collaborateur']} : {$row['prenom_utilisateur']} {$row['nom_utilisateur']}</option>
                HTML;
            }
        }
    }

    if ($_POST['action'] == 'edit_attribuer_collabo') {

        $id_collaborateur = $_POST['id_collaborateur'];
        $id_client = $_POST['id_client'];

        $query1 = "SELECT * FROM utilisateur, collaborateur WHERE utilisateur.id_utilisateur = collaborateur.id_utilisateur
        AND collaborateur.id_collaborateur = '$id_collaborateur'";
        $statement1 = $db->prepare($query1);
        $statement1->execute();
        $result1 = $statement1->fetch();

        $query2 = "SELECT * FROM utilisateur, client WHERE utilisateur.id_utilisateur = client.id_utilisateur
        AND client.id_client = '$id_client'";
        $statement2 = $db->prepare($query2);
        $statement2->execute();
        $result2 = $statement2->fetch();

        // insert
        $insert = insert(
            'assoc_client_collabo',
            [
                'role_assoc_client_collabo' => 'cm',
                'statut_assoc_client_collabo' => 'actif',
                'date_debut_assoc_client_collabo' => date('Y-m-d H:i:s'),
                'date_fin_assoc_client_collabo' => null,
                'created_at_assoc_client_collabo' => date('Y-m-d H:i:s'),
                'updated_at_assoc_client_collabo' => date('Y-m-d H:i:s'),
                'id_client' => $id_client,
                'id_collaborateur' => $id_collaborateur
            ],
            $db
        );

        // update
        $update = update(
            'client',
            ['prise_en_charge_client' => 'oui'],
            "id_client = '$id_client'",
            $db
        );

        if ($insert && $update) {
            $output = array(
                'success' => true,
                'message' => "Le dossier <b>{$result2['nom_utilisateur']}</b> a été attribué à <b>{$result1['prenom_utilisateur']} {$result1['nom_utilisateur']}</b> !"
            );
        }
    }

    // espace client
    if ($_POST['action'] == 'fetch_page_client') {
        $id_client = $_SESSION['id_view_client'];

        // Récupérer les informations de la base de données
        $query = "SELECT * FROM utilisateur, compte, client WHERE utilisateur.id_utilisateur = compte.id_utilisateur
        AND utilisateur.id_utilisateur = client.id_utilisateur AND id_client = $id_client ";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();

        foreach ($result as $row) {

            $id_utilisateur = $row['id_utilisateur'];
            $avatar_client = <<<HTML
                <img src="assets/media/avatars/{$row['avatar_utilisateur']}" alt="image">
            HTML;
            $nom_client = $row['nom_utilisateur'];
            $prenom_client = $row['prenom_utilisateur'];
            $email_client = $row['email_utilisateur'];
            $code_client = $row['code_client'];
            $date_naiss_client = si_funct1($row['date_naiss_utilisateur'], date('d-m-Y', strtotime($row['date_naiss_utilisateur'])), '--');
            $tel_client = $row['tel_utilisateur'];
            $adresse_client = $row['adresse_utilisateur'];

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
                                        <a href="" class="desactiver_compte menu-link px-3" data-id_client="{$id_client}">Désactiver ce compte</a>
                                    </div>
                                    <!--end::Menu item-->
                                    
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="" class="attribuer_collabo menu-link px-3" data-bs-toggle="modal" data-bs-target="#attribuer_modal" data-id_client="{$id_client}">Attribuer un dossier</a>
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
                'nom_prenom_client' => $nom_client . ' ' . $prenom_client,
                'email_client' => $email_client,
                'code_client' => $code_client,
                'date_naiss_client' => $date_naiss_client,
                'tel_client' => $tel_client,
                'adresse_client' => $adresse_client,
                'statut_client' => $statut_client_html,
                'action_client' => $action_client,
            );
        }
    }

    if ($_POST['action'] == 'retirer_dossier') {
        $id_client = $_POST['id_client'];
        $id_client = $_POST['id_client'];

        $update1 = update(
            'assoc_client_collabo',
            [
                'statut_assoc_client_collabo' => 'inactif',
                'date_fin_assoc_client_collabo' => date('Y-m-d H:i:s'),
                'updated_at_assoc_client_collabo' => date('Y-m-d H:i:s')
            ],
            "id_client = $id_client AND role_assoc_client_collabo = 'cm' AND id_client = $id_client",
            $db
        );

        $update2 = update(
            'client',
            [
                'prise_en_charge_client' => 'non',
            ],
            "id_client = $id_client",
            $db
        );

        if ($update1 && $update2) {
            $output = array(
                'success' => true,
                'message' => 'Le dossier a été retiré !',
            );
        } else {
            $output = array(
                'success' => false,
                'message' => 'Une erreur s\'est produite !',
            );
        }
    }

    if ($_POST['action'] == 'detail_dossier') {

        $id_client = $_POST['id_client'];

        $query = "SELECT * FROM utilisateur, client WHERE utilisateur.id_utilisateur = client.id_utilisateur AND client.id_client = $id_client";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        $output = [
            'nom_client' => $result['nom_utilisateur'],
            'matricule_client' => $result['matricule_client'],
            'tel_client' => $result['tel_utilisateur'],
            'email_client' => $result['email_utilisateur'],
            'adresse_client' => $result['adresse_utilisateur'],
        ];
    }
}



echo json_encode($output);
