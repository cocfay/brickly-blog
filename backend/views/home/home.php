<?php 
	use yii\helpers\Url; 
    $this->title = 'Bienvenido';
 ?>
<div class="container-fluid px-0 cpanel-home-page">
	<div class="cpanel-home-logo-wrap">
		<img src="<?= Yii::getAlias("@web"); ?>/images/logo.png" class="img-rounded cpanel-home-logo" alt="Brickly">
	</div>
	<h1 class="cpanel-home-title">Bienvenido <?=  $UserData->Name?:$UserData->UserName; ?> </h1>

    <?php 
        $data = [];

        // Primero, recopilar todos los servicios
        foreach($services as $service) {
            $serviceId = $service->ServiceID;
            $data[$serviceId] = [
                'NameService' => $service->Name,
                'items' => []
            ];
            
            // Procesar los requestServices relacionados (solo los que tienen Status ≠ 1)
            foreach($service->requestServices as $request) {
                // Saltar registros con Status = 1
                if($request->Status == 1) {
                    continue;
                }
                
                // Verificar si todos los checks son nulos o vacíos
                $allChecksEmpty = true;
                $hasDescription = !empty($request->Description);
                
                // Revisar todos los checks (Check1 al Check6)
                for($n = 1; $n <= 10; $n++) {
                    $checkField = "Check{$n}";
                    $checkValue = $request->$checkField;
                    
                    if(!empty($checkValue) && $checkValue != '0') {
                        $allChecksEmpty = false;
                        
                        // Procesar check válido
                        $found = false;
                        foreach($data[$serviceId]['items'] as &$item) {
                            if($item['check'] === $checkValue) {
                                $item['cantidad']++;
                                $found = true;
                                break;
                            }
                        }
                        
                        if(!$found) {
                            $data[$serviceId]['items'][] = [
                                'check' => $checkValue,
                                'cantidad' => 1
                            ];
                        }
                    }
                }
                
                // Procesar caso donde todos los checks están vacíos pero hay descripción
                if($allChecksEmpty && $hasDescription) {
                    $found = false;
                    foreach($data[$serviceId]['items'] as &$item) {
                        if($item['check'] === 'Prospectos') {
                            $item['cantidad']++;
                            $found = true;
                            break;
                        }
                    }
                    
                    if(!$found) {
                        $data[$serviceId]['items'][] = [
                            'check' => 'Prospectos',
                            'cantidad' => 1
                        ];
                    }
                }
            }
        }

        // Ordenar por ServiceID
        ksort($data);
    ?>
	<div class="cpanel-home-projects m-auto mt-5">
		<div class="text-center mb-3 fs-4">Bandeja de proyectos</div>
		<div class="cpanel-home-project-grid w-100 p-3 row m-auto">
			<?php foreach($data as $id => $services): ?>
				<a href="<?= Url::to(['service-requests/', 'id' => $id]) ?>" target="_blank" class="text-decoration-none col-md-4 mb-4" style="color: var(--bs-dark);">
				<!-- <div class="d-flex flex-column justify-content-center align-items-start"> -->
					<div class="mb-2 text-start fs-4">
						<?= $services['NameService'] ?> 
					</div>
					<?php foreach($services['items'] as $items): ?>
						<div class="d-flex align-items-center gap-2 text-danger"><span><?= $items['cantidad'] ?></span> <?= $items['check'] ?></div>
					<?php endforeach ?>
				<!-- </div> -->
				</a>
			<?php endforeach ?>
		</div>
	</div>
</div>
