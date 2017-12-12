<?php

/*
	Важно: Для того, чтобы редактировать настройки Sublime Text найдите в меню Sublime Text 2 > Preferences > Settings - Default и выберите нужные.

	highlight_line
	Эта настройка подсвечивает строку, на которой находится курсор другим цветом (зависит от цветовой схемы). Возможность видеть на какой строке вы сейчас находитесь помогает сконцентрироваться на текущей задаче, легко и быстро перемещаться по строкам, а также находить активную строку после переключения из другой программы.

	"highlight_line": true,

	highlight_modified_tabs

	Эта настройка подсветит вкладки с измененными файлами, чтобы привлечь к ним дополнительное внимание.

	"highlight_modified_tabs": true,

	fade_fold_buttons
	А вы знали, что Sublime Text позволяет сворачивать фрагменты кода? Я знал, но все время забывал об этом, из-за этой настройки. Выключите ее и стрелочки никогда больше не будут исчезать.

	"fade_fold_buttons": false,

	word_wrap
	Горизонтальный скроллинг раздражает всех без исключения. С включенной настройкой word_wrap текст не выходит за рамки текущего экрана и тем самым предотвращает горизонтальный скроллинг.

	"word_wrap": true,

	bold_folder_labels
	В саблайме есть несколько отличных настроек, чтобы расставить акценты в боковой панели. Начнем с bold_folder_labels, которая выделит все директории жирным.

	"bold_folder_labels": true,


	You will need to edit the Default.sublime-theme file to do this, not your preferences. Unfortunately, in Sublime Text 3 this file is contained in a zipped .sublime-package file, so you'll need to extract that first. Install the PackageResourceViewer plugin via Package Control, then hit CtrlShiftP (?ShiftP on OS X) and type prv to bring up the PackageResourceViewer options. Select Open Resource, scroll down to Theme - Default, hit Enter, scroll down to Default.sublime-theme, and hit Enter again to open it.

	{
		"class": "sidebar_label",
		"color": [0, 0, 0],
		"font.bold": false,
		"font.italic": false, // <-- add comma
		"font.size": 14 // <-- new line
		// , "shadow_color": [250, 250, 250], "shadow_offset": [0, 0]
	},
*/