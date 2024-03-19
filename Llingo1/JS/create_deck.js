function deleteCard(deckId, cardId) {
    var confirmation = confirm("Czy na pewno chcesz usunąć tę fiszkę?");

    if (confirmation) {
        var xhr = new XMLHttpRequest();
        var url = 'delete_card.php';
        var params = 'card_id=' + encodeURIComponent(cardId);

        xhr.open('POST', url, true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    var response = JSON.parse(xhr.responseText);

                    if (response.success) {
                        alert(response.message);
                        window.location.reload(); // Przeładuj stronę po pomyślnym usunięciu fiszki
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
function updateCardContainer(deckId) {
    var xhr = new XMLHttpRequest();
    var url = 'get_cards.php'; // Replace with the actual endpoint to fetch cards
    var params = 'deck_id=' + encodeURIComponent(deckId);

    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var cardContainer = document.getElementById('card-container');
            cardContainer.innerHTML = xhr.responseText;
        }
    };

    xhr.send(params);
}

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

function goToDeckDetails(deckId) {
    console.log("Próbuję przekierować do szczegółów decka o ID: " + deckId);
    window.location.href = 'deck_details.php?deck_id=' + deckId;
}



document.addEventListener('DOMContentLoaded', function() {
    console.log("JavaScript został wczytany."); // Dodaj ten log
    document.getElementById('createDeckButton').addEventListener('click', function() {
        var newDeckName = prompt('Podaj nazwę nowego decka:');

        if (newDeckName !== null && newDeckName !== '') {
            var xhr = new XMLHttpRequest();
            var url = 'create_deck.php';
            var params = 'newDeckName=' + encodeURIComponent(newDeckName);

            xhr.open('POST', url, true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var response = JSON.parse(xhr.responseText);

                    if (response.success) {
                        alert(response.message);
                        window.location.reload();
                    } else {
                        alert(response.message);
                    }
                }
            };

            xhr.send(params);
        } else {
            alert('Nie podano nazwy decka.');
        }
    });
});
