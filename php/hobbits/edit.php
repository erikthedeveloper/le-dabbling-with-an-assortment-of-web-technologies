<?php
require_once '../bootstrap.php';

if (!isset($_GET['id']) && !isset($_POST['id'])) {
  throw new Exception("ID Required!", 1);
}
$user_id = $_GET['id'];
$statement = $DB->retrieveStatement("SELECT * FROM people WHERE id = ?", [$user_id]);
$person    = $statement->fetch();
if (!$person) {
  throw new Exception("No person exists!", 1);
}

/**
 * Validate, Update, etc...
 */
$message = null;
if ($_POST) {
  // Validate...
  $new_data = [
    'id'         => $user_id,
    'first_name' => $_POST['first_name'],
    'last_name'  => $_POST['last_name']
  ];
  // Update...
  $sql = "UPDATE people
    SET first_name = :first_name, last_name = :last_name
    WHERE id = :id";
  $success = $DB->executeStatement($sql, $new_data);
  if ($success) {
    $message   = "Success! You updated something!";
    $statement = $DB->retrieveStatement("SELECT * FROM people WHERE id = ?", [$user_id]);
    $person    = $statement->fetch();
  } else {
    $message = "Ruh Roh! Database thing failed!";
  }
}
?>
<?= partial("header") ?>

<div class="container">
  <h1>Edit <?= sprintf("%s %s", $person->first_name, $person->last_name) ?> <small>GET hobbits.edit - POST hobbits.update</small></h1>

  <div class="jumbotron">
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem repellat esse magni quasi nulla tenetur aliquid rerum nam?</p>
    <?php if ($message): ?>
      <p class="alert alert-success">
        <?= $message ?>
      </p>
    <?php endif ?>
    <form class="form" method="POST">
      <div class="form-group">
        <input type="text" name="first_name" class="form-control input-lg" placeholder="First Name" value="<?= $person->first_name ?>">
      </div>
      <div class="form-group">
        <input type="text" name="last_name" class="form-control input-lg" placeholder="Last Name" value="<?= $person->last_name ?>">
      </div>
      <div class="form-group">
        <button class="btn btn-lg btn-primary">Update</button>
      </div>
    </form>

    <form action="destroy.php" method="POST">
      <input type="hidden" name="id" value="<?= $person->id; ?>">
      <button class="btn btn-sm btn-danger">Destroy</button>
    </form>
  </div>
</div>

<?= partial("footer") ?>