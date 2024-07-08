<?php

include '../required/alerts.php';
while ($row = mysqli_fetch_array($result)) {
?>
    <tr>
        <td>
            <?php
            if (isset($row['home_id'])) {
                echo $row['home_id'];
            } elseif (isset($row['agent_id'])) {
                echo $row['agent_id'];
            }
            ?>
        </td>
        <td>
            <?php echo $row['email'] ?>
        </td>
        <td>
            <?php echo $row['firstname'] ?>
        </td>
        <td>
            <?php echo $row['lastname'] ?>

        </td>
        <td>
            <?php echo $row['contact'] ?>

        </td>
        <td>
            <?php
            if (isset($row['idnum'])) {
                echo $row['idnum'];
            } elseif (isset($row['id_num'])) {
                echo $row['id_num'];
            }
            ?>
        </td>
        <td>
            <?php
            if (isset($row['adrs'])) {
                echo $row['adrs'];
            } else {
                echo '---';
            }
            ?>

        </td>
        <td>
            <?php
            if ($row['verified'] == 1) {
                echo '<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="checkmark" viewBox="0 0 16 16">
            <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>
            <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>
        </svg>';
            } else {
                echo '<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="crossmark" viewBox="0 0 16 16">
                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
            </svg>';
            }
            ?>
        </td>
        <?php
        if ($_SESSION['access'] == 1 || $_SESSION['access'] == 2) {
        ?>
            <td class="button_holder">
                <a href="../admin_listings_dashboard/view_details.php?<?php
                                                                        if (isset($row['home_id'])) {
                                                                            echo 'AdminHomeID=' . $row['home_id'];
                                                                        } elseif ($row['agent_id']) {
                                                                            echo 'AdminAgentID=' . $row['agent_id'];
                                                                        }
                                                                        ?>&verified=<?php echo $row['verified'] ?>" class="">
                    <button class="view_button">
                        View Documents
                    </button>
                </a>
            </td>
        <?php
        }
        ?>
    </tr>
<?php
}
?>