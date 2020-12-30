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

if ( !defined('EQDKP_INC') ){
    header('HTTP/1.0 404 Not Found');exit;
}

$english_array = array (
    'factions' => array(
        'cerulean_order' => 'The Cerulean Order',
        'crimson_legion' => 'The Crimson Legion',
    ),
    'regions' => array(
        'eu' => 'Europe',
        'na' => 'North America',
    ),
    'races' => array(
        0 => 'Unknown',
        1 => 'Gon',
        2 => 'Lyn',
        3 => 'Yun',
        4 => 'Jin',
    ),
    'classes' => array(
        0 => 'Unknown',
        1 => 'Blade Master',
        2 => 'Destroyer',
        3 => 'Summoner',
        4 => 'Force Master',
        5 => 'Kung Fu Master',
        6 => 'Assassin',
        7 => 'Blade Dancer',
        8 => 'Warlock',
        9 => 'Chi Master',
        10 => 'Gunslinger',
        11 => 'Warden',
        12 => 'Zen Archer',
        13 => 'Astromancer',
    ),
    'genders' => array(
        0 => 'Male',
        1 => 'Female',
    ),
    'lang' => array(
        'bs' => 'Blade & Soul',
        'core_sett_fs_gamesettings' => 'Blade & Soul Settings',
        'uc_faction' => 'Faction',
        'uc_gender' => 'Gender',
        'uc_guild' => 'Clan',
        'uc_race' => 'Race',
        'uc_class' => 'Class',
        'uc_level'=> 'Level',
        'uc_hongmoon' => 'Hongmoon Level',
        'uc_region' => 'Region',

        'raid_bt' => 'Skybreak Spire',
        'raid_vt' => 'Temple of Eluvium',
        'raid_sk' => 'Scion\'s Keep',
        'raid_tt' => 'Nightfall Sanctuary',
        'raid_et' => 'Scarlet Conservatory',
        'raid_ia' => 'Steelbreaker',

        'equipment' => 'Equipment',
        'stats' => 'Stats',
        'talents' => 'Talents',
        'skills' => 'Skills',

        'item_ring' => 'Ring',
        'item_earring' => 'Earring',
        'item_necklace' => 'Necklace',
        'item_bracelet' => 'Bracelet',
        'item_belt' => 'Belt',
        'item_gloves' => 'Gloves',
        'item_singongpae' => 'Soul Badge',
        'item_rune' => 'Badge',
        'item_soul' => 'Soul',
        'item_soul-2' => 'Heart',
        'item_guard' => 'Pet',
        'item_nova' => 'Talisman',
        'item_clothes' => 'Outfit',
        'item_clothesDecoration' => 'Adornment',
        'item_tire' => 'Head Adornment',
        'item_faceDecoration' => 'Face Adornment',

        'psyche' => 'Psyche',
        'psyche_stat_1' => 'Attack Power',
        'psyche_stat_2' => 'Defense',
        'psyche_stat_3' => 'Resistance',
        'psyche_stat_4' => 'Base Hit Rate',
        'psyche_stat_5' => 'Accuracy',
        'psyche_stat_6' => 'Critical Rate',
        'psyche_stat_7' => 'Critical',
        'psyche_stat_8' => 'Critical Evasion Rate',
        'psyche_stat_9' => 'Critical Defense',
        'psyche_stat_10' => 'Evasion Rate',
        'psyche_stat_11' => 'Evasion',
        'psyche_stat_12' => 'Block Rate',
        'psyche_stat_13' => 'Block Rate',
        'psyche_stat_14' => 'Increases duration of status effects',
        'psyche_stat_15' => 'Mastery',
        'psyche_stat_16' => 'Decreases duration of status effects',
        'psyche_stat_17' => 'Willpower',
        'psyche_stat_18' => 'Concentration Rate',
        'psyche_stat_19' => 'Concentration',
        'psyche_stat_20' => 'Physical damage Mitigation Rate',
        'psyche_stat_21' => 'Elemental damage Mitigation Rate',
        'psyche_stat_22' => 'Damage Amplification Rate',
        'psyche_stat_23' => 'Additional Damage',
        'psyche_stat_24' => 'Damage Mitigation Rate',
        'psyche_stat_25' => 'Damage Reduction',
        'psyche_stat_26' => 'HP',
        'psyche_stat_27' => 'Health Regen',
        'psyche_stat_28' => 'Combat Health Regen',
        'psyche_stat_29' => 'Piercing',
        'psyche_stat_30' => 'Concentration',
        'psyche_stat_31' => 'Block Piercing',
        'psyche_stat_32' => 'Counter Piercing',
        'psyche_stat_33' => 'Critical Damage',
        'psyche_stat_34' => 'Boss Attack Power',
        'psyche_stat_35' => 'Boss Defense',
        'psyche_stat_36' => 'PvP Attack Power',
        'psyche_stat_37' => 'PvP Defense',
        'psyche_stat_38' => 'Critical Damage',
        'psyche_stat_39' => 'Resilience',
        'psyche_stat_40' => 'Mystic',

        'attack_power' => 'Attack Power',
        'pvp_ap' => 'PvP Attack Power',
        'boss_ap' => 'Boss Attack Power',
        'piercing' => 'Piercing',
        'accuracy' => 'Accuracy',
        'crit' => 'Critical Hit',
        'crit_dmg' => 'Critical Dmg.',
        'additional_dmg' => 'Additional Dmg.',
        'threat' => 'Threat',
        'debuff_dmg' => 'Debuff Dmg.',
        'mystic' => 'Mystic',
        'hp' => 'HP',
        'defense' => 'Defense',
        'pvp_defense' => 'PvP Defense',
        'boss_defense' => 'Boss Defense',
        'evasion' => 'Evasion',
        'block' => 'Block',
        'crit_defense' => 'Critical Def.',
        'health_reg' => 'Health Regen',

        'no_data' => 'No connection could be established to the Blade & Soul server, so no additional character information is displayed.',
    ),
);

?>
