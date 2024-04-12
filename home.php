<?php
include_once __DIR__ . '/include/connect.php'; 

//this code for session
session_start();

if(!isset($_SESSION["user"])){
    header('Location: login.php');
    exit();
}

//end session
$per_page = 10;

//normal call all data 

// $page = isset($_GET['page']) ? $_GET['page'] : 1;



$host ="localhost";
$dbname = "structure_task_project";
$username ="root";
$password = "";

$dbh = new PDO("mysql:host={$host};dbname={$dbname}", $username, $password);

$sel_sql ="SELECT * FROM users";

$options = array(
    'results_per_page' =>$per_page,
    'url'        => 'http://localhost/12_04_pagination_acording_project\home.php?page=*VAR*', // Update the URL accordingly
    'db_handle'  => $dbh,
    'text_prev' => '&laquo; Prev',
    'text_next' => 'Next &raquo;',
    'text_first' => '&laquo; First',
    'text_last' => 'Last &raquo;',
    'text_ellipses' => '...',
    'class_ellipses' => 'ellipses',
    'class_dead_links' => 'dead-link',
    'class_live_links' => 'live-link',
    'class_current_page' => 'current-link',
  );

  $page = isset($_GET['page']) > 0 ? $_GET['page'] : 1;
  $paginate = new pagination($page, $sel_sql, $options);

// include_once 'tmpl/home.inc.php';
// exit;


//normal end

//call ajax and call that 
$incr = '';
$is_ajaxed = isset($_GET['is_ajaxed']);
// print_r($is_ajaxed);
$keyword = isset($_GET['keyword']);

$searchkey = "";

// if($searchkey != null){
//     print_r($_GET['search']);
// }


if ($is_ajaxed) {

    try {
    //   $ajax_sql = "SELECT * FROM users";
      $has_querystring = true;
    //   print_r($sel_sql);
    // if($searchkey ){
    //     // print_r($_GET['search']);
    //     $ajax_sql = 'SELECT * FROM company WHERE name LIKE :keyword OR email LIKE :keyword OR address LIKE :keyword';
        

    // }


    if(isset($_GET['search']) && !empty($_GET['search'])) {
        // A search query is provided, perform search

        $searchkey = $_GET['search'];
        // print_r($searchkey."val");
        // exit(); 
        $ajax_sql = "SELECT * FROM users WHERE firstname LIKE '%$searchkey%' OR lastname LIKE '%$searchkey%' OR email LIKE '%$searchkey%'";

    } else {

        print_r("else ma jay");
        // No search query provided, perform default query
        $ajax_sql = 'SELECT * FROM users';
        $has_querystring = true;
    }
    
   
    if (isset($_GET['pages']) && $_GET['pages'] > 0) {
        $has_querystring = true;
        $per_page = $_GET['pages'];
      }

    print_r($page."paginon");

    $query_string = $has_querystring ? (isset($_GET['page']) !='' ? str_replace('page=' . $_GET['page'], "page=*VAR*", $_SERVER['QUERY_STRING']) : $_SERVER['QUERY_STRING'] . "&page=*VAR*") : 'page=*VAR*';

$options = array(
    'results_per_page' => $per_page,
    'url' => 'http://localhost/12_04_pagination_acording_project\home.php??' . $query_string,
    'db_handle'  => $dbh,
    'text_prev' => '&laquo; Prev',
    'text_next' => 'Next &raquo;',
    'text_first' => '&laquo; First',
    'text_last' => 'Last &raquo;',
    'text_ellipses' => '...',
    'class_ellipses' => 'ellipses',
    'class_dead_links' => 'dead-link',
    'class_live_links' => 'live-link',
    'class_current_page' => 'current-link',
);
 
      $paginate = new pagination($page, $ajax_sql, $options);
   
    } catch (paginationException $e) {
      echo $e;
      exit();
    }
    include_once 'tmpl/home.inc.php';
    exit;
  }
//and ajax call 

$template = 'home.inc.php';
$layout = 'main.layout.php';
include_once ('layout/end.inc.php')

?>