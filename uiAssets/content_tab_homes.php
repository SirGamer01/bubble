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

                    $stmt2 = $db->prepare("SELECT * FROM test_data WHERE hub_id = ?");
                    $stmt2->bind_param("i", $hub_id);
                    $stmt2->execute();
                    $result2 = $stmt2->get_result();

                    if ($result2->num_rows === 1) {
                        $row2 = $result2->fetch_assoc();
                        $cost_day = $row2['cost_day'];
                        $cost_month = $row2['cost_month'];
                        $cost_total = $row2['cost_total'];
                        $cost_variance = $cost_total - $cost_month;
                    }
                    //todo test querry and implment the weekly, monthly and annual versions
                    //$stmt3 = $db->prepare("SELECT * FROM hourly_data WHERE (hub_id AND hourly_data.date >= NOW() - INTERVAL 1 DAY) ORDER BY hour ASC = ?");
                    //$stmt3->bind_param("i", $hourly_data);
                    //$stmt3->execute();
                    //$result3 = $stmt3->get_result();
                    //if ($result3->num_rows <= 24) {
                    //    $row3 = $result2->fetch_assoc();
                    //    $hours_measured = $row3['hour'];
                    //    $units_used = $row3['Watts_Used'];
                    //    $expected_usage =get last 4  // need new querry?
                    //}
                    //$dataRangeEncoded1 = json_encode($hours_measured, JSON_NUMERIC_CHECK);// last 24 hours
                    //$unitsUsedEncoded1 = json_encode($units_used, JSON_NUMERIC_CHECK);//corasponding data for the last 24 hours
                    //$dataAvgEncoded1 = json_encode($AvgPoints, JSON_NUMERIC_CHECK);//unused in current ver


                    //todo add querrys for pulling power usage
                    $dataPoints = array();
                    $dataPoints = array();
                    $AvgPoints = array();
                    $dataLabels = array();
                    $y = 40;
                    $avg = 0;
                    for ($i = 0; $i < 31; $i++) {
                        $y += rand(0, 250);
                        array_push($dataPoints, array($y));
                        array_push($dataLabels, array("$i"));
                        $avg = array_sum($dataPoints) / count($dataPoints);
                        array_push($AvgPoints, array($avg));

                    }
                    $dataLabelsEncoded = json_encode($dataLabels);
                    $dataPointsEncoded = json_encode($dataPoints, JSON_NUMERIC_CHECK);
                    $dataAvgEncoded = json_encode($AvgPoints, JSON_NUMERIC_CHECK);;

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
                            <!--todo change 3 donuts to carousels-->
                                <div class="flex-sm-row justify-content-center">     
                                    <div class="container mt-2">
                                        <div class="row row-cols-2 mb-1">
                                            <div class="col border border-primary rounded m-2">
                                                <h4 class="text-centre justify-content-center">Daily</h4>
                                                <canvas style="max-width:50% min-width:30%" id="heatingUsage"></canvas>
                                                <script>
                                                    //doughnut
                                                    var ctxD = document.getElementById("heatingUsage").getContext("2d");
                                                    var myLineChart = new Chart(ctxD, {
                                                    type: "doughnut",
                                                    data: {
                                                    labels: ["Spent [£]", "Remaining [£]"],
                                                    datasets: [{
                                                    data: [$cost_day, $cost_variance],
                                                    backgroundColor: ["#F7464A", "#D3D3D3"],
                                                    hoverBackgroundColor: ["#FF5A5E", "#D3D3D3"]
                                                    }]
                                                    },
                                                    options: {
                                                    responsive: true
                                                    }
                                                    });
                                                </script>
                                            </div>
                                            <div class="col border border-primary rounded m-2">
                                                <h4 class="text-centre align-middle">Monthly</h4>
                                                <canvas style="max-width:50% min-width:30%" id="heatingUsage1"></canvas>
                                                <script>
                                                    //doughnut
                                                    var ctxD = document.getElementById("heatingUsage1").getContext("2d");
                                                    var myLineChart = new Chart(ctxD, {
                                                    type: "doughnut",
                                                    data: {
                                                    labels: ["Spent [£]", "Remaining [£]"],
                                                    datasets: [{
                                                    data: [$cost_month, $cost_variance],
                                                    backgroundColor: ["#F7464A", "#D3D3D3"],
                                                    hoverBackgroundColor: ["#FF5A5E", "#D3D3D3"]
                                                    }]
                                                    },
                                                    options: {
                                                    responsive: true
                                                    }
                                                    });
                                                </script>
                                                
                                            </div>
                                            <div class="col border border-primary rounded m-2">
                                                <h4 class="text-centre align-middle">Variance</h4>
                                                <canvas style="max-width:50% min-width:30%" id="heatingUsage2"></canvas>
                                                <script>
                                                    //doughnut
                                                    var ctxD = document.getElementById("heatingUsage2").getContext("2d");
                                                    var myLineChart = new Chart(ctxD, {
                                                    type: "doughnut",
                                                    data: {
                                                    labels: ["Budget [£]", "Variance [£]"],
                                                    datasets: [{
                                                    data: [$cost_total, $cost_variance],
                                                    backgroundColor: ["#F7464A", "#D3D3D3"],
                                                    hoverBackgroundColor: ["#FF5A5E", "#D3D3D3"]
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
                                    <!--Date select-->
                                    <p class="lead align-content-center">
                                        <span class="badge info-color-dark p-2">Date range</span>
                                    </p>
                                    <select id="chartPicker" class="browser-default custom-select dropdown" onselect="chartSelect()">
                                        <option value="0" selected="selected">Choose time period</option>
                                        <option value="data1">Year</option>
                                        <option value="data2">Month</option>
                                        <option value="data3">Day</option>
                                    </select>
                                    <button id="control1">upDate -Placholder </button>
                                    
                                    <!--todo get displaying all 3--> 
                                    <canvas id="masterLineChart"></canvas>

                                    <script type="text/javascript">
                                        // Supplied Datasets to display
                                        //hourly 1 upto 24
                                        let dataLabels = $dataLabelsEncoded;
                                        let dataPoints = $dataPointsEncoded;
                                        let dataAvg = $dataAvgEncoded;
                                        
                                       
                                                                                
                                                                                
                                       //line
                                        var ctxL = document.getElementById("lineChart").getContext('2d');
                                        var masterLineChart = new Chart(ctxL, {
                                        type: 'line',
                                        data: {
                                        labels: [dataLabels],
                                        datasets: [{
                                        label: "Power usage",
                                        data: [dataPoints],
                                        backgroundColor: [
                                        'rgba(105, 0, 132, .2)',
                                        ],
                                        borderColor: [
                                        'rgba(200, 99, 132, .7)',
                                        ],
                                        borderWidth: 2
                                        },
                                        {
                                        label: "Average ",
                                        data: dataAvg,
                                        backgroundColor: [
                                        'rgba(0, 137, 132, .2)',
                                        ],
                                        borderColor: [
                                        'rgba(0, 10, 130, .7)',
                                        ],
                                        borderWidth: 2
                                        }
                                        ]
                                        },
                                        options: {
                                        responsive: true
                                        }
                                        });
                                
                                    // Called on Click
                                   $(document).ready(function(){
                                        $("select.dropdown").change(function(){
                                            let selectedChart = $(this).children("option:selected").val();
                                            if (selectedChart ===0)
                                            {
                                                updateChart();
                                            }
                                            alert("You have selected the first chart - " + selectedChart);
                                            }
                                            if (selectedChart ===1)
                                            {
                                            alert("You have selected the second chart - " + selectedChart);
                                            }
                                            if (selectedChart ===2)
                                            {
                                            alert("You have selected the third chart - " + selectedChart);
                                            }
                        
                                    function updateChart(chart, newLabels, newData , newAVG) {
                                        chart.clear();//clears the chart
                                           for (let x in newData ){
                                               chart.data.datasets[0].data[1].label =  newLabels[x];                                    
                                               chart.data.datasets[0].data[1] = newData[x];//should update the chart with a new value
                                               chart.data.datasets[0].data[2] = newAVG[x];//should update the chart with a new value
                                           }
                                        chart.update();//renders the new chart            
                                    }
                                      
                             
                                </script>

                                    
                               </div> 
                            </div>
                        </div>
                    </div>
                
              
                                  
                    <!-- Accordion card -->
html;
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
