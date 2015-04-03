<?php


function _getAddonsCinfig()
{
    $config = S('REPORT_ADDON_CONFIG');
    if (!$config) {
        $config = M('Addons')->where(array('name' => 'Report'))->find();
        $config = json_decode($config['config'], ture);
        $config = explode("\r\n", $config['meta']);
        S('REPORT_ADDON_CONFIG', $config, 600);
    }
    return $config;
}
