<?php
// Start or resume a session
session_start();

// include_once '/includes/connect.php'; 

include_once('include/connect.php');
// include_once('includes/config.php');


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data

    $passwordbycript = md5($_POST["password"]);

    // print_r($_POST['password']);
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password  = $passwordbycript;
    $gender = $_POST['gender'];
    $phoneNumber = $_POST['phoneNumber'];
    // $terms = $_POST['terms'];

    $validate = new Validation();
    $validate->string(array('required' => true, 'field' => 'firstName', 'min' => '3', 'max' => '30', 'value' => $firstName), array('required' => 'firstName is required'));
    // Validate first nam
    $validate->string(array('required' => true, 'field' => 'lastName', 'min' => '3', 'max' => '30', 'value' => $lastName), array('required' => 'lastName is required'));
    $validate->string(array('required' => true, 'field' => 'last_name', 'min' => '3', 'max' => '30', 'value' => $lastName), array('required' => 'Last Name is required'));
    $validate->email(array('required' => true, 'field' => 'email', 'min' => '3', 'max' => '30', 'value' => $email), array('required' => 'email is required'));
    $validate->string(array('required' => true, 'field' => 'password', 'min' => '6', 'max' => '255', 'value' => $password), array('required' => 'Password is required', 'min' => 'Password should be at least 6 characters long'));
    $validate->string(array('required' => true, 'field' => 'gender', 'min' => '1', 'max' => '10', 'value' => $gender), array('required' => 'Gender is required'));
    $validate->phoneDigit(array('required' => true, 'field' => 'phoneNumber', 'min' => '3', 'max' => '10', 'value' => $phoneNumber), array('required' => 'Phone number is required', 'max' => 'Phone number not write more than 10','invalid'=>"write valid"));
    
    
    if($validate->isValid()) {
   
    
        $insparams=array(
            "firstName"=>$firstName,
            "lastName"=>$lastName,
            "email"=>$email,
            "password"=>$password,
            "gender" => $gender,
            "phoneNumber" => $phoneNumber,
        );

    // var_dump($insparams);
        $id=$pdo->insert("users",$insparams);
    
        $_SESSION['message'] = "Data added successfully";
        // echo json_encode(array("statusCode" => 200 , "message"=>$id. " users added successfully"));
        // exit();
        if ($id) {
    
            $response = array(
                'statusCode' => 200,
                'message' => 'User registration successful',
                'data' => array(
                    'firstName' => $firstName,
                    'lastName' => $lastName,
                    'email' => $email,
                    'gender' => $gender,
                    'phoneNumber' => $phoneNumber
                )
            );
            // Insertion successful
            
    
            header('Content-Type: application/json');
            echo json_encode($response);
        } else {
            // Insertion failed
            header('Content-Type: application/json');
            echo json_encode(array("statusCode" => 400, "message" => "Failed to add user"));
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
