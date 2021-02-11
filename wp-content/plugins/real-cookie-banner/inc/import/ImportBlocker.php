<?php

namespace DevOwl\RealCookieBanner\import;

use DevOwl\RealCookieBanner\settings\Blocker;
use DevOwl\RealCookieBanner\settings\Cookie;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Trait to handle the importer for content blocker in the `Import` class.
 */
trait ImportBlocker {
    /**
     * Import content blocker from JSON.
     *
     * @param array $blockers
     */
    protected function doImportBlocker($blockers) {
        $currentBlockers = \DevOwl\RealCookieBanner\import\Export::instance()
            ->appendBlocker()
            ->finish()['blocker'];
        $blockerStatus = $this->getBlockerStatus();
        foreach ($blockers as $index => $blocker) {
            if (!$this->handleCorruptBlocker($blocker, $index)) {
                continue;
            }
            // Collect data
            $metas = $blocker['metas'];
            $post_name = $blocker['post_name'];
            $post_content = $blocker['post_content'];
            $post_status = $blockerStatus === 'keep' ? $blocker['post_status'] : $blockerStatus;
            $post_title = $blocker['post_title'];
            $countCookies = 0;
            $associatedCountCookies = 0;
            if (\is_array($metas)) {
                // Fix meta: hosts
                if (isset($metas['hosts']) && \is_array($metas['hosts'])) {
                    $metas['hosts'] = \join("\n", $metas['hosts']);
                }
                // Fix meta: cookies
                if (isset($metas['cookies']) && \is_array($metas['cookies'])) {
                    $countCookies = \count($metas['cookies']);
                    $metas['cookies'] = $this->correctCookieIdsForBlocker($metas['cookies']);
                    $associatedCountCookies = \count($metas['cookies']);
                    $metas['cookies'] = \join(',', $metas['cookies']);
                }
            }
            // Find current blocker with same post_name
            $found = \false;
            foreach ($currentBlockers as $currentBlocker) {
                if ($currentBlocker['post_name'] === $post_name) {
                    $found = $currentBlocker;
                    break;
                }
            }
            if ($this->isBlockerSkipExisting() && $found) {
                $this->addMessageSkipExistingBlocker($post_name);
                continue;
            }
            // Always create the entry
            $create = wp_insert_post(
                [
                    'post_type' => \DevOwl\RealCookieBanner\settings\Blocker::CPT_NAME,
                    'post_content' => $post_content,
                    'post_title' => $post_title,
                    'post_status' => $post_status,
                    'meta_input' => $metas
                ],
                \true
            );
            if (is_wp_error($create)) {
                $this->addMessageCreateFailure($post_name, __('Content Blocker', RCB_TD), $create);
                continue;
            }
            $this->probablyAddMessageDuplicateBlocker($found, $post_name, $found['ID'], $create);
            $this->probablyAddMessageBlockerCookieAssociation(
                $countCookies,
                $associatedCountCookies,
                $post_title,
                $create
            );
        }
    }
    /**
     * Check PRO limit as they get skipped on frontend, too.
     *
     * @param string $post_title
     */
    protected function handleBlockerProLimit($post_title) {
        if (!$this->isPro() && \DevOwl\RealCookieBanner\settings\Blocker::getInstance()->getAllCount() >= 1 + 4) {
            $this->addMessageBlockerLimit($post_title);
            return \false;
        }
        return \true;
    }
    /**
     * Fetch the correct cookie ids for the meta.
     *
     * @param string[] $post_names
     */
    protected function correctCookieIdsForBlocker($post_names) {
        global $wpdb;
        $result = [];
        foreach ($post_names as $post_name) {
            // Check if it is an imported cookie
            if (isset($this->mapCookies[$post_name])) {
                $result[] = $this->mapCookies[$post_name];
            } else {
                $post = $wpdb->get_var(
                    $wpdb->prepare(
                        "SELECT ID FROM {$wpdb->posts} WHERE post_name = %s AND post_type = %s",
                        $post_name,
                        \DevOwl\RealCookieBanner\settings\Cookie::CPT_NAME
                    )
                );
                if ($post) {
                    $result[] = get_post($post)->ID;
                }
            }
        }
        return \array_map('intval', $result);
    }
    /**
     * Check missing meta of passed blocker.
     *
     * @param array $blocker
     * @param int $index
     */
    protected function handleCorruptBlocker($blocker, $index) {
        if (
            !isset(
                $blocker['metas'],
                $blocker['post_name'],
                $blocker['post_content'],
                $blocker['post_status'],
                $blocker['post_title']
            )
        ) {
            $this->addMessageMissingProperties(
                $index,
                __('Content Blocker', RCB_TD),
                'ID, metas, post_content, post_name, post_status, post_title'
            );
            return \false;
        }
        return \true;
    }
}
