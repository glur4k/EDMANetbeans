<?php
require_once 'header.php';

$projekt = new Projekt();

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'projektname' => array(
                'fieldname' => 'Projektname',
                'required' => true,
                'min' => 3,
                'max' => 20,
                'unique' => true
            )
        ));

        if ($validation->passed()) {
            $projekt = new Projekt();

            $salt = Hash::salt(32);

            if ($projekt->data()->id > 0) {
                // Projekt updaten
            } else {
                // Neues Projekt
                try {
                    /*
                      $projekt->create(array(
                      'name' => Input::get('projektname'),
                      'passwort' => Hash::make(Input::get('passwort'), $salt),
                      'salt' => $salt,
                      'erstellt' => date('Y-m-d H:i:s'),
                      ));
                     */

                    // Session::flash('message', 'Projekt erfolgreich angelegt!');
                    // Redirect::to('index.php');
                } catch (Exception $ex) {
                    die($ex->getMessage());
                }
            }
        } else {
            $message = "";
            foreach ($validation->errors() as $error) {
                $message .= $error . '<br>';
            }
            if (!Session::exists('error')) {
                // Session::flash('error', $message);
                // Redirect::to('projekt.php');
            }
        }
    }
}
?>

<h2>
    <?php echo ($projekt->data() ? $projekt->data()->projekt . ' bearbeiten' : 'Neues Projekt anlegen'); ?>
</h2>
<br>
<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="projektname" class="col-sm-4 control-label">Projektname<sup>*</sup></label>
        <div class="col-sm-5">
            <input type="text" class="form-control" name="projektname" id="projektname" placeholder="Projektname">
        </div>
    </div>
    <div class="form-group">
        <label for="eingabefeldPasswort3" class="col-sm-4 control-label">Passwort für externe Besucher</label>
        <div class="col-sm-5">
            <input type="password" class="form-control" name="passwort" id="eingabefeldPasswort3" placeholder="Passwort">
        </div>
    </div>
    <div class="form-group">
        <label for="projektbeschreibung" class="col-sm-4 control-label">Projektbeschreibung</label>
        <div class="col-sm-5">
            <div class="panel panel-default">
                <!-- Standard-Panel-Inhalt -->
                <div class="panel-heading">Vorhandene Projektbeschreibungen</div>

                <!-- Tabelle -->
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Dateiname</th>
                            <th>Datum</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Mark</td>
                            <td>1.1.1970</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Jacob</td>
                            <td>1.1.1970</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Larry</td>
                            <td>1.1.1970</td>
                        </tr>
                    </tbody>
                </table>

                <div class="panel-body">
                    <div class="row">
                        <label class="col-xs-12 col-md-9" for="files">Projektbeschreibung hochladen</label>
                    </div>
                            <div class="progress-pie-chart" style="display: none;">
                                <div class="ppc-progress">
                                    <div class="ppc-progress-fill"></div>
                                </div>
                                <div class="ppc-percents">
                                    <div class="pcc-percents-wrapper">
                                        <span>40%</span>
                                    </div>
                                </div>
                            </div>
                    <div class="form-horizontal">
                        <div class="form-group">
                        </div>
                    </div>
                        <input class="col-xs-12 col-md-9" name="file[]" id="files" type="file" id="projektbeschreibung" multiple="multiple">
                        <div class="col-md-3" id="upload">
                            <button type="submit" name="upload" id="upload" class="btn btn-primary btn-sm pull-right">Upload</button>
                            
                        </div>
                    </div>
                    <p><strong>Achtung:</strong> Wenn der Name der Datei schon vorhanden ist, wird die existierende Beschreibung überschrieben.</p>

                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
    <div class="form-group">
        <div class="col-sm-offset-4 col-sm-5">
            <button type="submit" class="btn btn-primary">Speichern</button>
            <a href="index.php" class="btn btn-link">Abbrechen</a>
        </div>
    </div>

    <script>
        $('#upload').click(function(event) {
            var pie = $('.progress-pie-chart');
            var button = $(this);
            button.toggle();
            pie.toggle();
            
            event.preventDefault();
            var f = $('#files')[0];
            
            app.uploader({
                files: f,
                processor: 'upload.php',

                finished: function(data) {
                    //pie.toggle();
                    //button.toggle();
                    // Fuege Element in Tabelle ein
                    console.log(data);
                },

                error: function(data) {
                    // Zeige Fehlermeldung
                }
            });
        });
    </script>
</form>

<?php
require_once 'footer.php';
