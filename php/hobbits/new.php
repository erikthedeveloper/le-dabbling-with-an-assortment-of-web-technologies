<?php
require_once '../bootstrap.php';

/**
 * Validate, Update, etc...
 */
$user_message = "";
if ($_POST):
    $new_data = [
        'first_name' => $_POST['first_name'],
        'last_name'  => $_POST['last_name']
    ];

    // Validate...
    $errors = [];
    if (!isset($_POST['first_name']) || strlen($_POST['first_name']) < 2)
        $errors['first_name'] = "First name must be at least 5 characters";
    if (!isset($_POST['first_name']) || strlen($_POST['last_name']) < 2)
        $errors['last_name'] = "Last name must be at least 5 characters";

    // Update...
    if (empty($errors)) {
        $sql     = "INSERT INTO people (first_name, last_name) VALUES (:first_name, :last_name)";
        $success = $DB->executeStatement($sql, $new_data);
        if ($success) {
            $user_message = "Success! You updated something!";
            $new_id = $DB->pdo->lastInsertId();
            redirect_user("/hobbits/show.php?id={$new_id}");
        } else {
            $user_message = "Ruh Roh! Database thing failed!";
        }
    } else {
        $user_message = "<ul>";
        array_walk($errors, function ($message, $field) use (&$user_message) {
           $user_message .= "<li>{$message} [{$field}]</li>";
        });
        $user_message .= "</ul>";
    }
endif;
?>
<?= partial("header") ?>

    <div class="container">
        <h1>New Hobbit
            <small>GET hobbits.new - POST hobbits.create</small>
        </h1>

        <div class="jumbotron">
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem repellat esse magni quasi nulla tenetur aliquid rerum nam?</p>

            <?= ($user_message) ? partial("alert_message", ['message' => $user_message]) : "" ?>

            <form class="form" method="POST">
                <div class="form-group">
                    <input type="text" name="first_name" class="form-control input-lg" placeholder="First Name" value="<?= array_get($_POST, 'first_name') ?>">
                </div>
                <div class="form-group">
                    <input type="text" name="last_name" class="form-control input-lg" placeholder="Last Name" value="<?= array_get($_POST, 'last_name') ?>">
                </div>
                <div class="form-group">
                    <button class="btn btn-lg btn-primary">Create</button>
                </div>
            </form>
        </div>
    </div>

<?= partial("footer") ?>