<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
@php
    $order=App\Models\Order::query()->with('orderItem')->where('id',$orderId)->first();

@endphp
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>{{$order->booking_id}} Invoice </title>

        <!-- Start Common CSS -->
        <style type="text/css">
            #outlook a {padding:0;}
            body{max-width:400px !important;; padding:0; font-family: Helvetica, arial, sans-serif;margin-left: 50px}
            .ExternalClass {width:100%;}
            .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;}
            .backgroundTable {margin:0; padding:0; width:100% !important; line-height: 100% !important;}
            .main-temp table { border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; font-family: Helvetica, arial, sans-serif;}
            .main-temp table td {border-collapse: collapse;}
        </style>
        <!-- End Common CSS -->
    </head>
    <body style="display: flex;margin:auto">
        <table width="400px" cellpadding="0" cellspacing="0" border="0" class="backgroundTable main-temp" style="background-color: #d5d5d5;margin:auto">
            <tbody>
                <tr>
                    <td>
                        <table width="400" align="left" cellpadding="15" cellspacing="0" border="0" class="devicewidth" style="background-color: #ffffff;">
                            <tbody>
                                <!-- Start header Section -->
                                <tr>
                                    <td style="padding-top: 30px;">
                                        <table width="400" align="left" cellpadding="0" cellspacing="0" border="0" class="devicewidthinner" style="border-bottom: 1px solid #eeeeee; text-align: center;">
                                            <tbody>
                                                <tr>
                                                    <td style="padding-bottom: 10px;">
                                                        <a href="{{route('home')}}"><img src="{{getImage(cms('logo'))}}" alt="{{cms('meta_title')}}" width="100"/></a>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td style="font-size: 14px; line-height: 18px; color: #666666;">
                                                        Phone: {{cms('phone1')}} | Email: {{cms('email1')}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 14px; line-height: 18px; color: #666666; padding-bottom: 25px;">
                                                        <strong>Order ID:</strong> {{$order->order_id}} | <strong>Booking Date:</strong> {{Carbon\Carbon::parse($order->created_at)->format('d M Y')}}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <!-- End header Section -->

                                <!-- Start address Section -->
                                <tr>
                                    <td style="padding-top: 0;">
                                        <table width="400" align="left" cellpadding="0" cellspacing="0" border="0" class="devicewidthinner" style="border-bottom: 1px solid #bbbbbb;">
                                            <tbody>
                                                <tr>
                                                    <td style="width: 55%; font-size: 16px; font-weight: bold; color: #666666; padding-bottom: 5px;">
                                                        Customer Detail
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td style="width: 55%; font-size: 14px; line-height: 18px; color: #666666;">
                                                        {{$order->user->name}}
                                                    </td>
                                                    <td style="width: 55%; font-size: 14px; line-height: 18px; color: #666666;">
                                                        {{$order->address?->state}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 55%; font-size: 14px; line-height: 18px; color: #666666;">
                                                        {{$order->user->phone}}
                                                    </td>
                                                    <td style="width: 55%; font-size: 14px; line-height: 18px; color: #666666;">
                                                        {{$order->address?->city}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 55%; font-size: 14px; line-height: 18px; color: #666666; padding-bottom: 10px;">
                                                        {{$order->user->email}}
                                                    </td>
                                                    <td style="width: 55%; font-size: 14px; line-height: 18px; color: #666666;">
                                                        {{$order->address?->address}}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <!-- End address Section -->

                                <!-- Start product Section -->
                                <tr>
                                    <td style="padding-top: 0;padding-right:50px">
                                        <table width="400" align="left" cellpadding="0" cellspacing="0" border="0" class="devicewidthinner" style="border-bottom: 1px solid #eeeeee;">
                                            <tbody>
                                                <tr>
                                                    <td style="font-size: 14px; line-height: 18px; color: #757575;font-weight:bold; width: 440px;">
                                                       Order Items
                                                    </td>
                                                    <td style="font-size: 14px; line-height: 18px; color: #757575; text-align: right; padding-bottom: 10px;">

                                                    </td>
                                                </tr>

                                                @foreach ($order->orderItem as $item)
                                                <tr>
                                                    <td style="font-size: 14px; line-height: 18px; color: #757575; width: 440px;">
                                                        {{ $item->qty }} x {{ $item->product->name }} ({{ $item->weight }})
                                                    </td>
                                                    <td style="font-size: 14px; line-height: 18px; color: #757575; text-align: right; padding-bottom: 10px;">
                                                        <b style="color: #666666;">
                                                            {{ $item->unit_price * $item->qty }}
                                                        </b>
                                                    </td>
                                                </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </td>
                                </tr>

                                <!-- End product Section -->

                                <!-- Start calculation Section -->
                                <tr>
                                    <td style="padding-top: 0;padding-right:50px">
                                        <table width="400" align="left" cellpadding="0" cellspacing="0" border="0" class="devicewidthinner" style="border-bottom: 1px solid #bbbbbb; margin-top: -5px;">
                                            <tbody>
                                                <tr>
                                                    <td rowspan="5" style="width: 55%;">
                                                    </td>
                                                    <td style="font-size: 14px; line-height: 18px; color: #666666;">
                                                        Sub Total:
                                                    </td>
                                                    <td style="font-size: 14px; line-height: 18px; color: #666666; width: 130px; text-align: right;">
                                                        {{$order->subtotal}}
                                                    </td>
                                                </tr>


                                                <tr>
                                                    <td style="font-size: 14px; line-height: 18px; color: #666666;">
                                                        Delivery Fee:
                                                    </td>
                                                    <td style="font-size: 14px; line-height: 18px; color: #666666; width: 130px; text-align: right;">
                                                        {{$order->delivery_charge??'Free'}}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td style="font-size: 14px; line-height: 18px; color: #666666;">
                                                        Handling Fee:
                                                    </td>
                                                    <td style="font-size: 14px;  line-height: 18px; color: #666666; text-align: right;">
                                                       {{$order->handling_charge??'Free'}}
                                                    </td>
                                                </tr>


                                                @if ($order->discount)
                                                <tr>
                                                    <td style="font-size: 14px; line-height: 18px; color: #666666;">
                                                        Discount:
                                                    </td>
                                                    <td style="font-size: 14px; line-height: 18px; color: #666666; width: 130px; text-align: right;">
                                                        {{$order->discount}}
                                                    </td>
                                                </tr>
                                                @endif

                                                <tr>
                                                    <td style="font-size: 14px; font-weight: bold; line-height: 18px; color: #666666; padding-top: 10px;">
                                                        Total
                                                    </td>
                                                    <td style="font-size: 14px; font-weight: bold; line-height: 18px; color: #666666; padding-top: 10px; text-align: right;">
                                                        {{$order->final_total}}
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <!-- End calculation Section -->

                                <!-- Start payment method Section -->
                                <tr>
                                    <td style="padding: 0 10px;">
                                        <table width="400" align="left" cellpadding="0" cellspacing="0" border="0" class="devicewidthinner">
                                            <tbody>

                                                <tr>
                                                    <td colspan="2" style="width: 100%; text-align: center; font-style: italic; font-size: 13px; font-weight: 600; color: #666666; padding: 15px 0;">
                                                        <b style="font-size: 14px;">Note:</b> This is just computer generated invoice.Don't use it for offical use.
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <!-- End payment method Section -->

                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>

    </body>
</html>
