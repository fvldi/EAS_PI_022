<?php

namespace App\Models;

use App\Core\Model;
use PDO;
use PDOException;

class Donasi extends Model {

    // Method untuk memasukkan data transaksi kedalam database
    public static function create($data) {
        try {
            $db = static::getDb();
            $id_transaksi = static::getLatestIdTransaksi();
            $id_transaksi = $id_transaksi+1;
            $donatur = $data['donatur'];
            $email_donatur = $data['email_donatur'];
            foreach ($data['donasi'] as $entry) {
                $sql = "INSERT INTO donasi VALUES('', :id_transaksi, :donatur, :email_donatur, :id_kategori, :deskripsi, :kuantitas, CURRENT_TIMESTAMP)";
                $stmt = $db->prepare($sql);

                $stmt->bindParam(":id_transaksi", $id_transaksi);
                $stmt->bindParam(":donatur", $donatur);
                $stmt->bindParam(":email_donatur", $email_donatur);
                $stmt->bindParam(":id_kategori", $entry['id_kategori']);
                $stmt->bindParam(":deskripsi", $entry['deskripsi']);
                $stmt->bindParam(":kuantitas", $entry['kuantitas']);
    
                $stmt->execute();
            }
            
            return 1;
        } catch (PDOException $e) {
            echo "Terjadi kegagalan saat menyimpan data";
        }
    }

    // Method untuk mendapatkan seluruh entry donasi pada database
    public static function getAll() {
        try {
            $db = static::getDb();
            $stmt = $db->query(
                'SELECT 
                    donasi.id,
                    donasi.id_transaksi,
                    donasi.donatur,
                    donasi.email_donatur,
                    donasi.deskripsi,
                    donasi.kuantitas,
                    donasi.date,
                    kategori.nama_kategori
                FROM donasi LEFT JOIN kategori ON donasi.id_kategori=kategori.id'
            );
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo "Terjadi kegagalan koneksi ke database";
        }
    }

    // Method untuk mendapatkan entry donasi berdasarkan kategori pada database
    public static function getByCategory($id_kategori) {
        try {
            $db = static::getDb();
            $stmt = $db->prepare('SELECT 
                donasi.id,
                donasi.id_transaksi,
                donasi.donatur,
                donasi.email_donatur,
                donasi.deskripsi,
                donasi.kuantitas,
                donasi.date,
                kategori.nama_kategori 
            FROM donasi LEFT JOIN kategori ON donasi.id_kategori = kategori.id WHERE id_kategori = :id_kategori');
            $stmt->bindParam(':id_kategori', $id_kategori);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo "Terjadi kegagalan koneksi ke database";
        }
    }

    // Method untuk mendapatkan id_transaksi terbaru
    public static function getLatestIdTransaksi() {
        try {
            $db = static::getDb();
            $stmt = $db->prepare("SELECT id_transaksi FROM donasi ORDER BY id_transaksi DESC LIMIT 1");
            $stmt->execute();
            $id_transaksi = $stmt->fetchColumn();

            return $id_transaksi;
        } catch (PDOException $e) {
            echo "Terjadi kegagalan koneksi ke database";
        }
    }

}

?>