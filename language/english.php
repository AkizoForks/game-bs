<?php
/*	Project:	EQdkp-Plus
 *	Package:	Blade & Soul game package
 *	Link:		http://eqdkp-plus.eu
 *
 *	Copyright (C) 2006-2016 EQdkp-Plus Developer Team
 *
 *	This program is free software: you can redistribute it and/or modify
 *	it under the terms of the GNU Affero General Public License as published
 *	by the Free Software Foundation, either version 3 of the License, or
 *	(at your option) any later version.
 *
 *	This program is distributed in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *	GNU Affero General Public License for more details.
 *
 *	You should have received a copy of the GNU Affero General Public License
 *	along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

if ( !defined('EQDKP_INC') ){
	header('HTTP/1.0 404 Not Found');exit;
}
					
$english_array = array (
	'factions' => array(
    		'cerulean_order' => 'The Cerulean Order',
    		'crimson_legion' => 'The Crimson Legion',
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
  	),
	'genders' => array(
		0 => 'Male',
		1 => 'Female',
	),
  	'lang' => array(
		'bs'				=> 'Blade & Soul',
		'core_sett_fs_gamesettings'	=> 'Blade & Soul Settings',
		'uc_faction'			=> 'Faction',
		'uc_gender'			=> 'Gender',
		'uc_guild'			=> 'Clan',
		'uc_race'			=> 'Race',
		'uc_class'			=> 'Class',
		'uc_level'			=> 'Level',
		'uc_hongmoon'			=> 'Hongmoon Level',
  	),
);
		
?>
