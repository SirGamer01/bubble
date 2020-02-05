<?php
include_once dirname(__DIR__) . '/required/config.php';

function generateHomeTab()
{
    global $db;
    $html = '<div class="accordion md-accordion z-depth-1-half" id="accordionEx194" role="tablist" aria-multiselectable="true">';

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        $stmt = $db->prepare("SELECT * FROM hub_users WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $hub_id = $row['hub_id'];
                $stmt1 = $db->prepare("SELECT * FROM hub_info WHERE hub_id = ?");
                $stmt1->bind_param("i", $hub_id);
                $stmt1->execute();
                $result1 = $stmt1->get_result();

                if ($result1->num_rows === 1) {
                    $row1 = $result1->fetch_assoc();
                    $hub_name = $row1['hub_name'];
                    if (empty($hub_name)) {
                        $hub_name = "My Home";
                    }

                    $dataPoints = array();
                    $dataPoints = array();
                    $AvgPoints = array();
                    $dataLabels = array();
                    $y = 40;
                    $avg = 0;
                    for ($i = 0; $i < 100; $i++) {
                        $y += rand(0, 100) - 5;
                        array_push($dataPoints, array("x" => $i, "y" => $y));
                        array_push($dataLabels, array($i));

                        $avg = array_sum($dataPoints) / count($dataPoints);
                        array_push($AvgPoints, array($avg));
                    }
                    $dataPointsEncoded = json_encode($dataPoints, JSON_NUMERIC_CHECK);
                    $dataAvgEncoded = json_encode($AvgPoints, JSON_NUMERIC_CHECK);
                    $dataLablesEncoded = json_encode($dataLabels, JSON_NUMERIC_CHECK);

                    $dataPoints = 1;
                    $html .= <<<html
                    <!-- Accordion card -->
                    <div class="card">
                    <!-- Card header -->
                        <div class="card-header" role="tab" id="heading$hub_id">
                            <a data-toggle="collapse" data-parent="#accordionEx194" href="#collapse$hub_id" aria-expanded="true" aria-controls="collapse4">
                                <h3 class="mb-0 mt-3 red-text">
                                    <div class="row">
                                        <div class="col-auto mr-auto">$hub_name</div>
                                        <div class="col-auto"><i class="fas fa-angle-down rotate-icon fa-2x"></i></div>
        
                                    </div>
                                </h3>
                            </a>
                        </div>
        
                        <!-- Card body -->
                        <div id="collapse$hub_id" class="collapse show" role="tabpanel" aria-labelledby="heading$hub_id" data-parent="#accordionEx194">
                            <div class="card-body pt-0">
                                <div class="flex-sm-row justify-content-center">     
                                    <div class="container mt-2">
                                        <div class="row row-cols-2 mb-1">
                                            <div class="col border border-primary rounded m-2">
                                                <h4 class="text-centre justify-content-center">Heating Usage</h4>
                                                <canvas style="max-width:50% min-width:30%" id="heatingUsage"></canvas>
                                                <script>
                                                    //doughnut
                                                    var ctxD = document.getElementById("heatingUsage").getContext("2d");
                                                    var myLineChart = new Chart(ctxD, {
                                                    type: "doughnut",
                                                    data: {
                                                    labels: ["Red"],
                                                    datasets: [{
                                                    data: [200, 100],
                                                    backgroundColor: ["#F7464A", "#FFFFFF00"],
                                                    hoverBackgroundColor: ["#FF5A5E", "#FFFFFF00"]
                                                    }]
                                                    },
                                                    options: {
                                                    responsive: true
                                                    }
                                                    });
                                                </script>
                                            </div>
                                            <div class="col border border-primary rounded m-2">
                                                <h4 class="text-centre align-middle">Heating Usage</h4>
                                                <canvas style="max-width:50% min-width:30%" id="heatingUsage1"></canvas>
                                                <script>
                                                    //doughnut
                                                    var ctxD = document.getElementById("heatingUsage1").getContext("2d");
                                                    var myLineChart = new Chart(ctxD, {
                                                    type: "doughnut",
                                                    data: {
                                                    labels: ["Red"],
                                                    datasets: [{
                                                    data: [200, 100],
                                                    backgroundColor: ["#F7464A", "#FFFFFF00"],
                                                    hoverBackgroundColor: ["#FF5A5E", "#FFFFFF00"]
                                                    }]
                                                    },
                                                    options: {
                                                    responsive: true
                                                    }
                                                    });
                                                </script>
                                                
                                            </div>
                                            <div class="col border border-primary rounded m-2">
                                                <h4 class="text-centre align-middle">Heating Usage</h4>
                                                <canvas style="max-width:50% min-width:30%" id="heatingUsage2"></canvas>
                                                <script>
                                                    //doughnut
                                                    var ctxD = document.getElementById("heatingUsage2").getContext("2d");
                                                    var myLineChart = new Chart(ctxD, {
                                                    type: "doughnut",
                                                    data: {
                                                    labels: ["Red"],
                                                    datasets: [{
                                                    data: [200, 100],
                                                    backgroundColor: ["#F7464A", "#FFFFFF00"],
                                                    hoverBackgroundColor: ["#FF5A5E", "#FFFFFF00"]
                                                    }]
                                                    },
                                                    options: {
                                                    responsive: true
                                                    }
                                                    });
                                                </script>
                                            </div>
                                            <div class="col border border-primary rounded m-2">
                                                <h4 class="text-centre align-middle">Heating Usage</h4>
                                                <canvas style="max-width:50% min-width:30%" id="heatingUsage3"></canvas>
                                                <script>
                                                    //doughnut
                                                    var ctxD = document.getElementById("heatingUsage3").getContext("2d");
                                                    var myLineChart = new Chart(ctxD, {
                                                    type: "doughnut",
                                                    data: {
                                                    labels: ["Red"],
                                                    datasets: [{
                                                    data: [200, 100],
                                                    backgroundColor: ["#F7464A", "#FFFFFF00"],
                                                    hoverBackgroundColor: ["#FF5A5E", "#FFFFFF00"]
                                                    }]
                                                    },
                                                    options: {
                                                    responsive: true
                                                    }
                                                    });
                                                </script>

                                            </div>
                                        </div>
                                    </div>
        
                                    <!--Grid column-->
                                    <!--Date select
                                    <p class="lead align-content-center">
                                        <span class="badge info-color-dark p-2">Date range</span>
                                    </p>
                                    <select id="chartPicker" class="browser-default custom-select">
                                        <option value="0" selected>Choose time period</option>
                                        <option value="1">Year</option>
                                        <option value="2">Month</option>
                                        <option value="3">Day</option>
                                    </select>-->
                                    
                                    <!--todo get displaying all 3--> 

                                    
                                    <canvas id="masterLineChart"></canvas>
                                    <script type="text/javascript">
                                        // Supplied Datasets to display
                                        let data1 = { "labels": ["1", "2", "3","4","5","6","7", "8", "9","10","11","12"],"label": "My First dataset", "datasets": [{ "label": "avg", "data": $dataPointsEncoded, "backgroundColor": "rgba(101, 209, 159, 0.6)", "borderColor": "rgba(101, 209, 159,1)", "borderWidth": 1 },{ "label": "Power usage", "data": $dataAvgEncoded, "backgroundColor": "rgba(93, 176, 201, 0.6)", "borderColor": "rgba(0, 10, 130, .4)", "borderWidth": 1 }] };
                                        let data2 = { "labels": ["1", "2", "3","4","5","6","7", "8", "9","10","11","12"],"label": "My First dataset", "datasets": [{ "label": "avg", "data": $dataPointsEncoded, "backgroundColor": "rgba(101, 209, 159, 0.6)", "borderColor": "rgba(101, 209, 159,1)", "borderWidth": 1 },{ "label": "Power usage", "data": $dataAvgEncoded, "backgroundColor": "rgba(93, 176, 201, 0.6)", "borderColor": "rgba(0, 10, 130, .4)", "borderWidth": 1 }] };
                                        let data3 = { "labels": ["1", "2", "3","4","5","6","7", "8", "9","10","11","12"],"label": "My First dataset", "datasets": [{ "label": "avg", "data": $dataPointsEncoded, "backgroundColor": "rgba(101, 209, 159, 0.6)", "borderColor": "rgba(101, 209, 159,1)", "borderWidth": 1 },{ "label": "Power usage", "data": $dataAvgEncoded, "backgroundColor": "rgba(93, 176, 201, 0.6)", "borderColor": "rgba(0, 10, 130, .4)", "borderWidth": 1 }] };
                                        // Draw the initial chart
                                        let kChartCanvas = $("#masterLineChart")[0].getContext('2d');
                                        let myChart = new Chart(kChartCanvas, {
                                            type: 'line',
                                            data: data1,
                                            options: {
                                                scales: {
                                                    yAxes: [{
                                                        ticks: {
                                                            beginAtZero: true
                                                        }
                                                    }]
                                                }
                                            }
                                        });
                                        
                                        // Called on Click
                                        function chartContent() {
                                            myChart["config"]["data"] = data2; //<--- THIS WORKS!
                                            myChart.update();
                                        }
                                        
                                        // Set the listener for the click function
                                        $(document).ready(function() {
                                            $("#control1").click(chartContent);
                                        });
                                </script>

                                    
                               </div> 
                            </div>
                        </div>
                    </div>
                
              
                                  
                    <!-- Accordion card -->
html;
                    //require "charts/lineChart_Day.php";
                    //require "charts/lineChart_Year.php";
                    //require "charts/lineChart_Month.php";
                    //require "charts/allCharts.php";
                    //$html .= generateLineChart_All();

                    //$html .= generateLineChart_Day();
                    //$html .= generateLineChart_Month();
                    //$html .= generateLineChart_Year();

                }
                $stmt1->close();

            }
        }

        $stmt->close();
    }

    $html .= "</div>";

    return $html;

}

?>
