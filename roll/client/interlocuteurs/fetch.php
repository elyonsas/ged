<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions-sql.php');

connected('client');

$output = '';

if (isset($_POST['datatable'])) {

    if ($_POST['datatable'] == 'all_interlo') {

        $output = array();
        $query = '';

        $query .= "SELECT * FROM interlocuteur, utilisateur, compte 
        WHERE utilisateur.id_utilisateur = compte.id_utilisateur AND utilisateur.id_utilisateur = interlocuteur.id_utilisateur 
        AND statut_compte <> 'supprime' ORDER BY statut_compte ASC";

        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();

        $data = array();

        $id_client = select_info('id_client', 'client', "id_utilisateur = {$_SESSION['id_utilisateur']}", $db);

        foreach ($result as $row) {

            if (is_client_interlocuteur($id_client, $row['id_interlocuteur'], $db)) {
                $sub_array = array();

                $id_interlocuteur = $row['id_interlocuteur'];
                $nom = $row['nom_utilisateur'];
                $prenom = $row['prenom_utilisateur'];
                $email = $row['email_utilisateur'];
                $telephone = $row['tel_utilisateur'];

                $statut_compte = $row['statut_compte'];

                $fonction = $row['fonction_interlocuteur'];

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

                // interlocuteur
                $sub_array[] = <<<HTML
                    <div class="d-flex flex-column justify-content-center">
                        <div data-sorting="{$prenom} {$nom}" class="fs-6 text-gray-800">$prenom $nom</div>
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

                // fonction
                $sub_array[] = <<<HTML
                    <td>
                        <div class="text-dark fw-bold d-block fs-6">$fonction</div>
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
                                            <a href="" class="edit_interlocuteur menu-link px-3" data-bs-toggle="modal" data-bs-target="#edit_interlocuteur_modal" data-id_interlocuteur="{$id_interlocuteur}">Modifier interlocuteur</a>
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="" class="desactiver_compte menu-link px-3" data-id_interlocuteur="{$id_interlocuteur}">Désactiver ce compte</a>
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="" class="supprimer_compte menu-link px-3 text-hover-danger" data-id_interlocuteur="{$id_interlocuteur}">Supprimer ce compte</a>
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu separator-->
                                        <!-- <div class="separator mt-3 opacity-75"></div> -->
                                        <!--end::Menu separator-->

                                        <!--begin::Menu item-->
                                        <!-- <div class="menu-item">
                                            <div class="menu-content px-3 py-3">
                                                <a href="" class="supprimer_definitivement btn btn-light-danger px-4 w-100" data-id_interlocuteur="{$id_interlocuteur}">Supprimer définitivement</a>
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
                                            <a href="" class="activer_compte menu-link px-3" data-id_interlocuteur="{$id_interlocuteur}">Activer ce compte</a>
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="" class="supprimer_compte menu-link px-3 text-hover-danger" data-id_interlocuteur="{$id_interlocuteur}">Supprimer ce compte</a>
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu separator-->
                                        <!-- <div class="separator mt-3 opacity-75"></div> -->
                                        <!--end::Menu separator-->

                                        <!--begin::Menu item-->
                                        <!-- <div class="menu-item">
                                            <div class="menu-content px-3 py-3">
                                                <a href="" class="supprimer_definitivement btn btn-light-danger px-4 w-100" data-id_interlocuteur="{$id_interlocuteur}">Supprimer définitivement</a>
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
        }


        $output = array(
            "data"                =>    $data
        );
    }
}

if (isset($_POST['action'])) {

    if ($_POST['action'] == 'activer_compte') {
        $id_interlocuteur = $_POST['id_interlocuteur'];
        $id_client = select_info('id_client', 'client', "id_utilisateur = {$_SESSION['id_utilisateur']}", $db);

        $query = "SELECT * FROM utilisateur, compte, interlocuteur WHERE utilisateur.id_utilisateur = compte.id_utilisateur 
        AND utilisateur.id_utilisateur = interlocuteur.id_utilisateur AND interlocuteur.id_interlocuteur = '$id_interlocuteur'";

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

        $insert = insert(
            'assoc_client_interlo',
            [
                'statut_assoc_client_interlo' => 'actif',
                'date_debut_assoc_client_interlo' => date('Y-m-d H:i:s'),
                'created_at_assoc_client_interlo' => date('Y-m-d H:i:s'),
                'updated_at_assoc_client_interlo' => date('Y-m-d H:i:s'),
                'id_client' => $id_client,
                'id_interlocuteur' => $id_interlocuteur
            ],
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
        $id_interlocuteur = $_POST['id_interlocuteur'];

        $query = "SELECT * FROM utilisateur, compte, interlocuteur WHERE utilisateur.id_utilisateur = compte.id_utilisateur 
        AND utilisateur.id_utilisateur = interlocuteur.id_utilisateur AND interlocuteur.id_interlocuteur = '$id_interlocuteur'";

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
            'assoc_client_interlo',
            [
                'statut_assoc_client_interlo' => 'inactif',
                'date_fin_assoc_client_interlo' => date('Y-m-d H:i:s'),
                'updated_at_assoc_client_interlo' => date('Y-m-d H:i:s')
            ],
            "id_interlocuteur = $id_interlocuteur AND statut_assoc_client_interlo = 'actif'",
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
    if ($_POST['action'] == 'supprimer_compte') {
        $id_interlocuteur = $_POST['id_interlocuteur'];

        $query = "SELECT * FROM utilisateur, compte, interlocuteur WHERE utilisateur.id_utilisateur = compte.id_utilisateur 
        AND utilisateur.id_utilisateur = interlocuteur.id_utilisateur AND interlocuteur.id_interlocuteur = '$id_interlocuteur'";

        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        $id_utilisateur = $result['id_utilisateur'];
        $statut_compte = $result['statut_compte'];

        $update1 = update(
            'compte',
            ['statut_compte' => 'supprime'],
            "id_utilisateur = '$id_utilisateur'",
            $db
        );

        $update2 = update(
            'assoc_client_interlo',
            [
                'statut_assoc_client_interlo' => 'inactif',
                'date_fin_assoc_client_interlo' => date('Y-m-d H:i:s'),
                'updated_at_assoc_client_interlo' => date('Y-m-d H:i:s')
            ],
            "id_interlocuteur = $id_interlocuteur AND statut_assoc_client_interlo = 'actif'",
            $db
        );


        if ($update1 && $update2) {
            $output = array(
                'success' => true,
                'message' => 'Compte supprimé !'
            );
        } else {
            $output = array(
                'success' => false,
                'message' => 'Une erreur s\'est produite !'
            );
        }
    }

    if ($_POST['action'] == 'add_interlocuteur') {

        // Si le compte existe déjà alors exit
        if (compte_exists($_POST['email_interlocuteur'], $db)) {
            $output = [
                'success' => false,
                'message' => 'Cet email existe déjà dans GED !'
            ];
            
            echo json_encode($output);
            exit();
            
        }
            
        $insert1 = insert(
            'utilisateur',
            [
                'nom_utilisateur' => $_POST['nom_interlocuteur'],
                'prenom_utilisateur' => $_POST['prenom_interlocuteur'],
                'tel_utilisateur' => $_POST['tel_interlocuteur'],
                'email_utilisateur' => $_POST['email_interlocuteur'],
                'created_at_utilisateur' => date('Y-m-d H:i:s'),
                'updated_at_utilisateur' => date('Y-m-d H:i:s'),
            ],
            $db
        );

        $id_utilisateur = $db->lastInsertId();

        $insert2 = insert(
            'compte',
            [
                'pseudo_compte' => $_POST['nom_interlocuteur'],
                'email_compte' => $_POST['email_interlocuteur'],
                'statut_compte' => 'actif',
                'type_compte' => 'interlocuteur',
                'created_at_compte' => date('Y-m-d H:i:s'),
                'updated_at_compte' => date('Y-m-d H:i:s'),
                'id_utilisateur' => $id_utilisateur,
            ],
            $db
        );

        $insert3 = false;
        $update = false;
        if ($insert1 && $insert2) {
            $insert3 = insert(
                'interlocuteur',
                [
                    'fonction_interlocuteur' => $_POST['fonction_interlocuteur'],
                    'id_utilisateur' => $id_utilisateur,
                ],
                $db
            );

            $id_interlocuteur = $db->lastInsertId();

            $update = update(
                'interlocuteur',
                [
                    'code_interlocuteur' => 15000 + $id_interlocuteur,
                ],
                "id_interlocuteur = $id_interlocuteur",
                $db
            );
        }
        $id_client = select_info('id_client', 'client', "id_utilisateur = {$_SESSION['id_utilisateur']}", $db);
        $insert4 = insert(
            'assoc_client_interlo',
            [
                'statut_assoc_client_interlo' => 'actif',
                'date_debut_assoc_client_interlo' => date('Y-m-d H:i:s'),
                'created_at_assoc_client_interlo' => date('Y-m-d H:i:s'),
                'updated_at_assoc_client_interlo' => date('Y-m-d H:i:s'),
                'id_client' => $id_client,
                'id_interlocuteur' => $id_interlocuteur,
            ],
            $db
        );

        if ($insert1 && $insert2 && $insert3 && $insert4 && $update) {
            $output = array(
                'success' => true,
                'message' => 'Un interlocuteur ajouté avec succès'
            );
        } else {
            $output = array(
                'success' => false,
                'message' => 'Une erreur s\'est produite'
            );
        }
    }
    if ($_POST['action'] == 'fetch_edit_interlocuteur') {
        $id_interlocuteur = $_POST['id_interlocuteur'];

        $query = "SELECT * FROM utilisateur, compte, interlocuteur WHERE utilisateur.id_utilisateur = compte.id_utilisateur 
        AND utilisateur.id_utilisateur = interlocuteur.id_utilisateur
        AND interlocuteur.id_interlocuteur = $id_interlocuteur";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        $output = $result;
    }
    if ($_POST['action'] == 'edit_interlocuteur'){

        $id_interlocuteur = $_POST['id_interlocuteur'];
        $id_utilisateur = select_info('id_utilisateur', 'interlocuteur', "id_interlocuteur = $id_interlocuteur", $db);

        $update1 = update(
            'utilisateur',
            [
                'nom_utilisateur' => $_POST['nom_interlocuteur'],
                'prenom_utilisateur' => $_POST['prenom_interlocuteur'],
                'tel_utilisateur' => $_POST['tel_interlocuteur'],
                'email_utilisateur' => $_POST['email_interlocuteur'],
                'updated_at_utilisateur' => date('Y-m-d H:i:s'),
            ],
            "id_utilisateur = $id_utilisateur",
            $db
        );

        $update2 = update(
            'interlocuteur',
            [
                'fonction_interlocuteur' => $_POST['fonction_interlocuteur'],
            ],
            "id_interlocuteur = $id_interlocuteur",
            $db
        );

        if ($update1 && $update2) {
            $output = array(
                'success' => true,
                'message' => 'Interlocuteur modifié !'
            );
        } else {
            $output = array(
                'success' => false,
                'message' => 'Une erreur s\'est produite !'
            );
        }


    }

}



echo json_encode($output);
