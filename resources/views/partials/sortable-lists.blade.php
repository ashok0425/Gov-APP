{{-- Drag-and-drop ordering for one or more full lists on a page: every
     element with data-sortable-list becomes a drag list, and dropping a row
     POSTs the ids of that list, in order, to $reorderUrl. These pages never
     paginate, so positions start at 0 and each list is the whole of its
     group. --}}
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script>
    (function () {
        if (typeof Sortable === 'undefined') return;

        Array.prototype.forEach.call(document.querySelectorAll('[data-sortable-list]'), function (list) {
            new Sortable(list, {
                handle: '.drag-handle',
                animation: 150,
                onEnd: function () {
                    var rows = list.querySelectorAll('[data-id]');
                    var ids = Array.prototype.map.call(rows, function (row) { return row.dataset.id; });

                    Array.prototype.forEach.call(rows, function (row, index) {
                        var number = row.querySelector('.row-number');
                        if (number) number.textContent = index + 1;
                    });

                    fetch(@json($reorderUrl), {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': @json(csrf_token()),
                        },
                        body: JSON.stringify({ ids: ids, start: 0 }),
                    }).then(function (response) {
                        if (!window.toastr) return;
                        if (response.ok) {
                            toastr.success('Order saved');
                        } else {
                            toastr.error('Could not save the order');
                        }
                    }).catch(function () {
                        if (window.toastr) toastr.error('Could not save the order');
                    });
                },
            });
        });
    })();
</script>
