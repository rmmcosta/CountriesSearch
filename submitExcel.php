<?php
    // require to handle excel files
    require 'vendor/autoload.php';
    // alias to the spreadsheet
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
    
    if(isset($_POST['submit'])){

        $excel = $_FILES["excel"];
        
        $allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
  
        if(in_array($excel["type"],$allowedFileType)){

                $targetPath = 'uploads/'.$excel["name"];
                move_uploaded_file($excel["tmp_name"], $targetPath);

                $inputFileName = $targetPath;
                
                /**  Identify the type of $inputFileName  **/
                $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);
                /**  Create a new Reader of the type that has been identified  **/
                $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
                /**  Advise the Reader that we only want to load cell data  **/
                $reader->setReadDataOnly(true);
                /**  Load $inputFileName to a Spreadsheet Object  **/
                $spreadsheet = $reader->load($inputFileName);
                
                $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
                
                $conn = mysqli_connect('localhost','root','','countriessearch');
                    
                $worksheet = $spreadsheet->getActiveSheet();

                $highestRow = $worksheet->getHighestRow();

                $query = 'delete from countries;';
                $result = mysqli_query($conn, $query) or die('Unable to cleat the countries Table!');

                for ($row = 1; $row <= $highestRow; ++$row) {
                    $country = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                    $region = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                    $population = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                    $area = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                    $density = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                    $query = "insert into countries(country,region,population,area,density) 
                    values('".$country."','".$region."',".$population.",".$area.",".$density.")";
                    $result = mysqli_query($conn, $query);
                
                    if (! empty($result)) {
                        $type = "success";
                        $message = "Excel Data Imported into the Database";
                    } else {
                        $type = "error";
                        $message = "Problem in Importing Excel Data";
                    }
                }
        }
        else
        { 
                $type = "error";
                $message = "Invalid File Type. Upload Excel File.";
        }

        echo $type.'<br>'.$message;
        header('Location:uploadExcel.php');
    }
?>