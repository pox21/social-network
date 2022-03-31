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
      <i class='subheader-icon fal fa-lock'></i> Безопасность
    </h1>
  </div>
  <?php if (isset($_SESSION['passError']) && !empty($_SESSION['passError']) ) { ?>
    <div class="alert alert-danger col-xl-6">
        <?php displayFlashMessage('passError') ?>
    </div>
  <?php } ?>
  <?php if (isset($_SESSION['emailError']) && !empty($_SESSION['emailError']) ) { ?>
    <div class="alert alert-danger col-xl-6">
        <?php displayFlashMessage('emailError') ?>
    </div>
  <?php } ?>
  <form action="includes/edit_user.php" method="post">
    <div class="row">
      <div class="col-xl-6">
        <div id="panel-1" class="panel">
          <div class="panel-container">
            <div class="panel-hdr">
              <h2>Обновление эл. адреса и пароля</h2>
            </div>
            <div class="panel-content">
              <!-- id -->
              <input type="hidden" name="id" value="<?=$_GET['id'] ?? ''?>">
              <!-- email -->
              <div class="form-group">
                <label class="form-label" for="simpleinput">Email</label>
                <input type="text" id="simpleinput" class="form-control" value="<?=$user['email']?>" name="email">
              </div>

              <!-- password -->
              <div class="form-group">
                <label class="form-label" for="simpleinput">Пароль</label>
                <input type="password" id="simpleinput" class="form-control" name="pass">
              </div>

              <!-- password confirmation-->
              <div class="form-group">
                <label class="form-label" for="simpleinput">Подтверждение пароля</label>
                <input type="password" id="simpleinput" class="form-control" name="pass2">
              </div>


              <div class="col-md-12 mt-3 d-flex flex-row-reverse">
                <button class="btn btn-warning">Изменить</button>
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