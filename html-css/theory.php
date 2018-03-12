<?php

/*
	В качестве селектора может выступать любой элемент HTML, 
	для которого определяются правила форматирования, 
	такие как: цвет, фон, размер и др. Например тэг <p></p> это селектор на который можно навесить стили
*/
p {
	color: green;
}

/*
	Идентификатор определяет уникальное имя элемента, которое используется для изменения его стиля и обращения к нему через скрипты.

	#help {
		color: white;
	}
*/
<p id="help"></p>

/*
	Классы применяют, когда необходимо определить стиль для одного или нескольких элементов веб-страницы.

	.overview {
		color: blue;
	}

	К любому элементу одновременно можно добавить несколько классов, перечисляя их в атрибуте class через пробел.
*/
<p class="overview text"></p>

/*
	Иногда требуется установить одновременно один стиль для всех элементов веб-страницы, например, задать шрифт или начертание текста. В этом случае поможет универсальный селектор, который соответствует любому элементу веб-страницы.

	* {
		margin: 0;
		padding: 0;
	}
*/

/*
	При создании веб-страницы часто приходится вкладывать одни элементы внутрь других. Чтобы стили для этих элементов использовались корректно, помогут вложенные селекторы.

	p b { 
		font-family: Times, serif;
	}
*/
<p>
	<b>Одновременно жирное начертание текста и выделенное цветом</b>
</p>

/*
	Дочерним называется элемент, который непосредственно располагается внутри родительского элемента. Какой элемент выступает родителем, а какой его потомком легко выяснить с помощью дерева элементов. Стилизация дочерних элементов происходит таким образом:

	#menu > li {
		list-style: none;
	}
*/

/*
	Соседними называются элементы веб-страницы, когда они следуют непосредственно друг за другом в коде документа. Для управления стилем соседних элементов используется символ плюса (+), который устанавливается между двумя селекторами E и F. Пробелы вокруг плюса не обязательны. Стиль при такой записи применяется к элементу F, но только в том случае, если он является соседним для элемента E и следует сразу после него.

	b + i {
		color: red;
	}
*/

/*
	Родственные селекторы по своему поведению похожи на соседние селекторы (запись вида E + F), но в отличие от них стилевые правила применяются ко всем близлежащим элементам.

	h1 ~ p { 
		color: red; 
	}
*/
<h1>Заголовок</h1>
<p>Абзац 1</p>
<p>Абзац 2</p>

/*
	Существуют атрибуты, которые помогают стилизовать элементы.

	q[title] {
		color: maroon;
	}

	title - это атрибут

	Можно задать имя атрибуту и стилизовать только атрибуты с определёнными именами

	q[title="go"] {
		display: block;
	}

	Так же есть возможность стилизовать элемент если по началу имени атрибута

	a[href^="http://"] { 
		font-weight: bold;
	}

	Ещё мы можем добавить стили к элементы по конечному тексту его атрибута

	a[href$=".ru"] {
		padding-left: 18px;
	}

	Возможны варианты, когда стиль следует применить к тегу с определённым атрибутом, когда частью его значения является некоторый текст. При этом точно не известно, в каком месте значения включён данный текст — в начале, середине или конце. В подобном случае следует использовать конструкцию *=. Она определяет, что значение атрибута содержит указанный текст.

	[href*="htmlbook"] { 
		background: yellow;
	}
*/
<q title="test">После того, как веб-страница...</q>
<q title="go">После того, как веб-страница...</q>

<p>
	<a href="http://htmlbook.ru" target="_blank">Внешняя ссылка на сайт htmlbook.ru</a>
</p>

<a href="http://stepbystep.htmlbook.ru">Шаг за шагом</a>

/*
	Существует такое понятие, как псевдоклассы. Они определяют динамическое состояние элементов, которое изменяется с помощью действий пользователя. Примеры: :active, :checked
*/

/*
	Псевдоэлементы позволяют задать стиль элементов не определённых в дереве элементов документа, а также генерировать содержимое, которого нет в исходном коде текста. Примеры: ::after, ::before, ::backdrop
*/

/*
	Позиционирование элементов задаётся с помощью св-ва position. Виды позиционирования:

		- Абсолютное позиционирование. (Указывает, что элемент абсолютно позиционирован, при этом другие элементы отображаются на веб-странице словно абсолютно позиционированного элемента и нет)

		- Фиксированное позиционирование. (По своему действию это значение близко к absolute, но в отличие от него привязывается к указанной свойствами left, top, right и bottom точке на экране и не меняет своего положения при прокрутке веб-страницы)

		- Относительное позиционирование или relative. (Положение элемента устанавливается относительно его исходного места. Добавление свойств left, top, right и bottom изменяет позицию элемента и сдвигает его в ту или иную сторону от первоначального расположения)

		- Статичное позиционирование. (Элементы отображаются как обычно. Использование свойств left, top, right и bottom не приводит к каким-либо результатам.)

		- Sticky - это сочетание относительного и фиксированного позиционирования. Элемент рассматривается как позиционированный относительно, пока он не пересекает определённый порог, после чего рассматривается как фиксированный. Обычно применяется для фиксации заголовка на одном месте, пока содержимое, к которому относится заголовок, прокручивается на странице.
*/

/*
	Строчными называются такие элементы документа, которые являются непосредственной частью строки. К строчным элементам относятся теги <img>, <span>, <a>, <q>, <code> и др., а также элементы, у которых свойство display установлено как inline. В основном они используются для изменения вида текста или его логического выделения.
*/

/*
	Блочным называется элемент, который отображается на веб-странице в виде прямоугольника. Такой элемент занимает всю доступную ширину, высота элемента определяется его содержимым, и он всегда начинается с новой строки. К блочным элементам относятся теги <address>, <blockquote>, <div>, <fieldset>, <form>, <h1>,...,<h6>, <hr>, <ol>, <p>, <pre>, <table>, <ul> и др. Также блочным становится элемент, если в стиле для него свойство display задано как block, list-item, table и в некоторых случаях run-in.
*/

/*
	Flex элемент (или гибкий макет). Основная идея «гибкого» макета - дать контейнеру возможность изменять ширину, высоту и порядок расположения его элементов, чтобы наиболее эффективно использовать доступное пространство. «Гибкий» контейнер это умеет: он способен увеличивать ширину элемента, чтобы заполнить свободное пространство, или, наоборот, уменьшать.

	Flexbox – это целый набор CSS свойств, часть из которых применяются непосредственно к контейнеру (flex container), а часть — к его дочерним элементам (flex items).

	Итак, все элементы располагаются либо по оси main axis по горизонтали (начинается в точке main start, заканчивается в точке main end), либо по оси cross axis по вертикали (от точки cross start до cross end соответственно).

	Display определяет наш гибкий контейнер, блочный или инлайновый в зависимости от заданного параметра, и активирует flex-контекст для всех дочерних элементов контейнера (то есть делает их «резиновыми», а не блочными):

	.container {
		display: flex;
	}

	По умолчанию все flex-элементы будут сидеть на одной строке. Вы можете это изменять, меняя значение данного свойства. В зависимости от направления возможны следующие значения
*/