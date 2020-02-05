<!-- Card deck -->
<?php
include_once dirname(__DIR__).'/required/config.php';

function generateDeviceTab(){
    $html = '';
    
    $html .= <<<html
        <a href="index.php?action=adddevice">
            <div class="card mb-4 container">
                <!--Card image-->
                <div class="view overlay">
                    <div class="mask rgba-white-slight"></div>
                </div>
        
                <!--Card content-->
                <div class="card-body d-flex justify-content-between">
        
                <!--Title-->      
                    <div class="d-flex flex-column">  
                        Add new device
                    </div>
                    
                    <div class="d-flex flex-column">
                        <i class="far fa-plus-square"></i>
                    </div>
                </div>
            </div>
        </a>
html;

    global $db;
    session_start();
    if(isset($_SESSION['hub_id'])){
        $hub_id = $_SESSION['hub_id'];
        session_write_close();

        $stmt = $db->prepare("SELECT * FROM device_info WHERE hub_id = ?");
        $stmt->bind_param("i", $hub_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $device_id = $row['device_id'];
                $device_name = $row['device_name'];
                $device_type = $row['device_type'];

                $stmt3 = $db->prepare("SELECT * FROM device_types WHERE type_id = ?");
                $stmt3->bind_param("i", $device_type);
                $stmt3->execute();
                $result3 = $stmt3->get_result();
                $row3 = $result3->fetch_assoc();
                $icon = $row3['type_icon'];

                $html .= <<<html
                <!-- Card -->
                <div class="card mb-4 container">
                    <!--Card image-->
                    <div class="view overlay">
                        <div class="mask rgba-white-slight"></div>
                    </div>
              
                    <!--Card content-->
                    <div class="card-body d-flex justify-content-between">
                
                        <!--Title-->      
                        <div class="d-flex flex-column">  
                            <div class="row">
                                $icon &nbsp; $device_name
                            </div>
                        </div>
                        
                        <div class="d-flex flex-column">
                            <!-- Default switch -->
                            <div class="custom-control custom-switch">
                                <form onsubmit="toggleDevice($device_id;)" method="POST">
                                    <input type="checkbox" class="custom-control-input" id="deviceSwitch">
                                    <label class="custom-control-label" for="deviceSwitch">off/on</label>
                                </form>
                            </div>  
                        </div>

                    </div>
                </div>
html;
                $stmt3->close();

            }
        }
        $stmt->close();
    } else{
        exit("Error, user is not logged in!");
    }
    return $html;
}
   
?>