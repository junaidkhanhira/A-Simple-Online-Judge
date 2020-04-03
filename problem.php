<?php
include_once('inc/header.php');
include_once('inc/Class.Problem.php');
include_once('inc/Class.User.php');

$problem = new Problem();
$user = new User();

if (isset($_GET["prob_id"])) {
    $problemData = $problem->get_problem($_GET["prob_id"]);
} else {
    header("location: index.php");
}

if ($user->get_session()) {
    $user_id = $_SESSION['user_id'];
    $logged_in = true;
} else {
    $logged_in = false;
}

?>

<div class="container">
    <div class="single-problem-section white-bg shadow-bg">
        <div class="problem-header">
            <h2 class="problem-title"><?php echo nl2br($problemData["prob_title"]); ?></h2>
        </div>
        <div class="problem-detail">
            <div class="problem-statement">
                <h2>Problem Statement</h2>
                <p>
                    <?php echo nl2br($problemData["prob_statement"]); ?>
                </p>
            </div>
            <div class="problem-input-format">
                <h2>Input Format</h2>
                <p>
                    <?php echo nl2br($problemData["input_format"]); ?>
                </p>
            </div>
            <div class="problem-output-format">
                <h2>Output Format</h2>
                <p>
                    <?php echo nl2br($problemData["output_format"]); ?>
                </p>
            </div>
            <div class="problem-sample-input">
                <h2>Sample Input</h2>
                <p>
                    <?php echo nl2br($problemData["sample_input"]); ?>
                </p>
            </div>
            <div class="problem-sample-output">
                <h2>Sample Output</h2>
                <p>
                    <?php echo nl2br($problemData["sample_output"]); ?>
                </p>
            </div>
        </div>

        <?php if ($logged_in): ?>
            <div class="problem-solution-submit">
                <form id="code-submit" action="submit.php?prob_id=<?php echo $problemData["prob_id"]; ?>" method="post">
                    <h3 class="section-msg">Submit Your Solution</h3>
                    <textarea name="problem_solution" id="problem_solution" placeholder="Paste Your Code..." required></textarea>
                    <input class="btn btn-large" type="submit" value="Submit">
                </form>
            </div>
        <?php else: ?>
            <div class="problem-solution-submit">
                <a class="btn btn-lg" href="login.php" style="display:inline-block;">Login To Submit Solution</a>
            </div>
        <?php endif; ?>
        
    </div>
</div>
        
<?php include('inc/footer.php'); ?>
