<?php
use yii\helpers\Html;
use yii\helpers\Url;

date_default_timezone_set('America/Guatemala');
$ActualDate = new \DateTime();
?>

<div class="pt-3 pb-4 px-4 mycard-second color1 mt-4" style="width: min(800px, 100%)">
    <div class="fs-3 mb-5">Sesiones activas</div>
    <div class="row align-items-center">
    <?php foreach(Yii::$app->SessionActivity->listActive() as $it): ?>
        <div class="col-6 col-lg-4 d-flex align-items-center gap-2">
            <i class="fa fa-<?= $it->Device; ?>"></i> <?= $it->Browser; ?> (<?= ucfirst($it->Device) ?>) 
            <!-- <?= ($it->compare()) ? '<span class="text-success">sesión actual</span>' : ""; ?> -->
            <?= ($it->compare()) ? '<i class="fa-solid fa-circle-check" style="color: #FF0351"></i>' : ""; ?>
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
            <?= $message ?>
        </div>
        <hr class="my-3" style="border-bottom: 1.2px solid var(--bs-highlight-color);">
        <?php endforeach ?>
    </div>
</div>
