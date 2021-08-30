var ajax; // глобальная переменная для хранения объекта AJAX
InitAjax();
function InitAjax() 
{
    try
    { /* пробуем создать компонент XMLHTTP для IE старых версий */
    ajax = new ActiveXObject("Microsoft.XMLHTTP");
    } 
catch (e)
    {
        try
        {
        ajax = new ActiveXObject("Msxml2.XMLHTTP"); // для IE версий >6
        }
    catch (e) 
        {
            try {// XMLHTTP для Mozilla и остальных
            ajax = new XMLHttpRequest(); // на текущий момент можно ограничится этим вызовом
            } catch(e) { ajax = 0; }
        }
    }
}

function getWardByNurse()
 {
    if (!ajax)
     {
    alert("Ajax не инициализирован"); return;
    }
    var s1val = document.getElementById("nurse").value;
    
    ajax.onreadystatechange = OutWardByNurse;
    var param1 = 'id_nurse=' + encodeURIComponent(s1val);
    
    ajax.open("GET", "requests.php?"+param1, true);
    ajax.send(null);
}

function OutWardByNurse()
 {
    if (ajax.readyState == 4) 
    {
        if (ajax.status == 200) 
        {
        // если ошибок нет
        var select = document.getElementById('text');
        select.innerHTML = ajax.responseText;
        }
    else alert(ajax.status + " - " + ajax.statusText);
    ajax.abort();
    }
}

function getNurseByDepartment()
 {
    

    if (!ajax)
     {
    alert("Ajax не инициализирован"); return;
    }
    var s1val = document.getElementById("department").value;
    
    ajax.onreadystatechange = OutNurseByDepartment;
    var param1 = 'department=' + encodeURIComponent(s1val);
    
    ajax.open("GET", "requests.php?"+param1, true);
    ajax.send(null);
}

function OutNurseByDepartment()
{
    if (ajax.readyState == 4) 
    {
        if (ajax.status == 200) 
        {
        
            var res = document.getElementById("text");
                
            var result = "";
            var rows = ajax.responseXML.firstChild.children;
            result +="<table border=1> <tr><td>Ім`я</td><td>Відділення</td><td>Зміна</td></tr>";
            for (var i = 0; i < rows.length; i++) 
            {
                result += "<tr>";
                result += "<td>" + rows[i].children[0].firstChild.nodeValue + "</td>";
                result += "<td>" + rows[i].children[1].textContent + "</td>";
                result += "<td>" + rows[i].children[2].textContent + "</td>";
                result += "</tr>";
            }
            result +="</table>";
            res.innerHTML = result;
       
        }
    }
    
}

function getDutyInWardByShift()
 {
    

    if (!ajax)
     {
    alert("Ajax не инициализирован"); return;
    }
    var val1 = document.getElementById("shift").value;    
    
    ajax.onreadystatechange = OutDutyInWardByShift;
    var param1 = 'shift=' + encodeURIComponent(val1);
    
    
    ajax.open("GET", "requests.php?"+param1, true);
    ajax.send(null);
}

function OutDutyInWardByShift()
 {
    if (ajax.readyState == 4) 
    {
        if (ajax.status == 200) 
        {
        // если ошибок нет
        var res = document.getElementById("text");
        var result ="<table border=1> <tr><td>Ім`я</td><td>Дата</td><td>Відділення</td><td>Зміна</td><td>Палата</td></tr>";

        var arr = JSON.parse(ajax.responseText);
        
        for(i=0; i<arr.length/5; i++)
        {
            result += "<tr>";
            result += "<td>" + arr[0+(5*i)] + "</td>";
            result += "<td>" + arr[1+(5*i)] + "</td>";
            result += "<td>" + arr[2+(5*i)] + "</td>";
            result += "<td>" + arr[3+(5*i)] + "</td>";
            result += "<td>" + arr[4+(5*i)] + "</td>";
            result += "</tr>";
        }


        result +="</table>";
        res.innerHTML = result;
        }
    else alert(ajax.status + " - " + ajax.statusText);
    ajax.abort();
    }
}
    