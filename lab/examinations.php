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

                $parent_iterator = new MultipleIterator;
                $parent_iterator->attachIterator(new ArrayIterator($names));
                $parent_iterator->attachIterator(new ArrayIterator($dates));

                $sql = "INSERT INTO research_parents (name, date, patient_id) VALUES (?, ?, ?)";
                $stmt = $connect->prepare($sql);

                foreach ($parent_iterator as $values) {
                    $stmt->bind_param("ssd", $values[0], $values[1], $patient_id);
                    $stmt->execute();
                }
            }

            if(isset($_POST['children_name']))
            {
                $children_names = $_POST['children_name'];
                $children_results = $_POST['result'];
                $children_units = $_POST['units'];
                $children_reference_values = $_POST['reference_value'];
                $parent_id = $_POST['research_parent_id'];

                $child_iterator = new MultipleIterator;
                $child_iterator->attachIterator(new ArrayIterator($children_names));
                $child_iterator->attachIterator(new ArrayIterator($children_results));
                $child_iterator->attachIterator(new ArrayIterator($children_units));
                $child_iterator->attachIterator(new ArrayIterator($children_reference_values));

                $sql = "INSERT INTO research_children (name, research_parent_id, result, units, reference_value) VALUES (?, ?, ?, ?, ?)";
                $stmt = $connect->prepare($sql);

                foreach ($child_iterator as $values) {
                    $stmt->bind_param("sdsss", $values[0], $parent_id, $values[1], $values[2], $values[3]);
                    $stmt->execute();
                }
            }

            header("Location: " . $_SERVER['HTTP_REFERER']);
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
    <link rel="stylesheet" href="static/css/examinations.css">
    <script src="static/js/examinations.js"></script>
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
    <button class="btn btn-dark"><a href="employee.php" class="text-light">Go back</a></button>
    <form method="post" style="all: unset;">
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
    </form>
</div>






