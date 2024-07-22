<div class="verify_pop_up" id="verify_pop_up">
    <form action="../../homerunphp/admin_verification_script.php" method="post" class="pop_up_verify">
        <h2>
            Are You Sure You Want To Verify
        </h2>
        <br>
        <?php if (isset($_SESSION['table']) && $_SESSION['table'] == 'house') { ?>
            <input type="text" name="home_id" value="<?php echo $row['home_id'] ?>" id="" class="verify_id" readonly>
        <?php } elseif (isset($_SESSION['table']) && $_SESSION['table'] == 'agent') { ?>
            <input type="text" name="agent_id" value="<?php echo $row['agent_id'] ?>" id="" class="verify_id" readonly>
        <?php } else {
            redirect('./index.php?error=Failed To Get ID');
        } ?>
        <br>
        <div class="verify_div">
            <button class="action_button" type="submit">
                Verify
            </button>
            <button class="view_button" onclick="closeVerify()" type="button">
                Close
            </button>
        </div>
    </form>
</div>