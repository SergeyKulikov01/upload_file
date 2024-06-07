<?php
// Подключение необходимых файлов Битрикса
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

use Bitrix\Main\Application;
use Bitrix\Main\Web\Json;
use Bitrix\Main\Loader;

Loader::includeModule('highloadblock');

use Bitrix\Highloadblock as HL;

$request = Application::getInstance()->getContext()->getRequest();

$hlbl = 13; // HL для сохранения файлов

$hlblock = HL\HighloadBlockTable::getById($hlbl)->fetch();
$entity = HL\HighloadBlockTable::compileEntity($hlblock);
$entity_data_class = $entity->getDataClass();

    $data = [
        'UF_FILE' => $request->getPost('loaded_file'),
    ];
    $result = $entity_data_class::add($data);

$response = array(
    'success' => true,
    'message' => 'Файл добавлен успешно',
);
header('Content-Type: application/json');
echo Json::encode($response);
