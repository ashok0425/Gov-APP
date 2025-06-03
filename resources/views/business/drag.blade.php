@extends('layout.master')
@section('main-content')
    <div class="card">
        <div class="card-header d-flex justify-content-between bg-dark">
            <div>
                <h5 class="card-title text-white">Ward List</h5>
            </div>

        </div>
        <table id="sortable-table" class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($wards as $user)
                    <tr data-id="{{$user->id}}">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>


                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
@endsection
@push('style')
    <style>

    </style>
@endpush
@push('scripts')
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.min.js"></script>
<script>
    $(function () {
    $('#sortable-table tbody').sortable({
        update: function (event, ui) {
            var order = [];
            $('#sortable-table tbody tr').each(function (index, element) {
                order.push({
                    id: $(element).attr('data-id'),
                    position: index + 1
                });
            });

            // Send AJAX request
            $.ajax({
                url: '',
                method: 'POST',
                data: {
                    order: order,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    toastr.success('Order Changed')
                }
            });
        }
    });
});
</script>
@endpush
