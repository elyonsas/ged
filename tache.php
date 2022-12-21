<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/vendor/autoload.php');

require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions-sql.php');

// Tâche pour relance facture client
$query = "SELECT * FROM facture WHERE statut_facture <> 'en attente' AND statut_facture <> 'supprimer' ";
$statement = $db->prepare($query);
$statement->execute();
$result = $statement->fetchAll();

foreach ($result as $row) {
    $id_facture = $row['id_facture'];
    $id_client = $row['id_client'];                                                                                                                                   
    $date_echeance_plus_5_jours = date('Y-m-d H:i:s', strtotime($row['date_echeance_facture'] . ' +5 days'));
    $date_echeance_plus_30_jours = date('Y-m-d H:i:s', strtotime($row['date_echeance_facture'] . ' +30 days'));

    if (/*$row['relance_option_facture'] != 'after_5_days' && $date_echeance_plus_5_jours < date('Y-m-d H:i:s')*/ $id_client == 7) {
        
        $update = update('facture', ['relance_option_facture' => 'after_5_days'], "id_facture = $id_facture", $db);

        // Send email

        $n_facture = $row['n_facture'];
        $date_emission_facture = date('d/m/Y', strtotime($row['date_emission_facture']));
        $montant_ttc_facture = format_am($row['montant_ttc_facture']);
        $matricule_client = find_info_client('matricule_client', $id_client, $db);
        $nom_client = find_info_client('nom_utilisateur', $id_client, $db);
        $email_client = find_info_client('email_utilisateur', $id_client, $db);
        $nom_responsable_client = find_info_client('nom_responsable_client', $id_client, $db);
        $prenom_responsable_client = find_info_client('prenom_responsable_client', $id_client, $db);
        $role_responsable_client = find_info_client('role_responsable_client', $id_client, $db);
        $civilite_responsable_client = find_info_client('civilite_responsable_client', $id_client, $db);

        $mail_html_client = find_info_client('mail_html_client', $id_client, $db);
        $mail_html_client = str_replace('{n_facture}', $n_facture, $mail_html_client);
        $mail_html_client = str_replace('{date_emission_facture}', $date_emission_facture, $mail_html_client);
        $mail_html_client = str_replace('{montant_ttc_facture}', $montant_ttc_facture, $mail_html_client);
        $mail_html_client = str_replace('{matricule_client}', $matricule_client, $mail_html_client);
        $mail_html_client = str_replace('{nom_client}', $nom_client, $mail_html_client);
        $mail_html_client = str_replace('{nom_responsable_client}', $nom_responsable_client, $mail_html_client);
        $mail_html_client = str_replace('{prenom_responsable_client}', $prenom_responsable_client, $mail_html_client);
        $mail_html_client = str_replace('{role_responsable_client}', $role_responsable_client, $mail_html_client);
        $mail_html_client = str_replace('{civilite_responsable_client}', $civilite_responsable_client, $mail_html_client);
        $mail_html_client = str_replace('{article_apres_civilite}', $civilite_responsable_client == 'Monsieur' ? 'le' : 'la', $mail_html_client);

        $url = "";

        $to = [
            'to' => [],
        ];

        // Ajouter le client
        $to['to'][] = [$email_client, $nom_client];

        // // Ajouter les AG
        // $ag = find_ag_cabinet($db);
        // foreach ($ag as $row) {
        //     $to['to'][] = [$row['email_utilisateur'], $row['prenom_utilisateur'] . ' ' . $row['nom_utilisateur']];
        // }

        // // Ajouter le DD DEC
        // $dd = find_dd_dec($db);
        // $to['to'][] = [$dd['email_utilisateur'], $dd['prenom_utilisateur'] . ' ' . $dd['nom_utilisateur']];
        
        $from = ['c_elyon@yahoo.fr', 'Cabinet Elyon'];
        
        $subject = "Première relance d'impayé - facture n° $n_facture";
        
        $message = <<<HTML
        
        $mail_html_client
        
        <table width="100%" style="margin: auto;">
            <tr>
                <td valign="middle" class="bg_light footer">
                    <table>
                        <tr>
                            <td width="25%"
                                class="padding-bottom-20 padding-left-20 padding-right-20 padding-top-20">
                                <img width="130" height="130" src="https://elyonsas.github.io/ged-assets/assets/media/ged-mail/logo_elyon.png" alt="elyon-icon">
                            </td>
                            <td width="75%" colspan="2"
                                style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 13px; text-align: left; line-height: 1.5;">
                                CABINET ÉLYÔN
                                Audit, Expertise comptable, Commissariat aux comptes, Conseils
                                09 BP 290 Saint Michel - Cotonou
                                Tél: (+229) 21 32 77 78 / 21 03 35 32 / 97 22 19 85 / 90 94 07 99
                                Email: c_elyon@yahoo.fr, contact@elyonsas.com
                                Cotonou-Bénin
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        
        HTML;
        
        $send_mail = send_mail($to, $from, $subject, $message);
    } else if($row['relance_option_facture'] != 'after_30_days' && $date_echeance_plus_30_jours < date('Y-m-d H:i:s')) {
        
        $update = update('facture', ['relance_option_facture' => 'after_30_days'], "id_facture = $id_facture", $db);
    }
}