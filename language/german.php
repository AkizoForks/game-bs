<?php
/*    Project:    EQdkp-Plus
 *    Package:    Blade & Soul game package
 *    Link:        http://eqdkp-plus.eu
 *
 *    Copyright (C) 2006-2016 EQdkp-Plus Developer Team
 *
 *    This program is free software: you can redistribute it and/or modify
 *    it under the terms of the GNU Affero General Public License as published
 *    by the Free Software Foundation, either version 3 of the License, or
 *    (at your option) any later version.
 *
 *    This program is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU Affero General Public License for more details.
 *
 *    You should have received a copy of the GNU Affero General Public License
 *    along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

if (!defined('EQDKP_INC')) {
    header('HTTP/1.0 404 Not Found');
    exit;
}

$german_array = array(
    'factions' => array(
        'cerulean_order' => 'Der Coelinorden',
        'crimson_legion' => 'Die Karminlegion',
    ),
    'regions' => array(
        'eu' => 'Europa',
        'na' => 'Nordamerika',
    ),
    'races' => array(
        0 => 'Unbekannt',
        1 => 'Gon',
        2 => 'Lyn',
        3 => 'Yun',
        4 => 'Jin',
    ),
    'classes' => array(
        0 => 'Unbekannt',
        1 => 'Klingenmeister',
        2 => 'Berserker',
        3 => 'Beschwörer',
        4 => 'Gewaltenbändiger',
        5 => 'Kungfu-Meister',
        6 => 'Nachtklinge',
        7 => 'Klingentänzer',
        8 => 'Paktierer',
        9 => 'Elementarkämpfer',
        10 => 'Schütze',
        11 => 'Beschützer',
        12 => 'Bogenläufer',
        13 => 'Astromant',
    ),
    'genders' => array(
        0 => 'Männlich',
        1 => 'Weiblich',
    ),
    'lang' => array(
        'bs' => 'Blade & Soul',
        'core_sett_fs_gamesettings' => 'Blade & Soul Settings',
        'uc_faction' => 'Fraktion',
        'uc_gender' => 'Geschlecht',
        'uc_guild' => 'Clan',
        'uc_race' => 'Volk',
        'uc_class' => 'Klasse',
        'uc_level' => 'Level',
        'uc_hongmoon' => 'Hongmoon Level',
        'uc_region' => 'Region',

        'raid_bt' => 'Himmelsspitze',
        'raid_vt' => 'Tempel der Winde',
        'raid_sk' => 'Festung des Usurpators',
        'raid_tt' => 'Mausoleum der Dämmerung',
        'raid_et' => 'Scharlachrote Pagode',
        'raid_ia' => 'Stählerne Arche',

        'equipment' => 'Ausrüstung',
        'stats' => 'Stats',
        'talents' => 'Talente',
        'skills' => 'Skills',

        'item_ring' => 'Ring',
        'item_earring' => 'Ohrring',
        'item_necklace' => 'Halsschmuck',
        'item_bracelet' => 'Armband',
        'item_belt' => 'Gürtel',
        'item_gloves' => 'Handschuhe',
        'item_singongpae' => 'Seelenabzeichen',
        'item_rune' => 'Geistesabzeichen',
        'item_soul' => 'Seele',
        'item_soul-2' => 'Geist',
        'item_guard' => 'Gefährte',
        'item_nova' => 'Amulett',
        'item_clothes' => 'Kleidung',
        'item_clothesDecoration' => 'Kleidungsverzierung',
        'item_tire' => 'Kopfverzierung',
        'item_faceDecoration' => 'Gesichtsverzierung',

        'psyche' => 'Lebensenergie',
        'psyche_stat_1' => 'Angriffskraft',
        'psyche_stat_2' => 'Verteidigung',
        'psyche_stat_3' => 'Resistenz',
        'psyche_stat_4' => 'Trefferrate',
        'psyche_stat_5' => 'Genauigkeit',
        'psyche_stat_6' => 'Krit. Trefferchance',
        'psyche_stat_7' => 'Krit. Trefferrate',
        'psyche_stat_8' => 'Verteidigungschance gegen Kritische Treffer',
        'psyche_stat_9' => 'Krit. Verteidigung',
        'psyche_stat_10' => 'Ausweichrate',
        'psyche_stat_11' => 'Ausweichen',
        'psyche_stat_12' => 'Blockrate',
        'psyche_stat_13' => 'Blocken',
        'psyche_stat_14' => 'Erhöht die Dauer von Statuseffekten',
        'psyche_stat_15' => 'Beherrschung',
        'psyche_stat_16' => 'Reduziert die Dauer von Statuseffekten',
        'psyche_stat_17' => 'Willenskraft',
        'psyche_stat_18' => 'Konzentrationsrate',
        'psyche_stat_19' => 'Konzentration',
        'psyche_stat_20' => 'Reduktionsrate von Körperlichem Schaden',
        'psyche_stat_21' => 'Reduktionsrate von Elementarschaden',
        'psyche_stat_22' => 'Schadensbonusrate',
        'psyche_stat_23' => 'Bonusschaden',
        'psyche_stat_24' => 'Schadenreduktionsrate',
        'psyche_stat_25' => 'Schadensreduktion',
        'psyche_stat_26' => 'LP',
        'psyche_stat_27' => 'Regeneration',
        'psyche_stat_28' => 'Lebensreg. im Kampf',
        'psyche_stat_29' => 'Durchdringung',
        'psyche_stat_30' => 'Konzentration',
        'psyche_stat_31' => 'Blockdurchdringung',
        'psyche_stat_32' => 'Konterdurchdringung',
        'psyche_stat_33' => 'Kritischer Schaden',
        'psyche_stat_34' => 'Boss-Angriffskraft',
        'psyche_stat_35' => 'Boss-Verteidgung',
        'psyche_stat_36' => 'PvP-Angriffskraft',
        'psyche_stat_37' => 'PvP-Verteidgung',
        'psyche_stat_38' => 'Kritischer Schaden',
        'psyche_stat_39' => 'Widerstand',
        'psyche_stat_40' => 'Chi-Kraft',

        'attack_power' => 'Angriffskraft',
        'pvp_ap' => 'PvP-Angriffskraft',
        'boss_ap' => 'Boss-Angriffskraft',
        'piercing' => 'Durchdringung',
        'accuracy' => 'Genauigkeit',
        'crit' => 'Kritische Rate',
        'crit_dmg' => 'Kritischer Schaden',
        'additional_dmg' => 'Zusatzschaden',
        'threat' => 'Bedrohung',
        'debuff_dmg' => 'Debuffschaden',
        'mystic' => 'Chi-Kraft',
        'hp' => 'LP',
        'defense' => 'Verteidigung',
        'pvp_defense' => 'PvP-Verteidigung',
        'boss_defense' => 'Boss-Verteidigung',
        'evasion' => 'Ausweichen',
        'block' => 'Blocken',
        'crit_defense' => 'Krit. Verteidigung',
        'health_reg' => 'Lebensregeneration',

        'no_data' => 'Es konnte keine Verbindung zum Server von Blade & Soul aufgebaut werden, daher werden keine zusätzlichen Informationen zum Charakter angezeigt.',
    ),
);

?>

