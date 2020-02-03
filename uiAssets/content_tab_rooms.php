<!-- Card deck -->
<?php
include_once dirname(__DIR__).'/required/config.php';

function generateRoomTab(){
    $html = '';
    global $db;
    if(isset($_SESSION['hub_id'])){
        $hub_id = $_SESSION['hub_id'];
        $stmt = $db->prepare("SELECT * FROM room_info WHERE hub_id = ?");
        $stmt->bind_param("i", $hub_id);
        $stmt->execute();
        $result = $stmt->get_result();
        

        $html .= <<<html
            <a href="index.php?action=addroom">
                <div class="card mb-4 container">
                    <!--Card image-->
                    <div class="view overlay">
                        <div class="mask rgba-white-slight"></div>
                    </div>
              
                    <!--Card content-->
                    <div class="card-body d-flex justify-content-between">
              
                    <!--Title-->      
                        <div class="d-flex flex-column">  
                            Add new room
                        </div>
                        
                        <div class="d-flex flex-column">
                            <i class="far fa-plus-square"></i>
                        </div>
                    </div>
                </div>
            </a>
html;

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $room_id = $row['room_id'];
                $room_name = $row['room_name'];
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
                            $room_name
                        </div>
                        
                        <div class="d-flex flex-column">
                            <!-- Default switch -->
                            <div class="custom-control custom-switch">
                                <form onsubmit="toggleRoom($device_id);" method="POST">
                                    <input type="checkbox" class="custom-control-input" id="roomSwitch">
                                    <label class="custom-control-label" for="roomSwitch">off/on</label>
                                </form>
                            </div>  
                        </div>
                    </div>
                </div>
html;
            }
        }
        $stmt->close();
    } else{
        exit("Error, user is not logged in!");
    }
    return $html;

}
   
?>