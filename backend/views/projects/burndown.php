<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = 'Burndown Chart';
?>

<div class="row">
    <div class="col-md-12">
        <h2>Burndown Chart por Sprint</h2>
        Projecto: <?= $project->Name; ?>
    </div>
</div>
<div class="row mt-4">
    <div class="col-md-4">
        <?php $form = ActiveForm::begin([
            'id' => 'sprint-form',
            'method' => 'get',
            'action' => ['projects/load-burndown-chart'],
        ]); ?>
            <div class="form-group">
                <label for="">Sprints</label>
                <?= Html::dropDownList('sprint', null, array_combine($sprints, $sprints), [
                    'prompt' => 'Seleccione un Sprint...',
                    'class' => 'form-control',
                    'id' => 'sprint-selector'
                ]) ?>
            </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <canvas id="burndownChart" width="400" height="200"></canvas>
    </div>
    <div class="col-md-4">
        <div class="row">
            <div class="col-md-12 mb-4 p-2" style="display: flex;justify-content: center;align-items: center;border: solid 1px black;flex-direction: column;">
                <h3>Por hacer</h3>
                <span style="font-size: 1.5rem;" class="num-phacer">0</span> Tareas
            </div>
            <div class="col-md-12 mb-4 p-2" style="display: flex;justify-content: center;align-items: center;border: solid 1px black;flex-direction: column;">
                <h3>Haciendo</h3>
                <span style="font-size: 1.5rem;" class="num-haciendo">0</span>Tareas
            </div>
            <div class="col-md-12 mb-4 p-2" style="display: flex;justify-content: center;align-items: center;border: solid 1px black;flex-direction: column;">
                <h3>Terminadas</h3>
                <span style="font-size: 1.5rem;" class="num-terminada">0</span>Tareas
            </div>
        </div>
    </div>
</div>






<?php
$this->registerJsFile('https://cdn.jsdelivr.net/npm/chart.js');

$UrlBurnData = Url::to(['projects/load-burndown-chart']);

$this->registerJs(<<<JS
let chart;

console.log('Este log imprime una variable php', 'hola')
$('#sprint-selector').on('change', function () {
    let sprint = $(this).val();
    if (!sprint) return;
    let idproject = {$project->ProjectClientID};

    $.ajax({
        url: "{$UrlBurnData}",
        type: 'GET',
        data: { sprint: sprint, id: idproject },
        success: function(data) {
            if (data.error) {
                alert(data.error);
                return;
            }

            const ctx = document.getElementById('burndownChart').getContext('2d');

            if (chart) chart.destroy();

            const maxY = data.ideal[0]; // Siempre parte del valor inicial
            const numPuntos = data.labels.length;
            data.ideal = Array.from({ length: numPuntos }, (_, i) =>
                Math.round((maxY - (i * maxY / (numPuntos - 1))) * 100) / 100
            );

            $('.num-phacer').text(data.countPendding);
            $('.num-haciendo').text(data.conutInit);
            $('.num-terminada').text(data.countComplete);

            chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.labels,
                    datasets: [
                        {
                            label: 'Ideal',
                            data: data.ideal,
                            borderColor: 'rgba(54, 162, 235, 1)',
                            fill: false
                        },
                        {
                            label: 'Real',
                            data: data.real,
                            borderColor: 'rgba(255, 99, 132, 1)',
                            fill: false
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
            
        },
        error: function() {
            alert('Ocurrió un error al cargar los datos');
        }
    });
});
JS);
?>