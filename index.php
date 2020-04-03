<?php
include_once('inc/header.php');
include_once('inc/Class.Problem.php');

$problem = new Problem();

$all_problems = $problem->get_all_problems();
$problem_count = $all_problems->num_rows;

?>

<div class="container">
    <div class="all-problems-section white-bg shadow-bg br-10">
        <h1 class="center-align">All Problems</h1>
        <div class="section-content">
            <?php if ($problem_count > 0): ?>
                <table class="problems-table">
                    <thead>
                        <tr>
                            <th>Problem Title</th>
                            <th>Difficulty</th>
                            <th>Submissions</th>
                            <th>Acceptance Rate</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        foreach($all_problems as $single_problem) {
                            if ($single_problem['solve_count'] == 0) {
                                $acceptance_rate = 0;
                            } else {
                                $acceptance_rate = ceil(($single_problem['solve_count']/$single_problem['submission_count'])*100);
                            }

                            $difficulty_array = ["", "Basic", "Easy", "Advanced", "Hard", "Expert"];
                            
                            echo "<tr>";
                            echo "<td><a href=\"problem.php?prob_id=". $single_problem['prob_id'] ."\">". $single_problem['prob_title'] ."</a></td>";
                            echo "<td><span class=\"problem-difficulty\">". $difficulty_array[$single_problem['difficulty']] ."</span></td>";
                            echo "<td>". $single_problem['submission_count'] ."</td>";
                            echo "<td>";
                            echo "<span class=\"problem-success-bar\"><i data-percentage=\"". $acceptance_rate ."\"></i></span>";
                            echo "<span class=\"problem-success-percent\">". $acceptance_rate ."%</span>";
                            echo "</td>";
                            echo "</tr>";
                        }
                        
                        ?>
                        
                        
                    </tbody>
                </table>
            <?php else: echo "<h3 class=\"empty-msg\">0 problems found!</h3>"; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
        
<?php include('inc/footer.php'); ?>
