<?php
/*XLSX*/
    $_['xlsx_sheet_name_products'] = 'Товары';
    $_['xlsx_sheet_name_categories'] = 'Категории';
    $_['xlsx_sheet_name_attribute_groups'] = 'Группы атрибутов';
    $_['xlsx_sheet_name_attributes'] = 'Атрибуты';
    $_['xlsx_sheet_name_options'] = 'Опции';
    $_['xlsx_sheet_name_option_values'] = 'Значения опции';
    $_['xlsx_sheet_name_manufacturers'] = 'Производители';
    $_['xlsx_sheet_name_filter_groups'] = 'Группы фильтра';
    $_['xlsx_sheet_name_filters'] = 'Фильтры';
    $_['xlsx_sheet_name_customer_groups'] = 'Группы покупателей';
    $_['xlsx_sheet_name_customers'] = 'Покупатели';
    $_['xlsx_sheet_name_addresses'] = 'Адреса';
    $_['xlsx_sheet_name_orders'] = 'Заказы';

    $_['xlsx_error_max_character_by_cell'] = '<b>ОШИБКА</b>: Попытка добавить значение, превышающее максимально допустимое количество символов в ячейке (32,767). Таблица <b>%s</b> - Поле: "<b>%s</b>". Используйте другой формат экспорта или уменьшите границы поля.';
    $_['xlsx_error_max_character_by_cell_2'] = '<b>ОШИБКА</b>: Попытка добавить значение, превышающее максимально допустимое количество символов в ячейке (32,767). Используйте другой формат экспорта или уменьшите границы поля. Поле <b>%s</b> - Содержание: "<b>%s</b>".';
/*END XLSX*/

/*Google Spreadsheets*/
    $_['google_spreadsheet_error_token'] = '<b>Ошибка:</b> Невозможно получить учетные данные, убедитесь, что соответствующий .json файл загружен.';
    $_['google_spreadsheet_error_empty_filename'] = '<b>Ошибка:</b> Имя таблицы не заполнено, перейдите в настройки профиля и заполните имя таблицы.';
    $_['google_spreadsheet_sending_data'] = 'Отправка данных в таблицу Google...';
    $_['google_spreadsheet_export_finished'] = 'Отправлены данные в таблицу "<b>%s</b>"';
/*Google Spreadsheets*/

/*Export*/
    $_['progress_export_preparing_to_download'] = 'Подготовка файла для загрузки...';
    $_['progress_export_finished'] = 'Экспорт завершен';
    $_['progress_export_copying_file_to_destiny'] = 'Копирование файла по заданному пути...';
    $_['progress_export_empty_internal_server_path'] = 'Путь для сохранения файла пуст.';
    $_['progress_export_file_copied'] = 'Завершено: файл скопирован в <b>%s</b>';
    $_['progress_export_ftp_error_connection'] = 'Ошибка создания FTP соединения. Проверьте FTP сервер.';
    $_['progress_export_ftp_error_login'] = 'Ошибка авторизации при FTP соединении. Проверьте имя пользователя и пароль.';
    $_['progress_export_ftp_empty_filename'] = '<b>Ошибка:</b> Пустое имя файла. Загрузка по FTP не может быть завершена.';
    $_['progress_export_ftp_error_uploaded'] = 'Ошибка загрузки файла в <b>%s</b>';
    $_['progress_export_ftp_file_uploaded'] = 'Файл загружен в <b>%s</b>';
    $_['progress_export_inserting_sheet_data'] = 'Вставка данных из "<b>%s</b>"...';
/*END Export*/

/*Import*/
    $_['progress_import_error_empty_file'] = '<b>Ошибка:</b> Загрузите файл перед запуском импорта по выбранному профилю.';
    $_['progress_import_error_extension'] = '<b>Ошибка:</b> Расширение файла, указанное в настройках профиля - <b>.%s</b>, файл, который Вы пытаетесь импортировать с расширением - <b>.%s</b>.';
    $_['progress_import_error_file_url_empty'] = '<b>Ошибка:</b> Не найдена ссылка на файл, отредактируйте профиль для получения файла по ссылке.';
    $_['progress_import_reading_rows'] = 'Обработанных строк <b>%s</b>';
    $_['progress_import_error_columns_spaces'] = 'Следующие номера колонок содержат пробелы в имени, удалите пробелы в имени или колонки целиком и повторите процесс импорта еще раз: <b>%s</b>';
/*END Import*/
?>