
 var kapaliyollar =[];
 var elevatorsarray =[];
 var stairsarray=[];
  // İlk açılışta kat planlarını oluştur
    createFloorPlans();

   
    // Kat planlarını veri tabanından alıp otomatik oluştur
    function createFloorPlans() {
        $.ajax({
            url: 'router/mainrouter.php', // Kat verilerini almak için PHP isteği
            type: 'POST',
            data: {
                mode: 'getFloors' // Veritabanından katları çekmek için mod
            },
            dataType: 'json',
            success: function(response) {
                console.log(response);
                let floors = response.floors; // Kat bilgileri ve koordinatlar
                let elevators = response.elevetors;
                let stairs = response.stairs;
                let kapali = response.closedarea;

                kapali.forEach(element => {
                kapaliyollar.push(element);    
                });

              
                elevators.forEach(element => {
                    elevatorsarray.push(element);    
                }); 
               
                stairs.forEach(element => {
                    stairsarray.push(element);    
                });
                // Veritabanından gelen bilgileri gruplara ayırarak işleme
                let groupedFloors = groupByFloor(floors);
                console.log("Kapalı yollar : "+kapaliyollar);
                console.log("Asansorler" + elevatorsarray);
                console.log("Merdivenler " + stairsarray);
                
                // Tabloları dinamik olarak oluştur
                for (let floor in groupedFloors) {
                    createFloorGrid(floor); // Kat için tablo ve başlık oluştur
                    createTable(`gridTable-${floor}`); // Kat için tabloyu oluştur
                    updateGridTable(`gridTable-${floor}`, groupedFloors[floor]); // Tabloda koordinatları işaretle
                }
            },
            error: function(xhr, status, error) {
                console.error("Hata: ", error);
            }
        });
      
    }

    // Kat verilerini kat adına göre gruplandıran fonksiyon
    function groupByFloor(floorData) {
        return floorData.reduce((acc, current) => {
            // Eğer kat daha önce eklenmemişse, boş bir dizi başlat
            if (!acc[current.floor]) {
                acc[current.floor] = [];
            }
            // Geçerli katın bilgilerini ekle
            acc[current.floor].push(current);
            return acc;
        }, {});
    }

    // Her kat için bir başlık ve tablo oluştur
    function createFloorGrid(floorName) {
        // HTML yapısını oluştur ve sayfaya ekle
        const floorHtml = `
    <div class="floor-section">
        <h3> KAT : ${floorName}</h3>
        <table id="gridTable-${floorName}" class="table table-bordered"></table>
    </div>
`;
        $('#floorPlans').append(floorHtml); // "floorPlans" id'li konteynıra ekle
    }

    // Tabloyu bir defa oluştur ve ID'leri ata
    function createTable(tableId) {
        const letters = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K'];
        let tableHtml = '<thead><tr><th></th>';

        // Harf sütunları
        for (let i = 0; i < 11; i++) {
            tableHtml += `<th>${letters[i]}</th>`;
        }
        tableHtml += '</tr></thead><tbody>';

        // Hücrelerin oluşturulması
        for (let i = 1; i <= 11; i++) {
            tableHtml += `<tr><th>${i}</th>`;
            for (let j = 1; j <= 11; j++) {
                const cellId = `cell-${i}-${j}`;
                tableHtml += `<td id="${tableId}-${cellId}"></td>`;
            }
            tableHtml += '</tr>';
        }
        tableHtml += '</tbody>';

        // Tablonun HTML'ye eklenmesi
        $(`#${tableId}`).html(tableHtml);
    }

    // Grid tablosunu güncelleyen fonksiyon
    function updateGridTable(tableId, markedCoordinates) {
        $.each(markedCoordinates, function(index, coord) {
            const x = coord.x;
            const y = coord.y;
            const storeName = coord.storeName || ''; // Mağaza adı, yoksa boş
            const style = coord.style || '#ffffff'; // Varsayılan stil beyaz

            const cellId = `${tableId}-cell-${y}-${x}`;
            const $cell = $(`#${cellId}`);

            $cell.css('background-color', style); // Hücre rengini ayarla
            $cell.addClass('text-white'); // Hücreyi işaretle
            $cell.text(storeName); // Mağaza adını hücreye yaz
        });
    }
