<?php

class SLN_Action_Install
{
    /** @var array DB updates that need to be run */
    private static $dbUpdates = array(
        '2.3'    => 'sln-update-for-2.3.php',
        '2.3.1'  => 'sln-update-for-2.3.1.php',
        '2.3.3'  => 'sln-update-for-2.3.3.php',
    );

    private static $dbRollbacks = array(
        '2.3.3'  => 'sln-rollback-to-2.3.2.php',
    );

    public static function getDbUpdates()
    {
        return array_map(function($elem) {
            return plugin_dir_path(__FILE__) . 'Updates/' . $elem;
        }, self::$dbUpdates);
    }

    public static function getDbRollbacks()
    {
        return array_map(function($elem) {
            return plugin_dir_path(__FILE__) . 'Rollbacks/' . $elem;
        }, self::$dbRollbacks);
    }

    public static function initActions()
    {
        if (defined('DOING_AJAX') && DOING_AJAX) {
            return;
        }

        if (!empty($_GET['do_update_sln'])) {
            self::update();
        }

        if (!empty($_GET['do_rollback_sln'])) {
            self::rollback();
        }

        $max = max(array_keys(self::getDbUpdates()));
        $version = SLN_Plugin::getInstance()->getSettings()->getDbVersion();
        if (version_compare($version, $max, '<')) {
            if($version == '0.0.0')
                $version = '2.3.2';
            echo SLN_Plugin::getInstance()->loadView('notice/html_notice_update', compact('version'));
        } else {
            SLN_Plugin::getInstance()->getSettings()->setDbVersion()->save();
        }
    }

    public static function execute($force = false)
    {
        $data = require SLN_PLUGIN_DIR . '/_install_data.php';
        $ids  = array();
        foreach ($data['posts'] as $label => $post) {
            if (!self::checkPost($post['post']['post_title'], $post['post']['post_type'])) {
                $id = wp_insert_post($post['post']);
                if (isset($post['meta'])) {
                    foreach ($post['meta'] as $k => $v) {
                        add_post_meta($id, $k, $v);
                    }
                }
                $ids[$label] = $id;
            }
        }
        if (!get_option(SLN_Settings::KEY)) {
            if (isset($ids['thankyou'])) {
                $data['settings']['thankyou'] = $ids['thankyou'];
            }
            if (isset($ids['booking'])) {
                $data['settings']['booking'] = $ids['booking'];
                $data['settings']['pay'] = $ids['pay'];
            }

            update_option(SLN_Settings::KEY, $data['settings']);
        }

        new SLN_UserRole_SalonStaff(SLN_Plugin::getInstance(), SLN_Plugin::USER_ROLE_STAFF, __('Salon staff', 'salon-booking-system'));
        new SLN_UserRole_SalonCustomer(SLN_Plugin::getInstance(), SLN_Plugin::USER_ROLE_CUSTOMER, __('Salon customer', 'salon-booking-system'));
    }

    private static function update()
    {
        $current_version = SLN_Plugin::getInstance()->getSettings()->getDbVersion();

        $updates = self::getDbUpdates();
        ksort($updates);
        foreach ($updates as $version => $updater) {
            if (version_compare($current_version, $version, '<')) {
                include($updater);
                SLN_Plugin::getInstance()->getSettings()->setDbVersion($version)->save();
            }
        }

        SLN_Plugin::getInstance()->getSettings()->setDbVersion()->save();
    }

    private static function rollback()
    {
        $current_version = SLN_Plugin::getInstance()->getSettings()->getDbVersion();

        $rollbacks = self::getDbRollbacks();
        krsort($rollbacks);
        foreach ($rollbacks as $version => $rollback) {
            if (version_compare($current_version, $version, '>=')) {
                if (preg_match('/sln-rollback-to-(\d+[\.\d+]*).php$/', $rollback, $matches)) {
                    $versionToRollback = $matches[1];
                    include($rollback);
                    SLN_Plugin::getInstance()->getSettings()->setDbVersion($versionToRollback)->save();
                    break;
                }
            }
        }
    }

    private static function checkPost($title, $post_type)
    {
        return get_page_by_title($title, null, $post_type) ? true : false;
    }
}
