<?php

namespace DevOwl\RealCookieBanner\Vendor;

if (!\class_exists('DevOwl\\RealCookieBanner\\Vendor\\Puc_v4p10_DebugBar_PluginExtension', \false)) {
    class Puc_v4p10_DebugBar_PluginExtension extends \DevOwl\RealCookieBanner\Vendor\Puc_v4p10_DebugBar_Extension {
        /** @var Puc_v4p10_Plugin_UpdateChecker */
        protected $updateChecker;
        public function __construct($updateChecker) {
            parent::__construct($updateChecker, 'Puc_v4p10_DebugBar_PluginPanel');
            \add_action('wp_ajax_puc_v4_debug_request_info', [$this, 'ajaxRequestInfo']);
        }
        /**
         * Request plugin info and output it.
         */
        public function ajaxRequestInfo() {
            if ($_POST['uid'] !== $this->updateChecker->getUniqueName('uid')) {
                return;
            }
            $this->preAjaxRequest();
            $info = $this->updateChecker->requestInfo();
            if ($info !== null) {
                echo 'Successfully retrieved plugin info from the metadata URL:';
                echo '<pre>', \htmlentities(\print_r($info, \true)), '</pre>';
            } else {
                echo 'Failed to retrieve plugin info from the metadata URL.';
            }
            exit();
        }
    }
}
