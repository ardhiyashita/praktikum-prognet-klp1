<!DOCTYPE html>
<html>
<head>
    <title>Bar Chart</title>
    <script src="https://www.chartjs.org/dist/2.9.3/Chart.min.js"></script>
    <script src="https://www.chartjs.org/samples/latest/utils.js"></script>
    <style>
        canvas {
        -moz-user-select: none;
        -webkit-user-select: none;
        -ms-user-select: none;
        }
    </style>
</head>

<body>
    <div id="container" style="width: 75%;">
    <canvas id="canvas"></canvas>
    </div>
    
    <?php 
        //misal ada 3 dealer
        $dealer = 1;
        for($d=1;$d<=$dealer;$d++){
        //kemudian misal data dari bulan 1 hingga bulan 12
            for($b=1;$b<=12;$b++){
                $data[$d][$b] = rand(0,999);
            }
        }

        function random_color(){  
            return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
        }
    ?>

 <script>
var MONTHS = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
var color = Chart.helpers.color;
var barChartData = {
    labels: MONTHS,
    datasets: [
        <?php 
            for($d=1;$d<=$dealer;$d++){
                $color = random_color();
                // ?>
                {
                    label: '<?php echo "Dealer $d";?>',
                    backgroundColor: color('<?php echo $color;?>').alpha(0.5).rgbString(),
                    borderColor: '<?php echo $color;?>',
                    borderWidth: 1,
                    data: [
                        <?php 
                            for($b=1;$b<=12;$b++){
                                echo $data[$d][$b].",";
                            }
                        ?>     
                    ]
                },
            <?php 
            }
        ?>
   ]

  };

window.onload = function() {
    var ctx = document.getElementById('canvas').getContext('2d');
    window.myBar = new Chart(ctx, {
        type: 'bar',
        data: barChartData,
        options: {
            responsive: true,
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Grafik Transaksi bulanan'
            }
        }
   });

};

</script>
</body>

</html>