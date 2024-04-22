// delete_deck.js

function deleteDeck(deckId) {
    var confirmation = confirm("Czy na pewno chcesz usunąć ten deck?");

    if (confirmation) {
        var xhr = new XMLHttpRequest();
        var url = 'delete_deck.php';
        var params = 'deck_id=' + encodeURIComponent(deckId);

        xhr.open('POST', url, true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    var response = JSON.parse(xhr.responseText);

                    if (response.success) {
                        alert(response.message);
                        window.location.reload(); // Przeładuj stronę po pomyślnym usunięciu decka
                    } else {
                        alert(response.message);
                    }
                } else {
                    alert('Wystąpił błąd podczas komunikacji z serwerem.');
                }
            }
        };

        xhr.send(params);
    }
}
