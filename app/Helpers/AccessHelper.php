<?php

/**
 * 
 */
if (!function_exists('isValidPrefix')) {
    function isValidPrefix($prefix, $role_name)
    {
        $config_prefix = config("access-roles.$role_name.prefix");
        if ($config_prefix['is_full']) {
            return true;
        }

        if (! in_array($prefix, $config_prefix['not_allow'])) {
            return true; 
        }

        return false;
    }
}

/**
 * 
 */
if (!function_exists('isValidAction')) {
    function isValidAction($prefix, $action, $role_name)
    {
        $sample = makePrefixAction($prefix, $action); // req
        $config_action_specials = config("access-roles.$role_name.action_special");

        if (empty($config_action_specials['not_allow'])) {
            return true;
        }

        foreach ($config_action_specials['not_allow'] as $config_action_special) {

            $config_not_allow = explode(':', $config_action_special);
            $config_prefix    = $config_not_allow[0] ?? null;
            $config_actions   = !empty($config_not_allow[1]) ? explode(',', $config_not_allow[1]) : [];

            if (is_null($config_prefix) || empty($config_actions)) {
                continue;
            }

            foreach ($config_actions as $cf_action) {
                if (makePrefixAction($config_prefix, $cf_action) == $sample) {
                    return false;
                }
            }
        }

        return true;
    }
}

/**
 * 
 */
if (!function_exists('isValidMethod')) {
    function isValidMethod($method, $role_name)
    {
        $config_method = config("access-roles.$role_name.method");
        if ($config_method['is_full']) {
            return true;
        }

        if (! in_array(strtolower($method), $config_method['not_allow'])) {
            return true; 
        }

        return false;
    }
}

/**
 * 
 */
if (!function_exists('makePrefixAction')) {
    function makePrefixAction($prefix, $action)
    {
        return "$prefix:$action";
    }
}