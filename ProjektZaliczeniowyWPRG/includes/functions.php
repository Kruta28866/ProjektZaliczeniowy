<?php
function render_template($template_path, $data) {
    $template = file_get_contents($template_path);

    foreach ($data as $key => $value) {
        if (is_array($value)) {
            $section_start = '{{#' . $key . '}}';
            $section_end = '{{/' . $key . '}}';
            if (strpos($template, $section_start) !== false) {
                $section_content = get_string_between($template, $section_start, $section_end);
                $rendered_section = '';

                foreach ($value as $nested_data) {
                    $rendered_section .= render_template_from_string($section_content, $nested_data);
                }

                $template = str_replace($section_start . $section_content . $section_end, $rendered_section, $template);
            }
        } else {
            $template = str_replace('{{' . $key . '}}', htmlspecialchars($value), $template);
        }
    }

    return $template;
}

function get_string_between($string, $start, $end) {
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}

function render_template_from_string($template_string, $data) {
    foreach ($data as $key => $value) {
        if (is_array($value)) {
            // handle nested arrays if necessary
        } else {
            $template_string = str_replace('{{' . $key . '}}', htmlspecialchars($value), $template_string);
        }
    }

    return $template_string;
}

?>