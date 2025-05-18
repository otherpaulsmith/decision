<?php
session_start();



function calculations($option_factors, $options, $priorities){
    $options["stayput"] = "Stay at Home";
    $rate_opts = ["same" => "0", "better" => "+1", "worse" => "-1"];
    $result = ["stayput" => "0"];
    $final = [];
    for($i=0;$i<=3;$i++){
        $ee = [];
        for($j=0;$j<=9;$j++){
            $dd = $rate_opts[$option_factors[$i][$j]];
            $pKey = "priority".$j;
            $ee[] = $priorities[$pKey]*$dd;
        }
        $optKey = "option".$i;
        $result[$optKey] = array_sum($ee);
    }
    arsort($result);
    $final = [];
    foreach($result as $key=>$val){
        $final[] = ["option" => $options[$key], "score" => $val];
    }


    return $final;
}




if(isset($_POST["action"])){

    if($_POST["action"] == "step1"){
        unset($_SESSION["step1"]);
        unset($_SESSION["step2"]);
        $_SESSION["step1"] = [ "name" => $_POST["name"],"option0" => $_POST["option0"], "option1" => $_POST["option1"], "option2" => $_POST["option2"], "option3" => $_POST["option3"] ];
        echo json_encode( array(
            'sucess'   => true,
            'data' => $_SESSION["step1"]
        ) );
    }


    if($_POST["action"] == "step2"){
        unset($_SESSION["step2"]);
        $_SESSION["step2"] = [ "priority0" => $_POST["priority0"],"priority1" => $_POST["priority1"],"priority2" => $_POST["priority2"], "priority3" => $_POST["priority3"], "priority4" => $_POST["priority4"], "priority5" => $_POST["priority5"], "priority6" => $_POST["priority6"],"priority7" => $_POST["priority7"], "priority8" => $_POST["priority8"], "priority9" => $_POST["priority9"] ];
        echo json_encode( array(
            'sucess'   => true,
            'data' => $_SESSION["step2"]
        ) );
    }    

    if($_POST["action"] == "step3"){
        $option_factors = $_POST["option_factor"];
         $options = $_SESSION["step1"];
         $priorities = $_SESSION["step2"];
         $result = calculations($option_factors, $options, $priorities);
        echo json_encode( array(
            'sucess'   => true,
            'data' => $result
        ) );
    } 

}



exit;



?>