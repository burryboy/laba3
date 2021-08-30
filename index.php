<header>
<script src="script.js"></script>
<style>
.block
{
    
    border: 1px solid black;
    width: 300px;
    height: 120px;
    padding: 15px;
    margin:5px;
    text-align:center ; border-radius: 25px;  float: left;
}
.insert
{
    padding: 15px;
    margin:5px;
   
    border: 1px solid black;
   
    text-align:center ; border-radius: 5px;  
    float: left;
}

</style>
</header>

<div class="block">
    <form action = "requests.php" method="POST">
    <b>перечень палат, в которых дежурит выбранная медсестра </b><p>
    <?php include 'conect.php';
        echo "<select id='nurse' >";

        
    $stmt = $dbh->prepare ("SELECT name, id_nurse FROM nurse ");
    $stmt->execute();

    if ($stmt->execute(array($_GET['name']))) 
    {
        while ($row = $stmt->fetch()) 
        {
            echo "<option value=".$row['id_nurse'].">".$row['name']."</option>";
        }
    }

    echo "</select>"."<br>";

    ?>

<input type="button" name="form1" value="Поиск" onclick="getWardByNurse()"><p>
    </form>
</div>


<div class="block">
    <form action = "requests.php" method="POST">
    <b>медсестры выбранного отделения</b><p> отделение №: 
    <?php include 'conect.php';
      echo "<select id='department' >";

        
    $stmt = $dbh->prepare ("SELECT DISTINCT department FROM nurse");
    $stmt->execute();

    if ($stmt->execute(array($_GET['department']))) 
    {
        while ($row = $stmt->fetch()) 
        {
            echo "<option value=".$row['department'].">".$row['department']."</option>";
        }
    }

    echo "</select>"."<br>";
    
    ?>
    <input type="button" name="form1" value="Поиск" onclick="getNurseByDepartment()"><p>
    </form>
</div>


<div class="block">
    <form action = "requests.php" method="POST">
    <b>дежурства (в любых палатах) в указанную смену </b><p>
    <?php include 'conect.php';
        echo "<select id='shift' >";
    
    $stmt = $dbh->prepare ("SELECT DISTINCT  shift FROM nurse");
            $stmt->execute();
        
            if ($stmt->execute(array($_GET['shift']))) 
            {
                while ($row = $stmt->fetch()) 
                {
                    echo "<option value=".$row['shift'].">".$row['shift']."</option>";
                }
            }

    echo "</select>";
        
    ?>
    <br>
    <input type="button" name="form2" value="Поиск" onclick="getDutyInWardByShift()"><p>

    </form>
</div>


<div class="insert" id="text" style=" float: left ">
Окно для результата:
</div>

