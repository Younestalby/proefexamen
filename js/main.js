// assets/js/main.js

document.addEventListener("DOMContentLoaded", () => {
    const voteForm = document.getElementById("vote-form");

    if (voteForm) {
        voteForm.addEventListener("submit", function(event) {
            event.preventDefault();

            const formData = new FormData(voteForm);
            fetch('ajax_vote.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    alert(data.success);
                    voteForm.reset();
                    updateResults();
                } else if(data.error) {
                    alert(data.error);
                }
            })
            .catch(error => console.error('Error:', error));
        });
    }

    // Function to update live results
    updateResults();

    function updateResults() {
        fetch('ajax_results.php')
        .then(response => response.json())
        .then(data => {
            const resultsDiv = document.getElementById('results');
            if(resultsDiv) {
                resultsDiv.innerHTML = '<h3>Live Stemmen</h3>';
                data.forEach(party => {
                    const partyDiv = document.createElement('div');
                    partyDiv.innerHTML = `<strong>${party.name}:</strong> ${party.vote_count} stemmen`;
                    resultsDiv.appendChild(partyDiv);
                });
            }
        })
        .catch(error => console.error('Error:', error));
    }
});
