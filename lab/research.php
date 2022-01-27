<?php
 // temp solution
    session_start();

    include("includes/connection.php");

    // Fetch all research children nodes form DB
    if(isset($_POST['command'])){
        if($_POST['command'] == "getAllResearchChildren"){
            $sql = "SELECT name, result, units, reference_value FROM research_children where research_parent_id='$_POST[research_parent_id]'";
            $stmt = $connect->prepare($sql);
            $stmt->execute();

            $prepare_stmt_result = $stmt->get_result();
            $result = [];
            while($row = $prepare_stmt_result->fetch_assoc()){
                $result[] = $row;
            }
            echo json_encode($result);
            return;
        }
    }

    include("includes/header.php");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Dexter's Lab</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script>
        $(document).ready(function(){
            $(".research_parent_row").click(function(){
                let clicked_parent_research = $(this);
                $.ajax({
                    url: "research.php",
                    method: "POST",
                    data: {command: "getAllResearchChildren", research_parent_id: clicked_parent_research.attr("data-id")},
                    success: function(result){
                        json = JSON.parse(result);

                        $("#research_children_wrapper").append('<table class="table">' +
                                                                    '<thead>' +
                                                                        '<tr>' +
                                                                            '<th scope="col">Name</th>' +
                                                                            '<th scope="col">Result</th>' +
                                                                            '<th scope="col">Units</th>' +
                                                                            '<th scope="col">Reference value</th>' +
                                                                        '</tr>' +
                                                                    '</thead>' +
                                                                    '<tbody>');

                        json.forEach(row => {
                            $("#research_children_wrapper").append('<tr>' +
                                                                        '<td>' + row.name + '</td>' +
                                                                        '<td>' + row.result + '</td>' +
                                                                        '<td>' + row.units + '</td>' +
                                                                        '<td>' + row.reference_value + '</td>' +
                                                                    '</tr>');
                        });

                        $("#research_children_wrapper").append('</tbody>' +
                            '</table>');
                    }
                });
            });
        });
    </script>
    <style>
        html,
        body {
            height: 100%;
        }
        .research_parent_row:hover{
            background-color: #2C3034;
            cursor: pointer;
        }
    </style>
</head>
<body>

<?php

    $stmt = $connect->prepare("SELECT * FROM research_parents where patient_id='$_SESSION[user_id]'");
    $stmt->execute();

    $prepare_stmt_result = $stmt->get_result();
    ?>

<div style="position: relative;top:100px;width:100%;height: 80%;">
    <!-- Left side -->
    <div style="position: relative;left: 50px;background-color: #343A40;width:40%;border-radius: 5px;padding: 20px;height: 100%;display: inline-block;">
        <div style="font-weight: bold;color: white;margin-bottom: 30px;padding: 5px;">
            <div style="display: inline-block;width: 50%;">Date</div>
            <div style="display: inline-block;">Name</div>
        </div>
        <?php while ($row = $prepare_stmt_result->fetch_assoc()){ ?>
            <div style="color: white;padding-top: 20px;padding-bottom: 20px;padding-left: 8px;padding-right: 8px;" class="research_parent_row" data-id="<?=$row['id']?>">
                <div style="display: inline-block;width: 50%;"><?=$row['date']?></div>
                <div style="display: inline-block;"><?=$row['name']?></div>
            </div>
            <?php
        }
        ?>
    </div>

    <!-- Right side -->
    <div style="position: relative;float:right;right: 50px;background-color: #343A40;width:40%;border-radius: 5px;padding: 20px;height: 100%;display: inline-block;" id="research_children_wrapper">

    </div>
</div>






