<?php
include_once('inc/header.php');
include_once('inc/Class.Problem.php');
include_once('inc/Class.User.php');

$problem = new Problem();
$user = new User();
$active_class = "";


if ($user->get_session()) {
    $user_id = $_SESSION['user_id'];
    $user_data = $user->get_user_data($user_id);
    if ($user_data['user_level'] == "problem_solver" || $user_data['user_level'] == "problem_setter_pending") {
        header("location: index.php");
    }
} else {
    header("location: login.php");
}

if (isset($_POST["ap-submit-btn"])) {
    $prob_title = trim($_POST["ap-prob-title"]);
    $prob_setter_id = $user_data['user_id'];
    $prob_statement = trim($_POST["ap-prob-statement"]);
    $input_format = trim($_POST["ap-input-format"]);
    $output_format = trim($_POST["ap-output-format"]);
    $sample_input = trim($_POST["ap-sample-input"]);
    $sample_output = trim($_POST["ap-sample-output"]);
    $prob_input = $_POST["ap-prob-input"];
    $prob_output = $_POST["ap-prob-output"];
    $difficulty = trim($_POST["ap-difficulty"]);

    $add_result = $problem->add_problem($prob_setter_id, $prob_title, $prob_statement, $input_format, $output_format,
                                        $sample_input, $sample_output, $prob_input, $prob_output, $difficulty);
    if ($add_result) {
        $active_class = "active";
        $status_message = "Problem Added";
    } else {
        $active_class = "active";
        $status_message = "Error Adding Problem";
    }
}

include_once('inc/toast.php');

?>

<div class="container">
    <div class="add-problem-section white-bg shadow-bg br-10">
        <h1>Add a Problem</h1>
        <div class="section-content">
            <form id="add-problem-form" class="add-problem-form" action="add-problem.php" method="post" autocomplete="off" onsubmit="return addProblemValidation()">
                <div>
                    <p>Problem Title</p>
                    <input id="ap-prob-title" type="text" name="ap-prob-title">
                    <span id="ap-prob-title-error"></span>
                </div>

                <div>
                    <p>Difficulty</p>
                    <select id="ap-difficulty" name="ap-difficulty">
                        <option value="1" selected="selected">Basic</option>
                        <option value="2">Easy</option>
                        <option value="3">Advanced</option>
                        <option value="4">Hard</option>
                        <option value="5">Expert</option>
                    </select>
                </div>

                <div>
                    <p>Problem Statement</p>
                    <textarea id="ap-prob-statement" type="text" name="ap-prob-statement"></textarea>
                    <span id="ap-prob-statement-error"></span>
                </div>

                <div>
                    <p>Input Format</p>
                    <textarea id="ap-input-format" type="text" name="ap-input-format"></textarea>
                    <span id="ap-input-format-error"></span>
                </div>

                <div>
                    <p>Output Format</p>
                    <textarea id="ap-output-format" type="text" name="ap-output-format"></textarea>
                    <span id="ap-output-format-error"></span>
                </div>

                <div>
                    <p>Sample Input</p>
                    <textarea id="ap-sample-input" type="text" name="ap-sample-input"></textarea>
                    <span id="ap-sample-input-error"></span>
                </div>

                <div>
                    <p>Sample Output</p>
                    <textarea id="ap-sample-output" type="text" name="ap-sample-output"></textarea>
                    <span id="ap-sample-output-error"></span>
                </div>

                <div>
                    <p>Problem Input</p>
                    <textarea id="ap-prob-input" type="text" name="ap-prob-input"></textarea>
                    <span id="ap-prob-input-error"></span>
                </div>

                <div>
                    <p>Problem Output</p>
                    <textarea id="ap-prob-output" type="text" name="ap-prob-output"></textarea>
                    <span id="ap-prob-output-error"></span>
                </div>

                <input class="btn btn-lg" type="submit" name="ap-submit-btn" value="Add Problem">
            </form>
        </div>
    </div>
</div>

<?php include('inc/footer.php'); ?>
