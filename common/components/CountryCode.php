<?php
namespace common\components;

use Yii;

class CountryCode extends \yii\web\Request {
    public function codecountry($country){

        $codePhoneCountry = array(
            // América del Norte
            array(
                'NameES' => 'Estados Unidos',
                'NameEN' => 'United States',
                'CodePhone' => '+1'
            ),
            array(
                'NameES' => 'Canadá',
                'NameEN' => 'Canada',
                'CodePhone' => '+1'
            ),
            array(
                'NameES' => 'México',
                'NameEN' => 'Mexico',
                'CodePhone' => '+52'
            ),
            
            // América Central
            array(
                'NameES' => 'Guatemala',
                'NameEN' => 'Guatemala',
                'CodePhone' => '+502'
            ),
            array(
                'NameES' => 'Honduras',
                'NameEN' => 'Honduras',
                'CodePhone' => '+504'
            ),
            array(
                'NameES' => 'El Salvador',
                'NameEN' => 'El Salvador',
                'CodePhone' => '+503'
            ),
            array(
                'NameES' => 'Nicaragua',
                'NameEN' => 'Nicaragua',
                'CodePhone' => '+505'
            ),
            array(
                'NameES' => 'Costa Rica',
                'NameEN' => 'Costa Rica',
                'CodePhone' => '+506'
            ),
            array(
                'NameES' => 'Panamá',
                'NameEN' => 'Panama',
                'CodePhone' => '+507'
            ),
            
            // Caribe
            array(
                'NameES' => 'República Dominicana',
                'NameEN' => 'Dominican Republic',
                'CodePhone' => '+1-809'
            ),
            array(
                'NameES' => 'Puerto Rico',
                'NameEN' => 'Puerto Rico',
                'CodePhone' => '+1-787'
            ),
            array(
                'NameES' => 'Cuba',
                'NameEN' => 'Cuba',
                'CodePhone' => '+53'
            ),
            array(
                'NameES' => 'Jamaica',
                'NameEN' => 'Jamaica',
                'CodePhone' => '+1-876'
            ),
            
            // América del Sur
            array(
                'NameES' => 'Brasil',
                'NameEN' => 'Brazil',
                'CodePhone' => '+55'
            ),
            array(
                'NameES' => 'Argentina',
                'NameEN' => 'Argentina',
                'CodePhone' => '+54'
            ),
            array(
                'NameES' => 'Colombia',
                'NameEN' => 'Colombia',
                'CodePhone' => '+57'
            ),
            array(
                'NameES' => 'Chile',
                'NameEN' => 'Chile',
                'CodePhone' => '+56'
            ),
            array(
                'NameES' => 'Perú',
                'NameEN' => 'Peru',
                'CodePhone' => '+51'
            ),
            array(
                'NameES' => 'Venezuela',
                'NameEN' => 'Venezuela',
                'CodePhone' => '+58'
            ),
            array(
                'NameES' => 'Ecuador',
                'NameEN' => 'Ecuador',
                'CodePhone' => '+593'
            ),
            array(
                'NameES' => 'Bolivia',
                'NameEN' => 'Bolivia',
                'CodePhone' => '+591'
            ),
            array(
                'NameES' => 'Paraguay',
                'NameEN' => 'Paraguay',
                'CodePhone' => '+595'
            ),
            array(
                'NameES' => 'Uruguay',
                'NameEN' => 'Uruguay',
                'CodePhone' => '+598'
            ),
            array(
                'NameES' => 'Guyana',
                'NameEN' => 'Guyana',
                'CodePhone' => '+592'
            ),
            array(
                'NameES' => 'Surinam',
                'NameEN' => 'Suriname',
                'CodePhone' => '+597'
            ),
            array(
                'NameES' => 'Guayana Francesa',
                'NameEN' => 'French Guiana',
                'CodePhone' => '+594'
            ),
            array(
                'NameES' => 'España',
                'NameEN' => 'Spain',
                'CodePhone' => '+34'
            ),
            array(
                'NameES' => 'Francia',
                'NameEN' => 'France',
                'CodePhone' => '+33'
            ),
            array(
                'NameES' => 'Italia',
                'NameEN' => 'Italy',
                'CodePhone' => '+39'
            ),
            array(
                'NameES' => 'Alemania',
                'NameEN' => 'Germany',
                'CodePhone' => '+49'
            ),
            array(
                'NameES' => 'Reino Unido',
                'NameEN' => 'United Kingdom',
                'CodePhone' => '+44'
            ),
            array(
                'NameES' => 'Portugal',
                'NameEN' => 'Portugal',
                'CodePhone' => '+351'
            ),
            array(
                'NameES' => 'Países Bajos',
                'NameEN' => 'Netherlands',
                'CodePhone' => '+31'
            ),
            array(
                'NameES' => 'Bélgica',
                'NameEN' => 'Belgium',
                'CodePhone' => '+32'
            ),
            array(
                'NameES' => 'Suiza',
                'NameEN' => 'Switzerland',
                'CodePhone' => '+41'
            ),
            array(
                'NameES' => 'Austria',
                'NameEN' => 'Austria',
                'CodePhone' => '+43'
            ),
            array(
                'NameES' => 'Suecia',
                'NameEN' => 'Sweden',
                'CodePhone' => '+46'
            ),
            array(
                'NameES' => 'Noruega',
                'NameEN' => 'Norway',
                'CodePhone' => '+47'
            ),
            array(
                'NameES' => 'Dinamarca',
                'NameEN' => 'Denmark',
                'CodePhone' => '+45'
            ),
            array(
                'NameES' => 'Finlandia',
                'NameEN' => 'Finland',
                'CodePhone' => '+358'
            ),
            array(
                'NameES' => 'Rusia',
                'NameEN' => 'Russia',
                'CodePhone' => '+7'
            ),
            array(
                'NameES' => 'Polonia',
                'NameEN' => 'Poland',
                'CodePhone' => '+48'
            ),
            array(
                'NameES' => 'Ucrania',
                'NameEN' => 'Ukraine',
                'CodePhone' => '+380'
            ),
            array(
                'NameES' => 'Grecia',
                'NameEN' => 'Greece',
                'CodePhone' => '+30'
            ),
            array(
                'NameES' => 'Turquía',
                'NameEN' => 'Turkey',
                'CodePhone' => '+90'
            ),
            array(
                'NameES' => 'Hungría',
                'NameEN' => 'Hungary',
                'CodePhone' => '+36'
            ),
            array(
                'NameES' => 'República Checa',
                'NameEN' => 'Czech Republic',
                'CodePhone' => '+420'
            ),
            array(
                'NameES' => 'Rumanía',
                'NameEN' => 'Romania',
                'CodePhone' => '+40'
            ),
            array(
                'NameES' => 'Irlanda',
                'NameEN' => 'Ireland',
                'CodePhone' => '+353'
            ),
            array(
                'NameES' => 'Islandia',
                'NameEN' => 'Iceland',
                'CodePhone' => '+354'
            ),
            array(
                'NameES' => 'Bulgaria',
                'NameEN' => 'Bulgaria',
                'CodePhone' => '+359'
            )
        );

        $code = '';
        foreach($codePhoneCountry as $c){
            if(stripos($country, $c['NameES']) !== false || stripos($country, $c['NameEN']) !== false){
                $code = $c['CodePhone'];
            }
        }

        return $code;
    }
}