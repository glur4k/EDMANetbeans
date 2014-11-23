<?php 
require_once 'header.php';

$db = DB::getInstance();

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'password' => array(
                'fieldname' => 'Passwort',
                'required' => true
            )
        ));

        if ($validation->passed()) {
            if ($login) {
                Redirect::to('index.php');
            } else {
                echo 'login failed';
            }
        } else {
            echo '<div class="row"><div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">';
            echo $validation->errors();
            echo '</div></div>';
        }
    }
}
?>

<div class="row">
    <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
        <form class="form-signin" role="form" action="" method="post">
            <h2>Bitte Projekt auswählen</h2>
            <label for="projekt" class="sr-only">Projekt</label>
            <div class="form-group">
                <select class="form-control" id="projekt">
                    <option value="0">Projekt hinzuf&uuml;gen</option>
                    <?php
                    $db->query('SELECT name, id FROM projekte');
                    foreach ($db->results() as $projekt) {
                        echo '<option value="' . $projekt->id . '">' . escape($projekt->name) . '</option>';
                    }

                    ?>
                </select>
            </div>
            <label for="password" class="sr-only">Passwort</label>
            <div class="form-group">
                <div class="input-group">
                    <input type="password" name="password" class="form-control" placeholder="Passwort" id="password">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span></span>
                </div>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" value="remember-me">Anmeldung speichern
                </label>
            </div>
            <input name="token" type="hidden" value="<?php echo Token::generate(); ?>">
            <input class="btn btn-lg btn-primary btn-block" type="submit" value="&Ouml;ffnen">
        </form>
    </div>
</div>

<?php
    require_once 'footer.php';
?>
