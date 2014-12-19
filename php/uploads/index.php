<?php
require_once '../bootstrap.php';

function validateImageUploadFile(array $file, &$errors)
{
    $file_validation_message = 'File validation failed.';

    if (!in_array($file['type'], ['image/png', 'image/jpg', 'image/jpeg'])) {
        $file_validation_message .= ' Invalid file type.';
    }
    if ($file['size'] > 2000000) {
        $file_validation_message .= " File too large.";
    }

    if (
        !in_array($file['type'], ['image/png', 'image/jpg', 'image/jpeg'])
        ||
        $file['size'] > 2000000
    ) {
        $errors['file'] = $file_validation_message;
        return false;
    };
    return true;
}

function makeStoredFileName($id, $filename)
{
    $exploded  = explode(".", $filename);
    $ext       = end($exploded);
    $real_path = md5($id) . "." . $ext;
    return $real_path;
}


$statement = $DB->retrieveStatement("SELECT * FROM new_uploads ORDER BY id DESC");
$uploads   = $statement->fetchAll();

/**
 * Validate, Update, etc...
 */
$user_message = "";
if ($_POST):
    $file  = $_FILES['file'];
    $title = $_POST['title'];

    $new_data = [
        'original_filename' => $file['name'],
        //'stored_filename'   => 'foo',
        'file_type'         => $file['type'],
        'file_size'         => $file['size'],
        'title'             => $_POST['title']
    ];

    // Validate...
    $errors = [];
    // &$errors
    validateImageUploadFile($file, $errors);

    // Update...
    if (empty($errors)) {
        $sql     = "INSERT INTO new_uploads (original_filename, file_type, file_size, title) VALUES (:original_filename, :file_type, :file_size, :title)";
        $success = $DB->executeStatement($sql, $new_data);
        if ($success) {
            $user_message = "Success! You updated something!";
            $new_id = $DB->pdo->lastInsertId();
            $stored_filename = makeStoredFileName($new_id, $new_data['original_filename']);

            $sql = "UPDATE new_uploads
                SET stored_filename = :stored_filename
                WHERE id = :id";
            $DB->executeStatement($sql, ['id' => $new_id, 'stored_filename' => $stored_filename]);

            $real_path_dest = __DIR__ . "/files/" . $stored_filename;
            move_uploaded_file($file['tmp_name'], $real_path_dest);

            redirect_user("/uploads");

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
        <h1>All Uploads
            <small>GET uploads.index</small>
        </h1>

        <form class="form form-horizontal" method="POST" enctype="multipart/form-data" action="/uploads/index.php">
            <div class="form-group">
                <div class="col-sm-2">
                    <p class="lead">
                        Go Ahead.
                        <br/>
                        Add an image!
                    </p>
                </div>
                <div class="col-sm-3">
                    <label class="control-label" for="file">File (.png, .jpg, .jpeg):</label>
                    <input type="file" name="file" id="file">
                </div>
                <div class="col-sm-3">
                    <label class="control-label" for="title">Title:</label>
                    <input type="text" class="form-control input-md" name="title" id="title" value="Image Without a Title #<?= mt_rand(123, 456) ?>"/>
                </div>
                <div class="col-sm-2">
                    <strong>Upload Your Image!</strong><br/>
                    <button class="btn btn-lg btn-primary">Upload</button>
                </div>
            </div>
        </form>

        <?= ($user_message) ? partial("alert_message", ['message' => $user_message]) : "" ?>


        <div class="jumbotron">
            <ul class="unstyled">
                <?php foreach ($uploads as $upload): ?>
                    <h4><?= $upload->original_filename ?></h4>
                    <img class="img-responsive" src="<?= "/uploads/files/{$upload->stored_filename}" ?>" alt=""/>
                <?php endforeach ?>
            </ul>
        </div>
    </div>

<?= partial("footer") ?>