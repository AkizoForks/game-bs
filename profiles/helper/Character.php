<?php

class Character
{
    const WEAPON = 'wrapWeapon';
    const RING = 'wrapAccessory ring';
    const EARRING = 'wrapAccessory earring';
    const NECKLACE = 'wrapAccessory necklace';
    const BRACELET = 'wrapAccessory bracelet';
    const BELT = 'wrapAccessory belt';
    const GLOVES = 'wrapAccessory gloves';
    const SOUL = 'wrapAccessory soul';
    const HEART = 'wrapAccessory soul-2';
    const TALISMAN = 'wrapAccessory nova';
    const PET = 'wrapAccessory guard';
    const SOUL_BADGE = 'wrapAccessory singongpae';
    const MYSTIC_BADGE = 'wrapAccessory rune';

    const FASHION_MAIN = 'wrapAccessory clothes';
    const FASHION_BACK = 'wrapAccessory clothesDecoration';
    const FASHION_HEAD = 'wrapAccessory tire';
    const FASHION_FACE = 'wrapAccessory faceDecoration';

    private $statCheck = true;
    private $equipCheck = true;

    /**
     * @var array|null
     */
    protected $charData = null;

    /**
     * @var DOMXPath|null
     */
    protected $charEquip = null;

    /**
     * @var DOMXPath|null
     */
    protected $charMain = null;

    /**
     * @var DOMXPath[]|null
     */
    protected $charTalent = null;

    private $lang;
    private $langReplace = [
        'de' => [
            'hm_level' => 'HongmoonStufe',
            'level' => 'Stufe',
            'victories' => 'Siege',
        ],
        'en_US' => [
            'hm_level' => 'HongmoonLevel',
            'level' => 'Level',
            'victories' => 'Victories',
        ]
    ];

    public function __construct($region, $charName, $language = 'en_US')
    {
        $this->lang = $language;
        libxml_use_internal_errors(true);
        $contextJSON = stream_context_create(['http' => ['header' => 'Content-Type: application/json; charset=utf-8' . PHP_EOL . 'Cookie: language=' . $this->lang . PHP_EOL, 'timeout' => 2]]);
        $context = stream_context_create(['http' => ['header' => 'Content-Type: text/html; charset=utf-8' . PHP_EOL . 'Cookie: language=' . $this->lang . PHP_EOL, 'timeout' => 2]]);

        $tmp = file_get_contents('http://' . $region . '-bns.ncsoft.com/ingame/bs/character/data/abilities.json?c=' . urlencode($charName), false, $contextJSON);
        $this->charData = json_decode($tmp, true);
        if ($this->charData['result'] !== 'success') {
            $this->statCheck = false;
        }

        $tmp = file_get_contents('http://' . $region . '-bns.ncsoft.com/ingame/bs/character/data/equipments?c=' . urlencode($charName), false, $context);
        $dom = new \DOMDocument();
        $dom->loadHTML($tmp);
        $check = $dom->getElementById('equipResult');
        if ($check->nodeValue !== 'success') {
            $this->equipCheck = false;
        }
        $this->charEquip = new \DOMXPath($dom);

        $tmp2 = file_get_contents('http://' . $region . '-bns.ncsoft.com/ingame/bs/character/profile?c=' . urlencode($charName), false, $context);
        $dom2 = new \DOMDocument();
        $dom2->loadHTML(str_replace(['&nbsp;', ' <span class="ic_bull">&bull;</span> ', '<!-- (s) 비무 정보 ncw only--', '(e) 비무 정보 -->'], [' ', ' ', ' ', ' '], $tmp2));
        $this->charMain = new \DOMXPath($dom2);

        $tmpTalentPages = file_get_contents('http://' . $region . '-bns.ncsoft.com/ingame/api/training/characters/' . str_replace('+', '%20', urlencode($charName)) . '/stat.json', false, $contextJSON);
        $tmpTalentPagesJ = json_decode($tmpTalentPages, true)['records'] ?? null;
        if ($tmpTalentPagesJ !== null) {
            $tmpTalentSkills = file_get_contents('http://' . $region . '-bns.ncsoft.com/ingame/api/training/characters/' . str_replace('+', '%20', urlencode($charName)) . '/pages/' . $tmpTalentPagesJ['current_page'] . '/skills.json', false, $contextJSON);
            $tmpTalentTraits = file_get_contents('http://' . $region . '-bns.ncsoft.com/ingame/api/training/characters/' . str_replace('+', '%20', urlencode($charName)) . '/pages/' . $tmpTalentPagesJ['current_page'] . '/traits.json', false, $contextJSON);
            $this->charTalent = [
                'pages' => $tmpTalentPagesJ,
                'skills' => json_decode($tmpTalentSkills, true)['records'] ?? null,
                'traits' => json_decode($tmpTalentTraits, true)['records'] ?? null,
            ];
        }

        libxml_use_internal_errors(false);
    }

    public function getMainData()
    {
        $data = $this->charMain->query('//dl[contains(attribute::class, "signature")]//dd[contains(attribute::class, "desc")]//li');
        $tmpLv = explode(' ' . $this->langReplace[$this->lang]['hm_level'] . ' ', $data[1]->nodeValue);
        return [
            'level' => str_replace($this->langReplace[$this->lang]['level'] . ' ', '', $tmpLv[0]),
            'hm_level' => isset($tmpLv[1]) ? $tmpLv[1] : 0,
            'clan' => isset($data[4]) ? $data[4]->nodeValue : '',
            'server' => isset($data[2]) ? $data[2]->nodeValue : '',
            'faction' => isset($data[3]) ? $data[3]->nodeValue : '',
        ];
    }

    public function getStats()
    {
        return [
            // Offensive
            'ap' => $this->charData['records']['total_ability']['attack_power_value'],
            'pvp-ap' => $this->charData['records']['total_ability']['pc_attack_power_value'],
            'boss-ap' => $this->charData['records']['total_ability']['boss_attack_power_value'],
            'piercing' => $this->charData['records']['total_ability']['attack_pierce_value'],
            'accuracy' => $this->charData['records']['total_ability']['attack_hit_value'],
            'accuracy-rate' => $this->charData['records']['total_ability']['attack_hit_rate'],
            'crit' => $this->charData['records']['total_ability']['attack_critical_value'],
            'crit-rate' => $this->charData['records']['total_ability']['attack_critical_rate'],
            'crit-dmg' => $this->charData['records']['total_ability']['attack_critical_damage_value'],
            'crit-dmg-rate' => $this->charData['records']['total_ability']['attack_critical_damage_rate'],
            'additional-dmg' => $this->charData['records']['total_ability']['attack_damage_modify_diff'],
            'threat' => $this->charData['records']['total_ability']['hate_power_rate'],
            'debuff-dmg' => $this->charData['records']['total_ability']['abnormal_attack_power_value'],
            'mystic' => $this->charData['records']['total_ability']['attack_attribute_value'],
            'mystic-rate' => $this->charData['records']['total_ability']['attack_attribute_rate'],

            // Defensive
            'hp' => $this->charData['records']['total_ability']['max_hp'],
            'defense' => $this->charData['records']['total_ability']['defend_power_value'],
            'pvp-defense' => $this->charData['records']['total_ability']['pc_defend_power_value'],
            'boss-defense' => $this->charData['records']['total_ability']['boss_defend_power_value'],
            'evasion' => $this->charData['records']['total_ability']['defend_dodge_value'],
            'block' => $this->charData['records']['total_ability']['defend_parry_value'],
            'crit-defense' => $this->charData['records']['total_ability']['defend_critical_value'],
            'health-reg-in' => $this->charData['records']['total_ability']['hp_regen_combat'],
            'health-reg-out' => $this->charData['records']['total_ability']['hp_regen'],

            // Skill Points
            'sk-defense' => $this->charData['records']['point_ability']['defense_point'],
            'sk-health-reg' => $this->charData['records']['point_ability']['picks'][1]['point'],
            'sk-movement' => $this->charData['records']['point_ability']['picks'][2]['point'],
            'sk-debuff' => $this->charData['records']['point_ability']['picks'][4]['point'],
            'sk-offense' => $this->charData['records']['point_ability']['offense_point'],
            'sk-threat' => $this->charData['records']['point_ability']['picks'][0]['point'],
            'sk-focus' => $this->charData['records']['point_ability']['picks'][3]['point'],
        ];
    }

    public function getTalentSpec()
    {
        if ($this->charTalent !== null && $this->charTalent['pages'] !== null) {
            $page = $this->charTalent['pages']['pages'][$this->charTalent['pages']['current_page'] - 1];
            $icon = parse_url($page['icon']);
            return [
                'image' => '//' . $icon['host'] . $icon['path'],
                'name' => trim($page['style_name']),
            ];
        }
        return null;
    }

    public function hasTalents()
    {
        return $this->charTalent['pages']['advance_enabled'] ?? false;
    }

    public function getTalents()
    {
        if ($this->charTalent !== null && $this->charTalent['traits'] !== null) {
            $talents = [];
            foreach ($this->charTalent['traits'] as $tier) {
                $talents[$tier['tier']] = [];
                foreach ($tier['traits'] as $trait) {
                    if (!empty(trim($trait['name']))) {
                        $icon = parse_url($trait['icon']);
                        $talents[$tier['tier']][] = [
                            'image' => '//' . $icon['host'] . $icon['path'],
                            'name' => trim($trait['name']),
                            'class' => $trait['selected'] ? ' selected' : '',
                        ];
                    }
                }
            }

            return $talents;
        }
        return null;
    }

    public function getSkills()
    {
        if ($this->charTalent !== null && $this->charTalent['skills'] !== null) {
            $talents = [];
            foreach ($this->charTalent['skills'] as $level) {
                foreach ($level['skills'] as $skill) {
                    if (!empty(trim($skill['name'])) && isset($skill['buildup_max_level']) && $skill['buildup_max_level'] > 0) {
                        $icon = parse_url($skill['icon']);
                        $groupIcon = parse_url($skill['group_icon']);

                        $classes = [];
                        if (!$skill['activated']) {
                            $classes[] = 'deactivated';
                        }
                        if ($skill['passive']) {
                            $classes[] = 'passive';
                        }
                        if ($skill['buildup_max_level'] > 0 && $skill['buildup_level'] >= $skill['buildup_max_level']) {
                            $classes[] = 'skill_max';
                        }

                        $talents[] = [
                            'image' => '//' . $icon['host'] . $icon['path'],
                            'name' => trim($skill['name']),
                            'skill_level' => $skill['buildup_level'],
                            'skill_level_max' => $skill['buildup_max_level'],
                            'group_name' => trim($skill['group_name']),
                            'group_icon' => '//' . $groupIcon['host'] . $groupIcon['path'],
                            'class' => count($classes) > 0 ? ' ' . implode(' ', $classes) : '',
                        ];
                    }
                }
            }

            return $talents;
        }
        return null;
    }

    public function getAvatar()
    {
        $data = $this->charMain->query('//section[contains(attribute::class, "characterInfo")]//div[contains(attribute::class, "charaterView")]//img');
        if (isset($data[0])) {
            if (getimagesize($data[0]->getAttribute('src')) !== false) {
                return 'data:image/jpeg;base64,' . base64_encode(file_get_contents($data[0]->getAttribute('src')));
            }
        }
        return null;
    }

    public function getArenaStats()
    {
        $rating = $this->charMain->query('//ul[contains(attribute::class, "season-list")]//li//div[contains(attribute::class, "rank-point")]');
        $wins = $this->charMain->query('//ul[contains(attribute::class, "season-list")]//li//div[contains(attribute::class, "win-point")]');
        return [
            'solo' => [
                'rating' => isset($rating[0]) ? $rating[0]->nodeValue : 1300,
                'wins' => isset($wins[0]) ? str_replace($this->langReplace[$this->lang]['victories'] . ' ', '', $wins[0]->nodeValue) : 0,
            ],
            'tag' => [
                'rating' => isset($rating[1]) ? $rating[1]->nodeValue : 1300,
                'wins' => isset($wins[1]) ? str_replace($this->langReplace[$this->lang]['victories'] . ' ', '', $wins[1]->nodeValue) : 0,
            ]
        ];
    }

    public function getWeapon()
    {
        $weapon = $this->charEquip->query('//div[contains(attribute::class, "' . static::WEAPON . '")]//div[contains(attribute::class, "name")]//span')[0];

        if ($weapon->attributes[0]->nodeValue === 'empty') {
            return [
                'name' => '',
                'grade' => 0,
                'stage' => '',
                'image' => '',
                'psycheData' => '',
            ];
        } else {
            $tmp = explode('grade_', $weapon->attributes[0]->nodeValue);
            $grade = intval($tmp[1]);

            $tmp2 = explode(' - Stage ', $weapon->nodeValue);
            $stage = count($tmp2) > 1 ? $tmp2[1] : '';

            $itemIcon = $this->charEquip->query('//div[contains(attribute::class, "' . static::WEAPON . '")]//div[contains(attribute::class, "icon")]//img/@src')[0]->nodeValue;
            $tmp3 = parse_url($itemIcon);
            $image = $tmp3['host'] . $tmp3['path'];

            $gems = [];
            $tmp4 = $this->charEquip->query('//div[contains(attribute::class, "' . static::WEAPON . '")]//div[contains(attribute::class, "enchant")]//span//img');
            /** @var DOMElement $gem */
            foreach ($tmp4 as $gem) {
                $tmp5 = parse_url($gem->getAttribute('src'));

                $gems[] = [
                    'name' => utf8_decode($gem->getAttribute('alt')),
                    'image' => '//' . $tmp5['host'] . $tmp5['path']
                ];
            }

            return [
                'name' => utf8_decode($weapon->nodeValue),
                'grade' => $grade,
                'stage' => $stage,
                'image' => '//' . $image,
                'gems' => $gems,
                'psycheData' => '',
            ];
        }
    }

    public function getItem($itemType, $game)
    {
        $item = $this->charEquip->query('//div[contains(attribute::class, "' . $itemType . '")]//div[contains(attribute::class, "name")]//span')[0];

        if ($item->attributes[0]->nodeValue === 'empty') {
            return [
                'name' => $game->glang(str_replace('wrapAccessory ', 'item_', $itemType), true),
                'grade' => 0,
                'stage' => '',
                'image' => '',
                'psycheData' => '',
            ];
        } else {
            $tmp = explode('grade_', $item->attributes[0]->nodeValue);
            $grade = intval($tmp[1]);

            $tmp2 = explode(' - Stage ', $item->nodeValue);
            $stage = count($tmp2) > 1 ? (strpos($item->nodeValue, 'Awakened') !== false ? 'Awk. ' : '') . $tmp2[1] : '';

            $itemIcon = $this->charEquip->query('//div[contains(attribute::class, "' . $itemType . '")]//div[contains(attribute::class, "icon")]//img/@src')[0]->nodeValue;
            $tmp3 = parse_url($itemIcon);
            $image = $tmp3['host'] . $tmp3['path'];

            $itemDataValue = $this->charEquip->query('//div[contains(attribute::class, "' . $itemType . '")]//div[contains(attribute::class, "icon")]//img/@item-data')[0]->nodeValue;

            $ret = [
                'name' => utf8_decode($item->nodeValue),
                'grade' => $grade,
                'stage' => $stage,
                'image' => '//' . $image,
                'psycheData' => $this->getPsycheData($itemType, $itemDataValue, $game),
            ];

            if ($itemType === static::PET) {
                $tmp = explode('.', $itemDataValue);
                if (count($tmp) === 21) {
                    $petGemData = json_decode(file_get_contents(dirname(__FILE__) . '/pet_gem_data_' . $this->lang . '.json'), true);
                    $petGems = [];

                    for ($i = 8; $i <= 15; $i++) {
                        if (isset($tmp[$i]) && $tmp[$i] != '0' && isset($petGemData[$tmp[$i]])) {
                            $petGems[] = $petGemData[$tmp[$i]];
                        }
                    }

                    $ret['gems'] = $petGems;
                }
            }

            return $ret;
        }
    }

    private function getPsycheData($itemType, $data, $game)
    {
        if (in_array($itemType, [static::RING, static::EARRING, static::NECKLACE, static::BRACELET, static::BELT, static::GLOVES, static::SOUL, static::TALISMAN, static::HEART, static::SOUL_BADGE, static::MYSTIC_BADGE])) {
            $tmp = explode('.', $data);
            if (count($tmp) === 48 && isset($tmp[43]) && $tmp[43] != '0') {
                return '<span>' . $game->glang('psyche') . ': ' . $tmp[45] . ' ' . $game->glang('psyche_stat_' . $tmp[44]) . ' | ' . $tmp[47] . ' ' . $game->glang('psyche_stat_' . $tmp[46]) . '</span>';
            }
        } elseif ($itemType === static::PET) {
            $tmp = explode('.', $data);
            if (count($tmp) === 21 && isset($tmp[16]) && $tmp[16] != '0') {
                return '<span>' . $game->glang('psyche') . ': ' . $tmp[18] . ' ' . $game->glang('psyche_stat_' . $tmp[17]) . ' | ' . $tmp[20] . ' ' . $game->glang('psyche_stat_' . $tmp[19]) . '</span>';
            }
        } elseif ($itemType === Static::WEAPON) {
            // not yet implemented in NA/EU, only korean F2 has it
        }
        return null;
    }

    public function isLoaded()
    {
        return $this->statCheck && $this->equipCheck;
    }
}
