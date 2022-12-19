<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.mail.yahoo.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'c_elyon@yahoo.fr';                     //SMTP username
    $mail->Password   = 'iixialwiovbjnwlt';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('c_elyon@yahoo.fr', 'Cabinet Elyon');
    $mail->addAddress('arnaudadjovi274@gmail.com', 'Arnaud');     //Add a recipient
    // $mail->addAddress('ellen@example.com');               //Name is optional
    // $mail->addReplyTo('info@example.com', 'Information');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = <<<HTML

        <table role="presentation" border="0" width="100%" cellspacing="0" cellpadding="0">
            <tbody>
                <tr>
                    <td align="center">
                        <table style="width: 640px;" role="presentation" border="0" width="640" cellspacing="0" cellpadding="0">
                            <tbody>
                                <tr>
                                    <td align="left" valign="top" bgcolor="#FAF9F8">
                                        <table role="presentation" border="0" width="100%" cellspacing="0" cellpadding="0">
                                            <tbody>
                                                <tr>
                                                    <td align="center"><a
                                                            href="https://click.email2.office.com/?qs=c78e5528e91b70e7b8f9fb77ead4bee2f3ce72ac06a8ff7ffe3e5ae141a779888c4d7aed8c3ea9a8090e64022a61aa66eb69a57b1bd54dff8e1f964fc9ec68dd"
                                                            target="_blank" rel="noopener"><strong>D&eacute;bloquez
                                                                3&nbsp;mois&nbsp;pour&nbsp;1 &euro;</strong></a>&nbsp;|&nbsp;<a
                                                            href="https://view.email2.office.com/?qs=b3867fdaade30404e8d57378b95eb7cf3519048350254778713e2f28d659981c50408d92eca665a4565e325a28b1b3f886b2bbf7249eee23fe81d14a27f17621f3d90ec38c7728e28a60c240126c6b7f"
                                                            target="_blank" rel="noopener">&nbsp;<strong>Afficher en
                                                                ligne</strong></a></td>
                                                </tr>
                                                <tr>
                                                    <td align="center">
                                                        <table role="presentation" border="0" width="100%" cellspacing="0"
                                                            cellpadding="0">
                                                            <tbody>
                                                                <tr>
                                                                    <td align="left" width="21.875%"><a
                                                                            href="https://click.email2.office.com/?qs=c78e5528e91b70e71b26c7c4d097adcc1bff3942fb4e1674548250db6256515112eee84c356c0c857d695eef8fe7a400bbd39e217c45f214"
                                                                            target="_blank" rel="noopener"><img
                                                                                style="height: auto; width: 130px;"
                                                                                src="http://image.email2.office.com/lib/fe8f1372766502797c/m/1/Microsoft_Logo.png"
                                                                                alt="Microsoft" width="130" border="0" /></a>
                                                                    </td>
                                                                    <td width="78.125%">&nbsp;</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" valign="top">
                                        <table role="presentation" border="0" width="100%" cellspacing="0" cellpadding="0">
                                            <tbody>
                                                <tr>
                                                    <td align="left" bgcolor="#ffffff">
                                                        <table role="presentation" border="0" width="100%" cellspacing="0"
                                                            cellpadding="0">
                                                            <tbody>
                                                                <tr>
                                                                    <td align="center"><a
                                                                            href="https://click.email2.office.com/?qs=c78e5528e91b70e79b210cab7f564e35138913af550d125416f7c5096574ee9e906a38b82ddfe8dc868af5feae3f1b8edc948ea46e051897c39bf9c354285ac7"
                                                                            target="_blank" rel="noopener"><img
                                                                                style="height: auto;"
                                                                                src="https://image.email2.office.com/lib/fe8f1372766502797c/m/2/12f6a818-c76b-429b-a550-750b437fb973.jpg"
                                                                                alt="Parents et enfants travaillant sur un ordinateur portable et une tablette sur le plan de travail de la cuisine"
                                                                                width="640" height="235" border="0" /></a></td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="center" bgcolor="#ffffff">
                                                                        <h1>Obtenez 3&nbsp;mois
                                                                            de&nbsp;Microsoft&nbsp;365&nbsp;pour
                                                                            seulement&nbsp;1 &euro;</h1>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="center" bgcolor="#ffffff">
                                                                        <p>Depuis l&rsquo;expiration de votre abonnement
                                                                            &agrave; Microsoft&nbsp;365, vous ne pouvez plus
                                                                            modifier de fichiers avec vos applications de
                                                                            bureau. Pour une dur&eacute;e limit&eacute;e,
                                                                            renouvelez votre abonnement et obtenez 3&nbsp;mois
                                                                            de&nbsp;Microsoft&nbsp;365&nbsp;Famille pour&nbsp;1
                                                                            &euro;.<sup>*</sup></p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td width="38%">
                                                                        <table role="presentation" border="0" cellspacing="0"
                                                                            cellpadding="0" align="center">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td align="center"><a
                                                                                            href="https://click.email2.office.com/?qs=c78e5528e91b70e735dc04b3fcee5474ed10efe185546b64c2331ad008a65ef30a23205c21daebd7d122924f23afb051e8c03adaf0c98623569fef20c5f1deea"
                                                                                            target="_blank"
                                                                                            rel="noopener">&nbsp;Afficher les
                                                                                            d&eacute;tails&nbsp;</a></td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="center">
                                                                        <table role="presentation" border="0" width="340"
                                                                            cellspacing="0" cellpadding="0">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td align="center" valign="top"
                                                                                        width="100%">
                                                                                        <table role="presentation" border="0"
                                                                                            width="100%" cellspacing="0"
                                                                                            cellpadding="0" align="center">
                                                                                            <tbody>
                                                                                                <tr>
                                                                                                    <td align="center"
                                                                                                        width="100%">
                                                                                                        Microsoft&nbsp;365&nbsp;Famille
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td align="center"
                                                                                                        valign="top"
                                                                                                        width="100%">
                                                                                                        <table
                                                                                                            role="presentation"
                                                                                                            border="0"
                                                                                                            width="100%"
                                                                                                            cellspacing="0"
                                                                                                            cellpadding="0">
                                                                                                            <tbody>
                                                                                                                <tr>
                                                                                                                    <td align="right"
                                                                                                                        valign="top"
                                                                                                                        width="10%">
                                                                                                                        <img style="height: 20px; width: 22px;"
                                                                                                                            src="https://image.email2.office.com/lib/fe8f1372766502797c/m/2/3ef5bcf2-c5e3-4cb0-b136-ece96d8ff047.png"
                                                                                                                            alt="Checkmark"
                                                                                                                            width="22"
                                                                                                                            height="20"
                                                                                                                            border="0" />
                                                                                                                    </td>
                                                                                                                    <td align="left"
                                                                                                                        valign="top"
                                                                                                                        width="62%">
                                                                                                                        Pour un
                                                                                                                        maximum
                                                                                                                        de
                                                                                                                        6&nbsp;personnes
                                                                                                                    </td>
                                                                                                                </tr>
                                                                                                            </tbody>
                                                                                                        </table>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td align="center"
                                                                                                        valign="top"
                                                                                                        width="100%">
                                                                                                        <table
                                                                                                            role="presentation"
                                                                                                            border="0"
                                                                                                            width="100%"
                                                                                                            cellspacing="0"
                                                                                                            cellpadding="0">
                                                                                                            <tbody>
                                                                                                                <tr>
                                                                                                                    <td align="right"
                                                                                                                        valign="top"
                                                                                                                        width="10%">
                                                                                                                        <img style="height: 20px; width: 22px;"
                                                                                                                            src="https://image.email2.office.com/lib/fe8f1372766502797c/m/2/3ef5bcf2-c5e3-4cb0-b136-ece96d8ff047.png"
                                                                                                                            alt="Checkmark"
                                                                                                                            width="22"
                                                                                                                            height="20"
                                                                                                                            border="0" />
                                                                                                                    </td>
                                                                                                                    <td align="left"
                                                                                                                        valign="top"
                                                                                                                        width="62%">
                                                                                                                        1&nbsp;To
                                                                                                                        de
                                                                                                                        stockage
                                                                                                                        de cloud
                                                                                                                        par
                                                                                                                        utilisateur
                                                                                                                    </td>
                                                                                                                </tr>
                                                                                                            </tbody>
                                                                                                        </table>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td align="center"
                                                                                                        valign="top"
                                                                                                        width="100%">
                                                                                                        <table
                                                                                                            role="presentation"
                                                                                                            border="0"
                                                                                                            width="100%"
                                                                                                            cellspacing="0"
                                                                                                            cellpadding="0">
                                                                                                            <tbody>
                                                                                                                <tr>
                                                                                                                    <td align="right"
                                                                                                                        valign="top"
                                                                                                                        width="10%">
                                                                                                                        <img style="height: 20px; width: 22px;"
                                                                                                                            src="https://image.email2.office.com/lib/fe8f1372766502797c/m/2/3ef5bcf2-c5e3-4cb0-b136-ece96d8ff047.png"
                                                                                                                            alt="Checkmark"
                                                                                                                            width="22"
                                                                                                                            height="20"
                                                                                                                            border="0" />
                                                                                                                    </td>
                                                                                                                    <td align="left"
                                                                                                                        valign="top"
                                                                                                                        width="62%">
                                                                                                                        Utilisation
                                                                                                                        sur
                                                                                                                        plusieurs
                                                                                                                        PC/Macs,
                                                                                                                        tablettes
                                                                                                                        et
                                                                                                                        appareils
                                                                                                                        mobiles
                                                                                                                    </td>
                                                                                                                </tr>
                                                                                                            </tbody>
                                                                                                        </table>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td align="center"
                                                                                                        width="100%">Versions
                                                                                                        Premium de&nbsp;:</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td align="center"
                                                                                                        width="100%"><img
                                                                                                            style="height: auto; width: 215px;"
                                                                                                            src="https://image.email2.office.com/lib/fe8f1372766502797c/m/2/91cc78c5-eb9d-47ab-880d-b2dc73eac289.png"
                                                                                                            alt="Word, Excel, Photoshop, OneNote, Outlook, OneDrive"
                                                                                                            width="215"
                                                                                                            height="29"
                                                                                                            align="center"
                                                                                                            border="0" /></td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td width="38%">
                                                                                                        <table
                                                                                                            role="presentation"
                                                                                                            border="0"
                                                                                                            cellspacing="0"
                                                                                                            cellpadding="0"
                                                                                                            align="center">
                                                                                                            <tbody>
                                                                                                                <tr>
                                                                                                                    <td
                                                                                                                        align="center">
                                                                                                                        <a href="https://click.email2.office.com/?qs=c78e5528e91b70e735dc04b3fcee5474ed10efe185546b64c2331ad008a65ef30a23205c21daebd7d122924f23afb051e8c03adaf0c98623569fef20c5f1deea"
                                                                                                                            target="_blank"
                                                                                                                            rel="noopener">&nbsp;Afficher
                                                                                                                            les
                                                                                                                            d&eacute;tails&nbsp;</a>
                                                                                                                    </td>
                                                                                                                </tr>
                                                                                                            </tbody>
                                                                                                        </table>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                        <table role="presentation" border="0" width="93.75%"
                                                                            cellspacing="0" cellpadding="0" align="center">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td align="center">&nbsp;</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td align="center">&nbsp;</td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" valign="top" bgcolor="#ffffff">
                                        <table role="presentation" border="0" width="100%" cellspacing="0" cellpadding="0">
                                            <tbody>
                                                <tr>
                                                    <td align="left" bgcolor="#ffffff">
                                                        <table role="presentation" border="0" width="100%" cellspacing="0"
                                                            cellpadding="0">
                                                            <tbody>
                                                                <tr>
                                                                    <td align="center">
                                                                        <h1>D&eacute;couvrez l&rsquo;exp&eacute;rience premium
                                                                        </h1>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="center">
                                                                        <p>L&rsquo;abonnement&nbsp;Microsoft&nbsp;365&nbsp;avec
                                                                            des fonctionnalit&eacute;s en exclusivit&eacute;</p>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="left" valign="top" bgcolor="#FAF9F8">
                                                        <table role="presentation" border="0" width="100%" cellspacing="0"
                                                            cellpadding="0">
                                                            <tbody>
                                                                <tr>
                                                                    <td align="left" valign="middle" bgcolor="#FFFFFF"
                                                                        width="52%">
                                                                        <table role="presentation" border="0" width="100%"
                                                                            cellspacing="0" cellpadding="0">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td align="left" bgcolor="#FFFFFF">
                                                                                        <h1>&Eacute;crivez avec style en toute
                                                                                            confiance</h1>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td align="left" bgcolor="#FFFFFF">
                                                                                        <p>Profitez d&rsquo;une aide &agrave; la
                                                                                            r&eacute;daction intelligente et de
                                                                                            suggestions
                                                                                            d&rsquo;am&eacute;liorations
                                                                                            avanc&eacute;es gr&acirc;ce au
                                                                                            R&eacute;dacteur et aux&nbsp;plus de
                                                                                            20&nbsp;langues&nbsp;prises en
                                                                                            charge par&nbsp;Microsoft&nbsp;365.
                                                                                        </p>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td align="left" bgcolor="#ffffff">
                                                                                        <p><a href="https://click.email2.office.com/?qs=c78e5528e91b70e76226be395eb8aae7a4e82663a4d328111d70e590bea9b795c878697e4f7d28686b4dada0778ca9d1b8f5e99265ce24c7"
                                                                                                target="_blank"
                                                                                                rel="noopener"><strong>En savoir
                                                                                                    plus</strong></a></p>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                    <td align="right" bgcolor="#f5f5f5" width="48%">
                                                                        <table role="presentation" border="0" width="100%"
                                                                            cellspacing="0" cellpadding="0">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td align="right" bgcolor="#FAF9F8"><img
                                                                                            style="height: auto;"
                                                                                            src="https://image.email2.office.com/lib/fe8f1372766502797c/m/2/bea8dca8-fdea-46c7-b2fd-1db7ec3945ae.jpg"
                                                                                            alt="Capture d&rsquo;&eacute;cran inclin&eacute;e de Microsoft&nbsp;Word avec une ic&ocirc;ne"
                                                                                            width="300" /></td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="height: 16px;" width="2" height="16">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td align="left" valign="top" bgcolor="#FAF9F8">
                                                        <table role="presentation" border="0" width="100%" cellspacing="0"
                                                            cellpadding="0">
                                                            <tbody>
                                                                <tr>
                                                                    <td align="left" valign="middle" bgcolor="#FFFFFF"
                                                                        width="52%">
                                                                        <table role="presentation" border="0" width="100%"
                                                                            cellspacing="0" cellpadding="0">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td align="left" bgcolor="#FFFFFF">
                                                                                        <h1>Prenez le contr&ocirc;le de vos
                                                                                            finances</h1>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td align="left" bgcolor="#FFFFFF">
                                                                                        <p>Les mod&egrave;les de fichiers
                                                                                            budg&eacute;taires
                                                                                            Excel&nbsp;Premium vous permettent
                                                                                            de g&eacute;rer
                                                                                            facilement&nbsp;vos&nbsp;finances.
                                                                                        </p>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td align="left" bgcolor="#ffffff">
                                                                                        <p><a href="https://click.email2.office.com/?qs=c78e5528e91b70e709162c553234099865e801c7f413e9b8c49a6ba4229e6315f6f9a7ba5d9371488ff9ff507ffcc68c5794f04c37667424"
                                                                                                target="_blank"
                                                                                                rel="noopener"><strong>En savoir
                                                                                                    plus</strong></a></p>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                    <td align="right" bgcolor="#f5f5f5" width="48%">
                                                                        <table role="presentation" border="0" width="100%"
                                                                            cellspacing="0" cellpadding="0">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td align="right" bgcolor="#FAF9F8"><img
                                                                                            style="height: auto;"
                                                                                            src="https://image.email2.office.com/lib/fe8f1372766502797c/m/2/1347bad8-577b-477e-ae17-9b7e4bc390e7.jpg"
                                                                                            alt="Capture d&rsquo;&eacute;cran inclin&eacute;e de Microsoft&nbsp;Excel avec une ic&ocirc;ne"
                                                                                            width="300" /></td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="height: 16px;" width="2" height="16">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td align="left" valign="top" bgcolor="#FAF9F8">
                                                        <table role="presentation" border="0" width="100%" cellspacing="0"
                                                            cellpadding="0">
                                                            <tbody>
                                                                <tr>
                                                                    <td align="left" valign="middle" bgcolor="#FFFFFF"
                                                                        width="52%">
                                                                        <table role="presentation" border="0" width="100%"
                                                                            cellspacing="0" cellpadding="0">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td align="left" bgcolor="#FFFFFF">
                                                                                        <h1>Concevoir des diapositives n&rsquo;a
                                                                                            jamais &eacute;t&eacute; aussi
                                                                                            simple</h1>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td align="left" bgcolor="#FFFFFF">
                                                                                        <p>Cr&eacute;ez des diapositives
                                                                                            percutantes au style innovant avec
                                                                                            les fonctions Concepteur et
                                                                                            Id&eacute;es&nbsp;dans&nbsp;PowerPoint.
                                                                                        </p>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td align="left" bgcolor="#ffffff">
                                                                                        <p><a href="https://click.email2.office.com/?qs=c78e5528e91b70e7acb2982bdb3646c9b4e6f2c565297687f73cb9a30157284d1235b6f193ec4000a24724a5149be74448c9ab893b14398e"
                                                                                                target="_blank"
                                                                                                rel="noopener"><strong>En savoir
                                                                                                    plus</strong></a></p>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                    <td align="right" bgcolor="#f5f5f5" width="48%">
                                                                        <table role="presentation" border="0" width="100%"
                                                                            cellspacing="0" cellpadding="0">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td align="right" bgcolor="#FAF9F8"><img
                                                                                            style="height: auto;"
                                                                                            src="https://image.email2.office.com/lib/fe8f1372766502797c/m/2/a6bf8a3d-756a-49c6-a84e-2b3be449e904.jpg"
                                                                                            alt="Capture d&rsquo;&eacute;cran de Microsoft&nbsp;PowerPoint avec une ic&ocirc;ne"
                                                                                            width="300" /></td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="height: 32px;" width="2" height="32">&nbsp;</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" valign="top">
                                        <table role="presentation" border="0" width="100%" cellspacing="0" cellpadding="0">
                                            <tbody>
                                                <tr>
                                                    <td bgcolor="#ffffff">
                                                        <table role="presentation" border="0" width="100%" cellspacing="0"
                                                            cellpadding="0">
                                                            <tbody>
                                                                <tr>
                                                                    <td align="center" bgcolor="#ffffff"><img
                                                                            style="height: auto;"
                                                                            src="https://image.email2.office.com/lib/fe8f1372766502797c/m/2/e8352338-1f83-4c6b-bf30-d3ccb7f923c9.png"
                                                                            alt="Question Mark" width="42" border="0" /></td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="center" bgcolor="#ffffff">
                                                                        <p>Avez-vous des questions avant d&rsquo;acheter un
                                                                            abonnement&nbsp;Microsoft&nbsp;365&nbsp;?</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="center" bgcolor="#ffffff">
                                                                        <p><a href="https://click.email2.office.com/?qs=c78e5528e91b70e7f257a3bbeb02a1af2c55f4cb22a65470139f684d9405560ff170628578319d66ba87ab6a051bc6fbeb053251558d8fa76a02e27d8e780f18"
                                                                                target="_blank" rel="noopener"><strong>Consultez
                                                                                    la FAQ</strong></a></p>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" valign="top">
                                        <table role="presentation" border="0" width="100%" cellspacing="0" cellpadding="0">
                                            <tbody>
                                                <tr>
                                                    <td valign="top" bgcolor="#f2f2f2">
                                                        <table role="presentation" border="0" width="100%" cellspacing="0"
                                                            cellpadding="0">
                                                            <tbody>
                                                                <tr>
                                                                    <td align="left" bgcolor="#f2f2f2">
                                                                        <p><sup>*</sup>&nbsp;Obtenez 3&nbsp;mois de
                                                                            Microsoft&nbsp;365 pour seulement 1 &euro;. Moyen de
                                                                            paiement requis. Apr&egrave;s les 3&nbsp;premiers
                                                                            mois, votre abonnement se renouvellera
                                                                            automatiquement en un abonnement annuel. Vous devrez
                                                                            payer&nbsp;99,00 &euro;&nbsp;par an pour poursuivre
                                                                            votre abonnement et serez inform&eacute; de tout
                                                                            changement de prix. Vous pouvez annuler &agrave;
                                                                            tout moment afin d&rsquo;arr&ecirc;ter les
                                                                            pr&eacute;l&egrave;vements sur&nbsp;<a
                                                                                href="https://click.email2.office.com/?qs=c78e5528e91b70e749dd9761b910f125644ce65fd1010b6e6046856a3dadbd23f10dac765884e6198fe820e43fc262ae15a7f9bcfe6e2457"
                                                                                target="_blank"
                                                                                rel="noopener"><strong>account.microsoft.com</strong></a>.
                                                                            Les abonn&eacute;s actuels
                                                                            &agrave;&nbsp;Microsoft&nbsp;365&nbsp;ne sont pas
                                                                            &eacute;ligibles. L&rsquo;offre est limit&eacute;e
                                                                            dans le temps et n&rsquo;est pas disponible pour
                                                                            tous les march&eacute;s. Une offre par compte
                                                                            Microsoft. Le b&eacute;n&eacute;ficiaire doit
                                                                            &ecirc;tre le destinataire initial de cette offre.
                                                                            L&rsquo;offre ne peut &ecirc;tre
                                                                            transf&eacute;r&eacute;e ou combin&eacute;e &agrave;
                                                                            d&rsquo;autres promotions. Microsoft se
                                                                            r&eacute;serve le droit de modifier ses offres ou
                                                                            d&rsquo;y mettre fin &agrave; tout moment.</p>
                                                                    </td>
                                                                </tr>
                                                                <tr></tr>
                                                                <tr>
                                                                    <td align="left" bgcolor="#F0F0F0">
                                                                        <p><a href="https://click.email2.office.com/?qs=c78e5528e91b70e7827b2326419af170fdcf1a429ef045dde1c4b88fdc8b09263e312322bc9d722dcd9183d8a810f3adf7218015d8bc7520467a433bbce6e871"
                                                                                target="_blank"
                                                                                rel="noopener"><strong>D&eacute;claration de
                                                                                    confidentialit&eacute;</strong></a>&nbsp;
                                                                            |&nbsp;<a
                                                                                href="https://click.email2.office.com/?qs=c78e5528e91b70e7a30b8c39de1b4e8fa2237fb6d0ad031e6650850d91bad7a4359f878ebf0a6f6c50087ea280a31588634ea2256da0a412bee08cd2d56cccba"
                                                                                target="_blank" rel="noopener"><strong>Se
                                                                                    d&eacute;sabonner</strong></a></p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="left" bgcolor="#F0F0F0">
                                                                        <p>Microsoft Corporation, One Microsoft Way, Redmond, WA
                                                                            98052</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="center">
                                                                        <table role="presentation" border="0" width="100%"
                                                                            cellspacing="0" cellpadding="0">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td align="left" width="21.875%"><img
                                                                                            style="height: auto; width: 130px;"
                                                                                            src="http://image.email2.office.com/lib/fe8f1372766502797c/m/1/Microsoft_Logo.png"
                                                                                            alt="Microsoft" width="130"
                                                                                            border="0" /></td>
                                                                                    <td width="78.125%">&nbsp;</td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
        <p><img style="height: auto;"
                src="https://click.email2.office.com/open.aspx?ffcb10-fecb157677670c7d-fe0b15777564067d77177474-fe8f1372766502797c-ff961677-fe1d15727c6d0d78731174-ff3917707567&amp;d=70193&amp;bmt=0"
                alt="" width="1" height="1" />
        </p>

    HTML;
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}