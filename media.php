<?php
include_once "includes/functions.php";

$id = $_GET['id'] ?? '';

if (!loggedIn() || ($id != $_SESSION['id'] && !isAdmin())) {
    redirectTo("page_login.php");
}

$user = getUserById($id);

include_once "templates/header.php";
?>
<main id="js-page-content" role="main" class="page-content mt-3">
  <div class="subheader">
    <h1 class="subheader-title">
      <i class='subheader-icon fal fa-image'></i> Загрузить аватар
    </h1>

  </div>
  <form action="includes/upload_avatar.php" method="post" enctype="multipart/form-data">
    <div class="row">
      <div class="col-xl-6">
        <div id="panel-1" class="panel">
          <div class="panel-container">
            <div class="panel-hdr">
              <h2>Текущий аватар</h2>
            </div>
            <div class="panel-content">
              <div class="form-group">
                <img src="<?=$user['avatar'] ?? 'img/demo/avatars/avatar-m.png'?>" alt="" class="img-responsive" width="200">
              </div>
              <?php if (isset($_SESSION['fileError']) && !empty($_SESSION['fileError']) ) { ?>
                <div class="alert alert-danger">
                    <?php displayFlashMessage('fileError')?>
                </div>
              <?php } ?>
              <div class="form-group">
                <label class="form-label" for="example-fileinput">Выберите аватар</label>
                <input type="file" id="example-fileinput" class="form-control-file" name="avatar">
              </div>
              <input type="hidden" name="id" value="<?=$_GET['id'] ?? ''?>">
              <input type="hidden" name="old_avatar" value="<?=$user['avatar'] ?? '' ?>" >

              <div class="col-md-12 mt-3 d-flex flex-row-reverse">
                <button class="btn btn-warning">Загрузить</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</main>

<script src="js/vendors.bundle.js"></script>
<script src="js/app.bundle.js"></script>
<script>

    $(document).ready(function () {

        $('input[type=radio][name=contactview]').change(function () {
            if (this.value == 'grid') {
                $('#js-contacts .card').removeClassPrefix('mb-').addClass('mb-g');
                $('#js-contacts .col-xl-12').removeClassPrefix('col-xl-').addClass('col-xl-4');
                $('#js-contacts .js-expand-btn').addClass('d-none');
                $('#js-contacts .card-body + .card-body').addClass('show');

            } else if (this.value == 'table') {
                $('#js-contacts .card').removeClassPrefix('mb-').addClass('mb-1');
                $('#js-contacts .col-xl-4').removeClassPrefix('col-xl-').addClass('col-xl-12');
                $('#js-contacts .js-expand-btn').removeClass('d-none');
                $('#js-contacts .card-body + .card-body').removeClass('show');
            }

        });

        //initialize filter
        initApp.listFilter($('#js-contacts'), $('#js-filter-contacts'));
    });

</script>
</body>
</html>