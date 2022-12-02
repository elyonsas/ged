<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions-sql.php');

connected('ag');

$output = '';

if (isset($_POST['datatable'])) {

    if ($_POST['datatable'] == 'all_collabo') {

        $output = array();
        $query = '';

        $query .= "SELECT * FROM utilisateur, compte, collaborateur WHERE utilisateur.id_utilisateur = compte.id_utilisateur 
        AND utilisateur.id_utilisateur = collaborateur.id_utilisateur AND statut_compte <> 'supprime' ORDER BY statut_compte ASC";


        // // pour la recherche
        // if (isset($_POST["search"]["value"])) {
        //     $query .= 'AND (nom_utilisateur LIKE "%' . $_POST["search"]["value"] . '%" ';
        //     $query .= 'OR prenom_utilisateur LIKE "%'. $_POST["search"]["value"] .'%" ';
        //     $query .= 'OR titre_article LIKE "%' . $_POST["search"]["value"] . '%" ';
        //     $query .= 'OR created_at_article LIKE "%' . $_POST["search"]["value"] . '%" ';
        //     $query .= 'OR date_valide_article LIKE "%' . $_POST["search"]["value"] . '%" ';
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

            $id_collaborateur = $row['id_collaborateur'];
            $nom = $row['nom_utilisateur'];
            $prenom = $row['prenom_utilisateur'];
            $email = $row['email_utilisateur'];
            $telephone = $row['tel_utilisateur'];

            $statut_compte = $row['statut_compte'];

            $dossiers = select_all_actifs_dossiers_collabo($id_collaborateur, $db);

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

            // Collaborateur
            $sub_array[] = <<<HTML
                <div class="d-flex flex-column justify-content-center">
                    <a data-sorting="{$prenom} {$nom}" href="roll/ag/view_redirect/?action=view_collaborateur&id_view_collaborateur={$id_collaborateur}" 
                    class="fs-6 text-gray-800 text-hover-primary">$prenom $nom</a>
                </div>
            HTML;

            // email
            $sub_array[] = <<<HTML
                $email
            HTML;

            // Telephone
            $sub_array[] = <<<HTML
                $telephone
            HTML;

            // dossiers
            $sub_array[] = <<<HTML
                <td>
                    <div class="text-dark fw-bold d-block fs-6">$dossiers</div>
                    <span class="text-muted fw-semibold text-muted d-block fs-7">dossiers</span>
                </td>
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
                            
                                <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <i class="bi bi-three-dots fs-3"></i>
                                </button>
                                <!--begin::Menu 3-->
                                <div class="drop_action menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="" class="desactiver_compte menu-link px-3" data-id_collaborateur="{$id_collaborateur}">Désactiver ce compte</a>
                                    </div>
                                    <!--end::Menu item-->
                                    
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="" class="attribuer_dossier menu-link px-3" data-bs-toggle="modal" data-bs-target="#attribuer_modal" data-id_collaborateur="{$id_collaborateur}">Attribuer un dossier</a>
                                    </div>
                                    <!--end::Menu item-->

                                    <!--begin::Menu separator-->
                                    <!-- <div class="separator mt-3 opacity-75"></div> -->
                                    <!--end::Menu separator-->

                                    <!--begin::Menu item-->
                                    <!-- <div class="menu-item">
                                        <div class="menu-content px-3 py-3">
                                            <a href="" class="supprimer_definitivement btn btn-light-danger px-4 w-100" data-id_collaborateur="{$id_collaborateur}">Supprimer définitivement</a>
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

                                <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <i class="bi bi-three-dots fs-3"></i>
                                </button>
                                <!--begin::Menu 3-->
                                <div class="drop_action menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="" class="activer_compte menu-link px-3" data-id_collaborateur="{$id_collaborateur}">Activer ce compte</a>
                                    </div>
                                    <!--end::Menu item-->

                                    <!--begin::Menu separator-->
                                    <!-- <div class="separator mt-3 opacity-75"></div> -->
                                    <!--end::Menu separator-->

                                    <!--begin::Menu item-->
                                    <!-- <div class="menu-item">
                                        <div class="menu-content px-3 py-3">
                                            <a href="" class="supprimer_definitivement btn btn-light-danger px-4 w-100" data-id_collaborateur="{$id_collaborateur}">Supprimer définitivement</a>
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
            $statement = $db->prepare("SELECT * FROM utilisateur, compte, collaborateur WHERE utilisateur.id_utilisateur = compte.id_utilisateur 
            AND utilisateur.id_utilisateur = collaborateur.id_utilisateur ORDER BY statut_compte ASC"); // same query as above
            $statement->execute();
            return $statement->rowCount();
        }


        $output = array(
            "recordsTotal"      =>  $filtered_rows,
            "recordsFiltered"     =>     get_total_all_records($db),
            "data"                =>    $data
        );
    }

    if ($_POST['datatable'] == 'dossiers_collabo') {

        $id_collaborateur = $_SESSION['id_view_collaborateur'];

        $query = "SELECT * FROM assoc_client_collabo, client, collaborateur, utilisateur 
        WHERE assoc_client_collabo.id_client = client.id_client AND assoc_client_collabo.id_collaborateur = collaborateur.id_collaborateur 
        AND utilisateur.id_utilisateur = client.id_utilisateur AND collaborateur.id_collaborateur = $id_collaborateur 
        AND statut_assoc_client_collabo = 'actif' ORDER BY updated_at_assoc_client_collabo DESC";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();

        $data = array();
        $filtered_rows = $statement->rowCount();

        $i = 1;
        foreach ($result as $row) {

            $sub_array = array();

            $id_client = $row['id_client'];
            $nom_client = $row['nom_utilisateur'];
            $matricule_client = $row['matricule_client'];
            $email_client = $row['email_utilisateur'];
            $telephone_client = $row['tel_utilisateur'];
            $role_client = $row['role_assoc_client_collabo'];

            // #
            $sub_array[] = $i;

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

            // Rôle
            switch ($role_client) {
                case 'ag':
                    $role_client = 'Associé Gérant';
                    break;

                case 'dd':
                    $role_client = 'Directeur de département';
                    break;

                case 'dm':
                    $role_client = 'Directeur de mission';
                    break;

                case 'cm':
                    $role_client = 'Chef de mission';
                    break;

                case 'am':
                    $role_client = 'Assistant mission';
                    break;

                case 'stg':
                    $role_client = 'Stagiaire';
                    break;
            }

            $sub_array[] = <<<HTML
                $role_client
            HTML;

            // Actions
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
                                <a href="" class="detail_dossier menu-link px-3" data-bs-toggle="modal" data-bs-target="#detail_dossier_modal" data-id_client="{$id_client}">Details</a>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="" class="retirer_dossier menu-link text-hover-danger px-3" data-id_client="{$id_client}" data-id_collaborateur="{$id_collaborateur}">Retirer ce dossier</a>
                            </div>
                            <!--end::Menu item-->

                            <!--begin::Menu separator-->
                            <!-- <div class="separator mt-3 opacity-75"></div> -->
                            <!--end::Menu separator-->

                            <!--begin::Menu item-->
                            <!-- <div class="menu-item">
                                <div class="menu-content px-3 py-3">
                                    <a href="" class="supprimer_definitivement btn btn-light-danger px-4 w-100" data-id_collaborateur="{$id_collaborateur}">Supprimer définitivement</a>
                                </div>
                            </div> -->
                            <!--end::Menu item-->
                        </div>
                        <!--end::Menu 3-->
                    </div>
                </td>

            HTML;
            $sub_array[] = $action;

            $data[] = $sub_array;
            $i++;
        }


        $output = $data;
    }
}

if (isset($_POST['action'])) {

    // espace datatables
    if ($_POST['action'] == 'activer_compte') {
        $id_collaborateur = $_POST['id_collaborateur'];

        $query = "SELECT * FROM utilisateur, compte, collaborateur WHERE utilisateur.id_utilisateur = compte.id_utilisateur 
        AND utilisateur.id_utilisateur = collaborateur.id_utilisateur AND collaborateur.id_collaborateur = '$id_collaborateur'";

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
        $id_collaborateur = $_POST['id_collaborateur'];

        $query = "SELECT * FROM utilisateur, compte, collaborateur WHERE utilisateur.id_utilisateur = compte.id_utilisateur 
        AND utilisateur.id_utilisateur = collaborateur.id_utilisateur AND collaborateur.id_collaborateur = '$id_collaborateur'";

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
            "id_collaborateur = $id_collaborateur AND role_assoc_client_collabo = 'cm'",
            $db
        );

        $query = "SELECT * FROM assoc_client_collabo WHERE id_collaborateur = '$id_collaborateur'";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();

        $update3 = true;
        foreach ($result as $row) {
            if ($id_collaborateur == $row['id_collaborateur']) {
                $update3 = update(
                    'client',
                    [
                        'prise_en_charge_client' => 'non',
                    ],
                    "id_client = '" . $row['id_client'] . "'",
                    $db
                );
            }
        }


        if ($update1 && $update2 && $update3) {
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

    if ($_POST['action'] == 'fetch_attribuer_dossier') {

        $id_collaborateur = $_POST['id_collaborateur'];

        // Récupérer les infos du collaborateur
        $query = "SELECT * FROM utilisateur, compte, collaborateur WHERE utilisateur.id_utilisateur = compte.id_utilisateur 
        AND utilisateur.id_utilisateur = collaborateur.id_utilisateur AND collaborateur.id_collaborateur = '$id_collaborateur'";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        $output = [
            'success' => true,
            'id_collaborateur' => $result['id_collaborateur'],
            'nom_collaborateur' => $result['prenom_utilisateur'] . ' ' . $result['nom_utilisateur'],
            'code_collaborateur' => $result['code_collaborateur'],
            'dossier_html' => ''
        ];

        if ($result) {
            $query = "SELECT * FROM utilisateur, compte, client WHERE utilisateur.id_utilisateur = compte.id_utilisateur
            AND utilisateur.id_utilisateur = client.id_utilisateur AND prise_en_charge_client = 'non' AND statut_compte = 'actif'";
            $statement = $db->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll();

            $output['dossier_html'] .= '<option></option>';
            foreach ($result as $row) {
                $output['dossier_html'] .= <<<HTML
                    <option value="{$row['id_client']}">Client {$row['matricule_client']} : {$row['nom_utilisateur']}</option>
                HTML;
            }
        }
    }

    if ($_POST['action'] == 'edit_attribuer_dossier') {

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

    // espace collaborateur
    if ($_POST['action'] == 'fetch_page_collaborateur') {
        $id_collaborateur = $_SESSION['id_view_collaborateur'];

        // Récupérer les informations de la base de données
        $query = "SELECT * FROM utilisateur, compte, collaborateur WHERE utilisateur.id_utilisateur = compte.id_utilisateur
        AND utilisateur.id_utilisateur = collaborateur.id_utilisateur AND id_collaborateur = $id_collaborateur ";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();

        foreach ($result as $row) {

            $id_utilisateur = $row['id_utilisateur'];
            $avatar_collaborateur = <<<HTML
                <img src="assets/media/avatars/{$row['avatar_utilisateur']}" alt="image">
            HTML;
            $nom_collaborateur = $row['nom_utilisateur'];
            $prenom_collaborateur = $row['prenom_utilisateur'];
            $email_collaborateur = $row['email_utilisateur'];
            $code_collaborateur = $row['code_collaborateur'];
            $date_naiss_collaborateur = si_funct1($row['date_naiss_utilisateur'], date('d-m-Y', strtotime($row['date_naiss_utilisateur'])), '--');
            $tel_collaborateur = $row['tel_utilisateur'];
            $adresse_collaborateur = $row['adresse_utilisateur'];

            $statut_collaborateur = $row['statut_compte'];
            switch ($statut_collaborateur) {
                case 'actif':
                    $statut_collaborateur_html = <<<HTML
                        <span class="badge badge-light-success">Actif</span>
                    HTML;
                    break;
                case 'inactif':
                    $statut_collaborateur_html = <<<HTML
                        <span class="badge badge-light-danger">Inactif</span>
                    HTML;
                    break;
            }

            $action_collaborateur = '';
            switch ($statut_collaborateur) {
                case 'actif':
                    $action_collaborateur = <<<HTML

                        <td>
                            <div class="d-flex justify-content-end flex-shrink-0">
                            
                                <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <i class="bi bi-three-dots fs-3"></i>
                                </button>
                                <!--begin::Menu 3-->
                                <div class="drop_action menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="" class="desactiver_compte menu-link px-3" data-id_collaborateur="{$id_collaborateur}">Désactiver ce compte</a>
                                    </div>
                                    <!--end::Menu item-->
                                    
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="" class="attribuer_dossier menu-link px-3" data-bs-toggle="modal" data-bs-target="#attribuer_modal" data-id_collaborateur="{$id_collaborateur}">Attribuer un dossier</a>
                                    </div>
                                    <!--end::Menu item-->

                                    <!--begin::Menu separator-->
                                    <!-- <div class="separator mt-3 opacity-75"></div> -->
                                    <!--end::Menu separator-->

                                    <!--begin::Menu item-->
                                    <!-- <div class="menu-item">
                                        <div class="menu-content px-3 py-3">
                                            <a href="" class="supprimer_definitivement btn btn-light-danger px-4 w-100" data-id_collaborateur="{$id_collaborateur}">Supprimer définitivement</a>
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
                    $action_collaborateur = <<<HTML

                        <td>
                            <div class="d-flex justify-content-end flex-shrink-0">

                                <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <i class="bi bi-three-dots fs-3"></i>
                                </button>
                                <!--begin::Menu 3-->
                                <div class="drop_action menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="" class="activer_compte menu-link px-3" data-id_collaborateur="{$id_collaborateur}">Activer ce compte</a>
                                    </div>
                                    <!--end::Menu item-->

                                    <!--begin::Menu separator-->
                                    <!-- <div class="separator mt-3 opacity-75"></div> -->
                                    <!--end::Menu separator-->

                                    <!--begin::Menu item-->
                                    <!-- <div class="menu-item">
                                        <div class="menu-content px-3 py-3">
                                            <a href="" class="supprimer_definitivement btn btn-light-danger px-4 w-100" data-id_collaborateur="{$id_collaborateur}">Supprimer définitivement</a>
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

            $role_collaborateur = $row['type_compte'];
            switch ($role_collaborateur) {
                case 'ag':
                    $role_collaborateur = 'Associé Gérant';
                    break;

                case 'dd':
                    $role_collaborateur = 'Directeur de département';
                    break;

                case 'dm':
                    $role_collaborateur = 'Directeur de mission';
                    break;

                case 'cm':
                    $role_collaborateur = 'Chef de mission';
                    break;

                case 'am':
                    $role_collaborateur = 'Assistant mission';
                    break;

                case 'stg':
                    $role_collaborateur = 'Stagiaire';
                    break;
            }

            $output = array(
                'avatar_collaborateur' => $avatar_collaborateur,
                'nom_prenom_collaborateur' => $nom_collaborateur . ' ' . $prenom_collaborateur,
                'email_collaborateur' => $email_collaborateur,
                'role_collaborateur' => $role_collaborateur,
                'code_collaborateur' => $code_collaborateur,
                'date_naiss_collaborateur' => $date_naiss_collaborateur,
                'tel_collaborateur' => $tel_collaborateur,
                'adresse_collaborateur' => $adresse_collaborateur,
                'statut_collaborateur' => $statut_collaborateur_html,
                'action_collaborateur' => $action_collaborateur,
            );
        }
    }

    if ($_POST['action'] == 'retirer_dossier') {
        $id_collaborateur = $_POST['id_collaborateur'];
        $id_client = $_POST['id_client'];

        $update1 = update(
            'assoc_client_collabo',
            [
                'statut_assoc_client_collabo' => 'inactif',
                'date_fin_assoc_client_collabo' => date('Y-m-d H:i:s'),
                'updated_at_assoc_client_collabo' => date('Y-m-d H:i:s')
            ],
            "id_collaborateur = $id_collaborateur AND role_assoc_client_collabo = 'cm' AND id_client = $id_client",
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
