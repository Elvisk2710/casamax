<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Listings</title>
    <link rel="icon" href="../../images/logowhite.png">
    <link rel="stylesheet" href="./admin_listings_dashboard.css">
</head>
<body>
    <div class="container">
    <?php
        include '../components/admin_navbar.php';
        include './view_details.php';
        include './verify_popup.php';

    ?>
    <div class="right_col">
        <div class="left_col_top">
            <div class="left_col_top_left">
                <div class="left_col_top_left_details">
                <h2>
                    Casamax Agent Id
                </h2>
                <h2>
                    CM12345
                </h2>
                </div>
                <div class="left_col_top_left_details">
                <h2>
                    Total Listings
                </h2>
                <h2>
                    13
                </h2>
                </div>
                <div class="left_col_top_left_details">
                <h2>
                    Unverified Listings
                </h2>
                <h2>
                    8
                </h2>
                </div>
               
            </div>
            <div class="left_col_top_right">
                <div class="amount_earned">
                    <h2>
                        Amount Earned: $14
                    </h2>
                </div>
                <div class="select_view">
                <h2>
                    Select View
                </h2>
                <select name="listings_name" id="listings_name">
                    <option value="all">All</option>
                    <option value="notverified">Not-verified</option>
                    <option value="verified">Verified</option>
                </select>
                </div>
              
            </div>
        </div>
        <hr>
        <div class="right_col_bottom">
            <table>
                <tr>
                    <th>
                        Home ID
                    </th>
                    <th>
                        Email
                    </th>
                    <th>
                        Firstname
                    </th>
                    <th>
                       Lastname
                    </th>
                    <th>
                        Contact
                    </th>
                    <th>
                        ID Number
                    </th>
                    <th>
                        Address
                    </th>
                    <th>
                        Verified
                    </th>
                    <th>
                        Action
                    </th>
                </tr>
                <tbody>
                <tr>
                    <td>
                    7260_$2y$10$goO_1
                    </td>
                    <td>
                    Kadeyaelvis@gmail.com
                    </td>
                    <td>
                    Elvis
                    </td>
                    <td>
                       Kadeya
                    </td>
                    <td>
                    786989144
                    </td>
                    <td>
                    5050505050Ehh
                    </td>
                    <td>
                    28 Alfred Florida Mutare
                    </td>
                    <td>
                       Not-verified
                    </td>
                    <td class="button_holder">
                        <button  class="action_button" onclick="openVerify()">
                            Verify
                        </button>
                          <button class="view_button" onclick="openDocs()">
                            View Documents
                        </button>
                    </td>
                </tr>
                <tr>
                    <td>
                    7260_$2y$10$goO_1
                    </td>
                    <td>
                    Kadeyaelvis@gmail.com
                    </td>
                    <td>
                    Elvis
                    </td>
                    <td>
                       Kadeya
                    </td>
                    <td>
                    786989144
                    </td>
                    <td>
                    5050505050Ehh
                    </td>
                    <td>
                    28 Alfred Florida Mutare
                    </td>
                    <td>
                       Not-verified
                    </td>
                    <td class="button_holder">
                        <button  class="action_button" onclick="openVerify()">
                            Verify
                        </button>
                          <button class="view_button" onclick="openDocs()">
                            View Documents
                        </button>
                    </td>
                </tr>
                <tr>
                    <td>
                    7260_$2y$10$goO_1
                    </td>
                    <td>
                    Kadeyaelvis@gmail.com
                    </td>
                    <td>
                    Elvis
                    </td>
                    <td>
                       Kadeya
                    </td>
                    <td>
                    786989144
                    </td>
                    <td>
                    5050505050Ehh
                    </td>
                    <td>
                    28 Alfred Florida Mutare
                    </td>
                    <td>
                       Not-verified
                    </td>
                    <td class="button_holder">
                        <button  class="action_button" onclick="openVerify()">
                            Verify
                        </button>
                          <button class="view_button" onclick="openDocs()">
                            View Documents
                        </button>
                    </td>
                </tr>
                <tr>
                    <td>
                    7260_$2y$10$goO_1
                    </td>
                    <td>
                    Kadeyaelvis@gmail.com
                    </td>
                    <td>
                    Elvis
                    </td>
                    <td>
                       Kadeya
                    </td>
                    <td>
                    786989144
                    </td>
                    <td>
                    5050505050Ehh
                    </td>
                    <td>
                    28 Alfred Florida Mutare
                    </td>
                    <td>
                       Not-verified
                    </td>
                    <td class="button_holder">
                        <button  class="action_button" onclick="openVerify()">
                            Verify
                        </button>
                          <button class="view_button" onclick="openDocs()">
                            View Documents
                        </button>
                    </td>
                </tr>
                <tr>
                    <td>
                    7260_$2y$10$goO_1
                    </td>
                    <td>
                    Kadeyaelvis@gmail.com
                    </td>
                    <td>
                    Elvis
                    </td>
                    <td>
                       Kadeya
                    </td>
                    <td>
                    786989144
                    </td>
                    <td>
                    5050505050Ehh
                    </td>
                    <td>
                    28 Alfred Florida Mutare
                    </td>
                    <td>
                       Not-verified
                    </td>
                    <td class="button_holder">
                        <button  class="action_button" onclick="openVerify()">
                            Verify
                        </button>
                          <button class="view_button" onclick="openDocs()">
                            View Documents
                        </button>
                    </td>
                </tr>
                <tr>
                    <td>
                    7260_$2y$10$goO_1
                    </td>
                    <td>
                    Kadeyaelvis@gmail.com
                    </td>
                    <td>
                    Elvis
                    </td>
                    <td>
                       Kadeya
                    </td>
                    <td>
                    786989144
                    </td>
                    <td>
                    5050505050Ehh
                    </td>
                    <td>
                    28 Alfred Florida Mutare
                    </td>
                    <td>
                       Not-verified
                    </td>
                    <td class="button_holder">
                        <button  class="action_button" onclick="openVerify()">
                            Verify
                        </button>
                          <button class="view_button" onclick="openDocs()">
                            View Documents
                        </button>
                    </td>
                </tr>
                <tr>
                    <td>
                    7260_$2y$10$goO_1
                    </td>
                    <td>
                    Kadeyaelvis@gmail.com
                    </td>
                    <td>
                    Elvis
                    </td>
                    <td>
                       Kadeya
                    </td>
                    <td>
                    786989144
                    </td>
                    <td>
                    5050505050Ehh
                    </td>
                    <td>
                    28 Alfred Florida Mutare
                    </td>
                    <td>
                       Not-verified
                    </td>
                    <td class="button_holder">
                        <button  class="action_button" onclick="openVerify()">
                            Verify
                        </button>
                          <button class="view_button" onclick="openDocs()">
                            View Documents
                        </button>
                    </td>
                </tr>
                <tr>
                    <td>
                    7260_$2y$10$goO_1
                    </td>
                    <td>
                    Kadeyaelvis@gmail.com
                    </td>
                    <td>
                    Elvis
                    </td>
                    <td>
                       Kadeya
                    </td>
                    <td>
                    786989144
                    </td>
                    <td>
                    5050505050Ehh
                    </td>
                    <td>
                    28 Alfred Florida Mutare
                    </td>
                    <td>
                       Not-verified
                    </td>
                    <td class="button_holder">
                        <button  class="action_button" onclick="openVerify()">
                            Verify
                        </button>
                          <button class="view_button" onclick="openDocs()">
                            View Documents
                        </button>
                    </td>
                </tr>
                <tr>
                    <td>
                    7260_$2y$10$goO_1
                    </td>
                    <td>
                    Kadeyaelvis@gmail.com
                    </td>
                    <td>
                    Elvis
                    </td>
                    <td>
                       Kadeya
                    </td>
                    <td>
                    786989144
                    </td>
                    <td>
                    5050505050Ehh
                    </td>
                    <td>
                    28 Alfred Florida Mutare
                    </td>
                    <td>
                       Not-verified
                    </td>
                    <td class="button_holder">
                        <button class="action_button" onclick="openVerify()">
                            Verify
                        </button>
                          <button class="view_button" onclick="openDocs()">
                            View Documents
                        </button>
                      
                    </td>
                </tr>
                <tr>
                    <td>
                    7260_$2y$10$goO_1
                    </td>
                    <td>
                    Kadeyaelvis@gmail.com
                    </td>
                    <td>
                    Elvis
                    </td>
                    <td>
                       Kadeya
                    </td>
                    <td>
                    786989144
                    </td>
                    <td>
                    5050505050Ehh
                    </td>
                    <td>
                    28 Alfred Florida Mutare
                    </td>
                    <td>
                       Not-verified
                    </td>
                    <td class="button_holder">
                        <button class="action_button" onclick="openVerify()">
                            Verify
                        </button>
                          <button class="view_button" onclick="openDocs()">
                            View Documents
                        </button>
                      
                    </td>
                </tr>
                
                <tr>
                    <td>
                    7260_$2y$10$goO_1
                    </td>
                    <td>
                    Kadeyaelvis@gmail.com
                    </td>
                    <td>
                    Elvis
                    </td>
                    <td>
                       Kadeya
                    </td>
                    <td>
                    786989144
                    </td>
                    <td>
                    5050505050Ehh
                    </td>
                    <td>
                    28 Alfred Florida Mutare
                    </td>
                    <td>
                       Not-verified
                    </td>
                    <td class="button_holder">
                        <button class="action_button" onclick="openVerify()">
                            Verify
                        </button>
                          <button class="view_button" onclick="openDocs()">
                            View Documents
                        </button>
                      
                    </td>
                </tr>
                
                <tr>
                    <td>
                    7260_$2y$10$goO_1
                    </td>
                    <td>
                    Kadeyaelvis@gmail.com
                    </td>
                    <td>
                    Elvis
                    </td>
                    <td>
                       Kadeya
                    </td>
                    <td>
                    786989144
                    </td>
                    <td>
                    5050505050Ehh
                    </td>
                    <td>
                    28 Alfred Florida Mutare
                    </td>
                    <td>
                       Not-verified
                    </td>
                    <td class="button_holder">
                        <button class="action_button" onclick="openVerify()">
                            Verify
                        </button>
                          <button class="view_button" onclick="openDocs()">
                            View Documents
                        </button>
                      
                    </td>
                </tr>
                <tr>
                    <td>
                    7260_$2y$10$goO_1
                    </td>
                    <td>
                    Kadeyaelvis@gmail.com
                    </td>
                    <td>
                    Elvis
                    </td>
                    <td>
                       Kadeya
                    </td>
                    <td>
                    786989144
                    </td>
                    <td>
                    5050505050Ehh
                    </td>
                    <td>
                    28 Alfred Florida Mutare
                    </td>
                    <td>
                       Not-verified
                    </td>
                    <td class="button_holder">
                        <button class="action_button" onclick="openVerify()">
                            Verify
                        </button>
                          <button class="view_button" onclick="openDocs()">
                            View Documents
                        </button>
                      
                    </td>
                </tr>
                
                <tr>
                    <td>
                    7260_$2y$10$goO_1
                    </td>
                    <td>
                    Kadeyaelvis@gmail.com
                    </td>
                    <td>
                    Elvis
                    </td>
                    <td>
                       Kadeya
                    </td>
                    <td>
                    786989144
                    </td>
                    <td>
                    5050505050Ehh
                    </td>
                    <td>
                    28 Alfred Florida Mutare
                    </td>
                    <td>
                       Not-verified
                    </td>
                    <td class="button_holder">
                        <button class="action_button" onclick="openVerify()">
                            Verify
                        </button>
                          <button class="view_button" onclick="openDocs()">
                            View Documents
                        </button>
                      
                    </td>
                </tr>
                
                <tr>
                    <td>
                    7260_$2y$10$goO_1
                    </td>
                    <td>
                    Kadeyaelvis@gmail.com
                    </td>
                    <td>
                    Elvis
                    </td>
                    <td>
                       Kadeya
                    </td>
                    <td>
                    786989144
                    </td>
                    <td>
                    5050505050Ehh
                    </td>
                    <td>
                    28 Alfred Florida Mutare
                    </td>
                    <td>
                       Not-verified
                    </td>
                    <td class="button_holder">
                        <button class="action_button" onclick="openVerify()">
                            Verify
                        </button>
                          <button class="view_button" onclick="openDocs()">
                            View Documents
                        </button>
                      
                    </td>
                </tr>
                
                <tr>
                    <td>
                    7260_$2y$10$goO_1
                    </td>
                    <td>
                    Kadeyaelvis@gmail.com
                    </td>
                    <td>
                    Elvis
                    </td>
                    <td>
                       Kadeya
                    </td>
                    <td>
                    786989144
                    </td>
                    <td>
                    5050505050Ehh
                    </td>
                    <td>
                    28 Alfred Florida Mutare
                    </td>
                    <td>
                       Not-verified
                    </td>
                    <td class="button_holder">
                        <button class="action_button" onclick="openVerify()">
                            Verify
                        </button>
                          <button class="view_button" onclick="openDocs()">
                            View Documents
                        </button>
                      
                    </td>
                </tr>
                <tr>
                    <td>
                    7260_$2y$10$goO_1
                    </td>
                    <td>
                    Kadeyaelvis@gmail.com
                    </td>
                    <td>
                    Elvis
                    </td>
                    <td>
                       Kadeya
                    </td>
                    <td>
                    786989144
                    </td>
                    <td>
                    5050505050Ehh
                    </td>
                    <td>
                    28 Alfred Florida Mutare
                    </td>
                    <td>
                       Not-verified
                    </td>
                    <td class="button_holder">
                        <button class="action_button" onclick="openVerify()">
                            Verify
                        </button>
                          <button class="view_button" onclick="openDocs()">
                            View Documents
                        </button>
                      
                    </td>
                </tr>
                <tr>
                    <td>
                    7260_$2y$10$goO_1
                    </td>
                    <td>
                    Kadeyaelvis@gmail.com
                    </td>
                    <td>
                    Elvis
                    </td>
                    <td>
                       Kadeya
                    </td>
                    <td>
                    786989144
                    </td>
                    <td>
                    5050505050Ehh
                    </td>
                    <td>
                    28 Alfred Florida Mutare
                    </td>
                    <td>
                       Not-verified
                    </td>
                    <td class="button_holder">
                        <button class="action_button" onclick="openVerify()">
                            Verify
                        </button>
                          <button class="view_button" onclick="openDocs()">
                            View Documents
                        </button>
                      
                    </td>
                </tr>
                <tr>
                    <td>
                    7260_$2y$10$goO_1
                    </td>
                    <td>
                    Kadeyaelvis@gmail.com
                    </td>
                    <td>
                    Elvis
                    </td>
                    <td>
                       Kadeya
                    </td>
                    <td>
                    786989144
                    </td>
                    <td>
                    5050505050Ehh
                    </td>
                    <td>
                    28 Alfred Florida Mutare
                    </td>
                    <td>
                       Not-verified
                    </td>
                    <td class="button_holder">
                        <button class="action_button" onclick="openVerify()">
                            Verify
                        </button>
                          <button class="view_button" onclick="openDocs()">
                            View Documents
                        </button>
                      
                    </td>
                </tr>
                <tr>
                    <td>
                    7260_$2y$10$goO_1
                    </td>
                    <td>
                    Kadeyaelvis@gmail.com
                    </td>
                    <td>
                    Elvis
                    </td>
                    <td>
                       Kadeya
                    </td>
                    <td>
                    786989144
                    </td>
                    <td>
                    5050505050Ehh
                    </td>
                    <td>
                    28 Alfred Florida Mutare
                    </td>
                    <td>
                       Not-verified
                    </td>
                    <td class="button_holder">
                        <button class="action_button" onclick="openVerify()">
                            Verify
                        </button>
                          <button class="view_button" onclick="openDocs()">
                            View Documents
                        </button>
                      
                    </td>
                </tr>
                <tr>
                    <td>
                    7260_$2y$10$goO_1
                    </td>
                    <td>
                    Kadeyaelvis@gmail.com
                    </td>
                    <td>
                    Elvis
                    </td>
                    <td>
                       Kadeya
                    </td>
                    <td>
                    786989144
                    </td>
                    <td>
                    5050505050Ehh
                    </td>
                    <td>
                    28 Alfred Florida Mutare
                    </td>
                    <td>
                       Not-verified
                    </td>
                    <td class="button_holder">
                        <button class="action_button" onclick="openVerify()">
                            Verify
                        </button>
                          <button class="view_button" onclick="openDocs()">
                            View Documents
                        </button>
                      
                    </td>
                </tr>
                <tr>
                    <td>
                    7260_$2y$10$goO_1
                    </td>
                    <td>
                    Kadeyaelvis@gmail.com
                    </td>
                    <td>
                    Elvis
                    </td>
                    <td>
                       Kadeya
                    </td>
                    <td>
                    786989144
                    </td>
                    <td>
                    5050505050Ehh
                    </td>
                    <td>
                    28 Alfred Florida Mutare
                    </td>
                    <td>
                       Not-verified
                    </td>
                    <td class="button_holder">
                        <button class="action_button" onclick="openVerify()">
                            Verify
                        </button>
                          <button class="view_button" onclick="openDocs()">
                            View Documents
                        </button>
                      
                    </td>
                </tr>
                <tr>
                    <td>
                    7260_$2y$10$goO_1
                    </td>
                    <td>
                    Kadeyaelvis@gmail.com
                    </td>
                    <td>
                    Elvis
                    </td>
                    <td>
                       Kadeya
                    </td>
                    <td>
                    786989144
                    </td>
                    <td>
                    5050505050Ehh
                    </td>
                    <td>
                    28 Alfred Florida Mutare
                    </td>
                    <td>
                       Not-verified
                    </td>
                    <td class="button_holder">
                        <button class="action_button" onclick="openVerify()">
                            Verify
                        </button>
                          <button class="view_button" onclick="openDocs()">
                            View Documents
                        </button>
                      
                    </td>
                </tr>
                <tr>
                    <td>
                    7260_$2y$10$goO_1
                    </td>
                    <td>
                    Kadeyaelvis@gmail.com
                    </td>
                    <td>
                    Elvis
                    </td>
                    <td>
                       Kadeya
                    </td>
                    <td>
                    786989144
                    </td>
                    <td>
                    5050505050Ehh
                    </td>
                    <td>
                    28 Alfred Florida Mutare
                    </td>
                    <td>
                       Not-verified
                    </td>
                    <td class="button_holder">
                        <button class="action_button" onclick="openVerify()">
                            Verify
                        </button>
                          <button class="view_button" onclick="openDocs()">
                            View Documents
                        </button>
                      
                    </td>
                </tr>
                <tr>
                    <td>
                    7260_$2y$10$goO_1
                    </td>
                    <td>
                    Kadeyaelvis@gmail.com
                    </td>
                    <td>
                    Elvis
                    </td>
                    <td>
                       Kadeya
                    </td>
                    <td>
                    786989144
                    </td>
                    <td>
                    5050505050Ehh
                    </td>
                    <td>
                    28 Alfred Florida Mutare
                    </td>
                    <td>
                       Not-verified
                    </td>
                    <td class="button_holder">
                        <button class="action_button" onclick="openVerify()">
                            Verify
                        </button>
                          <button class="view_button" onclick="openDocs()">
                            View Documents
                        </button>
                      
                    </td>
                </tr>
                <tr>
                    <td>
                    7260_$2y$10$goO_1
                    </td>
                    <td>
                    Kadeyaelvis@gmail.com
                    </td>
                    <td>
                    Elvis
                    </td>
                    <td>
                       Kadeya
                    </td>
                    <td>
                    786989144
                    </td>
                    <td>
                    5050505050Ehh
                    </td>
                    <td>
                    28 Alfred Florida Mutare
                    </td>
                    <td>
                       Not-verified
                    </td>
                    <td class="button_holder">
                        <button class="action_button" onclick="openVerify()">
                            Verify
                        </button>
                          <button class="view_button" onclick="openDocs()">
                            View Documents
                        </button>
                      
                    </td>
                </tr>
                <tr>
                    <td>
                    7260_$2y$10$goO_1
                    </td>
                    <td>
                    Kadeyaelvis@gmail.com
                    </td>
                    <td>
                    Elvis
                    </td>
                    <td>
                       Kadeya
                    </td>
                    <td>
                    786989144
                    </td>
                    <td>
                    5050505050Ehh
                    </td>
                    <td>
                    28 Alfred Florida Mutare
                    </td>
                    <td>
                       Not-verified
                    </td>
                    <td class="button_holder">
                        <button class="action_button" onclick="openVerify()">
                            Verify
                        </button>
                          <button class="view_button" onclick="openDocs()">
                            View Documents
                        </button>
                      
                    </td>
                </tr>
                <tr>
                    <td>
                    7260_$2y$10$goO_1
                    </td>
                    <td>
                    Kadeyaelvis@gmail.com
                    </td>
                    <td>
                    Elvis
                    </td>
                    <td>
                       Kadeya
                    </td>
                    <td>
                    786989144
                    </td>
                    <td>
                    5050505050Ehh
                    </td>
                    <td>
                    28 Alfred Florida Mutare
                    </td>
                    <td>
                       Not-verified
                    </td>
                    <td class="button_holder">
                        <button class="action_button" onclick="openVerify()">
                            Verify
                        </button>
                          <button class="view_button" onclick="openDocs()">
                            View Documents
                        </button>
                      
                    </td>
                </tr>
                <tr>
                    <td>
                    7260_$2y$10$goO_1
                    </td>
                    <td>
                    Kadeyaelvis@gmail.com
                    </td>
                    <td>
                    Elvis
                    </td>
                    <td>
                       Kadeya
                    </td>
                    <td>
                    786989144
                    </td>
                    <td>
                    5050505050Ehh
                    </td>
                    <td>
                    28 Alfred Florida Mutare
                    </td>
                    <td>
                       Not-verified
                    </td>
                    <td class="button_holder">
                        <button class="action_button" onclick="openVerify()">
                            Verify
                        </button>
                          <button class="view_button" onclick="openDocs()">
                            View Documents
                        </button>
                      
                    </td>
                </tr>
                <tr>
                    <td>
                    7260_$2y$10$goO_1
                    </td>
                    <td>
                    Kadeyaelvis@gmail.com
                    </td>
                    <td>
                    Elvis
                    </td>
                    <td>
                       Kadeya
                    </td>
                    <td>
                    786989144
                    </td>
                    <td>
                    5050505050Ehh
                    </td>
                    <td>
                    28 Alfred Florida Mutare
                    </td>
                    <td>
                       Not-verified
                    </td>
                    <td class="button_holder">
                        <button class="action_button" onclick="openVerify()">
                            Verify
                        </button>
                          <button class="view_button" onclick="openDocs()">
                            View Documents
                        </button>
                      
                    </td>
                </tr>
                <tr>
                    <td>
                    7260_$2y$10$goO_1
                    </td>
                    <td>
                    Kadeyaelvis@gmail.com
                    </td>
                    <td>
                    Elvis
                    </td>
                    <td>
                       Kadeya
                    </td>
                    <td>
                    786989144
                    </td>
                    <td>
                    5050505050Ehh
                    </td>
                    <td>
                    28 Alfred Florida Mutare
                    </td>
                    <td>
                       Not-verified
                    </td>
                    <td class="button_holder">
                        <button class="action_button" onclick="openVerify()">
                            Verify
                        </button>
                          <button class="view_button" onclick="openDocs()">
                            View Documents
                        </button>
                      
                    </td>
                </tr>
                <tr>
                    <td>
                    7260_$2y$10$goO_1
                    </td>
                    <td>
                    Kadeyaelvis@gmail.com
                    </td>
                    <td>
                    Elvis
                    </td>
                    <td>
                       Kadeya
                    </td>
                    <td>
                    786989144
                    </td>
                    <td>
                    5050505050Ehh
                    </td>
                    <td>
                    28 Alfred Florida Mutare
                    </td>
                    <td>
                       Not-verified
                    </td>
                    <td class="button_holder">
                        <button class="action_button" onclick="openVerify()">
                            Verify
                        </button>
                          <button class="view_button" onclick="openDocs()">
                            View Documents
                        </button>
                      
                    </td>
                </tr>
                <tr>
                    <td>
                    7260_$2y$10$goO_1
                    </td>
                    <td>
                    Kadeyaelvis@gmail.com
                    </td>
                    <td>
                    Elvis
                    </td>
                    <td>
                       Kadeya
                    </td>
                    <td>
                    786989144
                    </td>
                    <td>
                    5050505050Ehh
                    </td>
                    <td>
                    28 Alfred Florida Mutare
                    </td>
                    <td>
                       Not-verified
                    </td>
                    <td class="button_holder">
                        <button class="action_button" onclick="openVerify()">
                            Verify
                        </button>
                          <button class="view_button" onclick="openDocs()">
                            View Documents
                        </button>
                      
                    </td>
                </tr>
                <tr>
                    <td>
                    7260_$2y$10$goO_1
                    </td>
                    <td>
                    Kadeyaelvis@gmail.com
                    </td>
                    <td>
                    Elvis
                    </td>
                    <td>
                       Kadeya
                    </td>
                    <td>
                    786989144
                    </td>
                    <td>
                    5050505050Ehh
                    </td>
                    <td>
                    28 Alfred Florida Mutare
                    </td>
                    <td>
                       Not-verified
                    </td>
                    <td class="button_holder">
                        <button class="action_button" onclick="openVerify()">
                            Verify
                        </button>
                          <button class="view_button" onclick="openDocs()">
                            View Documents
                        </button>
                      
                    </td>
                </tr>
                <tr>
                    <td>
                    7260_$2y$10$goO_1
                    </td>
                    <td>
                    Kadeyaelvis@gmail.com
                    </td>
                    <td>
                    Elvis
                    </td>
                    <td>
                       Kadeya
                    </td>
                    <td>
                    786989144
                    </td>
                    <td>
                    5050505050Ehh
                    </td>
                    <td>
                    28 Alfred Florida Mutare
                    </td>
                    <td>
                       Not-verified
                    </td>
                    <td class="button_holder">
                        <button class="action_button" onclick="openVerify()">
                            Verify
                        </button>
                          <button class="view_button" onclick="openDocs()">
                            View Documents
                        </button>
                      
                    </td>
                </tr>
                <tr>
                    <td>
                    7260_$2y$10$goO_1
                    </td>
                    <td>
                    Kadeyaelvis@gmail.com
                    </td>
                    <td>
                    Elvis
                    </td>
                    <td>
                       Kadeya
                    </td>
                    <td>
                    786989144
                    </td>
                    <td>
                    5050505050Ehh
                    </td>
                    <td>
                    28 Alfred Florida Mutare
                    </td>
                    <td>
                       Not-verified
                    </td>
                    <td class="button_holder">
                        <button class="action_button" onclick="openVerify()">
                            Verify
                        </button>
                          <button class="view_button" onclick="openDocs()">
                            View Documents
                        </button>
                      
                    </td>
                </tr>
            </tbody>
            </table>
        </div>
    </div>
    </div>
    
</body>
<script src="../../jsfiles/onclickscript.js"></script>
</html>