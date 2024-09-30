$(document).ready(() => {

    $("#getpath").click(function() {
        var baslangic = $("#startSelect").val();
        var bitis = $("#endSelect").val();

        // Başlangıç ve hedef noktalarını kapalı yollar listesinde çıkar
        var indexStart = kapaliyollar.indexOf(baslangic);
        if (indexStart > -1) {
            kapaliyollar.splice(indexStart, 1);
        }

        var indexEnd = kapaliyollar.indexOf(bitis);
        if (indexEnd > -1) {
            kapaliyollar.splice(indexEnd, 1);
        }


        $.ajax({
            url: 'router/mainrouter.php',
            type: 'POST',
            data: {
                mode: 'getPathDif',
                baslangic: baslangic,
                bitis: bitis,
                yasaklilar: JSON.stringify(kapaliyollar), // Kapalı yolları JSON formatında gönder
                merdivenler: JSON.stringify(stairsarray),
                asansorler: JSON.stringify(elevatorsarray),
                floorCount: 2
            },
            dataType: 'json',
            success: function(response) {
                console.log("yol : " + response);
                insertMap(response); // Haritayı güncelle

            },
            error: function(xhr, status, error) {
                console.error("Hata: ", error);
            }
        });
    });
})

function haveCommonElements(arr1, arr2) {
    // Bir diziyi Set'e dönüştürerek, hızlı arama için kullanırız
    const set1 = new Set(arr1);

    // Diğer diziyi tarar ve herhangi bir eleman Set'te varsa, true döner
    for (const item of arr2) {
        if (set1.has(item)) {
            return true;
        }
    }

    return false;
}

function formatPathCoordinates(pathCoordinates) {
    return pathCoordinates.map(coord => {
        const [x, y] = coord.split('-').slice(0, 2); // Sadece x ve y'yi al
        return `${x}-${y}`; // Format: "x-y"
    });
}

function insertMap(pathcoordinates) {
    clearMap(); // Haritayı temizle

    $.each(pathcoordinates, function(index, coord) {
        // İlk ve son koordinatları işleme alma
        if (index === 0 || index === pathcoordinates.length - 1) {
            return true; // Döngüye devam et, bu koordinatı atla
        }

        // Mevcut ve önceki koordinatları ayır
        const [x, y, floor] = coord.split('-'); // Katı da dahil ederek koordinatları ayır
        const tableId = `gridTable-${floor}`; // Kat bazında dinamik tablo ID'si oluştur

        // Önceki koordinat
        let prevCoord = index > 0 ? pathcoordinates[index - 1].split('-') : null;
        if (prevCoord) {
            // Önceki koordinatın yerini belirleyin
            const prevFloor = prevCoord[2];
            const prevX = prevCoord[0];
            const prevY = prevCoord[1];

            // Eğer kat değişimi varsa ve önceki kat farklı ise
            const katDegisti = prevFloor !== floor;

            // Şu anki hücre kimliğini oluştur
            const cellId = `${tableId}-cell-${y}-${x}`;
            const $cell = $(`#${cellId}`);

            // Önceki hücre kimliğini oluştur
            const prevCellId = `gridTable-${prevFloor}-cell-${prevY}-${prevX}`;
            const $prevCell = $(`#${prevCellId}`);

            const formattedPathCoordinates = formatPathCoordinates(pathcoordinates);

            let text = "Merdivenleri Kullanın";
            if (haveCommonElements(elevatorsarray, formattedPathCoordinates)) {
                text = "Asansöre Binin";
            }

            if ($prevCell.length && katDegisti) {
                // Kat değişimi varsa önceki hücreyi işaretle
                $prevCell.css('background-color', '#ffeb3b'); // Sarı renk ile kat değişimini işaretle
                $prevCell.text(text); // Asansöre binin yazısını ekle
            }

            if ($cell.length) {
                if (katDegisti) {
                    // Kat değiştiyse şu anki hücreyi işaretle
                    $cell.css('background-color', '#ffeb3b'); // Sarı renk ile kat değişimini işaretle
                    $cell.text("⇅"); // Kat değişimini simgelemek için bir ok işareti ekle
                } else {
                    // Kat değişmediyse normal işaretlemeyi yap
                    $cell.css('background-color', '#c3e6cb'); // Açık yeşil arka plan rengi
                    $cell.text("=="); // Yol işaretini ekle
                }
            }
        }
    });
}



function clearMap() {
    // Tüm tabloları hedef al ve hücreleri temizle
    $('td').each(function() {
        if ($(this).text() === '==') { // Eğer hücre işaretlenmişse
            $(this).css('background-color', ''); // Arka plan rengini sıfırla
            $(this).text(''); // Metni temizle
        }
        if ($(this).text() === 'Merdivenleri Kullanın') { // Eğer hücre işaretlenmişse
            $(this).css('background-color', 'green'); // Arka plan rengini sıfırla
            $(this).text('Stair'); // Metni temizle
        }
        if ($(this).text() === 'Asansöre Binin') { // Eğer hücre işaretlenmişse
            $(this).css('background-color', 'blue'); // Arka plan rengini sıfırla
            $(this).text('Elevator'); // Metni temizle
        }
    });
}