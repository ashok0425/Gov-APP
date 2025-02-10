@extends('admin.layout.master')
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


<div class="container-fluid p-0">
    <form action="" class="mb-2">
        <div class="row justify-content-end">

            <div class="col-md-2  mx-0 px-0">
                <input type="text" value="" id="dates" name="dates" class="form-control"  value="{{request()->query('dates')}}">
            </div>
            @can('do:anythings')

            <div class="col-md-2  mx-0 px-0">
               <select name="location" id="" class="form-control form-select">
                <option value="">Select Locaton</option>
                @foreach(App\Models\Location::all() as $location)
                <option value="{{$location->id}}" {{request()->query('location')==$location->id?'selected':''}}>{{$location->name}}</option>

                @endforeach
               </select>
            </div>
            @endcan

            <div class="col-md-1  mx-0 px-0">
                <button class="btn btn-primary">Apply</button>
                @if (request()->query('dates')||request()->query('keyword')||request()->query('status'))
                <a href="{{route('admin.dashboard')}}">Reset</a>
                @endif
            </div>
        </div>
       </form>
    <div class="row">
        <div class="col-xl-6 col-xxl-5 d-flex">
            <div class="w-100">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card">
                            <div
                                class="card-body d-flex justify-content-between align-items-center"
                            >

                                <div>
                                    <h5 class="card-title">No. of Order</h5>
                                    <h4 class="mt-1">
                                        <small></small>
                                        {{ number_format($data['orderCount'], 2) }}
                                    </h4>
                                </div>
                                <i class="fa fa-baby-carriage text-info"></i>
                            </div>
                        </div>



                    </div>
                    <div class="col-sm-6">
                        <div class="card">
                            <div
                                class="card-body d-flex justify-content-between align-items-center"
                            >

                                <div>
                                    <h5 class="card-title">Total Order Value</h5>
                                    <h4 class="mt-1">
                                        <small></small>
                                        {{ number_format($data['orderprice'], 2) }}
                                    </h4>
                                </div>
                                <i class="fa fa-baby-carriage text-info"></i>
                            </div>
                        </div>



                    </div>

                    <div class="col-sm-6">
                        <div class="card">
                            <div
                                class="card-body d-flex justify-content-between align-items-center"
                            >

                                <div>
                                    <h5 class="card-title"> No.of Delivered Order</h5>
                                    <h4 class="mt-1">
                                        <small></small>
                                        {{ number_format($data['deliverOrderCount'], 2) }}
                                    </h4>
                                </div>
                                <i class="fa fa-baby-carriage text-success"></i>
                            </div>
                        </div>



                    </div>

                    <div class="col-sm-6">
                        <div class="card">
                            <div
                                class="card-body d-flex justify-content-between align-items-center"
                            >

                                <div>
                                    <h5 class="card-title"> Delivered Order Value</h5>
                                    <h4 class="mt-1">
                                        <small></small>
                                        {{ number_format($data['deliverOrderPrice'], 2) }}
                                    </h4>
                                </div>
                                <i class="fa fa-baby-carriage text-success"></i>
                            </div>
                        </div>



                    </div>

                    <div class="col-sm-6">
                        <div class="card">
                            <div
                                class="card-body d-flex justify-content-between align-items-center"
                            >

                                <div>
                                    <h5 class="card-title"> No.of Cancelled Order</h5>
                                    <h4 class="mt-1">
                                        <small></small>
                                        {{ number_format($data['cancelOrderCount'], 2) }}
                                    </h4>
                                </div>
                                <i class="fa fa-baby-carriage text-danger"></i>
                            </div>
                        </div>



                    </div>

                    <div class="col-sm-6">
                        <div class="card">
                            <div
                                class="card-body d-flex justify-content-between align-items-center"
                            >

                                <div>
                                    <h5 class="card-title"> Cancelled Order Value</h5>
                                    <h4 class="mt-1">
                                        <small></small>
                                        {{ number_format($data['cancelOrderPrice'], 2) }}
                                    </h4>
                                </div>
                                <i class="fa fa-baby-carriage text-danger"></i>
                            </div>
                        </div>



                    </div>

                </div>
            </div>
        </div>

        <div class="col-xl-6 col-xxl-7">
            {{-- sales in week --}}
            <div class="card">
                <div class="card-header bg-dark">
                    <h5 class="card-title  text-white">Latest Order</h5>
                </div>
                <div class="card-body">
                  <table class="table">
                    <thead>
                        <tr>
                            <th>Order Id</th>
                    <th>Customer</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                            @foreach ($latestOrder as $order)
                             <tr>
                                <td>
                                   <a href="{{route('admin.orders.show',$order)}}">
                                    {{$order->order_id}}
                                   </a>
                                </td>
                                <td>
                                   <a href="">
                                    <small> {{$order->user->name}}</small>
                                    <br>
                                    <small>{{$order->user->phone}}</small>
                                   </a>
                                 </td>
                                 <td>
                                    {{$order->final_total}}
                                 </td>
                                 <td>
                                    @if ($order->status == App\Models\Order::ORDER_PENDING_STATUS)
                                        <span class="badge bg-danger">Pending</span>
                                    @elseif ($order->status == App\Models\Order::ORDER_PROCESSING_STATUS)
                                        <span class="badge bg-info">Processing</span>
                                    @elseif ($order->status == App\Models\Order::ORDER_DISPATCH_STATUS)
                                        <span class="badge bg-primary">dispatched</span>
                                    @elseif ($order->status == App\Models\Order::ORDER_CANCEL_STATUS)
                                        <span class="badge bg-danger">Cancelled</span>
                                    @elseif ($order->status == App\Models\Order::ORDER_DELIVER_STATUS)
                                        <span class="badge bg-info">Delivered</span>
                                    @endif
                                </td>
                                <td>
                                    {{Carbon\Carbon::parse($order->created_at)->format('d/m/Y')}}
                                </td>
                             </tr>
                            @endforeach
                    </tbody>
                  </table>
                </div>
            </div>
            <div class="card flex-fill w-100">
                <div class="card-body py-3">
                    <div id="chartContainer2" style="height: 340px; width: 100%"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card flex-fill w-100">
                <div id="chartContainer3" style="height: 340px; width: 100%"></div>
            </div>
        </div>
    </div>

</div>


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
