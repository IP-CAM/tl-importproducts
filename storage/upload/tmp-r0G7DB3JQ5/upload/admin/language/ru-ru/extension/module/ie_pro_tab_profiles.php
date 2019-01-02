<?php
$_['profile_start_to_work'] = 'Для начала работы, создайте свой первый профиль во вкладке "<b>%sProfiles%s</b>".';
$_['profile_legend_text'] = 'Управление профилями - загрузите профиль или создайте новый';
$_['profile_select_text'] = 'Загрузить профиль';
$_['profile_or'] = 'ИЛИ';
$_['profile_select_prefix_import'] = 'Импорт';
$_['profile_select_prefix_export'] = 'Экспорт';
$_['profile_select_text_empty'] = ' - Выбрать профиль - ';
$_['profile_create_text'] = 'Создать профиль';
$_['profile_create_import_text'] = 'Нажмите чтобы создать <b>профиль для импорта</b>';
$_['profile_create_export_text'] = 'Нажмите чтобы создать <b>профиль для экспорта</b>';
$_['profile_i_want_products'] = 'Товары';
$_['profile_i_want_specials'] = 'Акции';
$_['profile_i_want_discounts'] = 'Скидки';
$_['profile_i_want_categories'] = 'Категории';
$_['profile_i_want_attribute_groups'] = 'Группы атрибутов';
$_['profile_i_want_attributes'] = 'Атрибуты';
$_['profile_i_want_options'] = 'Опции';
$_['profile_i_want_option_values'] = 'Значения опций';
$_['profile_i_want_manufacturers'] = 'Производители';
$_['profile_i_want_filter_groups'] = 'Группы фильтров';
$_['profile_i_want_filters'] = 'Фильтры';
$_['profile_i_want_customer_groups'] = 'Группы покупатели';
$_['profile_i_want_customers'] = 'Покупатели';
$_['profile_i_want_addresses'] = 'Адреса';
$_['profile_i_want_orders'] = 'Заказы';
$_['profile_i_want_coupons'] = 'Купоны';
$_['profile_legend_text_import'] = 'Настройка профиля импорта';
$_['profile_legend_text_export'] = 'Настройка профиля экспорта';
$_['profile_save_configuration_import'] = 'Сохранить профиль для импорта';
$_['profile_delete_configuration_import'] = 'Удалить профиль для импорта';
$_['profile_save_configuration_export'] = 'Сохранить профиль для экспорта';
$_['profile_delete_configuration_export'] = 'Удалить профиль для экспорта';
$_['profile_import_file_format'] = 'Формат файла';
$_['profile_import_file_origin'] = 'Способ загрузки файла';
$_['profile_import_file_origin_manual'] = 'Локальная загрузка с компьютера';
$_['profile_import_file_origin_ftp'] = 'Загрузка с удаленного сервера';
$_['profile_import_file_origin_url'] = 'Загрузка по ссылке';
$_['profile_import_file_destiny'] = 'Действие с фалом';
$_['profile_import_file_download'] = 'Скачать с помощью браузера';
$_['profile_import_file_destiny_server'] = 'Сохранить на этом сервере';
$_['profile_import_file_destiny_server_path'] = 'Путь для сохранения';
$_['profile_import_file_destiny_server_path_remodal_link'] = '<b>ВАЖНО</b>: подробнее о путях сохранения фалов';
$_['profile_import_file_destiny_server_path_remodal_title'] = 'Путь для сохранения';
$_['profile_import_file_destiny_server_path_remodal_description'] = 'Корневая папка Вашего магазина OpenCart <b>%s</b>. Ниже несколько примеров указания правильного формата пути для сохранения файла:
           <ol>
                <li><b>Сохранить файл в корневой папке Вашего магазина: </b>%s</li>
                <li><b>Сохранить файл в папку "export_products", в корневой папке Вашего магазина: </b>%sexport_products/</li>
                <li><b>Сохранить файл в папку по пути "export_products/category_cars/", в корневой папке Вашего магазина: </b>%sexport_products/category_cars/</li>
                <li><b>Сохранить файл за пределами корневой папки магазина (например, так): </b>%s</li>
           </ol>';
$_['profile_import_file_destiny_server_file_name'] = 'Имя файла';
$_['profile_import_file_destiny_server_file_name_help'] = 'Расширение указывать не нужно! (например: products.xlsx - НЕ ПРАВИЛЬНО; products - ПРАВИЛЬНО!)';
$_['profile_import_file_destiny_server_file_name_sufix'] = 'Шаблон имени файла';
$_['profile_import_file_destiny_server_file_name_sufix_none'] = 'Без шаблона (файл будет перезаписан)';
$_['profile_import_file_destiny_server_file_name_sufix_date'] = 'Дата экспорта. Пример "-2019-01-31.xlsx"';
$_['profile_import_file_destiny_server_file_name_sufix_datetime'] = 'Дата и время экспорта. Пример "-2019-01-31-1035.xlsx"';
$_['profile_import_file_destiny_external_server'] = 'Сохранить на удаленном сервере';
$_['profile_i_want'] = 'Элементы';
$_['profile_import_csv_separator'] = 'Разделитель CSV';
$_['profile_import_csv_separator_help'] = 'Если вы используете пустой файл, то будет использован разделитель по-умолчанию (запятая).';
$_['profile_import_xml_node'] = 'Элемент XML node';
$_['profile_import_xml_node_help'] = 'Элемент XML node';
$_['profile_import_xml_node_link'] = 'Подробнее о XML nodes';
$_['profile_import_xml_node_remodal_title'] = 'XML Node';
$_['profile_import_xml_node_remodal_description'] = '<p>Представьте, что Вам нужно импортировать подобный XML файл:</p><img style="width: 630px;" src="%s"><br><br>
	    <p>В случае с XML элементы пути до файла разделяются символом ">", не должны содержать пробелов. а так же чувствительны к регистру.</p>
	    <p>Например, путь до файла может выглядеть так:: "<b>yml_catalog>shop>offers>offer</b>"</p>
	    <p>После этого, в разделе "колонки", озаглавить колонки, с которыми Вы хотите работать и отключить те, которые вам не нужны.</p><img style="width: 630px;" src="%s">';
$_['profile_import_spreadsheet_name'] = 'Имя таблицы Google';
$_['profile_import_spreadsheet_name_help'] = 'Помните, что структура и форматы загружаемого файла должны соответствовать файлам экспорта из профилей.';
$_['profile_import_spreadsheet_remodal_title'] = 'Настройка Google Drive API';
$_['profile_import_spreadsheet_remodal_description'] = '        <h3>1. Создание файла .json с параметрами доступа в Google API</h3>
        <p>По умолчанию любая новая таблица не доступна в Google API. Чтобы это изменить Вам нужно перейти в консоль Google API, создать новый проект и настроить его для получения данных таблиц.</p>
        <ol>
            <li>Перейдите в <a href="https://console.developers.google.com/" taget="_blank">консоль Google API</a>.</li>
            <li>Создайте новый проект.</li>
            <li>Нажмите кнопку Включить API. В строке поиска найдите сервис Google Drive API и активируйте его.</li>
            <li>Создайте учетные данные, чтобы использовать Google Drive API, нажав кнопку "Создать". В добавлении учетных данных, на вопрос "Какой API Вы используете?" - выберете "Google Drive API". Следующий вопрос "Откуда вы будете вызывать API?" - выберете ""Веб-сервер (например, node.js или Tomcat). На последний вопрос о типе данных, к которым Вы будете обращаться, нужно ответить "Данные приложения". На появившейся после этого вопрос о дальнейшем использовании данного API отвечаем "Нет".</li>
            <li>Дайте имя сервисному аккаунту, а в качестве роли выберете "Редактор". Тип ключа - JSON.</li>
            <li>После нажатия кнопки "Продолжить" появится окно загрузки файла с учетными данными. Сохраните его на Ваш компьютер.</li>
        </ol>
        <img style="margin-bottom: 15px;" src="%s">
        <h3>2. Загрузка полученного файла .json с учетными данными</h3>%s
        </br>
        <h3>3. Доступ к файлам в "Сервисе идентификации аккаунта"</h3>
        <p>Для работы с файлами таблиц, сохраненных в корневой папке Google диска, Вам нужно открыть доступ к файлу в "Сервисе идентификации аккаунта", для этого сервисного ключа: <b>%s</b></p>
        
	';
$_['profile_import_spreadsheet_remodal_link'] = '<b>ВАЖНО: Подробнее о настройке Google Drive API</b>';
$_['profile_import_spreadsheet_remodal_json_uploaded'] = 'Файл успешно загружен! Страница будет перезагружена через несколько секунд.';
$_['profile_import_spreadsheet_remodal_json_error_extension'] = '<b>Ошибка:</b> Выберете корректный <b>.json</b> файл в <b>шаге 2</b>.';
$_['profile_import_spreadsheet_remodal_json_error_uploading'] = '<b>Ошибка:</b> Файл не может быть загружен.';
$_['profile_import_spreadsheet_remodal_json_client_id_not_file'] = 'появится после загрузки файла с учетными данными .json.';
$_['profile_import_spreadsheet_remodal_json_client_id_not_found'] = 'Учетные данные не найдены, загрузите файл .json еще раз.';
$_['profile_import_url'] = 'Ссылка';
$_['profile_import_ftp_host'] = 'FTP - сервер';
$_['profile_import_ftp_username'] = 'FTP - пользователь';
$_['profile_import_ftp_password'] = 'FTP - пароль';
$_['profile_import_ftp_port'] = 'FTP - порт';
$_['profile_import_ftp_port_help'] = 'По умолчанию, обычно, используется 21-й порт';
$_['profile_import_ftp_path'] = 'FTP - путь к файлу';
$_['profile_import_ftp_path_help'] = 'Пример пути к файлу: /httpdocs/myfiles/';
$_['profile_import_ftp_file'] = 'FTP - имя файла';
$_['profile_import_ftp_file_help'] = 'Указать имя файла без расширения. (.xlsx не нужно)';
$_['profile_import_products_legend'] = 'Основные настройки колонок для товаров';
$_['profile_import_products_strict_update'] = 'Строгое обновление';
$_['profile_import_products_strict_update_link'] = '<b>ВАЖНО</b>: узнать подробнее';
$_['profile_import_products_strict_update_help'] = '	    <p>Если этот параметр включен, перед обновлением <b>ВСЕ ДАННЫЕ О ТОВАРАХ БУДУТ ОЧИЩЕНЫ</b>.</p>
	    <p>Важно чтобы Вы <b>включили все колонки</b>, если хотите избежать потери всех данных после импорта.</p>
	    <p>Этот параметр может быть использован в следующих случаях:
		    <ol>
		    	<li>Вы хотите сделать массовое обновление всего каталога или хотите удалить все данные о товарах из каталога</li>
		        <li>Ваш поставщик часто предоставляет измененные данные о товарах, приходится удалять или добавлять данные о товарах</li>
		    </ol>
		</p>
		<p><b>Пример</b>: представьте, что Вам необходимо сохранить только 2 и 5 дополнительное изображение товара и полученный результат сохранить в каталог магазина (смотрите скриншот файла excel, изображения, которые Вы хотите оставить отмечены зеленым).</p>
	    <img style="width: 605px;" src="%s">
	    <br><br>
	    <p>Изначально в данном товаре было 5 дополнительных изображений:
		    <ol>
		        <li>catalog/image1.jpg</li>
		        <li>catalog/image2.jpg</li>
		        <li>catalog/image3.jpg</li>
		        <li>catalog/image4.jpg</li>
		        <li>catalog/image5.jpg</li>
		    </ol>
	    </p>
	    <p>Мы удалили (красные) изображения и переместили (зеленые) изображения в первую колонку, а так же добавили новые, отмеченные (пурпурным), в результате получилось:</p>
	    <img style="width: 605px;" src="%s">
	    <br><br>
	    <p>При включенном "<b>Строгом обновлении</b>", после импорта нашего excel файла, часть изображений удалены, остались только 2 и 5, а также добавилось 6:</p>
	    <ol>
	        <li>catalog/image2.jpg</li>
	        <li>catalog/image5.jpg</li>
	        <li>catalog/image6.jpg</li>
	    </ol>
	    <p>В случае если Вам нужно <b>УДАЛИТЬ ВСЕ СВЯЗАННЫЕ С ТОВАРАМИ ДАННЫЕ (ИЗОБРАЖЕНИЯ)</b>, просто оставьте пустыми соответствующие колонки, относящиеся к изображениям, в нашем случае:</p>
	    <img style="width: 605px;" src="%s">
	    <br><br>
	    <p>При включенном  "<b>Строгом обновлении</b>", после импорта excel файла, все изображения у товара будут удалены.</p>
	';
$_['profile_import_products_multilanguage'] = 'Мульти язык';
$_['profile_import_products_multilanguage_help'] = '	    <p>Если этот параметр включен, то все колонки, которые есть для нескольких языков, будут продублированы.</p>
	    <p>Пример колонок, если "Мульти язык" <b>ВЫКЛЮЧЕН</b>:
	        <ul>
	            <li>Имя</li>
	            <li>Описание</li>
	            <li>Meta описание</li>
	            <li>Meta заголовок</li>
	            <li>...</li>
	        </ul>
	    </p>
	    <p>* Если у Вас установлен более чем 1 язык для магазина и данный параметр выключен, то данные из колонок для других языков, будут продублированы автоматически.</p>
	    <p>Пример колонок, если "Мульти язык" <b>ВКЛЮЧЕН</b>:
	    <ul>
	        <li>Имя en-gb</li>
	        <li>Имя nl-nl</li>
	        <li>Описание en-gb</li>
	        <li>Описание nl-nl</li>
	        <li>Meta описание en-gb</li>
	        <li>Meta описание nl-nl</li>
	        <li>Meta заголовок en-gb</li>
	        <li>Meta заголовок nl-nl</li>
	        <li>...</li>
	    </ul>
	';
$_['profile_import_products_category_tree'] = 'Дерево категорий';
$_['profile_import_products_profile_cat_tree_remodal_title'] = 'Дерево категорий';
$_['profile_import_products_profile_cat_tree_remodal_description'] = '    <p><b>Дерево категорий ОТКЛЮЧЕНО</b>: Отключите, если Вы не планируете использовать дерево категорий или хотите назначить собственные категории для продуктов
    <br>
    Excel пример (колонки помечены красным):</p>
    <img style="width: 605px;" src="%s">
    <br><br>
    <p><b>Дерево категорий ВКЛЮЧЕНО</b>: Включите, если хотите использовать дерево категорий для товаров.
    <br>
    Excel пример (колонки помечены красным, строки первой ветки - желтым, второй - голубым):</p>
    <img style="width: 605px;" src="%s">
';
$_['profile_import_products_profile_cat_tree_link_title'] = '<b>ВАЖНО</b>: узнать подробнее';
$_['profile_import_products_category_tree_last_child'] = 'Приоритет последней категории';
$_['profile_import_products_category_tree_last_child_modal_title'] = 'Приоритет последней категории';
$_['profile_import_products_category_tree_last_child_modal_description'] = '    <p>Результат работы если параметр <b>ВЫКЛЮЧЕН</b>:</p><img style="width: 260px;" src="%s">
    <br><br>
    <p>В итоговом файле будут представлены в том числе и промежуточные категории, к которым может относиться товар</p>
    <br><br>
    <p>Результат работы если параметр <b>ВКЛЮЧЕН</b>:</p><img style="width: 260px;" src="%s">
    <br><br>
    <p>В итоговом файле будет представлена только одна полная ветка, с указанием конечной категории, к которой относится товар.</p>
';
$_['profile_import_products_rest_tax'] = 'Вычесть налоги из цен';
$_['profile_import_products_rest_tax_remodal_title'] = 'Вычесть налоги из цен';
$_['profile_import_products_rest_tax_remodal_description'] = '    <p><b>Импорт:</b> Если у товара есть налоговый класс, то это значение будет вычтено из цены товара ВО ВРЕМЯ ЕГО СОЗДАНИЯ. Это может быть полезно, если в полученных от поставщика прайсах цены на товары указаны <b>с налогами</b>, а Вы хотите импортировать цены <b>без налогов</b>.</p>
    <p><b>Экспорт:</b> Если у товара есть налоговый класс, то это значение будет <b>вычтено из цены товара</b>. Это может быть полезно в том случае, если цены в Вашем каталоге указаны с учетом налогов, а в результате экспорта Вы хотели бы получить цены без учета налогов.</p>
';
$_['profile_import_products_rest_tax_link_title'] = '<b>ВАЖНО</b>: узнать подробнее';
$_['profile_import_products_sum_tax'] = 'Добавить налоги к цене';
$_['profile_import_products_sum_tax_remodal_title'] = 'Добавить налоги к цене';
$_['profile_import_products_sum_tax_remodal_description'] = '    <p><b>Импорт:</b> Если у товара есть налоговый класс, то это значение будет добавлено к цене товара ВО ВРЕМЯ ЕГО СОЗДАНИЯ. Это может быть полезно, если в полученных от поставщика прайсах цены на товары указаны <b>без  налогов</b>, а Вы хотите импортировать цены <b>с налогами</b>.</p>
    <p><b>Экспорт:</b> Если у товара есть налоговый класс, то это значение будет <b>добавлено к цене. Это может быть полезно в том случае, если в результате экспорта Вам необходимы цены с учетом налоговых ставок.</p>
';
$_['profile_import_products_sum_tax_link_title'] = '<b>ВАЖНО</b>: узнать подробнее';
$_['profile_import_products_data_related_legend'] = 'Дополнительные настройки колонок для товаров';
$_['profile_import_cat_number'] = 'Количество категорий';
$_['profile_cat_number_remodal_title'] = 'Количество категорий';
$_['profile_cat_number_remodal_description'] = '    <p>Данный параметр регулирует количество категорий, которые будут отображаться в соответствующих "<b>Колонках категорий</b>". Это так называемая глубина сканирования. Т.е., если в поле, к примеру,  указано число <b><u>3</u></b>, то это означает, что будет выгружено только 3 категории, к которым относится товар - "<b>количество категорий</b>" (колонки на картинке отмечены красным). Пример, товар относится к 5 категориям, если в данном параметре выставлено 3, то в файл попадут только 3 первых категории, а остальные будут проигнорированы. Рекомендуется указывать значение данного параметра не менее максимального количества категорий, к которой может относится товар.</p>
    <img style="width: 605px;" src="%s">
';
$_['profile_cat_number_link'] = '<b>ВАЖНО</b>: узнать подробнее';
$_['profile_cat_tree_number_parent'] = 'Количество родительских категорий';
$_['profile_cat_tree_number_parent_remodal_title'] = 'Количество родительских категорий';
$_['profile_cat_tree_number_parent_remodal_description'] = '    <p>Данный параметр регулирует количество <b>родительских</b> категорий, которые будут отображаться в соответствующих "<b>Колонках родительский категорий</b>". Это так называемая глубина сканирования. Т.е., если в поле, к примеру,  указано число <b><u>3</u></b>, то это означает, что будет выгружено только 3 родительские категории, к которым может относится товар - "<b>количество родительских категорий</b>" (колонки на картинке отмечены красным). Пример, товар относится к 2 родительским категориям, если в данном параметре выставлено 3, то в файл попадут 2 родительские категории, а еще одна колонка будет пустой. Рекомендуется указывать значение данного параметра не менее максимального количества родительских категорий, к которой может относится товар.<br><i>Примечание: данная настройка работает только при активном параметре "<b>Дерево категорий</b>"</i></p>
    <img style="width: 605px;" src="%s">
';
$_['profile_cat_tree_number_parent_link'] = '<b>ВАЖНО</b>: узнать подробнее';
$_['profile_cat_tree_number_children'] = 'Количество дочерних категорий';
$_['profile_cat_tree_number_children_remodal_title'] = 'Количество дочерних категорий';
$_['profile_cat_tree_number_children_remodal_description'] = '    <p>Данный параметр регулирует количество <b>дочерних</b> категорий, которые будут отображаться в соответствующих "<b>Колонках дочерних категорий</b>". Это так называемая глубина сканирования. Т.е., если в поле, к примеру,  указано число <b><u>3</u></b>, то это означает, что будет выгружено только 3 дочерние категории, к которым может относится товар - "<b>количество дочерних категорий</b>" (колонки на картинке отмечены красным). Пример, товар имеет 2 дочерние категории, если в данном параметре выставлено 3, то в файл попадут 2 дочерние категории, а еще одна колонка будет пустой. Рекомендуется указывать значение данного параметра не менее максимального количества дочерних категорий, к которой может относится товар.<br><i>Примечание: данная настройка работает только при активном параметре "<b>Дерево категорий</b>"</i></p>
    <img style="width: 605px;" src="%s">
';
$_['profile_cat_tree_number_children_link'] = '<b>ВАЖНО</b>: узнать подробнее';
$_['profile_import_image_number'] = 'Количество изображений';
$_['profile_import_image_number_remodal_title'] = 'Количество изображений';
$_['profile_import_image_number_remodal_description'] = '    <p>Данный параметр регулирует "<b>количество изображений</b>", которые попадут в файл экспорта или будут загружены в процессе импорта. Чем больше значение в данном поле, тем больше информации об изображениях у Вас получится использовать. Ниже в примере в "<b>колонках для изображений</b>" показаны файлы изображений. В примере значение данного параметра соответсвует <b><u>5</u></b>, но т.к. у товара только одно сопутствующее изображение, то оно попадает в первую колонку, а остальные колонки пусты (колонки в примере отмечены красным).</p>
    <img style="width: 605px;" src="%s">
';
$_['profile_import_image_number_link'] = '<b>ВАЖНО</b>: узнать подробнее';
$_['profile_import_attribute_number'] = 'Количество атрибутов';
$_['profile_import_attribute_number_remodal_title'] = 'Количество атрибутов';
$_['profile_import_attribute_number_remodal_description'] = '    <p>Данный параметр регулирует "<b>количество атрибутов</b>" для каждого товара, которые будут использованы в процессе экспорта или импорта. В примере ниже значение данного параметра указано <b><u>2</u></b>, поэтому в соответствующих колонках указана информация только по "<b>заданному количеству атрибутов</b>" (колонки в примере отмечены красным). Отметим, что для каждого атрибута показывается полная информация о группе, к которой он пренадлежит, наименовании, а так же значении.</p>
    <img style="width: 605px;" src="%s">
';
$_['profile_import_attribute_number_link'] = '<b>ВАЖНО</b>: узнать подробнее';
$_['profile_import_special_number'] = 'Количество акций';
$_['profile_import_special_number_remodal_title'] = 'Количество акций';
$_['profile_import_special_number_remodal_description'] = '    <p>Данный параметр регулирует "<b>количество акций</b>", которые будут присутствовать в результирующем файле. В примере ниже параметру присвоено значение <b><u>1</u></b> - это говорит о том, что в соответствующих колонках файла будет представлена полная информация об "<b>одной акции</b>" (колонки в примере отмечены красным).</p>
    <img style="width: 605px;" src="%s">
';
$_['profile_import_special_number_link'] = '<b>ВАЖНО</b>: узнать подробнее';
$_['profile_import_discount_number'] = 'Количество скидок';
$_['profile_import_discount_number_remodal_title'] = 'Количество скидок';
$_['profile_import_discount_number_remodal_description'] = '    <p>Данный параметр регулирует "<b>количество скидок</b>", которые будут присутствовать в результирующем файле. В примере ниже параметру присвоено значение <b><u>1</u></b> - это говорит о том, что в соответствующих колонках файла будет представлена полная информация об "<b>одной скидке</b>" (колонки в примере отмечены красным).</p>
    <img style="width: 605px;" src="%s">
';
$_['profile_import_discount_number_link'] = '<b>ВАЖНО</b>: узнать подробнее';
$_['profile_import_filter_group_number'] = 'Количество групп фильтров';
$_['profile_import_filter_group_number_remodal_title'] = 'Количество групп фильтров';
$_['profile_import_filter_group_number_remodal_description'] = '    <p>Данный параметр регулирует "<b>количество групп</b>", к которым могут относится те или иные фильтры. Например, может быть создано несколько групп фильтров, в примере ниже показано <b><u>3</u></b>, которые будут отражены в результирующем файле, как это показано "<b>для трех групп фильтров</b>" (колонки в примере отмечены красным).</p>
    <img style="width: 605px;" src="%s">
';
$_['profile_import_filter_group_number_link'] = '<b>ВАЖНО</b>: узнать подробнее';
$_['profile_import_filter_number'] = 'Количество фильтров для каждой группы фильтров';
$_['profile_import_filter_number_remodal_title'] = 'Количество фильтров для каждой группы фильтров';
$_['profile_import_filter_number_remodal_description'] = '    <p>Данный параметр регулирует "<b>количество фильтров для каждой группы фильтров</b>", которые будут отражены в результирующем файле. Например, для значения данного поля <b><u>1</u></b> "<b>количество фильтров для каждой группы</b>" будет распределено, как на изображении ниже (колонки в примере отмечены красным).</p>
    <img style="width: 605px;" src="%s">
';
$_['profile_import_filter_number_link'] = '<b>ВАЖНО</b>: узнать подробнее';
$_['profile_import_download_number'] = 'Количество загрузок';
$_['profile_import_download_number_remodal_title'] = 'Количество загрузок';
$_['profile_import_download_number_remodal_description'] = '    <p>Данный параметр регулирует "<b>количество загрузок</b>", которые будут отражены в результирующем файле с указание полной информации. Например, для значения данного поля <b><u>1</u></b> "<b>количество загрузок</b>" будет распределено, как на изображении ниже (колонки в примере отмечены красным).</p>
    <img style="width: 605px;" src="%s">
';
$_['profile_import_download_number_link'] = '<b>ВАЖНО</b>: узнать подробнее';
$_['profile_export_sort_order'] = 'Порядок сортировки в файле экспорта (опционально)';
$_['profile_export_sort_order_config'] = 'Порядок сортировки экспорта';
$_['profile_export_sort_order_table_field'] = 'По какой колонке сортировать';
$_['profile_export_sort_order_none'] = ' - Ничего не выбрано - ';
$_['profile_export_sort_order_order'] = 'Порядок сортировки';
$_['profile_export_sort_order_asc'] = 'По возрастанию a-z, 0-9';
$_['profile_export_sort_order_desc'] = 'По убыванию z-a, 9-0';
$_['profile_product_identificator'] = 'Идентификатор товара';
$_['profile_product_identificator_product_id'] = 'ID товара';
$_['profile_product_identificator_model'] = 'Модель товара';
$_['profile_product_identificator_sku'] = 'SKU товара';
$_['profile_product_identificator_upc'] = 'UPC товара';
$_['profile_product_identificator_ean'] = 'EAN товара';
$_['profile_product_identificator_jan'] = 'JAN товара';
$_['profile_product_identificator_isbn'] = 'ISBN товара';
$_['profile_product_identificator_mpn'] = 'MPN товара';
$_['profile_import_products_autoseo_gerator'] = 'Автоматизация ключевых слов для SEO';
$_['profile_import_products_autoseo_gerator_none'] = 'Ручной набор ключевых слов';
$_['profile_import_products_autoseo_gerator_name'] = 'Автоматическая генерация ключевых слов из имени товара';
$_['profile_import_products_autoseo_gerator_meta_title'] = 'Автоматическая генерация ключевых слов из из META заголовка товара';
$_['profile_import_products_autoseo_gerator_model'] = 'Автоматическая генерация ключевых слов из модели товара';
$_['profile_import_products_existing_products'] = 'Для существующих товаров';
$_['profile_import_products_existing_products_edit'] = 'Изменять данные';
$_['profile_import_products_existing_products_skip'] = 'Пропускать данные';
$_['profile_import_products_new_products'] = 'Для новых товаров';
$_['profile_import_products_new_products_edit'] = 'Создавать данные';
$_['profile_import_products_new_products_skip'] = 'Пропускать данные';
$_['profile_import_products_download_image_route'] = 'Путь до изображений';
$_['profile_import_products_download_image_route_remodal_title'] = 'Путь до изображений';
$_['profile_import_products_download_image_route_remodal_description'] = '    <p>Если модуль обнаруживает в стобцах "<b>изображение</b>" ссылку на него, то в процессе импорта изображение будет скачено и добавлено к соответствующему элементу.</p>
    <p>По умолчанию, Ваши изображения будут загружены и сохранены в папке "<b>%s</b>".</p>
    <p>В этом поле можно добавить папку, в которую можно будет так же сохранять изображения. Например, если Вы напишите в этом поле "<b>my_provider/cars/accesories</b>", изображения будут сохранены по пути  "<b>%smy_provider/cars/accesories</b>"</p>
';
$_['profile_import_products_download_image_route_remodal_link'] = '<b>ВАЖНО:</b> узнать подробнее';
$_['profile_products_columns'] = 'Настройка таблицы';
$_['profile_import_column_config'] = 'Колонки';
$_['profile_import_column_config_thead_clone_columns'] = 'Загрузить произвольные колонки из профиля:';
$_['profile_import_column_config_thead_select_all'] = 'Включить/Отключить все колонки';
$_['profile_import_column_config_thead_sort_order'] = 'Порядок';
$_['profile_import_column_config_thead_column'] = 'Колонка';
$_['profile_import_column_config_thead_column_custom_name'] = 'Произвольное имя колонки';
$_['profile_import_column_config_thead_column_default_value'] = 'Значение по умолчанию';
$_['columns_default_value_title'] = 'Значение по умолчанию';
$_['columns_default_value_description'] = '        <p><b>Экспорт:</b> Если Вы заполните "<b>Значение по умолчанию</b>" и эта колонка будет активна во время экспорта, модуль автоматически подставить его, если соответствующее поле будет <b>пусто</b>.</p>
        <br>
        <p><b>Импорт:</b> Если Вы заполните "<b>Значение по умолчанию</b>" и эта колонка будет активна во время импорта, модуль автоматически подставить его, если соответствующее поле будет <b>пусто или не создано</b>. Это может быть полезно если у Вас имеются прайс-листы без некоторых данных (например, категории, фильтры и т.д.).</p>
    ';
$_['columns_default_value_link'] = '  <i style="font-size: 18px:" class="fa fa-info-circle"></i>';
$_['profile_import_column_config_thead_column_extra_configuration'] = 'Дополнительная настройка';
$_['profile_column_config_extra_configuration_value_true'] = 'Значение, если ИСТИНА:';
$_['profile_column_config_extra_configuration_value_false'] = 'Значение, если ЛОЖЬ:';
$_['profile_column_config_extra_configuration_image_link'] = 'Полная ссылка на изображение:';
$_['profile_column_config_extra_configuration_names_instead_of_id'] = 'Имя вместо ID:';
$_['profile_column_config_extra_configuration_product_id_identificator'] = 'Как ID товара:';
$_['profile_column_config_extra_configuration_profit_margin'] = 'Размер прибули (%)';
$_['profile_column_config_extra_configuration_profit_margin_help'] = 'В <b><u>созданном товаре</u></b> модуль увеличит цену товара в %, согласно значению данного поля. <b><u>ТОЛЬКО ЦИФРЫ</b></u>';
$_['profile_import_column_config_thead_status'] = 'Статус';
$_['profile_products_columns_possible_values'] = 'Возможные значения';
$_['profile_products_columns_possible_values_id'] = 'ID';
$_['profile_products_columns_possible_values_name'] = 'Имя';
$_['profile_products_columns_possible_values_yes'] = 'Да';
$_['profile_products_columns_possible_values_no'] = 'Нет';
$_['profile_products_columns_possible_values_products_related'] = '<b>Модели товаров</b> разделитель "|", пример: ADTR4|ROFK8|DK8723';
$_['profile_products_columns_possible_values_stores'] = 'Если товар присутствует более чем в одном магазине, то ID магазинов следует писать через "|", например: <b>0|1|2</b>';
$_['profile_products_columns_possible_values_image_local'] = '<b>Локальное изображение</b>: путь до изображения должен начинаться с "<b>%s</b>", например "<b>%scars/tesla-model-3.jpg</b>"';
$_['profile_products_columns_possible_values_image_external'] = '<b>Удаленное изображение</b>: ссылка на изображение, например: <b>https://www.external-plataform.com/images/tesla-model-3.jpg</b>, модуль загрузет изображение по ссылке (в папку "<b>/image/%s</b>") и присвоит для Ваших элементов:
            <ul>
                <li><b>Товары</b>: "product-product-id.extension", пример: "<b>product-134.jpg</b>" (для главного изображения). "<b>product-134-1.jpg</b>" (для первого дополнительного изображения)...</li>
                <li><b>Категории</b>: "category-category-id.extension", пример: "<b>category-134.jpg</b>"</li>
                <li><b>Производители</b>: "manufacturer-manufacturer-id.extension", пример: "<b>manufacturer-134.jpg</b>"</li>
                <li><b>Option values</b>: "option-value-option-value-id.extension", пример: "<b>option-value-134.jpg</b>"</li>
            </ul>
        ';
$_['profile_categories_columns_possible_values_parent_id'] = 'ID категории';
$_['profile_categories_columns_possible_values_filters'] = 'Имена фильтров должны быть разделены символом "|" и написаны на Вашем языке по умолчанию "<b>%s</b>". Пример: Wheels|Accesories|Cars';
$_['profile_products_quick_filter'] = 'Быстрый фильтр для товаров';
$_['profile_products_quick_filter_categories'] = 'Категории';
$_['profile_products_quick_filter_categories_help'] = '(Если ничего не выбрано = Все категории) модуль сделает экспорт товаров из всех категорий или только из отмеченных.';
$_['profile_products_quick_filter_manufacturers'] = 'Производители';
$_['profile_products_quick_filter_manufacturers_help'] = '(Если ничего не выбрано = Все производители) модуль сделает экспорт товаров для всех производителей или только для отмеченных.';
$_['profile_products_filters'] = 'Настройка фильтров';
$_['profile_import_filter_config'] = 'Фильтры';
$_['profile_products_filters_add_filter'] = 'Нажмите чтобы добавить фильтр';
$_['profile_products_filters_remove_filter'] = 'Нажмите чтобы удалить фильтр';
$_['profile_products_filters_thead_field'] = 'Поле (параметр)';
$_['profile_products_filters_thead_condition'] = 'Условие';
$_['profile_products_filters_thead_value'] = 'Значение';
$_['profile_products_filters_thead_actions'] = 'Действие';
$_['profile_products_filters_conditional_contain'] = 'содержит';
$_['profile_products_filters_conditional_not_contain'] = 'НЕ содержит';
$_['profile_products_filters_conditional_is_exactly'] = 'точно';
$_['profile_products_filters_conditional_is_not_exactly'] = 'НЕ точно';
$_['profile_products_filters_conditional_is_yes'] = 'ДА';
$_['profile_products_filters_conditional_is_no'] = 'НЕТ';
$_['profile_products_filters_main_conditional'] = 'Главное условие для фильтров';
$_['profile_products_filters_main_conditional_or'] = 'логическое ИЛИ';
$_['profile_products_filters_main_conditional_and'] = 'логическое И';
$_['profile_products_filters_conditional_years_ago'] = 'Последние Х лет';
$_['profile_products_filters_conditional_months_ago'] = 'Последние Х месяцев';
$_['profile_products_filters_conditional_days_ago'] = 'Последние Х дней';
$_['profile_products_filters_conditional_hours_ago'] = 'Последние Х часов';
$_['profile_products_filters_conditional_minutes_ago'] = 'Последние Х минут';
$_['profile_error_option_option_value_default_filled'] = '<b>Error:</b> Default value only allowed to column "<b>%s</b>" or "<b>%s</b>", not both.';
$_['profile_import_profile_name'] = 'Имя профиля';
$_['profile_load_error_not_found'] = 'Профиль не найден';
$_['profile_error_delete_profile_id_empty'] = 'Параметр ID в профиле не найден.';
$_['profile_error_empty_column_custom_name'] = '<b>Ошибка:</b> Поле "Произвольное имя колонки" пусто';
$_['profile_error_repeat_column_custom_name'] = '<b>Ошибка:</b> Найдена <b>%s</b> повторяющаяся колонка "<b>%s</b>"';
$_['profile_error_empty_name'] = 'Ошибка сохранения профиля: проверьте имя профиля.';
$_['profile_error_max_input_vars'] = '<b>Ошибка сохранения профиля</b>: Превышение параметра РНР "<b>max_input_vars</b>" со значением <b>%s</b> а нужно отправить <b>%s</b>. Сократите количество колонок или увеличьте параметр "<b>max_input_vars</b>" в настройках Вашего сервера. Если Вы не знаете как и где изменить настройки, обратитесь в техническую поддержку хостинга.';
$_['profile_error_uncompleted'] = 'Ошибка сохранения профиля: заполните все поля в профиле.';
?>