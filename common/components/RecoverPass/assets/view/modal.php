   <?php 
    use yii\helpers\Url;
    use yii\helpers\Html;

    ?>

    <!-- Modal Recover pass-->
    <div id="modal-recover-pass" class="modal fade" role="dialog">
      <div class="modal-dialog">
       
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header" style="background-color: #6590ba; justify-content: center;">
            <button type="button" class="close" data-dismiss="modal" style="position: absolute; right: 0; top: 0; ">&times;</button>
            <h4 style="color: #fff;" class="modal-title">¿Olvido su contraseña?</h4>
            <!-- <h5 style="color:#ff751b">No te preocupes, ¡vamos a recuperar tu acceso!<br> por favor ingresa la información solicitada.</h5> -->
          </div>
          <div class="modal-body" style="color: #464646;">
                <div class="row">
                    <div class="col-sm-12 recover-pass-user">
                        <div class="recover-box-text"><p>Ingresa tu nombre de usuario o correo electrónico, para empezar con el proceso de recuperación.</p>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon" style=" background: silver; padding: 5px; border: solid 1px; border-radius: 5px 0 0 5px;"><i class="fa fa-user"></i></span>
                            <input type="text" class="form-control"  id="userinp-recover" Placeholder="Usuario o Correo" required>
                        </div>
                    </div>
                    <div class="col-sm-12 recover-pass-code" style="display: none;">
                        <div class="recover-box-text boxtext-code">
                            <p>
                                Revisa tu correo electrónico ( <b id='coreo-verificacion'></b> ) te enviamos el código de confirmación que necesitas para el proceso de recuperación.
                            </p>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon" style=" background: silver; padding: 5px; border: solid 1px; border-radius: 5px 0 0 5px;"><i class="fa fa-key"></i></span>
                            <input type="text" class="form-control" id="codeinp-recover" Placeholder="Código de verificación" required>
                        </div>
                    </div>
                    <div class="col-sm-12 recover-pass-newpass" style="display: none;">
                        <div class="recover-box-text boxtext-code">
                            <p>
                                Ingresa tu nueva contraseña, esta debe contener como minimo 6 caracteres, contener al menos un número y al menos una letra mayúscula.
                            </p>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon" style=" background: silver; padding: 5px; border: solid 1px; border-radius: 5px 0 0 5px;"><i class="fa fa-lock"></i></span>
                            <input type="password" class="form-control" id="passwordinp-recover" Placeholder="Nueva contraseña" required>
                        </div>
                    </div>
                    <div class="col-sm-12 recover-pass-finish" style="display: none;">
                        <div class="recover-box-text boxtext-code">
                            <p>
                                ¡Felicidades! Lograste recuperar el acceso a tu cuenta correctamente
                                <br>
                                Ahora puedes iniciar sesión con normalidad. 
                            </p>
                        </div>
                    </div>
                </div>
          </div>
          <div class="modal-footer">
            <?= Html::submitButton('Continuar', ['class' => 'btn btn-color-especial btnc-primary recover-continue','data-step'=>'user']) ?>
            <button type="button" class="btn btn-default" data-dismiss="modal" onclick="location.reload();">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
   
</div>


