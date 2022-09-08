<?php

    function insert($table, $column_value, PDO $db){
        $columns = [];
        $values = [];
        foreach($column_value as $column => $value){
            $columns[] = $column;
            $values[] = "'".$value."'";
        }

        $query = "INSERT INTO ".$table." (".implode(',',$columns).") VALUES (".implode(',',$values).")";
        if($db->query($query))
            return true;
        else
            return false;

    }
    function insert1($table, $column_value, PDO $db){
        $columns = [];
        $values = [];
        foreach($column_value as $column => $value){
            $columns[] = $column;
            $values[] = "'".$value."'";
        }

        $query = "INSERT INTO ".$table." (".implode(',',$columns).") VALUES (".implode(',',$values).")";
        // if($db->query($query))
        //     return true;
        // else
        //     return false;
        return $query;

    }

    function update($table, $column_value, $condition, $db){
        $column_value_normal_for_requete = [];
        foreach($column_value as $column => $value){
            $column_value_normal_for_requete[] = $column." = '".$value."'";
        }
        $query = "UPDATE ".$table." SET ".implode(' , ',$column_value_normal_for_requete)." WHERE ".$condition;
        if($db->query($query))
            return true;
        else
            return false;
    }
    function update1($table, $column_value, $condition, $db){
        $column_value_normal_for_requete = [];
        foreach($column_value as $column => $value){
            $column_value_normal_for_requete[] = $column." = '".$value."'";
        }
        $query = "UPDATE ".$table." SET ".implode(' , ',$column_value_normal_for_requete)." WHERE ".$condition;
        
        return $query;
    }

    function delete($table, $condition, $db){
        $query = "DELETE FROM ".$table." WHERE ".$condition;
        if($db->query($query))
            return true;
        else
            return false;
    }

    function select_all_article_redacteur($id_redacteur, PDO $db){

        $query = "SELECT COUNT(*) as articles FROM redacteur, article WHERE redacteur.id_redacteur = article.id_redacteur 
        AND redacteur.id_redacteur = :id_redacteur AND statut_article = 'valide' ";
        $statement = $db->prepare($query);
        $statement->execute([
            ':id_redacteur' => $id_redacteur
        ]);
        $result = $statement->fetch();

        return $result['articles'];

    }

    //// Pour les stats tableau de bord fournisseur

    function stat_article_en_cour(PDO $db, $acces = null){

        if($acces != null){

            $query = "SELECT COUNT(*) stat_article_en_cour FROM article WHERE statut_article = 'en cour' AND acces_article = '$acces'";
            $statement = $db->prepare($query);
            $statement->execute();
            $result = $statement->fetch();

        }else{

            $query = "SELECT COUNT(*) stat_article_en_cour FROM article WHERE statut_article = 'en cour'";
            $statement = $db->prepare($query);
            $statement->execute();
            $result = $statement->fetch();

        }

        return $result['stat_article_en_cour'];
    }

    function stat_article_en_attente(PDO $db){

        $query = "SELECT COUNT(*) stat_article_en_attente FROM article WHERE statut_article = 'en attente'";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        return $result['stat_article_en_attente'];
    }

    function stat_article_modification(PDO $db){

        $query = "SELECT COUNT(*) stat_article_modification FROM article WHERE statut_article = 'modification'";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        return $result['stat_article_modification'];
    }

    function stat_article_termine(PDO $db){

        $query = "SELECT COUNT(*) stat_article_termine FROM article WHERE statut_article = 'termine'";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        return $result['stat_article_termine'];
    }

    function stat_article_valide(PDO $db, $date = null){

        if($date != null){

            $query = "SELECT COUNT(*) stat_article_valide FROM article WHERE statut_article = 'valide' AND date_valide_article LIKE :date_valide_article";
            $statement = $db->prepare($query);
            $statement->execute([
                ':date_valide_article' => $date . '%'
            ]);
            $result = $statement->fetch();

        }else{

            $query = "SELECT COUNT(*) stat_article_valide FROM article WHERE statut_article = 'valide' AND date_valide_article LIKE :date_valide_article";
            $statement = $db->prepare($query);
            $statement->execute([
                ':date_valide_article' => date('Y-m-d') . '%'
            ]);
            $result = $statement->fetch();

        }

        return $result['stat_article_valide'];
    }

    function max_article_valide(PDO $db, $week){
        $date_array = [];
        if($week == 'this week'){

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

        }else{

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

    function stat_redacteur_actif(PDO $db){

        $query = "SELECT DISTINCT(redacteur.id_redacteur) FROM article, redacteur, utilisateur, compte 
        WHERE article.id_redacteur = redacteur.id_redacteur AND redacteur.id_utilisateur = utilisateur.id_utilisateur 
        AND utilisateur.id_utilisateur = compte.id_utilisateur AND statut_article <> 'en attente' AND statut_article <> 'termine' AND statut_compte = 'actif'";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->rowCount();

        return $result;

    }

    function nbr_total_redacteur(PDO $db){

        $query = "SELECT COUNT(*) nbr_total_redacteur FROM redacteur, utilisateur, compte
        WHERE redacteur.id_utilisateur = utilisateur.id_utilisateur AND utilisateur.id_utilisateur = compte.id_utilisateur AND statut_compte = 'actif'";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        return $result['nbr_total_redacteur'];
    }

    // stat tendance

    function stat_mois_article_valide(PDO $db, $date = null){

        if($date != null){

            $query = "SELECT COUNT(*) stat_article_valide FROM article WHERE statut_article = 'valide' AND date_valide_article LIKE :date_valide_article";
            $statement = $db->prepare($query);
            $statement->execute([
                ':date_valide_article' => $date . '%'
            ]);
            $result = $statement->fetch();

        }else{

            $query = "SELECT COUNT(*) stat_article_valide FROM article WHERE statut_article = 'valide' AND date_valide_article LIKE :date_valide_article";
            $statement = $db->prepare($query);
            $statement->execute([
                ':date_valide_article' => date('Y-m') . '%'
            ]);
            $result = $statement->fetch();

        }

        return $result['stat_article_valide'];
    }

    function max_mois_article_valide(PDO $db, $six_month){
        $date_array = [];
        if($six_month == 'six month'){

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

        }else{

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


?>