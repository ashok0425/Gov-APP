{{-- Repopulates the subcategory dropdown from the chosen category, no round trip. --}}
<script>
    (function () {
        var subcategories = @json($subcategoryMap);
        var categorySelect = document.getElementById('category-select');
        var subcategorySelect = document.getElementById('subcategory-select');

        if (!categorySelect || !subcategorySelect) return;

        function render() {
            // Keep the current pick when the page reloads with old input or an
            // existing post; drop it once the category changes underneath it.
            var wanted = subcategorySelect.dataset.selected || '';
            var options = subcategories[categorySelect.value] || [];

            subcategorySelect.innerHTML = '';

            var blank = document.createElement('option');
            blank.value = '';
            blank.textContent = options.length ? 'select subcategory' : 'no subcategory';
            subcategorySelect.appendChild(blank);

            options.forEach(function (item) {
                var option = document.createElement('option');
                option.value = item.id;
                option.textContent = item.name;
                if (String(item.id) === String(wanted)) option.selected = true;
                subcategorySelect.appendChild(option);
            });

            subcategorySelect.disabled = options.length === 0;
        }

        categorySelect.addEventListener('change', function () {
            subcategorySelect.dataset.selected = '';
            render();
        });

        render();
    })();
</script>
