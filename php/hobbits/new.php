<?php
require_once '../bootstrap.php';

/**
 * Validate, Update, etc...
 */
$message = null;
if ($_POST) {
  // Validate...
  $new_data = [
    'first_name' => $_POST['first_name'],
    'last_name'  => $_POST['last_name']
  ];
  // Update...
  $sql = "INSERT INTO people (first_name, last_name) VALUES (:first_name, :last_name)";
  $success = $DB->executeStatement($sql, $new_data);
  if ($success) {
    $message   = "Success! You updated something!";
    // Redirect to new user!
  } else {
    $message = "Ruh Roh! Database thing failed!";
  }
}
?>
<?= partial("header") ?>

<div class="container">
  <h1>New Hobbit <small>GET hobbits.new - POST hobbits.create</small></h1>

  <div class="jumbotron">
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem repellat esse magni quasi nulla tenetur aliquid rerum nam?</p>
    <?php if ($message): ?>
      <p class="alert alert-success">
        <?= $message ?>
      </p>
    <?php endif ?>
    <form class="form" method="POST">
      <div class="form-group">
        <input type="text" name="first_name" class="form-control input-lg" placeholder="First Name" value="<?= isset($_POST['first_name']) ? $_POST['first_name'] : '' ?>">
      </div>
      <div class="form-group">
        <input type="text" name="last_name" class="form-control input-lg" placeholder="Last Name" value="<?= isset($_POST['last_name']) ? $_POST['last_name'] : '' ?>">
      </div>
      <div class="form-group">
        <button class="btn btn-lg btn-primary">Update</button>
      </div>
    </form>
  </div>
</div>

<?= partial("footer") ?>