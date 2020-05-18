<?php

namespace App\Models;

use App\Core\Model;
use PDO;
use PDOException;

class Kategori extends Model {
    // Method untuk mendapatkan nama_kategori berdasarkan id
    public static function getById($id) {
        try {
            $db = static::getDb();
            $stmt = $db->prepare('SELECT nama_kategori FROM kategori WHERE id = :id');
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo "Terjadi kegagalan koneksi ke database";
        }
    }

    // Method untuk mendapatkan seluruh entry kategori pada database
    public static function getAll() {
        try {
            $db = static::getDb();
            $stmt = $db->query('SELECT * FROM kategori');
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo "Terjadi kegagalan koneksi ke database";
        }
    }

}

?>