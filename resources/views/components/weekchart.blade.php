<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

@php
    use carbon\carbon;
    $d1 = DB::table('orders')
        ->whereYear('created_at', carbon::now()->year)
        ->whereMonth('created_at', carbon::now()->month)
        ->whereDay('created_at', carbon::now()->day)
        ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
        ->count();

    $d2 = DB::table('orders')
        ->whereYear('created_at', carbon::now()->year)
        ->whereMonth('created_at', carbon::now()->month)
        ->whereDay('created_at', carbon::now()->subDay(1))
        ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
        ->count();
    $d3 = DB::table('orders')
        ->whereYear('created_at', carbon::now()->year)
        ->whereMonth('created_at', carbon::now()->month)
        ->whereDay('created_at', carbon::now()->subDay(2))
        ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
        ->count();

    $d4 = DB::table('orders')
        ->whereYear('created_at', carbon::now()->year)
        ->whereMonth('created_at', carbon::now()->month)
        ->whereDay('created_at', carbon::now()->subDay(3))
        ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
        ->count();

    $d5 = DB::table('orders')
        ->whereYear('created_at', carbon::now()->year)
        ->whereMonth('created_at', carbon::now()->month)
        ->whereDay('created_at', carbon::now()->subDay(4))
        ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
        ->count();

    $d6 = DB::table('orders')
        ->whereYear('created_at', carbon::now()->year)
        ->whereMonth('created_at', carbon::now()->month)
        ->whereDay('created_at', carbon::now()->subDay(5))
        ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
        ->count();

    $d7 = DB::table('orders')
        ->whereYear('created_at', carbon::now()->year)
        ->whereMonth('created_at', carbon::now()->month)
        ->whereDay('created_at', carbon::now()->subDay(6))
        ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
        ->count();
@endphp

<?php
$D1 = date('D');
$D2 = date('D', strtotime('-1 day'));
$D3 = date('D', strtotime('-2 day'));
$D4 = date('D', strtotime('-3 day'));
$D5 = date('D', strtotime('-4 day'));
$D6 = date('D', strtotime('-5 day'));
$D7 = date('D', strtotime('-6 day'));

?>

@php
    $m1 = DB::table('users')
        ->whereYear('created_at', carbon::now()->year)
        ->whereMonth('created_at', Carbon::now()->month)
        ->count();
    $m2 = DB::table('users')
        ->whereYear('created_at', carbon::now()->year)
        ->whereMonth('created_at', Carbon::now()->subMonth(1))
        ->count();
    $m3 = DB::table('users')
        ->whereYear('created_at', carbon::now()->year)
        ->whereMonth('created_at', Carbon::now()->subMonth(2))
        ->count();
@endphp

<?php
$M1 = date('M');

$M2 = date('M', strtotime('-1 month'));
$M3 = date('M', strtotime('-2 month'));

?>

@php
    $v1 = DB::table('users')
        ->whereYear('created_at', carbon::now()->year)
        ->whereMonth('created_at', Carbon::now()->month)
        ->count();
    $v2 = DB::table('users')
        ->whereYear('created_at', carbon::now()->year)
        ->whereMonth('created_at', Carbon::now()->subMonth(1))
        ->count();
    $v3 = DB::table('users')
        ->whereYear('created_at', carbon::now()->year)
        ->whereMonth('created_at', Carbon::now()->subMonth(2))
        ->count();
@endphp

<?php
$V1 = date('M');

$V2 = date('M', strtotime('-1 month'));
$V3 = date('M', strtotime('-2 month'));

?>

<script>
    window.onload = function () {
        var chart1 = new CanvasJS.Chart('chartContainer1', {
            title: {
                text: "User Report of First 3 Month's",
            },
            axisY: {
                title: 'Number of user',
            },
            data: [
                {
                    type: 'area',
                    markerSize: 5,
                    dataPoints: [
                        { label: '<?php echo $M3; ?>', y: <?php echo $m3; ?> },
                        { label: '<?php echo $M2; ?>', y: <?php echo $m2; ?> },
                        { label: '<?php echo $M1; ?>', y: <?php echo $m1; ?> },
                    ],
                },
            ],
        });

        var chart2 = new CanvasJS.Chart('chartContainer2', {
            title: {
                text: "Order Graph's of Current week",
            },
            axisY: {
                title: 'Orders Number',
            },
            data: [
                {
                    type: 'pie',

                    dataPoints: [
                        { label: '<?php echo $D7; ?>', y: <?php echo $d7; ?> },
                        { label: '<?php echo $D6; ?>', y: <?php echo $d6; ?> },
                        { label: '<?php echo $D5; ?>', y: <?php echo $d5; ?> },
                        { label: '<?php echo $D4; ?>', y: <?php echo $d4; ?> },
                        { label: '<?php echo $D3; ?>', y: <?php echo $d3; ?> },
                        { label: '<?php echo $D2; ?>', y: <?php echo $d2; ?> },
                        { label: '<?php echo $D1; ?>', y: <?php echo $d1; ?> },
                    ],
                },
            ],
        });

        var chart3 = new CanvasJS.Chart('chartContainer3', {
            title: {
                text: "Order Graph's of Current week",
            },
            axisY: {
                title: 'Orders Number',
            },
            data: [
                {
                    type: 'column', //change type to bar, line, area, pie, etc
                    //indexLabel: "{y}", //Shows y value on all Data Points
                    indexLabelFontColor: '#5A5757',
                    indexLabelPlacement: 'outside',
                    dataPoints: [
                        { label: '<?php echo $D7; ?>', y: <?php echo $d7; ?> },
                        { label: '<?php echo $D6; ?>', y: <?php echo $d6; ?> },
                        { label: '<?php echo $D5; ?>', y: <?php echo $d5; ?> },
                        { label: '<?php echo $D4; ?>', y: <?php echo $d4; ?> },
                        { label: '<?php echo $D3; ?>', y: <?php echo $d3; ?> },
                        { label: '<?php echo $D2; ?>', y: <?php echo $d2; ?> },
                        { label: '<?php echo $D1; ?>', y: <?php echo $d1; ?> },
                    ],
                },
            ],
        });

        var chart4 = new CanvasJS.Chart('chartContainer4', {
            title: {
                text: "Vendor Report of First 3 Month's",
            },
            axisY: {
                title: 'Number of vendor',
            },
            data: [
                {
                    type: 'column',

                    dataPoints: [
                        { label: '<?php echo $V3; ?>', y: <?php echo $v3; ?> },
                        { label: '<?php echo $V2; ?>', y: <?php echo $v2; ?> },
                        { label: '<?php echo $V1; ?>', y: <?php echo $v1; ?> },
                    ],
                },
            ],
        });
        chart1.render();
        chart2.render();
        chart3.render();
        chart4.render();
    };
</script>
