<div class="toast <?php if (isset($active_class)) echo $active_class; ?>">
    <span class="icon-cancel"></span>
    <?php
        if(isset($status_message)) echo $status_message;
    ?>
</div>