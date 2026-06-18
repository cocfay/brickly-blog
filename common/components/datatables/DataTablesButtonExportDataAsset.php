<?php
/**
 * @copyright Federico Nicolás Motta
 * @author Federico Nicolás Motta <fedemotta@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php The MIT License (MIT)
 * @package yii2-widget-datatables
 */

namespace common\components\datatables;


use yii\web\AssetBundle;

/**
 * Asset for the DataTables TableTools JQuery plugin
 * @author Federico Nicolás Motta <fedemotta@gmail.com>
 */
class DataTablesButtonExportDataAsset extends AssetBundle 
{
    public $sourcePath = '@common/components/datatables/bower/datatables/media/buttonexport'; 

    public $css = [
        // "css/dataTables.tableTools.css",
        'css/buttons.dataTables.min.css',

    ];

    public $js = [
        'js/dataTables.buttons.min.js', 
        'js/buttons.flash.min.js', 
        'js/jszip.min.js', 
        'js/pdfmake.min.js', 
        'js/vfs_fonts.js', 
        'js/buttons.html5.min.js', 
        'js/buttons.print.min.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'common\components\datatables\DataTablesAsset',
    ];
}