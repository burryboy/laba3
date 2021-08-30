<?php 

include 'conect.php';

function getWardListByNurse($dbh, $id_nurse)
{
    $stmt = $dbh->prepare ("SELECT name FROM ward WHERE id_ward IN (Select fid_ward from nurse_ward where fid_nurse= :id_nurse) ");

    echo "<b>Палати в яких чергує обрана медсестра: </b><br>"; 

    if ($stmt->execute(array(':id_nurse' => $id_nurse))) 
    {
        
        while ($row = $stmt->fetch()) 
        {
          print_r($row[0]);
          echo "<br>";
        }
    }
}

function getNurseByDepartment($dbh, $department)
{
    $stmt = $dbh->prepare ( "SELECT * FROM nurse WHERE department = ?"); 

    $stmt->bindParam(1,$department);
    if ($stmt->execute()) 
    {
       
        header('Content-Type: text/xml');
        header("Cache-Control: no-cache, must-revalidate");
        echo '<?xml version="1.0" encoding="utf8" ?>';
    
        print ("<root>");
    
        while ($row = $stmt->fetch()) 
        {
         // echo '<tr><td>'.$row['name'].'</td><td>'.$row['department'].'</td><td>'.$row['shift'].'</td></tr>';
          print ("<row><name>".$row['name']."</name><department>".$row['department']."</department> <shift>".$row['shift']."</shift> </row>");
        
        }
        
        print ("</root>");
    }
}

function getDutyInWardByShift($dbh, $shift)
{
    $sql = "SELECT DISTINCT nurse.name as nurse_name,  nurse.date as nurse_date, nurse.department as nurse_department, nurse.shift as nusre_shift, ward.name as ward_name
            FROM nurse Join nurse_ward on nurse.id_nurse = nurse_ward.fid_nurse Join ward On nurse_ward.fid_ward = ward.id_ward
            WHERE nurse.shift = '$shift'";
   
    
    $data = array();
        
    foreach ($dbh->query($sql) as $row) 
    {
       array_push($data, $row['nurse_name'], $row['nurse_date'],$row['nurse_department'], $row['nusre_shift'], $row['ward_name']);
    }
    echo json_encode($data);
}   


if ($_GET['id_nurse']!= null)
{
    getWardListByNurse($dbh, $_GET['id_nurse']); 
}
else if ($_GET['department']!= null)
{
    getNurseByDepartment($dbh, $_GET['department']); 
}
else if ($_GET['shift']!= null)
{    
    getDutyInWardByShift($dbh, $_GET['shift']); 
}

?>