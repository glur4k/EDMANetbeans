<?php
require_once 'header.php';

$projekt = new Projekt();
$projekt->logout();

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {

        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'password' => array('required' => true)
        ));

        if ($validation->passed()) {
            $projekt = new Projekt(Input::get('projekt'));
            
            if (Input::get('password') === 'master') {
                $projekt->setMaster();
            }
            
            if (Input::get('projekt') === 'new') {
                if ($projekt->canEdit()) {
                    Session::flash('yes', 'du darfst');
                    Redirect::to('projekt.php');
                } else {
                    Session::flash('error', 'Sie haben keine'
                        . ' Berechtigungen ein neues Projekt anzulegen!');
                }
            } else {
                $login = $projekt->login(Input::get('projekt'), Input::get('password'));

                if ($login) {
                    Redirect::to('index.php');
                } else {
                    Session::flash('error', 'Login fehlgeschlagen!');
                }
            }
            Redirect::to('login.php');
        } else {
            foreach ($validation->errors() as $error) {
                echo $error . "<br>";
            }
        }
    }
}
?>

<div class="row">
    <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
        <form role="form" action="" method="post">
            <h2>Bitte Projekt auswählen</h2>
            <label for="projekt" class="sr-only">Projekt</label>
            <div class="form-group">
                <select class="form-control" id="projekt" name="projekt">
                    <option value="new">Projekt hinzuf&uuml;gen</option>
                    <?php
                    $db = DB::getInstance();

                    $db->query('SELECT name, id FROM projekte');
                    foreach ($db->results() as $projekt) {
                        echo '<option value="' . $projekt->id . '">' . escape($projekt->name) . '</option>';
                    }
                    ?>
                </select>
            </div>
            <label for="password" class="sr-only">Passwort</label>
            <div class="form-group no-margin-bottom">
                <div class="input-group">
                    <input type="password" name="password" class="form-control" placeholder="Passwort" id="password" required>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span></span>
                </div>
            </div>
            <div class="form-group">
                <a href="#" tabindex="0" role="button" data-toggle="popover" data-placement="left" title="Passwort vergessen?" data-trigger="focus" data-content="Inhalt">Passwort vergessen?</a>
            </div>
            <input name="token" type="hidden" value="<?php echo Token::generate(); ?>">
            <input class="btn btn-lg btn-primary btn-block" type="submit" value="&Ouml;ffnen">
        </form>
    </div>
</div>

<?php
require_once 'footer.php';
