<?php
use yii\helpers\Html;
use yii\helpers\Url;
date_default_timezone_set('America/Guatemala');
$ActualDate = new \DateTime();

$this->registerCss('
    .mycard{
        background: var(--mycard-sc-bg1); 
        width: min(600px, 100%);
        border-radius: 4px;
        color: var(--bs-dark);
    }
    .mycard-second{
        border-radius: 4px;
        color: var(--bs-dark);
    }
    .mycard-second.color1{
        background: var(--mycard-sc-bg2); 
    }
    .mycard-second.color2{
        background: var(--mycard-sc-bg3); 
    }
');
?>


<div class="mt-4 d-flex align-items-center flex-column flex-md-row gap-4 mycard py-4 px-3">
    <img src="<?= Yii::getAlias("@web"); ?>/images/site/2AF.png" style="width: 90px;" alt="logo">
    <div class="d-flex flex-column gap-2">
        <div class="fs-4">Verificación 2AF</div>
        <div style="line-height: normal;">Solicita verificación de 2 factores para iniciar sesión con tu cuenta de cliente.</div>
    </div>
    <button class="btn py-0 px-5" style="background-color: var(--bg-bottom-primary); color: #fff; height: fit-content; margin-top: clamp(0.5rem, 2vw, 3.3rem);" onClick="$('#change-thwofactor-auth').modal('show');" type="button"><?= $UserData->TwoFactorActive == 1? 'Desactivar':'Verificar'; ?></button>
</div>

<div class="row mt-5">
    <div class="col-lg-6">
        <div class="pt-3 pb-4 px-4 mycard-second color1">
            <div class="fs-3 mb-5">Sesiones activas</div>
            <div class="row align-items-center">
            <?php foreach(Yii::$app->SessionActivity->listActive() as $it): ?>
                <div class="col-6 col-lg-4 d-flex align-items-center gap-2">
                    <i class="fa fa-<?= $it->Device; ?>"></i> <?= $it->Browser; ?> (<?= ucfirst($it->Device) ?>) 
                    <!-- <?= ($it->compare()) ? '<span class="text-success">sesión actual</span>' : ""; ?> -->
                </div>
                <div class="col-6 col-lg-4">
                    <?= $it->Country; ?> (<?= $it->IP; ?>)
                </div>
                <div class="d-flex col-6 col-lg-4 gap-3 align-items-center mt-3 mt-lg-0">
                   <?php 
                        $Diff = $ActualDate->diff((new \DateTime($it->DateActivity))); 
                        $message = "Hace ";
                        if($Diff->y > 0){
                            $message .= $Diff->y." ";
                            $message .= ($Diff->y > 1)?'años':'año';

                        }
                        elseif($Diff->m > 0){
                            $message .= $Diff->m." ";
                            $message .= ($Diff->m > 1)?'meses':'mes';
                        }
                        elseif($Diff->d > 0){
                            $WeekDay = '';
                            $num = $Diff->d;
                            if($Diff->d >= 7){
                                $num = ceil(($Diff->d / 7));
                                if($num > 1){
                                    $WeekDay = 'semanas';
                                }else{
                                    $WeekDay = 'semana';
                                }
                            }else{
                                if($num > 1){
                                    $WeekDay = 'dias';
                                }else{
                                    $WeekDay = 'día';
                                }
                            }
                            $message .= "{$num} {$WeekDay}";
                        }
                        elseif($Diff->h > 0){
                            $message .= $Diff->h." ";
                            $message .= ($Diff->h > 1)?'horas':'hora';

                        }
                        elseif($Diff->i > 0){
                            $message .= $Diff->i." ";
                            $message .= ($Diff->i > 1)?"minutos":"minuto" ;

                        }else{
                            $message .= " menos de 1 minuto";
                        }
                    ?>
                   <div style="min-width: 163.55px"><?= $message; ?></div>
                   <?php if($it->Status == 1 && !$it->compare()): ?>
                        <a href="<?= Url::to(['close-session','id'=>$it->ActivitySessionID]); ?>" class="btn btn-sm click-confirm py-1 px-2" tittle-alert="¿Cerrar esta sesión?" text-alert="(<?= $it->Device ?>) <?= $it->Country; ?> (<?= $it->IP; ?>)" style="background-color: #FF0351; color: #fff; height: fit-content;"><i class="fa fa-right-from-bracket"></i></a>
                    <?php endif; ?>
                </div>
                <hr class="my-3" style="border-bottom: 1.2px solid var(--bs-highlight-color);">
                <?php endforeach ?>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="pt-3 pb-4 px-4 mycard-second color2">
            <div class="fs-3 mb-2">Accesos recientes</div>
            <div class="fs-6 mb-5">Revisa la actividad reciente de tu cuenta cliente. incluyendo intentos de acceso correctos/fallidos o bloqueos automaticos.</div>
            <div class="row align-items-center">
                <?php foreach(Yii::$app->SessionActivity->list(20) as $it): ?>
                    <div class="col-6 col-lg-3 d-flex align-items-center gap-2">
                        <i class="fa fa-<?= $it->Device; ?>"></i> <?= $it->Browser; ?> (<?= ucfirst($it->Device) ?>) 
                        <!-- <?= ($it->compare()) ? '<span class="text-success">sesión actual</span>' : ""; ?> -->
                        <?= ($it->compare()) ? '<i class="fa-solid fa-circle-check" style="color: #FF0351"></i>' : ""; ?>
                    </div>
                    <div class="col-6 col-lg-3">
                        <?= $it->Country; ?> (<?= $it->IP; ?>)
                    </div>
                    <div class="col-6 col-lg-3 mt-3 mt-lg-0">
                        <?php 
                            $Diff = $ActualDate->diff((new \DateTime($it->DateActivity))); 
                            $message = "Hace ";
                            if($Diff->y > 0){
                                $message .= $Diff->y." ";
                                $message .= ($Diff->y > 1)?'años':'año';

                            }
                            elseif($Diff->m > 0){
                                $message .= $Diff->m." ";
                                $message .= ($Diff->m > 1)?'meses':'mes';
                            }
                            elseif($Diff->d > 0){
                                $WeekDay = '';
                                $num = $Diff->d;
                                if($Diff->d >= 7){
                                    $num = ceil(($Diff->d / 7));
                                    if($num > 1){
                                        $WeekDay = 'semanas';
                                    }else{
                                        $WeekDay = 'semana';
                                    }
                                }else{
                                    if($num > 1){
                                        $WeekDay = 'dias';
                                    }else{
                                        $WeekDay = 'día';
                                    }
                                }
                                $message .= "{$num} {$WeekDay}";
                            }
                            elseif($Diff->h > 0){
                                $message .= $Diff->h." ";
                                $message .= ($Diff->h > 1)?'horas':'hora';

                            }
                            elseif($Diff->i > 0){
                                $message .= $Diff->i." ";
                                $message .= ($Diff->i > 1)?"minutos":"minuto" ;

                            }else{
                                $message .= " menos de 1 minuto";
                            }
                        ?>
                        <div><?= $message; ?></div>
                    </div>
                    <div class="d-flex col-6 col-lg-3 gap-3 align-items-center mt-3 mt-lg-0">
                        <div class="d-flex gap-2 align-items-center">
                            <i class="<?= ($it->ActivityStatus == 1)? 'text-success':'text-danger'; ?> fa fa-circle"></i><?= ($it->ActivityStatus == 1) ? 'Abierta' : 'Cerrada' ?> 
                        </div>
                        <?php if($it->Status == 1 && !$it->compare()): ?>
                            <a href="<?= Url::to(['close-session','id'=>$it->ActivitySessionID]); ?>" class="text-reset btn click-confirm py-1 px-2" tittle-alert="¿Cerrar esta sesión?" text-alert="(<?= $it->Device ?>) <?= $it->Country; ?> (<?= $it->IP; ?>)" style="background-color: #FF0351; color: #fff !important; height: fit-content;"><i class="fa fa-right-from-bracket"></i></a>
                        <?php endif; ?>
                    </div>
                    <hr class="my-3" style="border-bottom: 1.2px solid var(--bs-highlight-color)">
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>