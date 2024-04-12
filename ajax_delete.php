<?php


include_once('include/connect.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $id = $_POST['id'];

    $detaa = "y";

    $updParams=array(
        "is_deleted"=>$detaa
    );

    $updWhere=array(
        'clause'=>"id =:id_record",
        'params'=>array(
            ":id_record"=>$id,
        )
    );

    $pdo->update("users",$updParams,$updWhere);
  
        if ($pdo) {
    
            $response = array(
                'statusCode' => 200,
                'message' => 'user deleted successful'
            );
            header('Content-Type: application/json');
            echo json_encode($response);
        } else {
            // Insertion failed
            header('Content-Type: application/json');
            echo json_encode(array("statusCode" => 400, "message" => "Failed to update user"));
        }
        exit();

}

?>
