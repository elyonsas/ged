<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions-sql.php');

connected('cm');

$output = '';

if (isset($_POST['datatable'])) {

    if ($_POST['datatable'] == 'all_dossiers') {

        $output = array();

        if (isset($_SESSION['data_client_saisie']) && $_POST['data_client'] != '') {
            $result = $_SESSION['data_client_saisie'];
        } else {
            $query = "SELECT * FROM utilisateur, compte, client WHERE utilisateur.id_utilisateur = compte.id_utilisateur 
            AND utilisateur.id_utilisateur = client.id_utilisateur AND statut_compte <> 'supprime' AND statut_compte <> 'inactif' ORDER BY statut_compte ASC";
            $statement = $db->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll();
        }

        $data = array();

        foreach ($result as $row) {

            $sub_array = array();

            $id_client = $row['id_client'];
            $nom_client = $row['nom_utilisateur'];
            $matricule_client = $row['matricule_client'];

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

            $statut_compte = $row['statut_compte'];
            // dump($statut_compte);
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
                    <a href="roll/cm/view_redirect/?action=view_saisie_client&id_view_saisie_client={$id_client}" 
                    class="fs-6 text-gray-800 text-hover-primary">$nom_client</a>
                </div>
            HTML;

            // Matricule
            $sub_array[] = <<<HTML
                $matricule_client
            HTML;

            // Statut
            $sub_array[] = <<<HTML
                $statut_compte_html
            HTML;

            $data[] = $sub_array;
        }

        $output = array(
            "data" => $data
        );
    }

    if ($_POST['datatable'] == 'saisies_clients') {

        $id_client = $_SESSION['id_view_saisie_client'];

        $annee_saisie = $_POST['annee_saisie'];
        $annee_saisie_query = "AND annee = '$annee_saisie'";

        $query = "SELECT * FROM saisie, client WHERE saisie.id_client = client.id_client 
        AND saisie.id_client = $id_client $annee_saisie_query ORDER BY created_at ASC";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();

        $data = array();
        $filtered_rows = $statement->rowCount();

        foreach ($result as $row) {

            $sub_array = array();

            $id_client = $row['id_client'];
            $id_saisie = $row['id_saisie'];
            $rubrique = $row['rubrique'];
            $janv_c = ($row['janv_c'] == '') ? '&nbsp;' : $row['janv_c'];
            $janv_i = ($row['janv_i'] == '') ? '&nbsp;' : $row['janv_i'];
            $janv_s = ($row['janv_s'] == '') ? '&nbsp;' : $row['janv_s'];
            $fevr_c = ($row['fevr_c'] == '') ? '&nbsp;' : $row['fevr_c'];
            $fevr_i = ($row['fevr_i'] == '') ? '&nbsp;' : $row['fevr_i'];
            $fevr_s = ($row['fevr_s'] == '') ? '&nbsp;' : $row['fevr_s'];
            $mars_c = ($row['mars_c'] == '') ? '&nbsp;' : $row['mars_c'];
            $mars_i = ($row['mars_i'] == '') ? '&nbsp;' : $row['mars_i'];
            $mars_s = ($row['mars_s'] == '') ? '&nbsp;' : $row['mars_s'];
            $avr_c = ($row['avr_c'] == '') ? '&nbsp;' : $row['avr_c'];
            $avr_i = ($row['avr_i'] == '') ? '&nbsp;' : $row['avr_i'];
            $avr_s = ($row['avr_s'] == '') ? '&nbsp;' : $row['avr_s'];
            $mai_c = ($row['mai_c'] == '') ? '&nbsp;' : $row['mai_c'];
            $mai_i = ($row['mai_i'] == '') ? '&nbsp;' : $row['mai_i'];
            $mai_s = ($row['mai_s'] == '') ? '&nbsp;' : $row['mai_s'];
            $juin_c = ($row['juin_c'] == '') ? '&nbsp;' : $row['juin_c'];
            $juin_i = ($row['juin_i'] == '') ? '&nbsp;' : $row['juin_i'];
            $juin_s = ($row['juin_s'] == '') ? '&nbsp;' : $row['juin_s'];
            $juil_c = ($row['juil_c'] == '') ? '&nbsp;' : $row['juil_c'];
            $juil_i = ($row['juil_i'] == '') ? '&nbsp;' : $row['juil_i'];
            $juil_s = ($row['juil_s'] == '') ? '&nbsp;' : $row['juil_s'];
            $aout_c = ($row['aout_c'] == '') ? '&nbsp;' : $row['aout_c'];
            $aout_i = ($row['aout_i'] == '') ? '&nbsp;' : $row['aout_i'];
            $aout_s = ($row['aout_s'] == '') ? '&nbsp;' : $row['aout_s'];
            $sept_c = ($row['sept_c'] == '') ? '&nbsp;' : $row['sept_c'];
            $sept_i = ($row['sept_i'] == '') ? '&nbsp;' : $row['sept_i'];
            $sept_s = ($row['sept_s'] == '') ? '&nbsp;' : $row['sept_s'];
            $oct_c = ($row['oct_c'] == '') ? '&nbsp;' : $row['oct_c'];
            $oct_i = ($row['oct_i'] == '') ? '&nbsp;' : $row['oct_i'];
            $oct_s = ($row['oct_s'] == '') ? '&nbsp;' : $row['oct_s'];
            $nov_c = ($row['nov_c'] == '') ? '&nbsp;' : $row['nov_c'];
            $nov_i = ($row['nov_i'] == '') ? '&nbsp;' : $row['nov_i'];
            $nov_s = ($row['nov_s'] == '') ? '&nbsp;' : $row['nov_s'];
            $dec_c = ($row['dec_c'] == '') ? '&nbsp;' : $row['dec_c'];
            $dec_i = ($row['dec_i'] == '') ? '&nbsp;' : $row['dec_i'];
            $dec_s = ($row['dec_s'] == '') ? '&nbsp;' : $row['dec_s'];

            // Rubrique
            $sub_array[] = <<<HTML
                $rubrique
            HTML;

            //janv_c
            $sub_array[] = <<<HTML
                <td>$janv_c
                    <!--begin::Radio group-->
                    <div class="tooltip-saisie btn-group" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button]">
                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="janv_c" class="btn-check" type="radio" name="method" value="X"/>
                            <!--end::Input-->
                            X
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="janv_c" class="btn-check" type="radio" name="method" value="N/A"/>
                            <!--end::Input-->
                            N/A
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="janv_c" class="btn-check" type="radio" name="method" value=""/>
                            <!--end::Input-->
                        </label>
                        <!--end::Radio-->
                    </div>
                    <!--end::Radio group-->
                </td>
            HTML;

            //janv_i
            $sub_array[] = <<<HTML
                <td>$janv_i
                    <!--begin::Radio group-->
                    <div class="tooltip-saisie btn-group" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button]">
                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="janv_i" class="btn-check" type="radio" name="method" value="X"/>
                            <!--end::Input-->
                            X
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="janv_i" class="btn-check" type="radio" name="method" value="N/A"/>
                            <!--end::Input-->
                            N/A
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="janv_i" class="btn-check" type="radio" name="method" value="" />
                            <!--end::Input-->
                        </label>
                        <!--end::Radio-->
                    </div>
                    <!--end::Radio group-->
                </td>
            HTML;

            //janv_s
            $sub_array[] = <<<HTML
                <td>$janv_s
                    <!--begin::Radio group-->
                    <div class="tooltip-saisie btn-group" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button]">
                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="janv_s" class="btn-check" type="radio" name="method" value="X"/>
                            <!--end::Input-->
                            X
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="janv_s" class="btn-check" type="radio" name="method" value="N/A"/>
                            <!--end::Input-->
                            N/A
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="janv_s" class="btn-check" type="radio" name="method" value="" />
                            <!--end::Input-->
                        </label>
                        <!--end::Radio-->
                    </div>
                    <!--end::Radio group-->
                </td>
            HTML;

            //fevr_c
            $sub_array[] = <<<HTML
                <td>$fevr_c
                    <!--begin::Radio group-->
                    <div class="tooltip-saisie btn-group" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button]">
                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="fevr_c" class="btn-check" type="radio" name="method" value="X"/>
                            <!--end::Input-->
                            X
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="fevr_c" class="btn-check" type="radio" name="method" value="N/A"/>
                            <!--end::Input-->
                            N/A
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="fevr_c" class="btn-check" type="radio" name="method" value="" />
                            <!--end::Input-->
                        </label>
                        <!--end::Radio-->
                    </div>
                    <!--end::Radio group-->
                </td>
            HTML;

            //fevr_i
            $sub_array[] = <<<HTML
                <td>$fevr_i
                    <!--begin::Radio group-->
                    <div class="tooltip-saisie btn-group" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button]">
                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="fevr_i" class="btn-check" type="radio" name="method" value="X"/>
                            <!--end::Input-->
                            X
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="fevr_i" class="btn-check" type="radio" name="method" value="N/A"/>
                            <!--end::Input-->
                            N/A
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="fevr_i" class="btn-check" type="radio" name="method" value="" />
                            <!--end::Input-->
                        </label>
                        <!--end::Radio-->
                    </div>
                    <!--end::Radio group-->
                </td>
            HTML;

            //fevr_s
            $sub_array[] = <<<HTML
                <td>$fevr_s
                    <!--begin::Radio group-->
                    <div class="tooltip-saisie btn-group" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button]">
                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="fevr_s" class="btn-check" type="radio" name="method" value="X"/>
                            <!--end::Input-->
                            X
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="fevr_s" class="btn-check" type="radio" name="method" value="N/A"/>
                            <!--end::Input-->
                            N/A
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="fevr_s" class="btn-check" type="radio" name="method" value="" />
                            <!--end::Input-->
                        </label>
                        <!--end::Radio-->
                    </div>
                    <!--end::Radio group-->
                </td>
            HTML;

            //mars_c
            $sub_array[] = <<<HTML
                <td>$mars_c
                    <!--begin::Radio group-->
                    <div class="tooltip-saisie btn-group" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button]">
                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="mars_c" class="btn-check" type="radio" name="method" value="X"/>
                            <!--end::Input-->
                            X
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="mars_c" class="btn-check" type="radio" name="method" value="N/A"/>
                            <!--end::Input-->
                            N/A
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="mars_c" class="btn-check" type="radio" name="method" value="" />
                            <!--end::Input-->
                        </label>
                        <!--end::Radio-->
                    </div>
                    <!--end::Radio group-->
                </td>
            HTML;

            //mars_i
            $sub_array[] = <<<HTML
                <td>$mars_i
                    <!--begin::Radio group-->
                    <div class="tooltip-saisie btn-group" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button]">
                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="mars_i" class="btn-check" type="radio" name="method" value="X"/>
                            <!--end::Input-->
                            X
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="mars_i" class="btn-check" type="radio" name="method" value="N/A"/>
                            <!--end::Input-->
                            N/A
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="mars_i" class="btn-check" type="radio" name="method" value="" />
                            <!--end::Input-->
                        </label>
                        <!--end::Radio-->
                    </div>
                    <!--end::Radio group-->
                </td>
            HTML;

            //mars_s
            $sub_array[] = <<<HTML
                <td>$mars_s
                    <!--begin::Radio group-->
                    <div class="tooltip-saisie btn-group" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button]">
                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="mars_s" class="btn-check" type="radio" name="method" value="X"/>
                            <!--end::Input-->
                            X
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="mars_s" class="btn-check" type="radio" name="method" value="N/A"/>
                            <!--end::Input-->
                            N/A
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="mars_s" class="btn-check" type="radio" name="method" value="" />
                            <!--end::Input-->
                        </label>
                        <!--end::Radio-->
                    </div>
                    <!--end::Radio group-->
                </td>
            HTML;

            //avr_c
            $sub_array[] = <<<HTML
                <td>$avr_c
                    <!--begin::Radio group-->
                    <div class="tooltip-saisie btn-group" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button]">
                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="avr_c" class="btn-check" type="radio" name="method" value="X"/>
                            <!--end::Input-->
                            X
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="avr_c" class="btn-check" type="radio" name="method" value="N/A"/>
                            <!--end::Input-->
                            N/A
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="avr_c" class="btn-check" type="radio" name="method" value="" />
                            <!--end::Input-->
                        </label>
                        <!--end::Radio-->
                    </div>
                    <!--end::Radio group-->
                </td>
            HTML;

            //avr_i
            $sub_array[] = <<<HTML
                <td>$avr_i
                    <!--begin::Radio group-->
                    <div class="tooltip-saisie btn-group" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button]">
                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="avr_i" class="btn-check" type="radio" name="method" value="X"/>
                            <!--end::Input-->
                            X
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="avr_i" class="btn-check" type="radio" name="method" value="N/A"/>
                            <!--end::Input-->
                            N/A
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="avr_i" class="btn-check" type="radio" name="method" value="" />
                            <!--end::Input-->
                        </label>
                        <!--end::Radio-->
                    </div>
                    <!--end::Radio group-->
                </td>
            HTML;

            //avr_s
            $sub_array[] = <<<HTML
                <td>$avr_s
                    <!--begin::Radio group-->
                    <div class="tooltip-saisie btn-group" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button]">
                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="avr_s" class="btn-check" type="radio" name="method" value="X"/>
                            <!--end::Input-->
                            X
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="avr_s" class="btn-check" type="radio" name="method" value="N/A"/>
                            <!--end::Input-->
                            N/A
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="avr_s" class="btn-check" type="radio" name="method" value="" />
                            <!--end::Input-->
                        </label>
                        <!--end::Radio-->
                    </div>
                    <!--end::Radio group-->
                </td>
            HTML;

            //mai_c
            $sub_array[] = <<<HTML
                <td>$mai_c
                    <!--begin::Radio group-->
                    <div class="tooltip-saisie btn-group" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button]">
                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="mai_c" class="btn-check" type="radio" name="method" value="X"/>
                            <!--end::Input-->
                            X
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="mai_c" class="btn-check" type="radio" name="method" value="N/A"/>
                            <!--end::Input-->
                            N/A
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="mai_c" class="btn-check" type="radio" name="method" value="" />
                            <!--end::Input-->
                        </label>
                        <!--end::Radio-->
                    </div>
                    <!--end::Radio group-->
                </td>
            HTML;

            //mai_i
            $sub_array[] = <<<HTML
                <td>$mai_i
                    <!--begin::Radio group-->
                    <div class="tooltip-saisie btn-group" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button]">
                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="mai_i" class="btn-check" type="radio" name="method" value="X"/>
                            <!--end::Input-->
                            X
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="mai_i" class="btn-check" type="radio" name="method" value="N/A"/>
                            <!--end::Input-->
                            N/A
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="mai_i" class="btn-check" type="radio" name="method" value="" />
                            <!--end::Input-->
                        </label>
                        <!--end::Radio-->
                    </div>
                    <!--end::Radio group-->
                </td>
            HTML;

            //mai_s
            $sub_array[] = <<<HTML
                <td>$mai_s
                    <!--begin::Radio group-->
                    <div class="tooltip-saisie btn-group" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button]">
                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="mai_s" class="btn-check" type="radio" name="method" value="X"/>
                            <!--end::Input-->
                            X
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="mai_s" class="btn-check" type="radio" name="method" value="N/A"/>
                            <!--end::Input-->
                            N/A
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="mai_s" class="btn-check" type="radio" name="method" value="" />
                            <!--end::Input-->
                        </label>
                        <!--end::Radio-->
                    </div>
                    <!--end::Radio group-->
                </td>
            HTML;

            //juin_c
            $sub_array[] = <<<HTML
                <td>$juin_c
                    <!--begin::Radio group-->
                    <div class="tooltip-saisie btn-group" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button]">
                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="juin_c" class="btn-check" type="radio" name="method" value="X"/>
                            <!--end::Input-->
                            X
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="juin_c" class="btn-check" type="radio" name="method" value="N/A"/>
                            <!--end::Input-->
                            N/A
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="juin_c" class="btn-check" type="radio" name="method" value="" />
                            <!--end::Input-->
                        </label>
                        <!--end::Radio-->
                    </div>
                    <!--end::Radio group-->
                </td>
            HTML;

            //juin_i
            $sub_array[] = <<<HTML
                <td>$juin_i
                    <!--begin::Radio group-->
                    <div class="tooltip-saisie btn-group" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button]">
                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="juin_i" class="btn-check" type="radio" name="method" value="X"/>
                            <!--end::Input-->
                            X
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="juin_i" class="btn-check" type="radio" name="method" value="N/A"/>
                            <!--end::Input-->
                            N/A
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="juin_i" class="btn-check" type="radio" name="method" value="" />
                            <!--end::Input-->
                        </label>
                        <!--end::Radio-->
                    </div>
                    <!--end::Radio group-->
                </td>
            HTML;

            //juin_s
            $sub_array[] = <<<HTML
                <td>$juin_s
                    <!--begin::Radio group-->
                    <div class="tooltip-saisie btn-group" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button]">
                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="juin_s" class="btn-check" type="radio" name="method" value="X"/>
                            <!--end::Input-->
                            X
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="juin_s" class="btn-check" type="radio" name="method" value="N/A"/>
                            <!--end::Input-->
                            N/A
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="juin_s" class="btn-check" type="radio" name="method" value="" />
                            <!--end::Input-->
                        </label>
                        <!--end::Radio-->
                    </div>
                    <!--end::Radio group-->
                </td>
            HTML;

            //juil_c
            $sub_array[] = <<<HTML
                <td>$juil_c
                    <!--begin::Radio group-->
                    <div class="tooltip-saisie btn-group" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button]">
                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="juil_c" class="btn-check" type="radio" name="method" value="X"/>
                            <!--end::Input-->
                            X
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="juil_c" class="btn-check" type="radio" name="method" value="N/A"/>
                            <!--end::Input-->
                            N/A
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="juil_c" class="btn-check" type="radio" name="method" value="" />
                            <!--end::Input-->
                        </label>
                        <!--end::Radio-->
                    </div>
                    <!--end::Radio group-->
                </td>
            HTML;

            //juil_i
            $sub_array[] = <<<HTML
                <td>$juil_i
                    <!--begin::Radio group-->
                    <div class="tooltip-saisie btn-group" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button]">
                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="juil_i" class="btn-check" type="radio" name="method" value="X"/>
                            <!--end::Input-->
                            X
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="juil_i" class="btn-check" type="radio" name="method" value="N/A"/>
                            <!--end::Input-->
                            N/A
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="juil_i" class="btn-check" type="radio" name="method" value="" />
                            <!--end::Input-->
                        </label>
                        <!--end::Radio-->
                    </div>
                    <!--end::Radio group-->
                </td>
            HTML;

            //juil_s
            $sub_array[] = <<<HTML
                <td>$juil_s
                    <!--begin::Radio group-->
                    <div class="tooltip-saisie btn-group" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button]">
                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="juil_s" class="btn-check" type="radio" name="method" value="X"/>
                            <!--end::Input-->
                            X
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="juil_s" class="btn-check" type="radio" name="method" value="N/A"/>
                            <!--end::Input-->
                            N/A
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="juil_s" class="btn-check" type="radio" name="method" value="" />
                            <!--end::Input-->
                        </label>
                        <!--end::Radio-->
                    </div>
                    <!--end::Radio group-->
                </td>
            HTML;

            //aout_c
            $sub_array[] = <<<HTML
                <td>$aout_c
                    <!--begin::Radio group-->
                    <div class="tooltip-saisie btn-group" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button]">
                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="aout_c" class="btn-check" type="radio" name="method" value="X"/>
                            <!--end::Input-->
                            X
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="aout_c" class="btn-check" type="radio" name="method" value="N/A"/>
                            <!--end::Input-->
                            N/A
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="aout_c" class="btn-check" type="radio" name="method" value="" />
                            <!--end::Input-->
                        </label>
                        <!--end::Radio-->
                    </div>
                    <!--end::Radio group-->
                </td>
            HTML;

            //aout_i
            $sub_array[] = <<<HTML
                <td>$aout_i
                    <!--begin::Radio group-->
                    <div class="tooltip-saisie btn-group" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button]">
                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="aout_i" class="btn-check" type="radio" name="method" value="X"/>
                            <!--end::Input-->
                            X
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="aout_i" class="btn-check" type="radio" name="method" value="N/A"/>
                            <!--end::Input-->
                            N/A
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="aout_i" class="btn-check" type="radio" name="method" value="" />
                            <!--end::Input-->
                        </label>
                        <!--end::Radio-->
                    </div>
                    <!--end::Radio group-->
                </td>
            HTML;

            //aout_s
            $sub_array[] = <<<HTML
                <td>$aout_s
                    <!--begin::Radio group-->
                    <div class="tooltip-saisie btn-group" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button]">
                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="aout_s" class="btn-check" type="radio" name="method" value="X"/>
                            <!--end::Input-->
                            X
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="aout_s" class="btn-check" type="radio" name="method" value="N/A"/>
                            <!--end::Input-->
                            N/A
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="aout_s" class="btn-check" type="radio" name="method" value="" />
                            <!--end::Input-->
                        </label>
                        <!--end::Radio-->
                    </div>
                    <!--end::Radio group-->
                </td>
            HTML;

            //sept_c
            $sub_array[] = <<<HTML
                <td>$sept_c
                    <!--begin::Radio group-->
                    <div class="tooltip-saisie btn-group" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button]">
                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="sept_c" class="btn-check" type="radio" name="method" value="X"/>
                            <!--end::Input-->
                            X
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="sept_c" class="btn-check" type="radio" name="method" value="N/A"/>
                            <!--end::Input-->
                            N/A
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="sept_c" class="btn-check" type="radio" name="method" value="" />
                            <!--end::Input-->
                        </label>
                        <!--end::Radio-->
                    </div>
                    <!--end::Radio group-->
                </td>
            HTML;

            //sept_i
            $sub_array[] = <<<HTML
                <td>$sept_i
                    <!--begin::Radio group-->
                    <div class="tooltip-saisie btn-group" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button]">
                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="sept_i" class="btn-check" type="radio" name="method" value="X"/>
                            <!--end::Input-->
                            X
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="sept_i" class="btn-check" type="radio" name="method" value="N/A"/>
                            <!--end::Input-->
                            N/A
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="sept_i" class="btn-check" type="radio" name="method" value="" />
                            <!--end::Input-->
                        </label>
                        <!--end::Radio-->
                    </div>
                    <!--end::Radio group-->
                </td>
            HTML;

            //sept_s
            $sub_array[] = <<<HTML
                <td>$sept_s
                    <!--begin::Radio group-->
                    <div class="tooltip-saisie btn-group" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button]">
                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="sept_s" class="btn-check" type="radio" name="method" value="X"/>
                            <!--end::Input-->
                            X
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="sept_s" class="btn-check" type="radio" name="method" value="N/A"/>
                            <!--end::Input-->
                            N/A
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="sept_s" class="btn-check" type="radio" name="method" value="" />
                            <!--end::Input-->
                        </label>
                        <!--end::Radio-->
                    </div>
                    <!--end::Radio group-->
                </td>
            HTML;

            //oct_c
            $sub_array[] = <<<HTML
                <td>$oct_c
                    <!--begin::Radio group-->
                    <div class="tooltip-saisie btn-group" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button]">
                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="oct_c" class="btn-check" type="radio" name="method" value="X"/>
                            <!--end::Input-->
                            X
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="oct_c" class="btn-check" type="radio" name="method" value="N/A"/>
                            <!--end::Input-->
                            N/A
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="oct_c" class="btn-check" type="radio" name="method" value="" />
                            <!--end::Input-->
                        </label>
                        <!--end::Radio-->
                    </div>
                    <!--end::Radio group-->
                </td>
            HTML;

            //oct_i
            $sub_array[] = <<<HTML
                <td>$oct_i
                    <!--begin::Radio group-->
                    <div class="tooltip-saisie btn-group" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button]">
                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="oct_i" class="btn-check" type="radio" name="method" value="X"/>
                            <!--end::Input-->
                            X
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="oct_i" class="btn-check" type="radio" name="method" value="N/A"/>
                            <!--end::Input-->
                            N/A
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="oct_i" class="btn-check" type="radio" name="method" value="" />
                            <!--end::Input-->
                        </label>
                        <!--end::Radio-->
                    </div>
                    <!--end::Radio group-->
                </td>
            HTML;

            //oct_s
            $sub_array[] = <<<HTML
                <td>$oct_s
                    <!--begin::Radio group-->
                    <div class="tooltip-saisie btn-group" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button]">
                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="oct_s" class="btn-check" type="radio" name="method" value="X"/>
                            <!--end::Input-->
                            X
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="oct_s" class="btn-check" type="radio" name="method" value="N/A"/>
                            <!--end::Input-->
                            N/A
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="oct_s" class="btn-check" type="radio" name="method" value="" />
                            <!--end::Input-->
                        </label>
                        <!--end::Radio-->
                    </div>
                    <!--end::Radio group-->
                </td>
            HTML;

            //nov_c
            $sub_array[] = <<<HTML
                <td>$nov_c
                    <!--begin::Radio group-->
                    <div class="tooltip-saisie btn-group" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button]">
                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="nov_c" class="btn-check" type="radio" name="method" value="X"/>
                            <!--end::Input-->
                            X
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="nov_c" class="btn-check" type="radio" name="method" value="N/A"/>
                            <!--end::Input-->
                            N/A
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="nov_c" class="btn-check" type="radio" name="method" value="" />
                            <!--end::Input-->
                        </label>
                        <!--end::Radio-->
                    </div>
                    <!--end::Radio group-->
                </td>
            HTML;

            //nov_i
            $sub_array[] = <<<HTML
                <td>$nov_i
                    <!--begin::Radio group-->
                    <div class="tooltip-saisie btn-group" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button]">
                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="nov_i" class="btn-check" type="radio" name="method" value="X"/>
                            <!--end::Input-->
                            X
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="nov_i" class="btn-check" type="radio" name="method" value="N/A"/>
                            <!--end::Input-->
                            N/A
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="nov_i" class="btn-check" type="radio" name="method" value="" />
                            <!--end::Input-->
                        </label>
                        <!--end::Radio-->
                    </div>
                    <!--end::Radio group-->
                </td>
            HTML;

            //nov_s
            $sub_array[] = <<<HTML
                <td>$nov_s
                    <!--begin::Radio group-->
                    <div class="tooltip-saisie btn-group" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button]">
                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="nov_s" class="btn-check" type="radio" name="method" value="X"/>
                            <!--end::Input-->
                            X
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="nov_s" class="btn-check" type="radio" name="method" value="N/A"/>
                            <!--end::Input-->
                            N/A
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="nov_s" class="btn-check" type="radio" name="method" value="" />
                            <!--end::Input-->
                        </label>
                        <!--end::Radio-->
                    </div>
                    <!--end::Radio group-->
                </td>
            HTML;

            //dec_c
            $sub_array[] = <<<HTML
                <td>$dec_c
                    <!--begin::Radio group-->
                    <div class="tooltip-saisie btn-group" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button]">
                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="dec_c" class="btn-check" type="radio" name="method" value="X"/>
                            <!--end::Input-->
                            X
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="dec_c" class="btn-check" type="radio" name="method" value="N/A"/>
                            <!--end::Input-->
                            N/A
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="dec_c" class="btn-check" type="radio" name="method" value="" />
                            <!--end::Input-->
                        </label>
                        <!--end::Radio-->
                    </div>
                    <!--end::Radio group-->
                </td>
            HTML;

            //dec_i
            $sub_array[] = <<<HTML
                <td>$dec_i
                    <!--begin::Radio group-->
                    <div class="tooltip-saisie btn-group" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button]">
                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="dec_i" class="btn-check" type="radio" name="method" value="X"/>
                            <!--end::Input-->
                            X
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="dec_i" class="btn-check" type="radio" name="method" value="N/A"/>
                            <!--end::Input-->
                            N/A
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="dec_i" class="btn-check" type="radio" name="method" value="" />
                            <!--end::Input-->
                        </label>
                        <!--end::Radio-->
                    </div>
                    <!--end::Radio group-->
                </td>
            HTML;

            //dec_s
            $sub_array[] = <<<HTML
                <td>$dec_s
                    <!--begin::Radio group-->
                    <div class="tooltip-saisie btn-group" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button]">
                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="dec_s" class="btn-check" type="radio" name="method" value="X"/>
                            <!--end::Input-->
                            X
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="dec_s" class="btn-check" type="radio" name="method" value="N/A"/>
                            <!--end::Input-->
                            N/A
                        </label>
                        <!--end::Radio-->

                        <!--begin::Radio-->
                        <label class="saisie-option btn btn-outline btn-color-muted btn-active-success" data-kt-button="true">
                            <!--begin::Input-->
                            <input data-id_saisie="{$id_saisie}" data-option="dec_s" class="btn-check" type="radio" name="method" value="" />
                            <!--end::Input-->
                        </label>
                        <!--end::Radio-->
                    </div>
                    <!--end::Radio group-->
                </td>
            HTML;

            // Action
            $sub_array[] = <<<HTML
                <i class="delete_saisie fas fa-times text-danger text-center" data-id_saisie="{$id_saisie}"></i>
            HTML;

            $data[] = $sub_array;
        }


        $output = array(
            "data" => $data
        );
    }
}

if (isset($_POST['action'])) {

    if ($_POST['action'] == 'fetch_page_saisie') {

        $id_client = $_SESSION['id_view_saisie_client'];

        $query = "SELECT * FROM utilisateur, compte, client WHERE utilisateur.id_utilisateur = compte.id_utilisateur 
        AND utilisateur.id_utilisateur = client.id_utilisateur AND client.id_client = $id_client";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        $output = $result;
    }

    if ($_POST['action'] == 'update_saisie') {

        $id_saisie = $_POST['id_saisie'];
        $option = $_POST['option'];
        $value = $_POST['value'];

        // update
        $update = update(
            'saisie',
            [$option => $value],
            "id_saisie = $id_saisie",
            $db
        );

        $value = ($value == '') ? '&nbsp;' : $value;

        if ($update) {
            $output = array(
                'success' => true,
                'value' => $value,
                'message' => "Saisie modifiée !"
            );
        }
    }

    if ($_POST['action'] == 'add_rubrique_saisie') {
        $id_client = $_SESSION['id_view_saisie_client'];
        $rubrique = $_POST['rubrique_saisie'];
        $annee = $_POST['annee_saisie'];

        // insert
        $insert = insert(
            'saisie',
            [
                'rubrique' => $rubrique,
                'annee' => $annee,
                'created_at' => date('Y-m-d H:i:s'),
                'id_client' => $id_client
            ],
            $db
        );

        if ($insert) {
            $output = array(
                'success' => true,
                'message' => "Rubrique ajoutée !"
            );
        }
    }

    if ($_POST['action'] == 'delete_saisie') {

        $id_saisie = $_POST['id_saisie'];

        // delete
        $delete = delete(
            'saisie',
            "id_saisie = $id_saisie",
            $db
        );

        if ($delete) {
            $output = array(
                'success' => true,
                'message' => "Saisie supprimée !"
            );
        }
    }
}



echo json_encode($output);
