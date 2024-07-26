<?php
echo '<div class="pagination">';

$total_pages = ceil($total_records / $num_per_page);

if ($page > 1) {
    echo "<a href='" . $page_name . "?page=" . ($page - 1) . $filter_url . "'>Prev</a>";
}

$before_pages = $page - 1;
$after_pages = $page + 1;

if ($page > 3) {
    echo "<a href='" . $page_name . "?page=1" . $filter_url . "'>1</a>";
    echo '<a href="">...</a>';
}

if ($page == $total_pages && $total_pages > 1) {
    $before_pages = $page - 2;
} elseif ($page == $total_pages - 1 && $total_pages > 1) {
    $before_pages = $page - 1;
}

if ($page == 1) {
    $after_pages = $page + 2;
} elseif ($page == 2) {
    $after_pages = $page + 1;
}

for ($i = $before_pages; $i <= $after_pages; $i++) {
    if ($i > $total_pages || $i <= 0) {
        continue;
    }
    if ($i == $page) {
        echo '<a class="active">' . $i . '</a>';
    } else {
        echo "<a href='" . $page_name . "?page=" . $i . $filter_url . "'>$i</a>";
    }
}

if ($page < $total_pages - 1) {
    if ($page < $total_pages - 2) {
        echo '<a href="">...</a>';
    }
    if ($total_pages > 3) {
        echo "<a href='" . $page_name . "?page=" . $total_pages . $filter_url . "'>$total_pages</a>";
    }
}

if ($page < $total_pages) {
    echo "<a href='" . $page_name . "?page=" . ($page + 1) . $filter_url . "'>Next</a>";
}

echo "</div>";
?>
