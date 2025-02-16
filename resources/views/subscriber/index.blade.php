@extends('layout.master')
@section('main-content')
    @php
        define('PAGE', 'subscriber');
    @endphp

    <div class="container">
        <form action="{{ route('subscriber.create') }}" method="GET">
            @csrf
            <div class="card py-3 px-4">
                <div class="d-flex justify-content-between">
                    <input
                        type="submit"
                        value="Send Email to selected Subscriber"
                        class="btn btn-primary"
                    />
                </div>
                <br />
                <table id="myTable" class="table table-responsive-sm">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="ischeck" /></th>
                            <th>#</th>

                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subscriber as $item)
                            <tr>
                                <td>
                                    <input
                                        type="checkbox"
                                        name="subscriber[]"
                                        value="{{ $item->email }}"
                                        class="check"
                                    />
                                </td>

                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->email }}</td>
                                <td>
                                    <a
                                        id="delete"
                                        href="{{ route('subscriber.delete', ['id' => $item->id, 'table' => 'subscribers']) }}"
                                        class="btn btn-danger"
                                    >
                                        <i class="fas fa-times"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        $('#ischeck').click(function (e) {
            if ($(this).prop('checked')) {
                $('.check').attr('checked', 'checked');
            } else {
                $('.check').removeAttr('checked', 'fg');
            }
        });
    </script>
@endpush
