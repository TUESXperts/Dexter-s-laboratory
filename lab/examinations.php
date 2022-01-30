<?php
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
        } else if($_POST['command'] == "save_examinations"){
            // If there are new parent examinations added
            if(isset($_POST['name'])){
                $names = $_POST['name'];
                $dates = $_POST['date'];
                $patient_id = $_POST['patient_id'];
                $remove_parents_ids = $_POST['remove_parents_ids'];

                $iterator = new MultipleIterator;
                $iterator->attachIterator(new ArrayIterator($names));
                $iterator->attachIterator(new ArrayIterator($dates));

                $sql = "INSERT INTO research_parents (name, date, patient_id) VALUES (?, ?, ?)";
                $stmt = $connect->prepare($sql);

                foreach ($iterator as $values) {
                    var_dump($values[0], $values[1]);
                    $stmt->bind_param("ssd", $values[0], $values[1], $patient_id);
                    $stmt->execute();
                }

                print_r($remove_parents_ids);
            }
            return;
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Dexter's Lab</title>
    <?php include("includes/header_links.php"); ?>
    <script>
        $(document).ready(function(){
            // Global variables
            var firstTimeAddingParentExamination = true;
            var remove_parents_ids = [];

            $(".research_parent_row").click(function(){
                let clicked_parent_research = $(this);
                $.ajax({
                    url: "examinations.php",
                    method: "POST",
                    data: {command: "getAllResearchChildren", research_parent_id: clicked_parent_research.attr("data-id")},
                    success: function(result){
                        json = JSON.parse(result);

                        $("#research_children_wrapper").empty();

                        if(json.length == 0)  {
                            $("#research_children_wrapper").append("<h4 id='no_children_research_nodes'>No results had been found.</h4>");
                            return;
                        }

                        $("#research_children_wrapper").append('<table class="table" id="research_children_table">' +
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
                            $("#research_children_table").append('<tr>' +
                                                                        '<td>' + row.name + '</td>' +
                                                                        '<td>' + row.result + '</td>' +
                                                                        '<td>' + row.units + '</td>' +
                                                                        '<td>' + row.reference_value + '</td>' +
                                                                    '</tr>');
                        });

                        $("#research_children_table").append('</tbody>' +
                            '</table>');

                        // Append Add or Remove buttons
                        $("#research_children_wrapper").append(
                            '<div class="form-group" style="display: flex;">' +
                                '<div class="button_add_child">' +
                                    '<i class="fas fa-plus-circle"></i>' +
                                '</div>' +
                                '<div class="button_remove_child">' +
                                    '<i class="fas fa-minus-circle"></i>' +
                                '</div>' +
                            '</div>'
                        );
                    }
                });
            });

            // $(".button_add_parent,.button_remove_parent").click(function(){
            //     if($("#save_examinations").length == 0) {
            //         $("body").append(
            //             '<div style="text-align:center;">' +
            //             '<button type="button" id="save_examinations" class="btn btn-primary">Save</button>'+
            //             '</div>'
            //         );
            //     }
            // });

            $(".button_add_parent").click(function(){

                if($("#parent_examinations_tab_columns").length == 0) {
                    $("#no_parent_examinations_nodes").remove();
                    $("#parent_examinations_wrapper").append(
                        '<div id="parent_examinations_tab_columns" style="font-weight: bold;color: white;margin-bottom: 30px;padding: 5px;">' +
                            '<div style="display: inline-block;width: 50%;">Date</div>' +
                            '<div style="display: inline-block;">Name</div>' +
                        '</div>');
                }

                // Add form tag
                if(firstTimeAddingParentExamination){
                    $("#parent_examinations_wrapper").append('<form method="post" id="parents_submission_form">');
                }

                    // Add input fields for each parent examination to the form
                    $("#parents_submission_form").append(
                    '<div style="color: white;padding-top: 20px;padding-bottom: 20px;padding-left: 8px;padding-right: 8px;" class="research_parent_row temp_parent">' +
                        '<div style="display: inline-block;width: 50%;"><input type="date" name="date[]"></div>' +
                        '<div style="display: inline-block;"><input type="text" name="name[]"></div>' +
                    '</div>');

                if(firstTimeAddingParentExamination){
                    $("#parent_examinations_wrapper").append('</form>');
                }

                firstTimeAddingParentExamination = false;
            });

            $(".button_remove_parent").click(function(){
                // Remove last Parent element
                let last_parents_element = $(".research_parent_row").last();

                if(!last_parents_element.hasClass("temp_parent")){
                    remove_parents_ids.push(last_parents_element.attr("data-id"));
                    console.log(remove_parents_ids);
                    console.log("inside the if sttement")
                }

                last_parents_element.remove();
            });


            $("#save_examinations").click(function(){
                let form = $("#parents_submission_form");
                //e.preventDefault();

                const urlParams = new URLSearchParams(window.location.search);
                const patient_id = urlParams.get('userid');

                // form.append('<input type="hidden" name="patient_id" value="' + patient_id + '">');
                // form.append('<input type="hidden" name="remove_parents_ids[]" value="' + remove_parents_ids + '">');
                // form.append('<input type="hidden" name="command" value="save_examinations">');

                // $.ajax({
                //     url: "examinations.php",
                //     method: "POST",
                //     data:  { formData: form.serialize(), patient_id, remove_parents_ids, command: save_examinations },
                //     success: function(data) {
                //         alert(data);
                //     }
                // });

                const url = "http://localhost/Dexters-lab/lab/examinations.php";
                fetch(url, {
                    method : "POST",
                    body:
                    JSON.stringify({
                        formData: new FormData($("#parents_submission_form").val()),
                        patient_id : patient_id,
                        remove_parents_ids: remove_parents_ids,
                        command: "save_examinations"
                    })
                }).then(response => response.json())
                    .then(data => console.log(data));

                console.log("executed");
               // form.submit();
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
        #research_children_table{
            color: white;
        }
        #no_children_research_nodes{
            color: white;
        }
        .button_add_parent, .button_add_child{
            width: 80%;
        }

        .button_remove_parent, .button_remove_child {
            width: 20%;
        }

        .button_add_parent, .button_remove_parent, .button_add_child, .button_remove_child{
            display: inline-block;
            height: 50px;
            text-align: end;
        }

        .fas.fa-plus-circle{
            color: #87D37C;
        }

        .fas.fa-minus-circle{
            color: #D24D57;
        }

        .fas.fa-plus-circle, .fas.fa-minus-circle{
            font-size: 25px;
        }

        .fas.fa-plus-circle:hover{
            cursor: pointer;
            font-size: 28px;
        }

        .fas.fa-minus-circle:hover{
            cursor: pointer;
            font-size: 28px;
        }
    </style>
</head>
<body>

<?php
    include("includes/header_navigation.php");

    $sql = "SELECT * FROM research_parents where patient_id='$_GET[userid]'";
    $stmt = $connect->prepare($sql);
    $stmt->execute();

    $prepare_stmt_result = $stmt->get_result();
    ?>

<div style="position: relative;margin-top:50px;width:100%;height: 80%;">
    <!-- Left side -->
    <div id="parent_examinations_tab" style="position: relative;left: 50px;background-color: #343A40;width:40%;border-radius: 5px;padding: 20px;height: 100%;display: inline-block;">
        <div id="parent_examinations_wrapper" style="position: relative;overflow-y: scroll;max-height: 100%;">
            <?php
                if($prepare_stmt_result->num_rows == 0) echo "<h4 id='no_parent_examinations_nodes' style='color:white;'>No results had been found.</h4>";
                else { ?>
                            <div id="parent_examinations_tab_columns" style="font-weight: bold;color: white;margin-bottom: 30px;padding: 5px;">
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
                } ?>
        </div>

        <!-- Add or remove parent research node-->
        <div class="form-group" style="display: flex;">
            <div class="button_add_parent">
                <i class="fas fa-plus-circle"></i>
            </div>
            <div class="button_remove_parent">
                <i class="fas fa-minus-circle"></i>
            </div>
        </div>
    </div>

    <!-- Right side -->
    <div style="position: relative;float:right;right: 50px;background-color: #343A40;width:40%;border-radius: 5px;padding: 20px;height: 100%;display: inline-block;" id="research_children_wrapper">

    </div>

    <div style="text-align:center;">
        <button type="button" id="save_examinations" class="btn btn-primary">Save</button>
        </div>
</div>






