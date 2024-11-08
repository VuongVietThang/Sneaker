document.addEventListener('DOMContentLoaded', function() {
    const searchForm = document.getElementById('search-form');
    const searchInput = document.getElementById('search-input');
    const searchResults = document.getElementById('search-results');

    searchForm.addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent form submission
    });

    searchInput.addEventListener('input', function() {
        const query = this.value.trim();
        if (query.length > 0) {
            fetch(`search_api.php?query=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    searchResults.innerHTML = '';
                    data.forEach(product => {
                        const li = document.createElement('li');
                        li.className = 'search-result-item';
                        li.textContent = product.name;
                        li.setAttribute('data-id', product.id || product.product_id);
                        searchResults.appendChild(li);
                    });
                    searchResults.style.display = 'block';
                })
                .catch(error => console.error('Error:', error));
        } else {
            searchResults.innerHTML = '';
            searchResults.style.display = 'none';
        }
    });

    // Close search results when clicking outside
    document.addEventListener('click', function(event) {
        if (!searchResults.contains(event.target) && event.target !== searchInput) {
            searchResults.style.display = 'none';
        }
    });

    // Handle click on search result
    searchResults.addEventListener('click', function(event) {
        if (event.target.classList.contains('search-result-item')) {
            const productId = event.target.getAttribute('data-id');
            window.location.href = `product-details.php?id=${productId}`;
        }
    });
});