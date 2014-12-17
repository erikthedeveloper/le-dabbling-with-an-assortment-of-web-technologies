<?php
require_once '../bootstrap.php';
if (!isset($_GET['id'])) {
    throw new Exception("ID Required!", 1);
}
$user_id   = $_GET['id'];
$statement = $DB->retrieveStatement("SELECT * FROM people WHERE id = ?", [$user_id]);
$person    = $statement->fetch();
if (!$person) {
    throw new Exception("No person exists!", 1);
}
?>
<?= partial("header") ?>

<?php
// If hobbit doesn't exist, redirect to hobbits.index
?>

    <div class="container">
        <h1><?= sprintf("%s %s", $person->first_name, $person->last_name) ?>
            <small>GET hobbits.show</small>
        </h1>

        <div class="jumbotron">
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem repellat esse magni quasi nulla tenetur aliquid rerum nam?</p>
            <a href="<?= sprintf("/hobbits/edit.php?id=%d", $person->id) ?>" class="btn btn-md btn-info">Edit</a>
        </div>
    </div>

<?= partial("footer") ?>