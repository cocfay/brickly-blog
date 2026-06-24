<page style="font-size:13pt">
    <style>
        .logo{
            margin: auto;
            width: 250px;
            height: 250px;
        }
        .logo img{
            width: 100%;
            height: 100%;
        }
        .titulo{
            font-weight: bold;
            text-align: center;
            font-size: 22px;
            margin: 20px 0px;
        }
        .table{
            border-collapse: collapse;
            margin: auto;
            text-align: center;
        }
        .table th{
            background-color: #294068;
            color: #dddddd;
        }
        .table td, .table th{
            padding: 0px 10px;
        }
        .date_footer{
            position: absolute;
            bottom: 0px;
            left:0px;
            font-size: 12px;
        }
    </style>
    <?php $meses = [1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril', 5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto', 9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'] ?>
    <div style="width: 800px; margin: auto;">
        <table style="vertical-align: middle">
            <tr>
                <td style="width: 400px; font-weight: bold; font-size: 26px">ESTADO DE CUENTA</td>
                <td style="width: 400px;" align="right"><?= $meses[date('m')].' '.date('d') ?></td>
            </tr>
        </table>
        <br>
        <div style="background: #e7e7e7; box-sizing: border-box; padding: 10px">
            <table style="vertical-align: middle">
                <tr>
                    <td style="width: 600px;"><span style="font-weight: bold">Nombre comercial: </span><?=$data[0]->nombre_crm?></td>
                    <td style="width: 200px;"><span style="font-weight: bold">NIT: </span><?=$data[0]->nit?></td>
                </tr>
            </table>
            <table>
                <tr>
                    <td style="width: 450px;"><span style="font-weight: bold; vertical-align: middle">Razón social: </span><?=$data[0]->razon_social_crm?></td>
                    <td style="width: 350px;"><span style="font-weight: bold">Correo: </span><?=$data[0]->Email?></td>
                </tr>
            </table>
        </div>
        <br><br>
        <table>
            <tr>
                <td></td>
                <td style="font-weight: bold; padding: 0 0 10px 0;" align="center">Cantidad</td>
                <td style="font-weight: bold; padding: 0, 10px 10px  0;" align="center">Quezales</td>
                <td style="font-weight: bold; padding: 0, 10px 10px  0;" align="center">Dólares</td>
            </tr>

            <?php $totlaQ = 0; $totalD = 0; foreach($items['result'] as $items): ?>
                <?php
                    if($items->moneda == "GTQ")
                        $totlaQ += $items->total;    
                    else
                        $totalD += $items->totla;
                ?>
                <tr style="width: 450px">
                    <td>
                        <div style="margin-bottom: 5px; font-weight: bold;"><?= $items->nombre_producto ?></div>
                        <div style="margin-bottom: 5px;"><?= date('d/m/Y H:i', strtotime($items->fecha)) ?></div>
                        <div style="margin-bottom: 10px;">Precio del curso: <?= ($items->moneda == "GTQ") ? 'Q ' : '$'?><?= $items->precio_unitario ?></div>
                    </td>
                    <td style="width: 116.6px" align="center"><?= $items->cantidad ?></td>
                    <td style="width: 116.6px" align="center"><?= ($items->moneda == "GTQ") ? 'Q '.$items->total : '' ?></td>
                    <td style="width: 116.6px" align="center"><?= ($items->moneda != "GTQ") ? '$'.$items->total : '' ?></td>
                </tr>
            <?php endforeach ?>
        </table>
        <br>
        <div style="box-sizing: border-box; padding: 10px; background: #000000; color: white;">
            <table>
                <tr>
                    <td align="right" style="font-weight: bold; width: 400px">TOTAL DEL MES</td>
                    <td style="width: 133.3px"></td>
                    <td align="right" style="width: 133.3px">Q <?= $totlaQ ?></td>
                    <td align="right" style="width: 133.3px">$<?= $totalD ?></td>
                </tr>
            </table>
        </div>
    </div>
        
    <div class="date_footer">
        <?= date("d/m/Y") ?> <?= date("H:i") ?>
    </div>
</page>