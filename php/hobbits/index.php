<?php
require_once '../bootstrap.php';
$statement = $DB->retrieveStatement("SELECT * FROM people ORDER BY id DESC");
$people    = $statement->fetchAll();
?>
<?= partial("header") ?>

    <div class="container">
        <h1>All Hobbits
            <small>GET hobbits.index</small>
        </h1>

        <div class="jumbotron">
            <ul class="unstyled">
                <?php foreach ($people as $person): ?>
                    <li>
                        <a href="<?= sprintf("/hobbits/show.php?id=%d", $person->id) ?>">
                            <?= sprintf("%s - %s, %s", $person->id, $person->first_name, $person->last_name) ?>
                        </a>
                    </li>
                <?php endforeach ?>
            </ul>
        </div>
    </div>

<?= partial("footer") ?>