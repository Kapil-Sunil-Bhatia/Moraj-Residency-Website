<?php
require_once 'config.php';
require '../vendor/autoload.php';
$host = "localhost";
$username = "u368660946_moraj";
$password = "mN]QJIa3b1";
$database = "u368660946_sms";


// Create DB Connection
$conn = mysqli_connect($host, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";

use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if (isset($_POST['save_excel_data'])) {
    $fileName = $_FILES['import_file']['name'];
    $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);

    $allowed_ext = ['xls', 'csv', 'xlsx'];

    if (in_array($file_ext, $allowed_ext)) {
        $inputFileNamePath = $_FILES['import_file']['tmp_name'];
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileNamePath);
        $data = $spreadsheet->getActiveSheet()->toArray();

        $count = "0";
        foreach ($data as $row) {
            if ($count > 0) {
                $flat_id = $row['0'];
                $bill_title = $row['1'];
                $amount = $row['2'];
                $month = $row['3'];

                $studentQuery = "INSERT INTO bills (flat_id,bill_title,amount,remaining_amount,month) VALUES ('$flat_id','$bill_title','$amount','$amount','$month')";
                $result = mysqli_query($conn, $studentQuery);
                $msg = true;
            } else {
                $count = "1";
            }
        }

        if (isset($msg)) {
            $_SESSION['message'] = "Successfully Imported";
            header('Location: index.php');
            exit(0);
        } else {
            $_SESSION['message'] = "Not Imported";
            header('Location: index.php');
            exit(0);
        }
    } else {
        $_SESSION['message'] = "Invalid File";
        header('Location: index.php');
        exit(0);
    }
}