<?php

namespace DevOwl\RealCookieBanner\import;

use DevOwl\RealCookieBanner\settings\CookieGroup;
use DevOwl\RealCookieBanner\settings\General;
use DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign;
use WP_Error;
use WP_Post;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Trait to handle messages output.
 */
trait ImportMessages {
    /**
     * A top-level cookie type has incorrect scheme.
     *
     * @param string $type
     */
    protected function addMessageWrongUsageKey($type) {
        // translators:
        $this->addMessage(\sprintf(__('Please provide a valid <code>%s</code> key.', RCB_TD), $type), 'error');
    }
    /**
     * A type definition is incorrect.
     *
     * @param int $index
     * @param string $type
     * @param string $properties
     */
    protected function addMessageMissingProperties($index, $type, $properties) {
        $this->addMessage(
            \sprintf(
                // translators:
                __(
                    'The %1$s with index <code>%2$d</code> is missing. Required properties: <code>%3$s</code>. Skipped.',
                    RCB_TD
                ),
                $type,
                $index,
                $properties
            ),
            'error'
        );
    }
    /**
     * `wp_insert_post` failed for given type.
     *
     * @param string $post_title
     * @param string $type
     * @param WP_Error $error
     */
    protected function addMessageCreateFailure($post_title, $type, $error) {
        $this->addMessage(
            \sprintf(
                // translators:
                __(
                    '%1$s <strong>%2$s</strong> could not be created due to the following error: <code>%3$s</code>. Skipped.',
                    RCB_TD
                ),
                $type,
                $post_title,
                $error->get_error_message()
            ),
            'error'
        );
    }
    /**
     * Add message for non-associated cookies.
     *
     * @param int $countCookies
     * @param int $associatedCountCookies
     * @param string $post_title
     * @param int $blockerId
     */
    protected function probablyAddMessageBlockerCookieAssociation(
        $countCookies,
        $associatedCountCookies,
        $post_title,
        $blockerId
    ) {
        if ($countCookies !== $associatedCountCookies) {
            $this->addMessage(
                \sprintf(
                    // translators:
                    __(
                        'The new created content blocker <code>%s</code> could not correctly resolve the associated cookies.',
                        RCB_TD
                    ),
                    $post_title
                ),
                'warning',
                'blocker',
                ['blocker' => $blockerId]
            );
        }
    }
    /**
     * The cookie got not created because already exists.
     *
     * @param string $post_name
     */
    protected function addMessageSkipExistingCookie($post_name) {
        $this->addMessage(
            \sprintf(
                // translators:
                __('The cookie <code>%s</code> already exists. Skipped.', RCB_TD),
                $post_name
            ),
            'info'
        );
    }
    /**
     * The content blocker got not created because already exists.
     *
     * @param string $post_name
     */
    protected function addMessageSkipExistingBlocker($post_name) {
        $this->addMessage(
            \sprintf(
                // translators:
                __('The content blocker <code>%s</code> already exists. Skipped.', RCB_TD),
                $post_name
            ),
            'info'
        );
    }
    /**
     * The content blocker got duplicated.
     *
     * @param boolean|WP_Post $found
     * @param string $post_name
     * @param int $original
     * @param int $duplicate
     */
    protected function probablyAddMessageDuplicateBlocker($found, $post_name, $original, $duplicate) {
        if ($found === \false) {
            return;
        }
        // Add a message when a duplicate got created
        $this->addMessage(
            \sprintf(
                // translators:
                __(
                    'The content blocker <code>%s</code> already exists. A new content blocker has been created anyway.',
                    RCB_TD
                ),
                $post_name
            ),
            'warning',
            'blockerDuplicate',
            ['blockerDuplicate' => ['original' => $original, 'duplicate' => $duplicate]]
        );
    }
    /**
     * The cookie got duplicated.
     *
     * @param boolean|WP_Post $found
     * @param string $post_name
     * @param int $group
     * @param int $created
     */
    protected function probablyAddMessageDuplicateCookie($found, $post_name, $group, $created) {
        if ($found === \false) {
            return;
        }
        $this->addMessage(
            \sprintf(
                // translators:
                __('The cookie <code>%s</code> already exists. A new cookie has been created anyway.', RCB_TD),
                $post_name
            ),
            'warning',
            'cookieDuplicate',
            [
                'cookieDuplicate' => [
                    'original' => [
                        get_the_terms($found['ID'], \DevOwl\RealCookieBanner\settings\CookieGroup::TAXONOMY_NAME)[0]
                            ->term_id,
                        $found['ID']
                    ],
                    'duplicate' => [$group, $created]
                ]
            ]
        );
    }
    /**
     * The cookie could not be associated to the given group, did fallback.
     *
     * @param boolean $groupNotFound
     * @param string $post_title
     * @param int $group
     * @param int $created
     */
    protected function probablyAddMessageCookieGroupNotFound($groupNotFound, $post_title, $group, $created) {
        if ($groupNotFound) {
            $this->addMessage(
                \sprintf(
                    // translators:
                    __(
                        'The new created cookie <code>%s</code> has been added to the fallback cookie group because the original cookie group could not be found.',
                        RCB_TD
                    ),
                    $post_title
                ),
                'warning',
                'cookie',
                ['cookie' => [$group, $created]]
            );
        }
    }
    /**
     * Self-explaining.
     *
     * @param string $post_title
     */
    protected function addMessageCookieLimit($post_title) {
        $this->addMessage(
            \sprintf(
                // translators:
                __(
                    'The cookie <strong>%s</strong> could not be created because it exceeded the limit of free cookies. Skipped. Please upgrade to Real Cookie Banner PRO!',
                    RCB_TD
                ),
                $post_title
            ),
            'error'
        );
    }
    /**
     * Self-explaining.
     *
     * @param string $post_title
     */
    protected function addMessageBlockerLimit($post_title) {
        $this->addMessage(
            \sprintf(
                // translators:
                __(
                    'The blocker <strong>%s</strong> could not be created because it exceeded the limit of free blockers. Skipped. Please upgrade to Real Cookie Banner PRO!',
                    RCB_TD
                ),
                $post_title
            ),
            'error'
        );
    }
    /**
     * Cookie could not be assigned to cookie.
     *
     * @param int $postId
     * @param WP_Error $error
     */
    protected function addMessageCookieAssignFailure($postId, $error) {
        $this->addMessage(
            \sprintf(
                // translators:
                __(
                    'The cookie <strong>%1$s</strong> could not be assigned to the given group due to the following error: <code>%2$s</code>. Skipped.',
                    RCB_TD
                ),
                get_the_title($postId),
                $error->get_error_message()
            ),
            'error'
        );
    }
    /**
     * Cookie group could not be updated.
     *
     * @param string $name
     * @param WP_Error $error
     */
    protected function addMessageCookieGroupUpdateFailure($name, $error) {
        $this->addMessage(
            \sprintf(
                // translators:
                __(
                    'The cookie group <strong>%1$s</strong> could not be updated due to the following error: <code>%2$s</code>. Skipped.',
                    RCB_TD
                ),
                $name,
                $error->get_error_message()
            ),
            'error'
        );
    }
    /**
     * Cookie group is not created instead it was updated.
     *
     * @param string $name
     */
    protected function addMessageCookieGroupUpdatedInfo($name) {
        $this->addMessage(
            \sprintf(
                // translators:
                __(
                    'The cookie group <strong>%s</strong> was not created. Instead, the existing one has been updated.',
                    RCB_TD
                ),
                $name
            ),
            'info'
        );
    }
    /**
     * A PRO-only setting can not be imported in lite.
     *
     * @param boolean $onlyPro
     * @param string $key
     */
    protected function probablyAddMessageSettingOnlyPro($onlyPro, $key) {
        if ($onlyPro) {
            $this->addMessage(
                \sprintf(
                    // translators:
                    __('Setting/Option <code>%s</code> can only be imported in the PRO version. Skipped.', RCB_TD),
                    $key
                ),
                'error'
            );
        }
    }
    /**
     * `update_option` failured.
     *
     * @param string $optionName
     */
    protected function addMessageUpdateOptionFailure($optionName) {
        $this->addMessage(
            \sprintf(
                // translators:
                __('Setting/Option <code>%s</code> could not be updated. Skipped.', RCB_TD),
                $optionName
            ),
            'error'
        );
    }
    /**
     * Option not related to RCB.
     *
     * @param string $key
     */
    protected function addMessageOptionOutdated($key) {
        $this->addMessage(
            \sprintf(
                // translators:
                __('Settings/Option <code>%s</code> not found or obsolete. Skipped.', RCB_TD),
                $key
            ),
            'error'
        );
    }
    /**
     * An option relates to a page ID, it can never be imported.
     *
     * @param string $name
     * @param string $key
     */
    protected function addMessageOptionRelatesPageId($name, $key) {
        $this->addMessage(
            \sprintf(
                // translators:
                __(
                    'Setting/Option <strong>%1$s</strong> (key <code>%2$s</code>) cannot be imported because it refers to a page (ID). Skipped.',
                    RCB_TD
                ),
                $name,
                $key
            ),
            'warning',
            'settings',
            ['settingsTab' => '']
        );
    }
    /**
     * An option relates to a media, it can never be imported.
     *
     * @param string $name
     * @param string $key
     */
    protected function addMessageOptionRelatesMedia($name, $key) {
        $this->addMessage(
            \sprintf(
                // translators:
                __(
                    'Setting/Option <strong>%1$s</strong> (key <code>%2$s</code>) cannot be imported because it refers to a media URL/ID. Skipped.',
                    RCB_TD
                ),
                $name,
                $key
            ),
            'warning',
            'link',
            [
                'href' => admin_url(
                    '/customize.php?autofocus[control]=' .
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::HEADLINE_LOGO
                )
            ]
        );
    }
    /**
     * Multisite options can not be imported due to reference issues.
     *
     * @param string $name
     * @param string $key
     */
    protected function addMessageOptionMultisite($name, $key) {
        $this->addMessage(
            \sprintf(
                // translators:
                __('Setting/Option <strong>%1$s</strong> (key <code>%2$s</code>) cannot be imported. Skipped.', RCB_TD),
                $name,
                $key
            ),
            'warning',
            'settings',
            ['settingsTab' => 'multisite']
        );
    }
}
