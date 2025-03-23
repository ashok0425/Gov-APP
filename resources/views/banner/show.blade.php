@extends('admin.layout.master')
@php
    define('PAGE', 'setting');
@endphp

@section('main-content')
    <style>
        @media print {
            #printbtn {
                display: none;
            }

            h5 {
                display: none;
            }

            .navbar {
                display: none;
            }

            .container div {
                float: left;
                width: 100px;
            }
        }

        .container div {
            float: left;
            width: 200px;
        }
    </style>
    <div class="card">
        <h3>Show Banner Detail</h3>

        <div class="card-body">
            <div class="container">
                <div>
                    <h4>Banner Image</h4>
                    <p>
                        <img
                            src="{{ getImage($category->image) }}"
                            alt="{{ $category->image }}"
                            width="100"
                        />
                    </p>
                </div>
                <div>
                    <h4>Banner Title</h4>
                    <p>{{ $category->title }}</p>
                </div>
                <h4>Banner Detail</h4>
                <p>{{ $category->text }}</p>
            </div>
        </div>
    </div>
@endsection
