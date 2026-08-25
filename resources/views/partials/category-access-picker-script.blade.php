{{-- Drives every .category-access-picker block on the page. Like the post
     form's cascade, the whole menu rides along in a data attribute; unlike
     it, every level is a multi-select, and a level lists the children of
     everything picked at the level above, grouped under their parent. --}}
<script>
    (function () {
        document.querySelectorAll('.category-access-picker').forEach(function (block) {
            var tree = JSON.parse(block.dataset.tree || '[]');
            var selects = Array.prototype.slice.call(block.querySelectorAll('.access-level'));

            if (!selects.length) return;

            function picked(select) {
                return Array.prototype.slice.call(select.selectedOptions).map(function (option) {
                    return option.value;
                });
            }

            // The option groups for one level: the children of every node
            // picked above, each group labelled with its parent's name.
            function groupsFor(level) {
                if (level === 0) return [{ label: null, nodes: tree }];

                var above = picked(selects[level - 1]);
                var groups = [];

                groupsFor(level - 1).forEach(function (group) {
                    group.nodes.forEach(function (node) {
                        if (above.indexOf(String(node.id)) === -1) return;
                        if (!node.children || !node.children.length) return;

                        groups.push({ label: node.name, nodes: node.children });
                    });
                });

                return groups;
            }

            // First paint keeps the stored picks; later repaints keep whatever
            // is still on offer after a level above changed.
            function render(level, keep) {
                var select = selects[level];
                var wanted = keep
                    ? picked(select)
                    : (select.dataset.selected || '').split(',').filter(Boolean);
                var count = 0;

                select.innerHTML = '';

                groupsFor(level).forEach(function (group) {
                    var holder = select;

                    if (group.label) {
                        holder = document.createElement('optgroup');
                        holder.label = group.label;
                        select.appendChild(holder);
                    }

                    group.nodes.forEach(function (node) {
                        var option = document.createElement('option');
                        option.value = node.id;
                        option.textContent = node.name;
                        if (wanted.indexOf(String(node.id)) !== -1) option.selected = true;
                        holder.appendChild(option);
                        count++;
                    });
                });

                select.disabled = count === 0;
                dress(select);
            }

            function dress(select) {
                if (!window.jQuery || !window.jQuery.fn.select2) return;

                var $select = window.jQuery(select);

                if ($select.hasClass('select2-hidden-accessible')) {
                    $select.select2('destroy');
                }

                $select.select2({
                    width: '100%',
                    placeholder: select.dataset.placeholder || 'select',
                    closeOnSelect: false,
                });
            }

            selects.forEach(function (select, level) {
                function cascadeDown() {
                    for (var below = level + 1; below < selects.length; below++) {
                        render(below, true);
                    }
                }

                // select2 reports its changes through jQuery, which never
                // reaches a native listener — so listen there when it is in.
                if (window.jQuery) {
                    window.jQuery(select).on('change select2:select select2:unselect select2:clear', cascadeDown);
                } else {
                    select.addEventListener('change', cascadeDown);
                }
            });

            selects.forEach(function (select, level) {
                render(level, false);
            });
        });
    })();
</script>
