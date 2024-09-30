<?php
require_once __DIR__ . '/../models/vt.php';
require_once __DIR__ . '/../models/node.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mode']) && $_POST['mode'] == "getFloors") {

    $coordinates = array();

    // Sorguyu güvenli bir şekilde çalıştırın
    $data = $vt->veriGetir(
        1,
        " 
     SELECT 
    'Store' AS type, 
    s.store_name AS name, 
    s.x_coordinate, 
    s.y_coordinate, 
    s.style,
    s.description,
    s.floor_id  as 'floor'
FROM stores s
 

UNION ALL
SELECT 
    'Kiosk' AS type, 
    k.kiosk_name AS name, 
    k.x_coordinate, 
    k.y_coordinate,
    k.style,
    NULL AS description,  k.floor_id as 'floor'
FROM kiosks k
 

UNION ALL
SELECT 
    'Closed Point' AS type, 
    'Closed Area' AS name, 
    c.x_coordinate, 
    c.y_coordinate, 
    c.style,
    NULL AS description,
      c.floor_id as 'floor'
FROM closedpoints c
 

UNION ALL
SELECT 
    'Elevator' AS type,
    e.elevator_name AS name, 
    e.x_coordinate, 
    e.y_coordinate, 
    e.style,
    NULL AS description,
      e.floor_id as 'floor'
    FROM elevators e
   
    UNION ALL
SELECT 
    'Stair' AS type,
    st.stairs_name AS name, 
    st.x_coordinate, 
    st.y_coordinate, 
    st.style,
    NULL AS description,
      st.floor_id  as 'floor'
FROM stairs st
 
    ",
        "",
        [],
        ""
    );
    $closed = array();
    $stairs = array();
    $elevators = array();

    foreach ($data as $k => $v) {
        $coordinates[] = array(
            'storeName' => $v['name'], // Mağaza adı veya kiosk adı
            'x' => $v['x_coordinate'], // X koordinatı
            'y' => $v['y_coordinate'],  // Y koordinatı
            'style' => $v['style'],
            'type' => $v['type'],
            'floor' => $v['floor']
        );

        if ($v['type'] == "Store" || $v['type'] == "Elevator" || $v['type'] == "Closed Point") {
            $closed[] =
                $v['x_coordinate'] . "-" . $v['y_coordinate'] . "-" . $v['floor'];
        }
        if ($v['type'] == "Elevator") {
            $elevators[] =
                $v['x_coordinate'] . "-" . $v['y_coordinate'];
        }
        if ($v['type'] == "Stair") {
            $stairs[] =
                $v['x_coordinate'] . "-" . $v['y_coordinate'];
        }
    }

    // JSON olarak döndür
    echo json_encode(array('floors' => $coordinates, 'closedarea' => $closed, 'stairs' => $stairs, 'elevetors' => $elevators));
    return;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mode']) && $_POST['mode'] == "getPathDif") {

    $baslangic = $_POST['baslangic'];

    // Bitiş noktası
    $bitis = $_POST['bitis'];

    // Kapalı hücreler
    $kapaliHucres = json_decode($_POST['yasaklilar'], true);
    $asonsorler = json_decode($_POST['asansorler'], true); // degismesi gerektiği durumlardan bu degiskenler
    $merdivenler = json_decode($_POST['merdivenler'], true); // degismesi gerektiği durumlardan bu degiskenler


    // Eğer kat değişimi yapılacaksa, asansörü yasaklılar listesinden çıkar
    if (explode("-", $baslangic)[2] < explode("-", $bitis)[2] || explode("-", $baslangic)[2] > explode("-", $bitis)[2]) {
        // Asansörün kat bilgilerini çıkararak sadece koordinat kısmını karşılaştırıyoruz
        $asansorKoordinat = "5-5";
        $kapaliHucres = array_filter($kapaliHucres, function ($deger) use ($asansorKoordinat) {
            return strpos($deger, $asansorKoordinat) === false;
        });
    }

    // Merdivenler (tüm katlarda 1-5 koordinatında)

    $stairs = $merdivenler;

    // Asansörler (tüm katlarda 5-5 koordinatında)

    $elevators = $asonsorler;

    // Kat sayısı
    $floorCount = 2;

    // Harita oluştur
    $map = new Map($baslangic, $bitis, $kapaliHucres, $stairs, $elevators, $floorCount);

    // En kısa yolu hesapla
    $shortestPath = $map->calcutePathCordinates();
    echo json_encode($shortestPath);
}

