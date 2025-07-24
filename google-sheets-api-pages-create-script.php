<?php
/*run ?import_pages=1*/
add_action('admin_init', function () {

    if (!is_admin() || !current_user_can('administrator') || !isset($_GET['import_pages'])) return;

    $id = '11FBYkJZZRUtREPV4A1l_msrD3fb7JsXcnBYapp_QLYQ';
    $gid = "972433532";
    $url = "https://docs.google.com/spreadsheets/d/$id/gviz/tq?tqx=out:json&gid=$gid";

    $json = file_get_contents($url);
    if ($json === false) {
        error_log("[Page Import] ❌ Ошибка загрузки данных из Google Sheets: $url");
        return;
    }

    $jsonTrimmed = substr($json, 47, -2);
    $data = json_decode($jsonTrimmed, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        error_log("[Page Import] ❌ Ошибка JSON: " . json_last_error_msg());
        return;
    }

    $rows = $data['table']['rows'] ?? [];
    $columns = $data['table']['cols'] ?? [];

    $headers = [];
    foreach ($columns as $index => $col) {
        $header_label = $col['label'] ?? "Column_$index";
        $headers[] = $header_label;
        error_log("[Page Import] 📌 Column_$index => $header_label");
    }

    $parsed_rows = [];
    foreach ($rows as $row) {
        $rowData = [];
        foreach ($row['c'] as $index => $cell) {
            $rowData[$headers[$index]] = $cell['v'] ?? null;
        }
        if (array_filter($rowData)) {
            $parsed_rows[] = $rowData;
        }
    }

    error_log("[Page Import] 📋 Начинаем импорт " . count($parsed_rows) . " строк...");

    foreach ($parsed_rows as $row) {
        $page_title = trim($row['Column_8'] ?? '');
        $page_content = trim($row['Column_9'] ?? '');
        $meta_title = trim($row['Column_5'] ?? '');
        $meta_description = trim($row['Column_6'] ?? '');

        if (!$page_title) continue;

        $existing = get_page_by_title($page_title, OBJECT, 'page');

        $postarr = [
            'post_title'   => $page_title,
            'post_content' => $page_content,
            'post_status'  => 'publish',
            'post_type'    => 'page',
        ];

        if ($existing) {
            $postarr['ID'] = $existing->ID;
            wp_update_post($postarr);
            error_log("[Page Import] 🔄 Обновлена страница: $page_title");
        } else {
            $page_id = wp_insert_post($postarr);
            error_log("[Page Import] 🆕 Создана страница: $page_title");
        }

        $target_id = $existing->ID ?? $page_id;

        if (!empty($meta_title)) {
            update_post_meta($target_id, 'rank_math_title', $meta_title);
        }
        if (!empty($meta_description)) {
            update_post_meta($target_id, 'rank_math_description', $meta_description);
        }
    }

    error_log("[Page Import] 🎉 Импорт завершен.");
});

?>