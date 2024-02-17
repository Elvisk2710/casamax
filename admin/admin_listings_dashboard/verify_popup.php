<div class="verify_pop_up" id="verify_pop_up">
    <form action="../../homerunphp/admin_verification_script.php" method="post" class="pop_up_verify">
        <h2>
            Are You Sure You Want To Verify 
        </h2>
        <br>
        <input type="text" name="home_id" value="<?php echo $row['home_id'] ?>" id="" class="verify_id" readonly>
        <br>
        <div class="verify_div">
            <button class="action_button" type="submit" >
                Verify
            </button>
            <button class="view_button" onclick="closeVerify()" type="button">
                Close
            </button>
    </div>
    </form>
</div>
