<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/vendor/autoload.php');

require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions-sql.php');

// Tâche pour relance facture client
$query = "SELECT * FROM facture WHERE statut_facture <> 'en attente' AND statut_facture <> 'supprime' ";
$statement = $db->prepare($query);
$statement->execute();
$result = $statement->fetchAll();

foreach ($result as $row) {
    $id_facture = $row['id_facture'];
    $id_client = $row['id_client'];
    $id_utilisateur = find_id_utilisateur_by_id_client($id_client, $db);
    $relance_auto_client = find_info_client('relance_auto_client', $id_client, $db);                                                                                                                                  
    $date_echeance_plus_5_jours = date('Y-m-d H:i:s', strtotime($row['date_echeance_facture'] . ' +5 days'));
    $date_echeance_plus_30_jours = date('Y-m-d H:i:s', strtotime($row['date_echeance_facture'] . ' +30 days'));

    if ($row['relance_option_facture'] != 'after_5_days' && $date_echeance_plus_5_jours < date('Y-m-d H:i:s') && $relance_auto_client == 'oui') {
        
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

        $mail_objet = select_info('mail_objet', 'modele_mail_client', "relance_option_facture = 'after_5_days'", $db);
        $mail_objet = str_replace('{n_facture}', $n_facture, $mail_objet);

        $mail_content = select_info('mail_content', 'modele_mail_client', "relance_option_facture = 'after_5_days'", $db);
        $mail_content = str_replace('{n_facture}', $n_facture, $mail_content);
        $mail_content = str_replace('{date_emission_facture}', $date_emission_facture, $mail_content);
        $mail_content = str_replace('{montant_ttc_facture}', $montant_ttc_facture, $mail_content);
        $mail_content = str_replace('{matricule_client}', $matricule_client, $mail_content);
        $mail_content = str_replace('{nom_client}', $nom_client, $mail_content);
        $mail_content = str_replace('{nom_responsable_client}', $nom_responsable_client, $mail_content);
        $mail_content = str_replace('{prenom_responsable_client}', $prenom_responsable_client, $mail_content);
        $mail_content = str_replace('{role_responsable_client}', $role_responsable_client, $mail_content);
        $mail_content = str_replace('{civilite_responsable_client}', $civilite_responsable_client, $mail_content);
        $mail_content = str_replace('{article_apres_civilite}', $civilite_responsable_client == 'Monsieur' ? 'le' : 'la', $mail_content);

        $url = "";

        $to = [
            'to' => [],
        ];

        // Ajouter le client
        $to['to'][] = [$email_client, $nom_client];

        // Ajouter les AG
        $ag = find_ag_cabinet($db);
        foreach ($ag as $row) {
            $to['to'][] = [$row['email_utilisateur'], $row['prenom_utilisateur'] . ' ' . $row['nom_utilisateur']];
        }

        // Ajouter le DD DEC
        $dd = find_dd_dec($db);
        $to['to'][] = [$dd['email_utilisateur'], $dd['prenom_utilisateur'] . ' ' . $dd['nom_utilisateur']];
        
        $from = ['c_elyon@yahoo.fr', 'Cabinet Elyon'];
        
        $subject = $mail_objet;
        
        $message = <<<HTML
        
            <div class="mail-parent" style="width: 100%; background-color: #f1f1f1;">
                <div class="mail-container" style="max-width: 600px; background-color: #ffffff; margin: 0 auto;">

                    <div class="mail-dinamique-container" style="padding: 25px;">
                        $mail_content
                    </div>
            
                    <table class="mail-footer" style="width: 100%; margin: auto;">
                        <tr>
                            <td valign="middle" style="background: #fafafa; border-top: 1px solid rgba(0, 0, 0, .05); color: rgba(0, 0, 0, .6);">
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
                        <tr>
                            <td style="margin: 0px auto; border-collapse: collapse; border-top: 1px solid rgba(0, 0, 0, .05); font-size: 0px; padding: 16px 0px 8px; word-break: break-word;">
                                <div style="font-family: system-ui, 'Segoe UI', sans-serif; font-size: 11px; line-height: 1.6; text-align: center; color: rgb(147, 149, 152);">
                                    Cet email à été automatiquement générer par le logiciel GED-ELYON.
                                    <a href="https://ged-elyon.com" style="color: rgb(0, 0, 0); text-decoration: none; background-color: transparent;">https://ged-elyon.com</a>
                                </div>
                            </td>
                        </tr>
                    </table>

                </div>
            </div>
        
        HTML;
        
        $send_mail = send_mail($to, $from, $subject, $message);

        if($send_mail) {

            // Ajouter une notification pour les AG
            foreach ($ag as $row) {
                add_notif(
                    'Envoi de mail de relance',
                    'Un mail de relance a été envoyé au client ' . $nom_client . ' pour la facture ' . $n_facture . '.',
                    'alert',
                    'important',
                    'roll/ag/dossiers/',
                    $row['id_utilisateur'],
                    $db
                );
            }

            // Ajouter une notification pour le DD DEC
            add_notif(
                'Envoi de mail de relance',
                'Un mail de relance a été envoyé au client ' . $nom_client . ' pour la facture ' . $n_facture . '.',
                'alert',
                'important',
                'roll/dd/dossiers/',
                $dd['id_utilisateur'],
                $db
            );
            

            // Ajouter une notification pour le client
            add_notif(
                'Envoi de mail de relance',
                'Un mail de relance vous a été envoyé pour la facture ' . $n_facture . '.',
                'alert',
                'important',
                'roll/client/dossiers/',
                $id_utilisateur,
                $db
            );
        }


    } else if($row['relance_option_facture'] != 'after_30_days' && $date_echeance_plus_30_jours < date('Y-m-d H:i:s') && $relance_auto_client == 'oui') {
        
        $update = update('facture', ['relance_option_facture' => 'after_30_days'], "id_facture = $id_facture", $db);

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

        $mail_objet = select_info('mail_objet', 'modele_mail_client', "relance_option_facture = 'after_30_days'", $db);
        $mail_objet = str_replace('{n_facture}', $n_facture, $mail_objet);

        $mail_content = select_info('mail_content', 'modele_mail_client', "relance_option_facture = 'after_30_days'", $db);
        $mail_content = str_replace('{n_facture}', $n_facture, $mail_content);
        $mail_content = str_replace('{date_emission_facture}', $date_emission_facture, $mail_content);
        $mail_content = str_replace('{montant_ttc_facture}', $montant_ttc_facture, $mail_content);
        $mail_content = str_replace('{matricule_client}', $matricule_client, $mail_content);
        $mail_content = str_replace('{nom_client}', $nom_client, $mail_content);
        $mail_content = str_replace('{nom_responsable_client}', $nom_responsable_client, $mail_content);
        $mail_content = str_replace('{prenom_responsable_client}', $prenom_responsable_client, $mail_content);
        $mail_content = str_replace('{role_responsable_client}', $role_responsable_client, $mail_content);
        $mail_content = str_replace('{civilite_responsable_client}', $civilite_responsable_client, $mail_content);
        $mail_content = str_replace('{article_apres_civilite}', $civilite_responsable_client == 'Monsieur' ? 'le' : 'la', $mail_content);

        $url = "";

        $to = [
            'to' => [],
            'cc' => []
        ];

        // Ajouter le client
        $to['to'][] = [$email_client, $nom_client];

        // Ajouter les AG
        $ag = find_ag_cabinet($db);
        foreach ($ag as $row) {
            $to['cc'][] = [$row['email_utilisateur'], $row['prenom_utilisateur'] . ' ' . $row['nom_utilisateur']];
        }

        // Ajouter le DD DEC
        $dd = find_dd_dec($db);
        $to['cc'][] = [$dd['email_utilisateur'], $dd['prenom_utilisateur'] . ' ' . $dd['nom_utilisateur']];
        
        $from = ['c_elyon@yahoo.fr', 'Cabinet Elyon'];
        
        $subject = $mail_objet;
        
        $message = <<<HTML
        
            <div class="mail-parent" style="width: 100%; background-color: #f1f1f1;">
                <div class="mail-container" style="max-width: 600px; background-color: #ffffff; margin: 0 auto;">

                    <div class="mail-dinamique-container" style="padding: 25px;">
                        $mail_content
                    </div>
            
                    <table class="mail-footer" style="width: 100%; margin: auto;">
                        <tr>
                            <td valign="middle" style="background: #fafafa; border-top: 1px solid rgba(0, 0, 0, .05); color: rgba(0, 0, 0, .6);">
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
                        <tr>
                            <td style="margin: 0px auto; border-collapse: collapse; border-top: 1px solid rgba(0, 0, 0, .05); font-size: 0px; padding: 16px 0px 8px; word-break: break-word;">
                                <div style="font-family: system-ui, 'Segoe UI', sans-serif; font-size: 11px; line-height: 1.6; text-align: center; color: rgb(147, 149, 152);">
                                    Cet email à été automatiquement générer par le logiciel GED-ELYON.
                                    <a href="https://ged-elyon.com" style="color: rgb(0, 0, 0); text-decoration: none; background-color: transparent;">https://ged-elyon.com</a>
                                </div>
                            </td>
                        </tr>
                    </table>

                </div>
            </div>
        
        HTML;
        
        $send_mail = send_mail($to, $from, $subject, $message);

        if($send_mail) {

            // Ajouter une notification pour les AG
            foreach ($ag as $row) {
                add_notif(
                    'Envoi de mail de relance',
                    'Un mail de relance a été envoyé au client ' . $nom_client . ' pour la facture ' . $n_facture . '.',
                    'alert',
                    'important',
                    'roll/ag/dossiers/',
                    $row['id_utilisateur'],
                    $db
                );
            }

            // Ajouter une notification pour le DD DEC
            add_notif(
                'Envoi de mail de relance',
                'Un mail de relance a été envoyé au client ' . $nom_client . ' pour la facture ' . $n_facture . '.',
                'alert',
                'important',
                'roll/dd/dossiers/',
                $dd['id_utilisateur'],
                $db
            );
            

            // Ajouter une notification pour le client
            add_notif(
                'Envoi de mail de relance',
                'Un mail de relance vous a été envoyé pour la facture ' . $n_facture . '.',
                'alert',
                'important',
                'roll/client/dossiers/',
                $id_utilisateur,
                $db
            );
        }
    }
}