<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grid with AJAX and Selectbox</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</head>

<body>
    <style>
        table tr td {
            max-width: 15px;
            max-height: 30px !important;
            border: 1px solid black !important;
            text-align: center;
        }
    </style>

    <?php
    require_once __DIR__ . '/models/vt.php';



    ?>
    <div class="container">
        <!-- Selectbox to choose the market -->
        <!-- Seçim kutuları -->
        <div class="card w-100 p-5 ">
            <div class="card-body">
                <div class="row gap-2">
                    <!-- Sol Kısım: Bulunduğunuz Kat -->
                    <div class="col-md-12 border  p-4">
                     
                        <h4 class="text-center">Bulunduğunuz Kat</h4>
                        <div class="form-group">
                            <label for="startSelect">Başlangıç Yeriniz:</label>
                            <select id="startSelect" class="form-control">
                                <option value="" selected disabled>Yeriniz</option>
                                <?php foreach ($vt->veriGetir(0, "kiosks", "", [], "") as $v) {
                                    ?>
                                    <option
                                        value="<?= $v['x_coordinate'] . "-" . $v['y_coordinate'] . "-" . $v['floor_id'] ?>">
                                        <?= $v['kiosk_name'] ?></option>
                                    <?php
                                } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="endSelect">Hedef Seçin:</label>
                            <select id="endSelect" class="form-control">
                                <option value="" selected disabled>Yeriniz</option>
                                <?php foreach ($vt->veriGetir(0, "stores", "", [], "") as $v) {
                                    ?>
                                    <option
                                        value="<?= $v['x_coordinate'] . "-" . $v['y_coordinate'] . "-" . $v['floor_id'] ?>">
                                        <?= $v['store_name'] ?></option>
                                    <?php
                                } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary" id="getpath">Sonuç</button>
                        </div>
                    </div>


                </div>

                <!-- Grid Tablosu Alt Satırda -->
                <div class="row mt-3">
                    <div class="col-12">
                        <div id="floorPlans"></div> <!-- Kat planlarının geleceği yer -->

                    </div>
                </div>
            </div>
        </div>


        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

        <script src="js/cizim.js"></script>
        <script src="js/main.js">

        </script>





</body>

</html>