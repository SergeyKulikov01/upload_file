<?php
// Подключение необходимых файлов Битрикса
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

use Bitrix\Main\Application;
use Bitrix\Main\Web\Json;

$request = Application::getInstance()->getContext()->getRequest();

$allow = [
    'jpeg',
    'png',
    'gif',
    'jpg'
]; // типы файлов которые можно загружать
$maxSize = 2; // максимальный размер в МБ.
$kb = $maxSize * 1024 * 1024;
$path = 'formFiles'; // название папки для сохранения в upload
$multi_load = true;

if (isset($_FILES['file'])) {
        $filePath = $_FILES['file']['tmp_name'];
        $fileName = $_FILES['file']['name'];
        $fileSize = $_FILES['file']['size'];
        $filename_parts = explode('.', $fileName);
        if (!in_array(end($filename_parts), $allow)) {
            unlink($filePath);
            $response = array(
                'success' => false,
                'message' => 'Файл ' . $fileName . ' имеет неверный тип и не был загружен',
                'multi' => $multi_load,
            );
            header('Content-Type: application/json');
            echo Json::encode($response);
            die();
        } else if ($fileSize > $kb) {
            unlink($filePath);
            $response = array(
                'success' => false,
                'message' => 'Файл ' . $fileName . ' слишком большой вес и не был загружен (Максимальный вес -' . $maxSize .' МБ )',
                'multi' => $multi_load,
            );
            header('Content-Type: application/json');
            echo Json::encode($response);
            die();
        }
        $file = CFile::MakeFileArray($filePath);
        $file['name'] = $fileName;
        $fileId = CFile::SaveFile($file, $path);
        $response = array(
            'success' => true,
            'message' => 'Файл '. $fileName .' загружен',
            'id' => $fileId,
            'multi' => $multi_load,
        );
        header('Content-Type: application/json');
        echo Json::encode($response);
}
