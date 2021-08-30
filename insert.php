<?php


include 'conect.php';

function getIdNurse($dbh)
{
    $sql = "SELECT max(id_nurse) as id From nurse";
    foreach ($dbh->query($sql) as $row) 
    { return $row['id']; }
}

function getIdWard($dbh)
{
    $sql = "SELECT max(id_ward) as id From ward";
    foreach ($dbh->query($sql) as $row) 
    { return $row['id']; }
}

function createNursu($pdo, $name, $date, $department, $shift)
{
    $sql = ("INSERT INTO `nurse`(id_nurse,`name`, `date`, `department`,`shift`) VALUES(?,?,?,?,?)");
    
        $query = $pdo->prepare($sql);
    $query->execute([(1+getIdNurse($pdo)),$name, $date, $department,$shift]);

    echo "Медсестра додана!";
}

function createWard($pdo, $name)
{
    $sql = ("INSERT INTO `ward`(id_ward,`name`) VALUES(:id, :name)");
    $query = $pdo->prepare($sql);
    $query->execute([':id' =>(getIdWard($pdo)+1), ':name'=>$name]);    
    echo "Палата додана!";
}

function setNurseToWard($pdo, $id_nurse, $id_ward)
{
    $stmt = $pdo->prepare("INSERT INTO nurse_ward (fid_nurse, fid_ward) VALUES(:id_nurse, :id_ward)");
    $stmt->bindParam(':id_nurse', $id_nurse);
    $stmt->bindParam(':id_ward', $id_ward);
    $stmt->execute();
    echo 'медсестру назначено!';
}

if(array_key_exists('new_nurse',$_POST))
{
    createNursu($dbh, $_POST['name'], $_POST['date'],$_POST['department'],$_POST['shift']);
}
elseif(array_key_exists('new_ward',$_POST))
{
    createWard($dbh, $_POST['name']);
}
elseif(array_key_exists('setNurseToWard',$_POST))
{
    setNurseToWard($dbh, $_POST['nurse'], $_POST['ward']);
}


//setNurseToWard
?>