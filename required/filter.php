<div class="sidebar">
     <div class="close_icon" onclick="closeFilter()">
          <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="crossmark" viewBox="0 0 16 16">
               <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
          </svg>
     </div>
     <form action="<?php $page_filter_name ?>" method="get">

          <h2>Apply Filters</h2>

          <div class="filter" id="filter">
               <h3>Amenities</h3>

               <div>
                    <label for="wifi">Wifi :<input id="wifi" type="checkbox" name="wifi" value="1" <?php if (isset($_GET['wifi']) && $_GET['wifi'] = 1) {
                                                                                                         echo "checked";
                                                                                                    } ?>> </label>
               </div>
               <br>

               <div>
                    <label for="kitchen">Kitchen :<input id="kitchen" type="checkbox" name="kitchen" value="1" <?php if (isset($_GET['kitchen']) && $_GET['kitchen'] = 1) {
                                                                                                                        echo "checked";
                                                                                                                   } ?>></label>
               </div>
               <br>

               <div>
                    <label for="borehole">Borehole :<input id="borehole" type="checkbox" name="borehole" value="1" <?php if (isset($_GET['borehole']) && $_GET['borehole'] = 1) {
                                                                                                                        echo "checked";
                                                                                                                   } ?>></label>
               </div>
               <br>

               <div>
                    <label for="fridge"> Fridge :<input id="fridge" type="checkbox" name="fridge" value="1" <?php if (isset($_GET['fridge']) && $_GET['fridge'] = 1) {
                                                                                                                   echo "checked";
                                                                                                              } ?>></label>
               </div>
               <br>

               <div>
                    <label for="Transport"> Transport :<input id="Transport" type="checkbox" name="transport" value="1" <?php if (isset($_GET['transport']) && $_GET['transport'] = 1) {
                                                                                                                             echo "checked";
                                                                                                                        } ?>></label>
               </div>
               <br>

               <div>
                    <label for="girls"> Girls :<input id="girls" type="radio" name="gender" value="girls"></label>
                    <br>
                    <label for="boys"> Boys :<input id="boys" type="radio" name="gender" value="boys"></label>
                    <br>
                    <label for="mixed"> Mixed :<input id="mixed" type="radio" name="gender" value="mixed"></label>

               </div>
               <br>

          </div>

          <div class="price_filter">
               <?php
               if (isset($_GET['price'])) {
                    $price = $_GET['price'];
               } else {
                    $price = '';
               }
               ?>
               <label for="price">Budget $:</label>
               <input type="number" id="price" name="price" value="<?php echo $price ?>" placeholder="What's Your $Budget">
          </div>
          <div class="sidebar-link">
               <button name="filter">Apply Filter</button>
               <br>
          </div>
     </form>
     <form action="<?php $page_filter_name ?>" method="post">
          <div class="sidebar-link">

               <button name="filter_reset" style="background-color: rgb(8,8,12); color:rgb(252,153,82);">Reset Filter</button>
               <br>
          </div>
     </form>
</div>

<script>
     function closeFilter() {
          console.log("closeFilter() called");
          const sidebarElement = document.querySelector(".sidebar");
          if (sidebarElement) {
               sidebarElement.style.display = "none";
          } else {
               console.error("Element with class 'sidebar' not found.");
          }
     }
</script>