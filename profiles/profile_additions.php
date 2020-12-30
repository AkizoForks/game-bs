<?php

/** @var array $member */
require_once('helper/Character.php');

$character = new Character($this->config->get('region'), $member['name'], $this->user->lang_name === 'german' ? 'de' : 'en_US');
infotooltip_js();
$this->tpl->css_file('/games/bs/profiles/css/profile.css');

if ($character->isLoaded()) {
    $mainData = $character->getMainData();

    $character->getTalents();

    $this->jquery->Tab_header('bns_tabs');

    $this->tpl->assign_vars([
        'BNS_ONLINE' => 1,
        'CHAR_AVATAR' => $character->getAvatar(),
        'CHAR_LEVEL' => $mainData['level'],
        'CHAR_HM_LEVEL' => $mainData['hm_level'],
        'CHAR_CLAN' => $mainData['clan'],
        'CHAR_SERVER' => $mainData['server'],
        'CHAR_FACTION' => $mainData['faction'],
        'CHAR_FACTION_COLOR' => getFactionColor($mainData['faction']),
        'HAS_TALENTS' => $character->hasTalents(),
    ]);
    $this->tpl->assign_array('CURRENT_SPEC', $character->getTalentSpec());
    $this->tpl->assign_array('CHAR_STATS', $character->getStats());

    if ($character->hasTalents()) {
        $talents = $character->getTalents();
        foreach ($talents as $tier => $traits) {
            $this->tpl->assign_block_vars('talents', ['tier' => $tier]);
            foreach ($traits as $trait) {
                $this->tpl->assign_block_vars('talents.traits', $trait);
            }
        }
    }

    $charSkills = $character->getSkills();
    foreach ($charSkills as $skill) {
        $this->tpl->assign_block_vars('character_skills', $skill);
    }

    $weapon = $character->getWeapon();
    $this->tpl->assign_array('WEAPON', [
        'name' => $weapon['name'],
        'image' => $weapon['image'],
        'grade' => $weapon['grade'],
        'psycheData' => $weapon['psycheData']
    ]);
    foreach ($weapon['gems'] as $gem) {
        $this->tpl->assign_block_vars('WEAPON_GEMS', $gem);
    }

    $pet = $character->getItem(Character::PET, $this->game);
    $this->tpl->assign_array('PET', [
        'name' => $pet['name'],
        'image' => $pet['image'],
        'grade' => $pet['grade'],
        'psycheData' => $pet['psycheData']
    ]);
    foreach ($pet['gems'] as $gem) {
        $this->tpl->assign_block_vars('PET_GEMS', $gem);
    }

    $this->tpl->assign_array('RING', $character->getItem(Character::RING, $this->game));
    $this->tpl->assign_array('EARRING', $character->getItem(Character::EARRING, $this->game));
    $this->tpl->assign_array('NECKLACE', $character->getItem(Character::NECKLACE, $this->game));
    $this->tpl->assign_array('BRACELET', $character->getItem(Character::BRACELET, $this->game));
    $this->tpl->assign_array('BELT', $character->getItem(Character::BELT, $this->game));
    $this->tpl->assign_array('GLOVES', $character->getItem(Character::GLOVES, $this->game));
    $this->tpl->assign_array('SOUL_BADGE', $character->getItem(Character::SOUL_BADGE, $this->game));
    $this->tpl->assign_array('MYSTIC_BADGE', $character->getItem(Character::MYSTIC_BADGE, $this->game));
    $this->tpl->assign_array('SOUL', $character->getItem(Character::SOUL, $this->game));
    $this->tpl->assign_array('HEART', $character->getItem(Character::HEART, $this->game));
    $this->tpl->assign_array('TALISMAN', $character->getItem(Character::TALISMAN, $this->game));
    $this->tpl->assign_array('FASHION_MAIN', $character->getItem(Character::FASHION_MAIN, $this->game));
    $this->tpl->assign_array('FASHION_BACK', $character->getItem(Character::FASHION_BACK, $this->game));
    $this->tpl->assign_array('FASHION_HEAD', $character->getItem(Character::FASHION_HEAD, $this->game));
    $this->tpl->assign_array('FASHION_FACE', $character->getItem(Character::FASHION_FACE, $this->game));
} else {
    $this->tpl->assign_vars([
        'BNS_ONLINE' => 0,
    ]);

    $pfields = $this->pdh->get('profile_fields', 'fields');
    if ($this->hooks->isRegistered('character_profilefields')) {
        $pfields = $this->hooks->process('addcharacter_profilefields', array($pfields, $this->url_id), true);
    }

    $category = array();
    $this->jquery->Tab_header('profile_field_data', true);
    if (is_array($pfields) && count($pfields) > 0) {
        foreach ($pfields as $pfid => $pfoption) {
            $pfname = $pfoption['name'];
            // only relevant data!
            $category[$pfoption['category']][$pfname] = $pfoption;
        }
        foreach ($category as $catname => $catvalues) {
            $this->tpl->assign_block_vars('cat_data', array(
                'NAME' => ($this->game->glang('uc_cat_' . $catname)) ? $this->game->glang('uc_cat_' . $catname) : ((strlen($this->user->lang('uc_cat_' . $catname))) ? $this->user->lang('uc_cat_' . $catname) : $catname),
                'ID' => 'id_' . preg_replace('/[^A-Za-z0-9\- ]/', '', $catname),
            ));

            foreach ($catvalues as $pfname => $pfoption) {
                if ($pfoption['category'] == $catname && $pfoption['enabled'] == '1' && $pfoption['type'] != 'hidden') {
                    $this->tpl->assign_block_vars('cat_data.pfield_data', array(
                        'NAME' => $this->pdh->get('member', 'html_caption_profile_field', array($pfname)),
                        'VALUE' => $this->pdh->get('member', 'html_profile_field', array($this->url_id, $pfname))
                    ));
                }
            }
        }
        $this->tpl->assign_var('S_PFIELDS', true);
    } else {
        $this->tpl->assign_var('S_PFIELDS', false);
    }
}

function getFactionColor($faction)
{
    if (mb_strpos($faction, 'Crimson') !== false || mb_strpos($faction, 'Karminlegion') !== false) {
        return 'red';
    } elseif (mb_strpos($faction, 'Cerulean') !== false || mb_strpos($faction, 'Coelinorden') !== false) {
        return 'blue';
    }
    return 'inherit';
}
