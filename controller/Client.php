<?php

require_once '../config/db.php';
require_once '../helper/utils.php';

class Client extends Config {

    public function fetch($client_id) {
        $sql = 'SELECT client_id,client_secret FROM client';

        if ($client_id != '') {
            $sql .= ' WHERE client_id = :client_id';
        }

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam('client_id', $client_id);
        $stmt->execute();

        $rows = $stmt->fetchAll();
        return $rows;
    }

    public function insert($client_id, $client_secret) {
        $timestamp = getCurrentTimestamp();
        $sql = 'INSERT INTO client (client_id, client_secret, timestamp ) VALUES (:client_id, :client_secret, :timestamp)';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['client_id' => $client_id, 'client_secret' => $client_secret, 'timestamp' => $timestamp]);

        return true;
    }

    public function update($client_id, $client_secret) {
        $sql = 'UPDATE client SET client_id = :client_id, client_secret = :client_secret WHERE client_id = :client_id';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['client_id' => $client_id, 'client_secret' => $client_secret]);
        return true;
    }


    public function delete($client_id) {
        $sql = 'DELETE FROM client WHERE client_id = :client_id';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['client_id' => $client_id]);
        return true;
    }

    public function getClient($client_id, $client_secret) {
        $sql = 'SELECT client_id,client_secret FROM client  WHERE client_id = :client_id and client_secret = :client_secret';

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam('client_id', $client_id);
        $stmt->bindParam('client_secret', $client_secret);
        $stmt->execute();

        $rows = $stmt->fetchAll();
        return $rows[0];
    }
}

?>