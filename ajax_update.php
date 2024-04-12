<?php
// Start or resume a session


// include_once '/includes/connect.php'; 

include_once('include/connect.php');
// include_once('includes/config.php');


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data

    

    // var_dump($_POST['firstname']);

    // print_r($_POST['password']);
    $id = $_POST['id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    
    $gender = $_POST['gender'];
    $phonenumber = $_POST['phonenumber'];
    // $terms = $_POST['terms'];

    $validate = new Validation();
    $validate->string(array('required' => true, 'field' => 'firstname', 'min' => '3', 'max' => '30', 'value' => $firstname), array('required' => 'firstName is required'));
    // Validate first nam
    $validate->string(array('required' => true, 'field' => 'lastname', 'min' => '3', 'max' => '30', 'value' => $lastname), array('required' => 'lastName is required'));
    $validate->email(array('required' => true, 'field' => 'email', 'min' => '3', 'max' => '30', 'value' => $email), array('required' => 'email is required'));
    $validate->string(array('required' => true, 'field' => 'gender', 'min' => '1', 'max' => '10', 'value' => $gender), array('required' => 'Gender is required'));
    $validate->phoneDigit(array('required' => true, 'field' => 'phonenumber', 'min' => '3', 'max' => '10', 'value' => $phonenumber), array('required' => 'Phone number is required', 'max' => 'Phone number not write more than 10','invalid'=>"write valid"));
    
    
    if($validate->isValid()) {
   
    
        $updParams=array(
            "firstname"=>$firstname,
            "lastname"=>$lastname,
            "email"=>$email,
            "gender" => $gender,
            "phonenumber" => $phonenumber,
        );

        $updWhere=array(
			'clause'=>"id =:id_record",
			'params'=>array(
				":id_record"=>$id,
			)
		);


        $pdo->update("users",$updParams,$updWhere);
    // var_dump($insparams);
        // $id=$pdo->insert("users",$insparams);


        // $lname = "Doe";
		// $city = "Mumbai";
		

		// $idRecord = 1;

		// $updParams=array(
		// 	"fname"=>"John",
		// 	"lname"=>$lname,
		// 	"city"=>$city,
		// 	"state"=>"MH",
		// );

		// $updWhere=array(
		// 	'clause'=>"id =:id_record",
		// 	'params'=>array(
		// 		":id_record"=>$idRecord,
		// 	)
		// );
		// $pdo->update("customer",$updParams,$updWhere);

    
        
        // echo json_encode(array("statusCode" => 200 , "message"=>$id. " users added successfully"));
        // exit();
        if ($pdo) {
    
            $response = array(
                'statusCode' => 200,
                'message' => 'Use updated successful',
                'data' => array(
                    'firstname' => $firstname,
                    'lastname' => $lastname,
                    'email' => $email,
                    'gender' => $gender,
                    'phonenumber' => $phonenumber
                )
            );
            // Insertion successful
            
    
            header('Content-Type: application/json');
            echo json_encode($response);
        } else {
            // Insertion failed
            header('Content-Type: application/json');
            echo json_encode(array("statusCode" => 400, "message" => "Failed to update user"));
        }
        exit();
        
     }
     else{
        $errors = $validate->getErrors();
        header('Content-Type: application/json');
        echo json_encode($errors); // Return only the error message for firstName
  
        
        // echo json_encode(array("statusCode" => 500, "message" => $errors));
     }


}

?>
