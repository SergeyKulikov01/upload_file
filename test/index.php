<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Форма");
?>
Форма загрузки файлов
<form data-form>
  <input name="file" type="file" multiple />
  <button type="submit">Отправить</button>
  <div data-show-msg></div>
</form>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>