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

if (!class_exists('bs')) {
    class bs extends game_generic {
        protected static $apiLevel = 20;
        public $version = '1.6.0';
        protected $this_game = 'bs';
        protected $types = array('factions', 'races', 'classes', 'genders', 'regions');
        protected $genders = array();
        protected $classes = array();
        protected $races = array();
        protected $factions = array();
        public $langs = array('english', 'german');
        protected $class_dependencies = array(
            array(
                'name' => 'faction',
                'type' => 'factions',
                'admin' => true,
                'decorate' => false,
                'parent' => false,
            ),
            array(
                'name' => 'region',
                'type' => 'regions',
                'admin' => true,
                'decorate' => false,
                'parent' => false,
            ),
            array(
                'name' => 'race',
                'type' => 'races',
                'admin' => false,
                'decorate' => true,
                'parent' => false,
            ),
            array(
                'name' => 'gender',
                'type' => 'genders',
                'admin' => false,
                'decorate' => false,
                'parent' => array(
                    'race' => array(
                        0 => array(0, 1),  // Unknown
                        1 => array(0, 1),  // Gon
                        2 => array(0, 1),  // Lyn
                        3 => array(1),    // Yun
                        4 => array(0, 1),  // Jin
                    ),
                ),
            ),
            array(
                'name' => 'class',
                'type' => 'classes',
                'admin' => false,
                'decorate' => true,
                'primary' => true,
                'colorize' => true,
                'roster' => true,
                'recruitment' => true,
                'parent' => array(
                    'race' => array(
                        0 => 'all',                // Unknown
                        1 => array(0, 2, 4, 5, 9, 11),  // Gon
                        2 => array(0, 3, 4, 6, 7, 8, 10, 13),  // Lyn
                        3 => array(0, 1, 4, 5, 9, 10, 12),  // Yun
                        4 => array(0, 1, 5, 6, 8, 9, 10, 11, 12),  // Jin
                    ),
                ),
            ),
        );

        protected $glang = array();
        protected $lang_file = array();
        protected $path = '';
        public $lang = false;
        protected $class_colors = array(
            1 => '#C8C8C8',
            2 => '#49A03E',
            3 => '#3287C1',
            4 => '#C66F0A',
            5 => '#18493C',
            6 => '#D345FF',
            7 => '#F6DC78',
            8 => '#A45934',
            9 => '#FF3021',
            10 => '#FF93AC',
            11 => '#CCFFFF',
            12 => '#B6985C',
            13 => '#7b2dff',
        );

        public function install($install = false) {
            $btID = $this->game->addEvent($this->glang('raid_bt'), 0, 'raid.png');
            $vtID = $this->game->addEvent($this->glang('raid_vt'), 0, 'raid.png');
            $skID = $this->game->addEvent($this->glang('raid_sk'), 0, 'raid.png');
            $ttID = $this->game->addEvent($this->glang('raid_tt'), 0, 'raid.png');
            $etID = $this->game->addEvent($this->glang('raid_et'), 0, 'raid.png');
            $iaID = $this->game->addEvent($this->glang('raid_ia'), 0, 'raid.png');

            $this->game->updateDefaultMultiDKPPool('Default', 'Default MultiDKPPool', array());

            $intItempoolBT = $this->game->addItempool($this->glang('raid_bt'), $this->glang('raid_bt') . " Itempool");
            $this->game->addMultiDKPPool($this->glang('raid_bt'), $this->glang('raid_bt') . " DKP", array($btID), array($intItempoolBT));

            $intItempoolVT = $this->game->addItempool($this->glang('raid_vt')."/" . $this->glang('raid_sk'), $this->glang('raid_vt') . "/" . $this->glang('raid_sk') . " Itempool");
            $this->game->addMultiDKPPool($this->glang('raid_vt')."/" . $this->glang('raid_sk'), $this->glang('raid_vt') . "/" . $this->glang('raid_sk') . " DKP", array($vtID, $skID), array($intItempoolVT));

            $intItempoolTT = $this->game->addItempool($this->glang('raid_tt'), $this->glang('raid_tt') . " Itempool");
            $this->game->addMultiDKPPool($this->glang('raid_tt'), $this->glang('raid_tt') . " DKP", array($ttID), array($intItempoolTT));

            $intItempoolET = $this->game->addItempool($this->glang('raid_et'), $this->glang('raid_et') . " Itempool");
            $this->game->addMultiDKPPool($this->glang('raid_et'), $this->glang('raid_et') . " DKP", array($etID), array($intItempoolET));

            $intItempoolIA = $this->game->addItempool($this->glang('raid_ia'), $this->glang('raid_ia') . " Itempool");
            $this->game->addMultiDKPPool($this->glang('raid_ia'), $this->glang('raid_ia') . " DKP", array($iaID), array($intItempoolIA));

            $this->game->addRank(0, 'Recruit', true);
            $this->game->addRank(1, 'Member');
            $this->game->addRank(2, 'Veteran');
            $this->game->addRank(3, 'Advisor');
            $this->game->addRank(4, 'Leader');
        }

        public function profilefields() {
            // Category 'character' is a fixed one! All others are created dynamically!
            $xml_fields = array(
                'level' => array(
                    'type' => 'spinner',
                    'category' => 'character',
                    'lang' => 'uc_level',
                    'max' => 60,
                    'min' => 1,
                    'undeletable' => true,
                    'sort' => 4
                ),
                'hongmoon' => array(
                    'type' => 'spinner',
                    'category' => 'character',
                    'lang' => 'uc_hongmoon',
                    'max' => 35,
                    'min' => 0,
                    'undeletable' => true,
                    'sort' => 5
                ),
                'guild' => array(
                    'type' => 'text',
                    'category' => 'character',
                    'lang' => 'uc_guild',
                    'size' => 20,
                    'undeletable' => true,
                ),
            );
            return $xml_fields;
        }

        protected function load_filters($langs) {
            return array();
        }
    }
}
?>
