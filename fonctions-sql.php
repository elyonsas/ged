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



function select_all_actifs_dossiers_collabo($id_collabo, PDO $db)
{
    $query = "SELECT COUNT(*) as dossiers FROM client, collaborateur, assoc_client_collabo WHERE client.id_client = assoc_client_collabo.id_client 
        AND collaborateur.id_collaborateur = assoc_client_collabo.id_collaborateur AND statut_assoc_client_collabo = 'actif' AND collaborateur.id_collaborateur = :id_collabo";
    $statement = $db->prepare($query);
    $statement->execute([
        'id_collabo' => $id_collabo
    ]);
    $result = $statement->fetch();

    return $result['dossiers'];
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

function compte_exists($email, PDO $db)
{
    $query = "SELECT * FROM compte WHERE email_compte = :email_compte";
    $statement = $db->prepare($query);
    $statement->execute([
        ':email_compte' => $email
    ]);
    $result = $statement->fetch();
    if ($result) {
        return true;
    } else {
        return false;
    }
}
