<?php

namespace DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\controls;

use WP_Customize_Control;
use WP_Customize_Manager;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Provide a TinyMCE in customizer.
 *
 * @see https://wordpress.stackexchange.com/a/274333/83335
 */
class TinyMCE extends \WP_Customize_Control {
    /**
     * C'tor.
     *
     * @param WP_Customize_Manager $manager
     * @param string $id
     * @param array $options
     */
    function __construct($manager, $id, $options) {
        parent::__construct($manager, $id, $options);
        // An identifier for all available TinyMCE instances
        global $num_customizer_teenies_initiated;
        $num_customizer_teenies_initiated = empty($num_customizer_teenies_initiated)
            ? 1
            : $num_customizer_teenies_initiated + 1;
    }
    /**
     * Render TinyMCE editor.
     */
    function render_content() {
        global $num_customizer_teenies_initiated, $num_customizer_teenies_rendered;
        $num_customizer_teenies_rendered = empty($num_customizer_teenies_rendered)
            ? 1
            : $num_customizer_teenies_rendered + 1;
        $value = $this->value();
        echo '<label>';
        \printf(
            '<label for="_customize-input-%s" class="customize-control-title customize-text_editor">%s</label>',
            esc_attr($this->id),
            esc_html($this->label)
        );
        \printf('<input id="%s-link" class="wp-editor-area" type="hidden" ', $this->id);
        $this->link();
        \printf(' value="%s"', esc_textarea($value));
        wp_editor($value, $this->id, [
            'textarea_name' => $this->id,
            'media_buttons' => \false,
            'drag_drop_upload' => \false,
            'wpautop' => \false,
            'teeny' => \false,
            'quicktags' => \false,
            'textarea_rows' => 5,
            'tinymce' => [
                'forced_root_block' => \false,
                'wordpress_adv_hidden' => \false,
                'setup' => \sprintf(
                    "function (editor) {\n    var cb = function () {\n        var linkInput = document.getElementById('%1\$s-link');\n        linkInput.value = editor.getContent();\n        linkInput.dispatchEvent(new Event('change'));\n    };\n    editor.on('Change', cb);\n    editor.on('Undo', cb);\n    editor.on('Redo', cb);\n    editor.on('KeyUp', cb); // Remove this if it seems like an overkill\n\n    // Attach editor instance to DOM element\n    editor.on('init', function() {\n        jQuery(editor.container).parent().data('editor', editor);\n    });\n}",
                    $this->id
                )
            ]
        ]);
        echo '</label>';
        // Finally, enqueue all needed scripts for TinyMCE
        if ($num_customizer_teenies_rendered === $num_customizer_teenies_initiated) {
            do_action('admin_print_footer_scripts');
        }
    }
}
