<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
?>
<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.comments",
	"mains",
	Array(
		"AJAX_POST" => "Y",
		"BLOG_TITLE" => $arParams["BLOG_TITLE"],
		"BLOG_URL" => $arParams["DETAIL_BLOG_URL"],
		"BLOG_USE" => "Y",
		"CACHE_GROUPS" => $arParams['CACHE_GROUPS'],
		"CACHE_TIME" => $arParams['CACHE_TIME'],
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"COMMENTS_COUNT" => $arParams['COMMENTS_COUNT'],
		"ELEMENT_CODE" => "",
		"ELEMENT_ID" => "1889",
		"EMAIL_NOTIFY" => $arParams["DETAIL_BLOG_EMAIL_NOTIFY"],
		"IBLOCK_ID" => "289",
		"IBLOCK_TYPE" => "content",
		"PATH_TO_SMILE" => "",
		"RATING_TYPE" => "",
		"SHOW_DEACTIVATED" => "N",
		"SHOW_RATING" => "Y",
		"SHOW_SPAM" => "Y",
		"TEMPLATE_THEME" => "blue",
		"URL_TO_COMMENT" => "",
		"VK_USE" => "N",
		"WIDTH" => ""
	),
false,
Array(
	'HIDE_ICONS' => 'Y'
)
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>