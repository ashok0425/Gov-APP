{{-- Drives every .category-cascade block on the page. The whole menu tree
     rides along in a data attribute, so changing a level refills the ones
     below it without a round trip.

     A pinned employee's tree holds only the nodes they were given. When that
     leaves a single category, the top level is picked for them and frozen,
     with a hidden input carrying the id since a disabled select never
     submits. --}}
<script>
    (function () {
        document.querySelectorAll('.category-cascade').forEach(function (block) {
            var tree = JSON.parse(block.dataset.tree || '[]');
            var selects = Array.prototype.slice.call(block.querySelectorAll('.cascade-level'));
            var organization = block.querySelector('.cascade-organization');
            var pinned = block.dataset.pinned === '1';

            if (!selects.length) return;

            // The options for one level, given what the level above holds.
            // An organization select in front narrows the top level to that
            // organization's own categories. Left empty, a required select
            // offers nothing yet — pick the organization first — while an
            // optional one (the list filter) falls back to the whole menu.
            function optionsFor(level) {
                if (level === 0) {
                    if (!organization) return tree;
                    if (!organization.value) return organization.required ? [] : tree;

                    return tree.filter(function (node) {
                        return String(node.organization_id) === String(organization.value);
                    });
                }

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
                // A pinned employee with one category: pick it and freeze
                // the level — it is required anyway.
                var forced = pinned && level === 0 && options.length === 1;
                if (forced) wanted = options[0].id;
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

                select.disabled = options.length === 0 || forced;
                lock(select, forced ? options[0].id : null);
                dress(select);
            }

            // The hidden twin that submits a frozen level's pick.
            function lock(select, value) {
                var hidden = select.parentNode.querySelector('input[data-locks="' + select.name + '"]');

                if (value === null) {
                    if (hidden) hidden.remove();
                    return;
                }

                if (!hidden) {
                    hidden = document.createElement('input');
                    hidden.type = 'hidden';
                    hidden.name = select.name;
                    hidden.dataset.locks = select.name;
                    select.parentNode.appendChild(hidden);
                }

                hidden.value = value;
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

            if (organization) {
                var organizationChanged = function () {
                    selects.forEach(function (select) {
                        select.dataset.selected = '';
                    });
                    selects.forEach(function (select, level) {
                        render(level);
                    });
                };

                organization.addEventListener('change', organizationChanged);

                if (window.jQuery) {
                    window.jQuery(organization).on('select2:select select2:clear', organizationChanged);
                }

                dress(organization);
            }

            selects.forEach(function (select, level) {
                render(level);
            });
        });
    })();
</script>
