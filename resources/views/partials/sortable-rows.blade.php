{{-- Drag-and-drop ordering for a list table: rows in #sortable-body carrying
     data-id become draggable by their .drag-handle, and dropping one POSTs
     the new order to $reorderUrl. $start offsets the positions so page two
     of a paginated list sorts after page one. --}}
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script>
    (function () {
        var body = document.getElementById('sortable-body');
        if (!body || typeof Sortable === 'undefined') return;

        new Sortable(body, {
            handle: '.drag-handle',
            animation: 150,
            onEnd: function () {
                var ids = Array.prototype.map.call(
                    body.querySelectorAll('tr[data-id]'),
                    function (row) { return row.dataset.id; }
                );

                fetch(@json($reorderUrl), {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': @json(csrf_token()),
                    },
                    body: JSON.stringify({ ids: ids, start: {{ (int) ($start ?? 0) }} }),
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
    })();
</script>
