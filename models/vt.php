<?php

class Vt
{
    var $sunucu = "localhost";
    var $user = "root";
    var $password = "";
    var $dbname = "proje";
    protected  $baglanti;



    function __construct()
    {
        try {
         

            $this->baglanti = new PDO("mysql:host=" . $this->sunucu . ";dbname=" . $this->dbname . ";charset=utf8", $this->user, $this->password);
        } catch (PDOException $error) {
            echo $error->getMessage();
            exit();
        }
    }

    public function getConnection()
    {

        return $this->baglanti;
    }

    public function veriGetir($innerjoin = 0, $tablo, $wherealanlar = "", $wherearraydeger = [], $orderby = "ORDER BY id ASC", $limit = "")
    {
        try {

            $sql = ($innerjoin == 1) ? $tablo : "SELECT * FROM " . $tablo;
            if (!empty($wherealanlar)) {
                $sql .= " " . $wherealanlar;
            }
            if (!empty($orderby)) {
                $sql .= " " . $orderby;
            }
            if (!empty($limit)) {
                $sql .= " LIMIT " . $limit;
            }

            $calistir = $this->baglanti->prepare($sql);


            $sonuc = $calistir->execute($wherearraydeger);
            if ($sonuc) {
                $veri = $calistir->fetchAll(PDO::FETCH_ASSOC);
                if ($veri && !empty($veri)) {
                    return $veri;
                }
            }
            return false;
        } catch (PDOException $e) {
            error_log("Veri getirme hatası: " . $e->getMessage()); // Günlüğe hata yaz
            return false;
        }
    }




    public function sorguCalistir($tablosorgu, $alanlar = "", $degerlerarray = [], $limit = "")
    {
        try {
            $this->baglanti->beginTransaction(); // İşlemi başlat

            // $this->baglanti->query("SET CHARACTER SET utf8");
            $sql = $tablosorgu . " " . $alanlar;
            if (!empty($limit)) {
                $sql .= " LIMIT " . $limit;
            }

            if (!empty($degerlerarray)) {
                $calistir = $this->baglanti->prepare($sql);
                $sonuc = $calistir->execute($degerlerarray);
            } else {
                $sonuc = $this->baglanti->exec($sql);
            }

            $this->baglanti->commit(); // İşlemi tamamla
            return true; // Başarılı olursa true döndür

        } catch (PDOException $e) {
            // Hata olursa işlemi geri al ve false döndür
            $this->baglanti->rollback();
            echo $e->getMessage();
            error_log("Veritabanı hatası: " . $e->getMessage()); // Günlüğe hata yaz
            return false;
        }
    }
    public function sorguCalistirSonIdAl($tablosorgu, $alanlar = "", $degerlerarray = [], $limit = "")
    {
        try {
            $this->baglanti->beginTransaction(); // İşlemi başlat

            //  $this->baglanti->query("SET CHARACTER SET utf8");
            $sql = $tablosorgu . " " . $alanlar;
            if (!empty($limit)) {
                $sql .= " LIMIT " . $limit;
            }

            if (!empty($degerlerarray)) {
                $calistir = $this->baglanti->prepare($sql);
                $sonuc = $calistir->execute($degerlerarray);
            } else {
                $sonuc = $this->baglanti->exec($sql);
            }

            // Son eklenen ID'yi al
            $lastInsertId = $this->baglanti->lastInsertId();

            $this->baglanti->commit(); // İşlemi tamamla
            return $lastInsertId; // Son eklenen ID'yi döndür

        } catch (PDOException $e) {
            // Hata olursa işlemi geri al ve false döndür
            $this->baglanti->rollback();
            echo $e->getMessage();
            error_log("Veritabanı hatası: " . $e->getMessage()); // Günlüğe hata yaz
            return false;
        }
    }
}

$vt = new Vt();
