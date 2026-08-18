{{-- Drives every .category-cascade block on the page. The whole menu tree
     rides along in a data attribute, so changing a level refills the ones
     below it without a round trip. --}}
<script>
    (function () {
        document.querySelectorAll('.category-cascade').forEach(function (block) {
            var tree = JSON.parse(block.dataset.tree || '[]');
            var selects = Array.prototype.slice.call(block.querySelectorAll('.cascade-level'));

            if (!selects.length) return;

            // The options for one level, given what the level above holds.
            function optionsFor(level) {
                if (level === 0) return tree;

                var parentId = selects[level - 1].value;
                if (!parentId) return [];

                var siblings = optionsFor(level - 1);
                var parent = siblings.filter(function (node) {
                    return String(node.id) === String(parentId);
                })[0];

                return parent ? parent.children || [] : [];
            }

            function render(level) {
                var select = selects[level];
                var options = optionsFor(level);
                // Keep the stored pick on first paint; drop it once a level
                // above changes underneath it.
                var wanted = select.dataset.selected || '';
                var label = select.querySelector('option[value=""]');
                var blank = label ? label.textContent : 'select';

                select.innerHTML = '';

                var empty = document.createElement('option');
                empty.value = '';
                empty.textContent = options.length ? blank : 'none';
                select.appendChild(empty);

                options.forEach(function (node) {
                    var option = document.createElement('option');
                    option.value = node.id;
                    option.textContent = node.name;
                    if (String(node.id) === String(wanted)) option.selected = true;
                    select.appendChild(option);
                });

                select.disabled = options.length === 0;
                dress(select);
            }

            // select2 keeps its own copy of the options, so it has to be torn
            // down and rebuilt whenever a level repaints underneath it.
            function dress(select) {
                if (!window.jQuery || !window.jQuery.fn.select2) return;

                var $select = window.jQuery(select);

                if ($select.hasClass('select2-hidden-accessible')) {
                    $select.select2('destroy');
                }

                $select.select2({
                    width: '100%',
                    placeholder: select.dataset.placeholder || 'select',
                });
            }

            selects.forEach(function (select, level) {
                function cascadeDown() {
                    for (var below = level + 1; below < selects.length; below++) {
                        selects[below].dataset.selected = '';
                        render(below);
                    }
                }

                select.addEventListener('change', cascadeDown);

                if (window.jQuery) {
                    window.jQuery(select).on('select2:select select2:clear', cascadeDown);
                }
            });

            selects.forEach(function (select, level) {
                render(level);
            });
        });
    })();
</script>
