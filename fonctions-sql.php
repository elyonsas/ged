<?php

    // Insert
    function insert($table, $data, PDO $db)
    {
        $sql = "INSERT INTO $table (";
        $sql .= implode(", ", array_keys($data));
        $sql .= ") VALUES (";
        $sql .= ":" . implode(", :", array_keys($data));
        $sql .= ")";
        $stmt = $db->prepare($sql);
        if ($stmt->execute($data)) {
            return true;
        } else {
            return false;
        }
    }

    function insert1($table, $data, PDO $db)
    {

        $values = [];
        foreach ($data as $value) {
            $values[] = "'$value'";
        }
        $sql = "INSERT INTO $table (";
        $sql .= implode(", ", array_keys($data));
        $sql .= ") VALUES (";
        $sql .= implode(", ", $values);
        $sql .= ")";
        return $sql;
    }

    // Update
    function update($table, $data, $where, PDO $db)
    {
        $sql = "UPDATE $table SET ";
        $sql .= implode(" = ?, ", array_keys($data));
        $sql .= " = ? WHERE $where";
        $stmt = $db->prepare($sql);
        if ($stmt->execute(array_values($data))) {
            return true;
        } else {
            return false;
        }
    }

    // function update1 with array_values and without ? in the query
    function update1($table, $data, $where, PDO $db)
    {
        $data_req = [];
        foreach ($data as $key => $value) {
            $date_req[] = "$key = '$value'";
        }
        $sql = "UPDATE $table SET ";
        $sql .= implode(", ", $data_req);
        $sql .= " WHERE $where";
        return $sql;
    }

    // Delete
    function delete($table, $where, PDO $db)
    {
        $sql = "DELETE FROM $table WHERE $where";
        $stmt = $db->prepare($sql);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function delete1($table, $where, PDO $db)
    {
        $sql = "DELETE FROM $table WHERE $where";
        return $sql;
    }



    function select_all_valide_article_redacteur($id_redacteur, PDO $db)
    {

        $query = "SELECT COUNT(*) as articles FROM redacteur, article WHERE redacteur.id_redacteur = article.id_redacteur 
            AND redacteur.id_redacteur = :id_redacteur AND statut_article = 'valide' ";
        $statement = $db->prepare($query);
        $statement->execute([
            ':id_redacteur' => $id_redacteur
        ]);
        $result = $statement->fetch();

        return $result['articles'];
    }

    function redacteur_article_datatable_html($id_redacteur, PDO $db)
    {

        if ($id_redacteur == NULL) {

            $html = <<< HTML
                <td>
                    <!--begin::User-->
                    <div class="d-flex align-items-center">
                    <!--begin::Wrapper-->
                    <div class="me-5 position-relative">
                        <!--begin::Avatar-->
                        <div class="symbol symbol-35px symbol-circle">
                        <img alt="Pic" src="assets/media/avatars/null.png" />
                        </div>
                        <!--end::Avatar-->
                    </div>
                    <!--end::Wrapper-->
                    <!--begin::Info-->
                    <div class="d-flex flex-column justify-content-center">
                        <a href="" class="fs-6 text-gray-800 text-hover-primary">null null</a>
                        <div class="fw-semibold text-gray-400">null</div>
                    </div>
                    <!--end::Info-->
                    </div>
                    <!--end::User-->
                </td>
            HTML;

            return $html;

        } else {
            $query = "SELECT * FROM utilisateur, redacteur WHERE utilisateur.id_utilisateur = redacteur.id_utilisateur AND redacteur.id_redacteur = :id_redacteur";
            $statement = $db->prepare($query);
            $statement->execute([
                ':id_redacteur' => $id_redacteur
            ]);
            $result = $statement->fetch();

            $nom = $result['nom_utilisateur'];
            $prenom = $result['prenom_utilisateur'];
            $email = $result['email_utilisateur'];
            $avatar = $result['avatar_utilisateur'];

            $html = <<< HTML
                <td>
                    <!--begin::User-->
                    <div class="d-flex align-items-center">
                    <!--begin::Wrapper-->
                    <div class="me-5 position-relative">
                        <!--begin::Avatar-->
                        <div class="symbol symbol-35px symbol-circle">
                        <img alt="Pic" src="assets/media/avatars/{$avatar}" />
                        </div>
                        <!--end::Avatar-->
                    </div>
                    <!--end::Wrapper-->
                    <!--begin::Info-->
                    <div class="d-flex flex-column justify-content-center">
                        <a href="" class="fs-6 text-gray-800 text-hover-primary">$prenom $nom</a>
                        <div class="fw-semibold text-gray-400">$email</div>
                    </div>
                    <!--end::Info-->
                    </div>
                    <!--end::User-->
                </td>
            HTML;

            return $html;
        }
    }

    function find_info_utilisateur($info, $id_utilisateur, PDO $db)
    {

        $query = "SELECT $info FROM utilisateur WHERE id_utilisateur = :id_utilisateur";
        $statement = $db->prepare($query);
        $statement->execute([
            ':id_utilisateur' => $id_utilisateur
        ]);
        $result = $statement->fetch();

        return $result["$info"];
    }

    //// Pour les stats tableau de bord fournisseur

    function stat_article_en_cour(PDO $db, $acces = null)
    {

        if ($acces != null) {

            $query = "SELECT COUNT(*) stat_article_en_cour FROM article WHERE article.id_fournisseur = {$_SESSION['id_fournisseur']} 
                AND statut_article = 'en cour' AND acces_article = '$acces'";
            $statement = $db->prepare($query);
            $statement->execute();
            $result = $statement->fetch();
        } else {

            $query = "SELECT COUNT(*) stat_article_en_cour FROM article WHERE article.id_fournisseur = {$_SESSION['id_fournisseur']} 
                AND statut_article = 'en cour'";
            $statement = $db->prepare($query);
            $statement->execute();
            $result = $statement->fetch();
        }

        return $result['stat_article_en_cour'];
    }

    function stat_article_en_attente(PDO $db)
    {

        $query = "SELECT COUNT(*) stat_article_en_attente FROM article WHERE article.id_fournisseur = {$_SESSION['id_fournisseur']} AND statut_article = 'en attente'";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        return $result['stat_article_en_attente'];
    }

    function stat_article_modification(PDO $db)
    {

        $query = "SELECT COUNT(*) stat_article_modification FROM article WHERE article.id_fournisseur = {$_SESSION['id_fournisseur']} AND statut_article = 'modification'";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        return $result['stat_article_modification'];
    }

    function stat_article_termine(PDO $db)
    {

        $query = "SELECT COUNT(*) stat_article_termine FROM article WHERE article.id_fournisseur = {$_SESSION['id_fournisseur']} AND statut_article = 'termine'";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        return $result['stat_article_termine'];
    }

    function stat_article_valide(PDO $db, $date = null)
    {

        if ($date != null) {

            $query = "SELECT COUNT(*) stat_article_valide FROM article WHERE article.id_fournisseur = {$_SESSION['id_fournisseur']} 
                AND statut_article = 'valide' AND date_valide_article LIKE :date_valide_article";
            $statement = $db->prepare($query);
            $statement->execute([
                ':date_valide_article' => $date . '%'
            ]);
            $result = $statement->fetch();
        } else {

            $query = "SELECT COUNT(*) stat_article_valide FROM article WHERE article.id_fournisseur = {$_SESSION['id_fournisseur']} 
                AND statut_article = 'valide' AND date_valide_article LIKE :date_valide_article";
            $statement = $db->prepare($query);
            $statement->execute([
                ':date_valide_article' => date('Y-m-d') . '%'
            ]);
            $result = $statement->fetch();
        }

        return $result['stat_article_valide'];
    }

    function max_article_valide(PDO $db, $week)
    {
        $date_array = [];
        if ($week == 'this week') {

            $today = date('Y-m-d');
            $today_1 = date('Y-m-d', strtotime('-1 day'));
            $today_2 = date('Y-m-d', strtotime('-2 days'));
            $today_3 = date('Y-m-d', strtotime('-3 days'));
            $today_4 = date('Y-m-d', strtotime('-4 days'));
            $today_5 = date('Y-m-d', strtotime('-5 days'));
            $today_6 = date('Y-m-d', strtotime('-6 days'));

            $date_array = [
                'today' => stat_article_valide($db, $today),
                'today_1' => stat_article_valide($db, $today_1),
                'today_2' => stat_article_valide($db, $today_2),
                'today_3' => stat_article_valide($db, $today_3),
                'today_4' => stat_article_valide($db, $today_4),
                'today_5' => stat_article_valide($db, $today_5),
                'today_6' => stat_article_valide($db, $today_6)
            ];
        } else {

            $today_7 = date('Y-m-d', strtotime('-7 day'));
            $today_8 = date('Y-m-d', strtotime('-8 day'));
            $today_9 = date('Y-m-d', strtotime('-9 days'));
            $today_10 = date('Y-m-d', strtotime('-10 days'));
            $today_11 = date('Y-m-d', strtotime('-11 days'));
            $today_12 = date('Y-m-d', strtotime('-12 days'));
            $today_13 = date('Y-m-d', strtotime('-13 days'));

            $date_array = [
                'today_7' => stat_article_valide($db, $today_7),
                'today_8' => stat_article_valide($db, $today_8),
                'today_9' => stat_article_valide($db, $today_9),
                'today_10' => stat_article_valide($db, $today_10),
                'today_11' => stat_article_valide($db, $today_11),
                'today_12' => stat_article_valide($db, $today_12),
                'today_13' => stat_article_valide($db, $today_13)
            ];
        }

        return max($date_array);
    }

    function stat_redacteur_actif(PDO $db)
    {

        $query = "SELECT DISTINCT(redacteur.id_redacteur) FROM article, redacteur, utilisateur, compte 
            WHERE article.id_redacteur = redacteur.id_redacteur AND redacteur.id_utilisateur = utilisateur.id_utilisateur 
            AND utilisateur.id_utilisateur = compte.id_utilisateur AND redacteur.id_fournisseur = {$_SESSION['id_fournisseur']} 
            AND statut_article <> 'en attente' AND statut_article <> 'termine' AND statut_compte = 'actif' ";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->rowCount();

        return $result;
    }

    function nbr_total_redacteur(PDO $db)
    {

        $query = "SELECT COUNT(*) nbr_total_redacteur FROM redacteur, utilisateur, compte
            WHERE redacteur.id_utilisateur = utilisateur.id_utilisateur AND utilisateur.id_utilisateur = compte.id_utilisateur 
            AND redacteur.id_fournisseur = {$_SESSION['id_fournisseur']} AND statut_compte = 'actif' ";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        return $result['nbr_total_redacteur'];
    }

    // stat tendance

    function stat_mois_article_valide(PDO $db, $date = null)
    {

        if ($date != null) {

            $query = "SELECT COUNT(*) stat_article_valide FROM article WHERE article.id_fournisseur = {$_SESSION['id_fournisseur']} 
                AND statut_article = 'valide' AND date_valide_article LIKE :date_valide_article";
            $statement = $db->prepare($query);
            $statement->execute([
                ':date_valide_article' => $date . '%'
            ]);
            $result = $statement->fetch();
        } else {

            $query = "SELECT COUNT(*) stat_article_valide FROM article WHERE article.id_fournisseur = {$_SESSION['id_fournisseur']} 
                AND statut_article = 'valide' AND date_valide_article LIKE :date_valide_article";
            $statement = $db->prepare($query);
            $statement->execute([
                ':date_valide_article' => date('Y-m') . '%'
            ]);
            $result = $statement->fetch();
        }

        return $result['stat_article_valide'];
    }

    function max_mois_article_valide(PDO $db, $six_month)
    {
        $date_array = [];
        if ($six_month == 'six month') {

            $month = date('Y-m');
            $month_1 = date('Y-m', strtotime('-1 month'));
            $month_2 = date('Y-m', strtotime('-2 months'));
            $month_3 = date('Y-m', strtotime('-3 months'));
            $month_4 = date('Y-m', strtotime('-4 months'));
            $month_5 = date('Y-m', strtotime('-5 months'));

            $date_array = [
                'month' => stat_mois_article_valide($db, $month),
                'month_1' => stat_mois_article_valide($db, $month_1),
                'month_2' => stat_mois_article_valide($db, $month_2),
                'month_3' => stat_mois_article_valide($db, $month_3),
                'month_4' => stat_mois_article_valide($db, $month_4),
                'month_5' => stat_mois_article_valide($db, $month_5),
            ];
        } else {

            $month_6 = date('Y-m', strtotime('-6 month'));
            $month_7 = date('Y-m', strtotime('-7 month'));
            $month_8 = date('Y-m', strtotime('-8 month'));
            $month_9 = date('Y-m', strtotime('-9 months'));
            $month_10 = date('Y-m', strtotime('-10 months'));
            $month_11 = date('Y-m', strtotime('-11 months'));

            $date_array = [
                'month_6' => stat_mois_article_valide($db, $month_6),
                'month_7' => stat_mois_article_valide($db, $month_7),
                'month_8' => stat_mois_article_valide($db, $month_8),
                'month_9' => stat_mois_article_valide($db, $month_9),
                'month_10' => stat_mois_article_valide($db, $month_10),
                'month_11' => stat_mois_article_valide($db, $month_11),
            ];
        }

        return max($date_array);
    }





    // ----------------------Begin::id_utilisateur to ...

    // for client
    function find_id_client($id_utilisateur, PDO $db)
    {
        $query = "SELECT id_client FROM client, utilisateur WHERE utilisateur.id_utilisateur = client.id_utilisateur AND utilisateur.id_utilisateur = :id_utilisateur";
        $statement = $db->prepare($query);
        $statement->execute([
            ':id_utilisateur' => $id_utilisateur
        ]);
        $result = $statement->fetch();

        return $result['id_client'];
    }

    // for fournisseur
    function find_id_fournisseur($id_utilisateur, PDO $db)
    {
        $query = "SELECT id_fournisseur FROM fournisseur, utilisateur WHERE utilisateur.id_utilisateur = fournisseur.id_utilisateur AND utilisateur.id_utilisateur = :id_utilisateur";
        $statement = $db->prepare($query);
        $statement->execute([
            ':id_utilisateur' => $id_utilisateur
        ]);
        $result = $statement->fetch();

        return $result['id_fournisseur'];
    }

    // for redacteur
    function find_id_redacteur($id_utilisateur, PDO $db)
    {
        $query = "SELECT id_redacteur FROM redacteur, utilisateur WHERE utilisateur.id_utilisateur = redacteur.id_utilisateur AND utilisateur.id_utilisateur = :id_utilisateur";
        $statement = $db->prepare($query);
        $statement->execute([
            ':id_utilisateur' => $id_utilisateur
        ]);
        $result = $statement->fetch();

        return $result['id_redacteur'];
    }

    // for correcteur
    function find_id_correcteur($id_utilisateur, PDO $db)
    {
        $query = "SELECT id_correcteur FROM correcteur, utilisateur WHERE utilisateur.id_utilisateur = correcteur.id_utilisateur AND utilisateur.id_utilisateur = :id_utilisateur";
        $statement = $db->prepare($query);
        $statement->execute([
            ':id_utilisateur' => $id_utilisateur
        ]);
        $result = $statement->fetch();

        return $result['id_correcteur'];
    }

    // ----------------------End::id_utilisateur to ...







    // -------------------------Begin::... to id_utilisateur

    // for client
    function find_id_utilisateur_client($id_client, PDO $db)
    {
        $query = "SELECT utilisateur.id_utilisateur FROM client, utilisateur WHERE utilisateur.id_utilisateur = client.id_utilisateur AND client.id_client = :id_client";
        $statement = $db->prepare($query);
        $statement->execute([
            ':id_client' => $id_client
        ]);
        $result = $statement->fetch();

        return $result['id_utilisateur'];
    }

    // for fournisseur
    function find_id_utilisateur_fournisseur($id_fournisseur, PDO $db)
    {
        $query = "SELECT utilisateur.id_utilisateur FROM fournisseur, utilisateur WHERE utilisateur.id_utilisateur = fournisseur.id_utilisateur AND fournisseur.id_fournisseur = :id_fournisseur";
        $statement = $db->prepare($query);
        $statement->execute([
            ':id_fournisseur' => $id_fournisseur
        ]);
        $result = $statement->fetch();

        return $result['id_utilisateur'];
    }

    // for redacteur
    function find_id_utilisateur_redacteur($id_redacteur, PDO $db)
    {
        $query = "SELECT utilisateur.id_utilisateur FROM redacteur, utilisateur WHERE utilisateur.id_utilisateur = redacteur.id_utilisateur AND redacteur.id_redacteur = :id_redacteur";
        $statement = $db->prepare($query);
        $statement->execute([
            ':id_redacteur' => $id_redacteur
        ]);
        $result = $statement->fetch();

        return $result['id_utilisateur'];
    }

    // for correcteur
    function find_id_utilisateur_correcteur($id_correcteur, PDO $db)
    {
        $query = "SELECT utilisateur.id_utilisateur FROM correcteur, utilisateur WHERE utilisateur.id_utilisateur = correcteur.id_utilisateur AND correcteur.id_correcteur = :id_correcteur";
        $statement = $db->prepare($query);
        $statement->execute([
            ':id_correcteur' => $id_correcteur
        ]);
        $result = $statement->fetch();

        return $result['id_utilisateur'];
    }

    // -------------------------End::... to id_utilisateur








    // find fournisseur of client
    function find_fournisseur_of_client($id_client, PDO $db)
    {
        $query = "SELECT id_fournisseur FROM client, fournisseur WHERE client.id_fournisseur = fournisseur.id_fournisseur AND client.id_client = :id_client";
        $statement = $db->prepare($query);
        $statement->execute([
            ':id_client' => $id_client
        ]);
        $result = $statement->fetch();

        return $result['id_fournisseur'];
    }

    // find fournisseur of redacteur
    function find_fournisseur_of_redacteur($id_redacteur, PDO $db)
    {
        $query = "SELECT id_fournisseur FROM redacteur, fournisseur WHERE redacteur.id_fournisseur = fournisseur.id_fournisseur AND redacteur.id_redacteur = :id_redacteur";
        $statement = $db->prepare($query);
        $statement->execute([
            ':id_redacteur' => $id_redacteur
        ]);
        $result = $statement->fetch();

        return $result['id_fournisseur'];
    }

    // find fournisseur of correcteur
    function find_fournisseur_of_correcteur($id_correcteur, PDO $db)
    {
        $query = "SELECT id_fournisseur FROM correcteur, fournisseur WHERE correcteur.id_fournisseur = fournisseur.id_fournisseur AND correcteur.id_correcteur = :id_correcteur";
        $statement = $db->prepare($query);
        $statement->execute([
            ':id_correcteur' => $id_correcteur
        ]);
        $result = $statement->fetch();

        return $result['id_fournisseur'];
    }
