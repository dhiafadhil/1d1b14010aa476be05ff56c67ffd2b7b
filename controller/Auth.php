<?php

require_once '../config/db.php';
require_once '../helper/utils.php';

class Auth extends Config {

    public function get_token($token)
    {
        $sql = 'SELECT client_id, token, expire FROM auth_log WHERE token = :token';

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam('token', $token);
        $stmt->execute();

        $rows = $stmt->fetchAll();
        return $rows[0];
    }

    public function generate_token($client_id, $client_secret)
    {
        $token = generateToken($client_id,$client_secret);
        $expire = time() + 86400;
        $sql = 'INSERT INTO auth_log (client_id, token, expire ) VALUES (:client_id, :token, :expire)';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam('client_id', $client_id);
        $stmt->bindParam('token', $token, PDO::PARAM_STR);
        $stmt->bindParam('expire', $expire, PDO::PARAM_STR);
        $stmt->execute();

        return [
            'token' => $token,
            'expire' => $expire
        ];
    }
}

