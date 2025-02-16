@extends('layout.master')
@section('main-content')
    <style>
        .card {
            border: 0;
            border-radius: 0;
            font-size: 14px;
        }

        .fa {
            font-size: 2.8rem;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


@endsection

@push('scripts')
<script
type="text/javascript"
src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"
></script>
<script
type="text/javascript"
src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"
></script>
<script>
    $(document).ready(function () {
        $('#dates').daterangepicker();
        });
</script>
@endpush
