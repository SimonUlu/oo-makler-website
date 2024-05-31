<div class="card p-3">
    <h2>Refresh Estates</h2>
    <button id="refresh-collection-button" class="btn">Refresh Collection</button>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('refresh-collection-button').addEventListener('click', function() {
                console.log('Refreshing collection...');
                fetch('/api/refresh-estate-collection', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            alert(data.message);
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch(error => {
                        alert('An error occurred while refreshing the collection.'); // Replace with Statamic toast notification if available
                        console.error('Error:', error);
                    });
            });
        });
    </script>
</div>
