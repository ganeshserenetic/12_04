<h6>welcome dashbord <?php echo $_SESSION['user']; ?>
</h6>
<div id="logout" style="
    display: flex;
    align-content: flex-start;
    justify-content: flex-end" ;>
  <!-- <button >logout</button> -->

  <a href="logout.php" class="btn btn-primary">Logout</a>

</div>
<?php

if ($paginate->success == true) {
  $fetch_rows = $paginate->resultset->fetchAll();
  $total_rows = count($fetch_rows);

  // print_r('sdhflkju'. $total_rows .'jdlkj');
  // print_r('this   '. $total_rows .'coutn');
  // exit;
}

?>

<?php if ($is_ajaxed) { ?>
  <!-- page number select -->
  <?php if ($total_rows > 0) { ?>
    
    <div class="recorde_perpage">
      <div class="form-inline">
        <div class="form-group mr-2" id="DataTables_Table_0_length">
          <label for="user_type">Records Per Page </label>
        </div>
        <div class="form-group">
          <select size="1" id="pages" name="pages" onchange="$('#per_pages').val(this.value);
      ajax_submit();" class="form-control">
            <option value="10" <?php echo $_GET['pages'] == 10 ? 'selected' : ''; ?>>10</option>
            <option value="25" <?php echo $_GET['pages'] == 25 || $_GET['pages'] == "" ? 'selected' : ''; ?>>25</option>
            <option value="50" <?php echo $_GET['pages'] == 50 ? 'selected' : ''; ?>>50</option>
            <option value="100" <?php echo $_GET['pages'] == 100 ? 'selected' : ''; ?>>100</option>
          </select>
        </div>
      </div>
    </div>
  <?php } ?>

  <!-- serach -->
  <div class="input-group rounded" style="    max-width: 25%;">
    <input type="search" class="form-control rounded" name="search" id="search" value="<?php echo $searchkey; ?>" placeholder="Search" aria-label="Search"
      aria-describedby="search-addon" />
      <button type="button" id="search_button"">serach</button>

  </div>
  <div class="table-responsive">
    <table class="<?= $table_class ?>">
      <thead class="thead-dark">
        <tr class="data-head">
          <th scope="col">id</th>
          <th scope="col">firstname</th>
          <th scope="col">lastname</th>
          <th scope="col">email</th>
          <th scope="col">gender</th>
          <th scope="col">phonenumber</th>
          <th colspan="2">Action</th>
        </tr>
      </thead>
      <tbody>


        <?php if ($total_rows > 0) { 
          
          
          ?>

          <?php foreach ($fetch_rows as $data): ?>
            <tr>
              <th scope="row"><?php echo $data['id']; ?></th>
              <td><?php echo $data['firstname']; ?></td>
              <td><?php echo $data['lastname']; ?></td>
              <td><?php echo $data['email']; ?></td>
              <td><?php echo $data['gender']; ?></td>
              <td><?php echo $data['phonenumber']; ?></td>
              <td><a href="edit.php?id=<?php echo $data['id']; ?>" class="btn btn-info"><i class="material-icons"
                    data-toggle="tooltip" title="Edit">&#xE254;</i></a></td>


              <td><a href="#deleteEmployeeModal" class="delete btn btn-danger" data-toggle="modal" data-id=<?php echo $data['id']; ?>><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a></a></td>
            </tr>
          <?php endforeach; ?>

        <?php } else { ?>
          <tr>
            <td colspan="7" class="text-center">No record(s) found</td>
          </tr>
        <?php } ?>

      </tbody>
      <?php if ($total_rows > 0) { ?>
        <tfoot>
          <tr>
            <td colspan="7">
              <?php echo $paginate->links_html; ?>

            </td>
          </tr>
        </tfoot>
      <?php } ?>
    </table>
  </div>
<?php } else { ?>

  <div class="card card-search">
    <div class="card-left">
      <form id="frm_search" action="home.php" method="GET" class="">
        <!-- <ul>
      <li><a href="javascript:void(0)" class="search-btn show"><i class="bx bx-search"></i></a></li>
    </ul> -->
        <input type="text" name="search" id="searchkey" placeholder="serach"  value="<?=$searchkey?>">
        <input type="hidden" name="is_ajaxed" id="is_ajaxed" value="1" />
        <input type="hidden" name="pages" id="per_pages" value="<?= $per_page; ?>" />
      </form>
    </div>
  </div>
  <div class="card list-data">
    <div class="card-body">
      <div id="ajax_loader" class="ajex_loader" style="display: none;">
        <div class="loader"></div>
      </div>
      <div id="ajax_data">
      </div>
    </div>
  </div>



  <script type="text/javascript">
    $(document).ready(function () {

      $('.list-data').css('display', 'none');

      $(document).off('click', '#ajax_data ul.pagination li a');
      $(document).on('click', '#ajax_data ul.pagination li a', function (e) {
        e.preventDefault();
        $('#ajax_loader').show();
        $('#ajax_data').hide();
        $.ajax({
          url: $(this).attr('href'),
          type: 'GET',
          success: function (res) {
            $('#ajax_loader').hide();
            $('#ajax_data').html(res).show();
          }
        });
      });



      $(document).off('click', '#ajax_data ul.pagination li a');
		$(document).on('click', '#ajax_data ul.pagination li a', function(e) {
			e.preventDefault();
			$('#ajax_loader').show();
			$('#ajax_data').hide();
			$.ajax({
				url: $(this).attr('href'),
				type: 'GET',
				success: function(res) {
					$('#ajax_loader').hide();
					$('#ajax_data').html(res).show();
				}
			});
		});



      ajax_submit();
    });

    $(document).keypress(function (e) {
      if (e.which == 13) {
        ajax_submit();
      }
    });
    function export_data(type) {
      $("input#export").val(type);
      $('input#is_ajaxed').val('');
      $('#frm_search').submit();
    }

    $(document).on("change", "#pages", function () {
      $("#per_pages").val($(this).val());
      console.log( $("#per_pages").val());
      ajax_submit();
    });
    $(document).on("click", "#search_button", function () {
      
      var searchQuery = $("#search").val(); // Get the search query
        $("#searchkey").val(searchQuery); // 
      // console.log( $("#searchkey").val());
      ajax_submit();
    });
 
 
    function ajax_submit() {
      $('.list-data').css('display', 'block');
      // $("#export").val('');
      $('#ajax_loader').show();
      $('#ajax_data').hide();
      $('input#is_ajaxed').val('1');
      $data = $('#frm_search').serialize();
      $data += "&pages=" + $("#per_pages").val();
      
      console.log($data);
      $.ajax({
        url: $('#frm_search').attr('action'),
        type: 'GET',
        data: $data,
        success: function (res) {
          $('#ajax_loader').hide();
          $('#ajax_data').html(res).show();
          // $('[data-toggle="tooltip"]').tooltip();
        }
      });
      return false;
    }

  </script>


<?php } ?>







<!-- Delete Modal HTML -->
<div id="deleteEmployeeModal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="deleteForm" action="delete.php" method="post">
        <div class="modal-header">
          <h4 class="modal-title">Delete Company</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to delete this record?</p>
          <p class="text-warning"><small>This action cannot be undone.</small></p>
          <!-- Hidden input field to store the ID of the record -->
          <input type="hidden" name="id" id="deleteId">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <!-- Delete button within the form -->
          <button type="submit" class="btn btn-danger">Delete</button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- show toastr massage use -->

<script>
  // Check if there's a success message stored in sessionStorage
  var successMessage = sessionStorage.getItem('successMessage');
  if (successMessage) {
    // Display the success message using Toastr
    toastr.success(successMessage);

    // Clear the stored success message from sessionStorage
    sessionStorage.removeItem('successMessage');
  }
</script>

<!-- use for delete data -->
<script>

  $(document).ready(function () {
    $('.delete').click(function () {
      var deleteid = $(this).data('id');
      // Set the value of deleteId input field in the modal
      $('#deleteId').val(deleteid);
      // Show the modal
      $('#deleteEmployeeModal').modal('show');
    });

    // AJAX form submission
    $('#deleteForm').submit(function (e) {
      e.preventDefault(); // Prevent default form submission
      var data = $(this).serialize();

      $.ajax({
        type: 'POST',
        url: 'ajax_delete.php',
        data: data, // Use the serialized form data
        dataType: 'json',
        cache: false,
        success: function (dataResult) {
          if (dataResult && dataResult.statusCode == 200) {
            sessionStorage.setItem('successMessage', dataResult.message);
            // Clear form fields
            window.location.reload();
          } else {
            $('.error-message').text('');
            $.each(dataResult, function (fieldName, errorMessage) {
              var errorElement = $('#' + fieldName + '-error');
              if (errorElement.length) {
                errorElement.text(errorMessage);
              }
            });
          }
        },
        error: function (xhr, status, error) {
          console.error(xhr.responseText);
          if (xhr.status === 400) {
            var errorMessage = JSON.parse(xhr.responseText);
            alert("Bad Request: " + errorMessage[0]);
          } else {
            toastr.error(error);
            console.error("An error occurred: ", error);
          }
        }
      });
    });
  });
</script>