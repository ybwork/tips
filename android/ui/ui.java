/*
	Настройка и подключение.

	Существует два способа объявить макет:
		- Объявление элементов пользовательского интерфейса в XML

		- Создание экземпляров элементов во время выполнения

	В каждом файле макета должен быть всего один корневой элемент, в качестве которого должен выступать объект представления (View) или представления группы (ViewGroup).

	Расположение:

		app -> res -> layout -> filename.xml

	В отличие от исходников на Java, в ресурсах не предусмотрено вложенности директорий, поэтому все файлы лежат в одной директории и чтобы не запутаться в них, когда их много, приняты следующие названия:

		- activity_name.xml — для Activity

		- fragment_name.xml — для фрагментов

		- view_name.xml — для View

	Загрузка в активити:
		в методе onCreate() пишем это: setContentView(R.layout.main_layout);
*/

/*
	Общее.

	Самые важные понятия в интерфейсе Android — это Activity, View, ViewGroup, Layout.

		Activity — это та часть приложения, с которой взаимодействует пользователь.

		View — элемент интерфейса.

		ViewGrop — это модифицированный View, созданный для того, чтобы служить контейнером для других View.

		Layout — общее название для нескольких наследников ViewGroup. Лэйауты служат контейнерами для View, и созданы они для того, чтобы мы могли удобно располагать всяческие кнопочки, поля для ввода текста и прочие элементы интерфейса.

		Пример: 

			поле для ввода и 2 кнопки - View

			2 кнопки объединены зелёной рамкой (схематично) - ViewGroup

			рамка вокрук поля ввода и двух кнопок - другое ViewGroup

	Все группы представлений включают в себя параметры ширины и высоты (layout_width и layout_height), и каждое представление должно определять их.
*/

/*
	Настройка рабочего окружения.

	Открыть app > res > layout > activity_main.xml

	Выбрать View > Tool Windows > Project

	Выбрать Design в нижней части панели.

	Выбрать bluprint в панели чуть ниже вкладок с открытыми файлами.

	Включить Turn On Autoconnect (подкова возле глаза).

	Выставить Default Margins в 16 (справа от подковы).

	Выбрать модель телефона для разработки (выше Default Margins) 

	Component Three -> ConstraitLayout (нажать правой кнопкой мыши) -> Constrait Layout -> Infer Contraints или выбрать Turn on AutoConnect
*/

/*
	Позиционирование.

	widgets (View objects) - компоненты пользовательского интерфейса (кнопки, чекбоксы).

	layouts (ViewGroup objects) - невидимые контейнеры, они определяют, как их дочерние представления располагаются на экране.

	Component Tree - окно в программе, которое показывает иерархию представлений макета.

	ConstraintLayout - общий контейнер, который находится внутри окна Component Tree. В нём могут лежать другие контейнер/контейнеры (определение придуманное мной на основе описанного в документации). Например выставим ConstraintLayout 16dp. Внутри этого контейнера лежит 2 других контейнера (контейнер а и контейнер б). Теперь контейнер а будет отсупать от верха на 16dp и от ConstraintLayout слева на 16dp, в свою очеред контейнер б будет отсупать от контейнера а на 16dp и от верха на 16dp.

	В меню pallete, которое ниже вкладок с открытыми файлами можно выбрать нужный виджет (представление).

	При клике на виджет вокру него появляется рамка с кругляшками по периметру. Нажимаем на кругляшок и тянем к нужной стороне, должна появиться стрелка с хвостом. Когда притянули куда нужно, отпускаем - установка якоря относительно ConstraintLayout.

	При клике на виджет ниже него появляются 2 иконки. Нажимаем на правую и видим в центре виджета появилась полоска. Зажимаем правой кнопкой полоску и тянем к нужному элементу, должна появиться стрелка с хвостом. Когда притянули куда нужно, отпускаем - горизонтальное выравнивание.

	Выбрали один виджет, зажали Shift и выбрали остальные, затем нажали правую кнопку мыши и выбрали center horizontaly. (выравнивание по горизонтали)

	Для редактирование отступов используем панель справа, должна выезжать при нажатии на виджет.

	Чтобы поместить один виджет по центру нужно взять его и перетащить к верхнему краю
*/

/*
	View.

	Для того чтобы взаимодействовать с элементами интерфейса, нам надо как-то отличать их друг от друга. Для этого существует механизм присваивания id. 

	У любого объекта View может быть связанный с ним целочисленный идентификатор, который служит для обозначения уникальности объекта View в иерархии. 
	Пример: <Button android:id="@+id/my_button" />	
*/

	
/*
	Ширина и высота.

		- android:layout_width="match_parent"

		- android:layout_height="match_parent"

	Для задания значений ширины и высоты используется одна из следующих констант:

		- match_parent (элемент будет занимать все доступное ему пространство)

		- wrap_content (элемент будет использовать столько места, сколько требуется для отображения контента внутри. Кнопка, например, будет иметь размер текста + отступы.)

		Как правило, не рекомендуется задавать абсолютные значения ширины и высоты макета (например, в пикселах).
		
			- dp - единица измерения не зависящая от разрешения экрана

	View имеет прямоугольную форму. Расположение view определяется его координатами слева и сверху, а его размеры — параметрами ширины и высоты.

	Расположение view можно получить путем вызова методов:

		- getLeft()

		- getTop()

		- getRight()

		- getBottom()

	Оба этих метода возвращают расположение view относительно его родительского элемента.

	Размер view выражается его шириной и высотой. Виды:

		- измеренная ширина и измеренная высота (размер представления в границах своего родительского элемента)

			Получить:

				- getMeasuredWidth()

				- getMeasuredHeight()

		- просто ширина и высота (определяют фактический размер представления на экране после разметки во время их отрисовки)

			Получить:

				- getWidth()

				- getHeight()
*/

/*
	Макеты.

	Один макет может содержать один или несколько вложенных макетов, рекомендуется использовать как можно более простую иерархию макетов. Чем проще эта структура, тем лучше для производительности.

	Наиболее часто используемые:

		- LinearLayout (макет, в котором дочерние элементы представлены в горизонтальных или вертикальных столбцах. Если длина окна больше длины экрана, в нем создается полоса прокрутки.)

		- RelativeLayout (в этом макете можно задавать расположение дочерних объектов относительно друг друга)

		- WebView (отображает веб страницы)

		- FrameLayout

		- ConstraintLayout

	Если содержимое макета является динамическим или не определено заранее, можно использовать макет, который создает подклассы класса AdapterView для заполнения макета представлениями во время выполнения.

	Виды адаптер макетов:

		- List View (отображение списка в один столбец с возможностью прокрутки)

		- Grid View (отображение сетки из столбцов и строк с возможностью прокрутки)

	В Android предусмотрено несколько подклассов адаптера Adapter, которые полезно использовать для извлечения данных различных видов и создания представлений для AdapterView. Вот два наиболее часто используемых адаптера:

		- ArrayAdapter (этот адаптер используется в случае, когда в качестве источника данных выступает массив)

		- SimpleCursorAdapter (этот адаптер используется в случае, когда в качестве источника данных выступает объект Cursor)

	При создании макетов задавать размеры в пикселях не рекомендуется, поскольку из-за различной плотности пикселей на экранах разных устройств фактический размер макета будет неодинаков. Всегда задавайте размеры в единицах dp или sp. 

		dp – это не зависящий от разрешения пиксель, равный физическому пикселю на экране с плотностью 160 точек/дюйм. 

		sp - это единица измерения, но масштабируется на основе выбранного пользователем размера текста, поэтому ее следует применять для указания величины шрифта, но не размера макета.

		Например, если вы задаете расстояние между двумя представлениями, рекомендуется использовать dp, а не px.
*/

/*
	LinearLayout.

	Располагает дочерние элементы в «линейном» порядке, т.е. друг за другом. Линейный лэйаут может быть горизонтальным или вертикальным.

	<LinearLayout xmlns:android="http://schemas.android.com/apk/res/android"
	    android:layout_width="match_parent"
	    android:layout_height="match_parent"
	    android:orientation="horizontal">

	    <Button
	        android:layout_width="0dp"
	        android:layout_height="wrap_content"
	        android:layout_weight="1"
	        android:text="Button 1"/>

	    <Button
	        android:layout_width="0dp"
	        android:layout_height="wrap_content"
	        android:layout_weight="1"
	        android:text="Button 2" />

	    <Button
	        android:layout_width="0dp"
	        android:layout_height="wrap_content"
	        android:layout_weight="2"
	        android:text="Button 3" />
	</LinearLayout>
*/

/*
	FrameLayout.

	Располагает элементы друг над другом.

	<FrameLayout xmlns:android="http://schemas.android.com/apk/res/android"
		android:layout_width="match_parent"
		android:layout_height="match_parent">
		
		<View 
			android:layout_width="300dp"
			android:layout_height="300dp"
			android:background="#ff0000"
			android:textSize="20sp" />

		<View
			android:layout_width="200dp"
			android:layout_height="200dp"
			android:background="#00ff00"
			android:textSize="20sp" />

		<View
			android:layout_width="100dp"
			android:layout_height="100dp"
			android:background="#0000ff"
			android:textSize="10sp" />
	</FrameLayout>

	Первым мы создали красный квадрат. Он находится «дальше» всех от нас. Вторым создали зеленый, он находится «над» красным квадратом. Ну и больше всех координата Z у синего квадрата.

	FrameLayout не поддерживает гравитацию, но её можно реализовать через дочерние элементы.
	Пример:

		<?xml version="1.0" encoding="utf-8"?>
		<FrameLayout xmlns:android="http://schemas.android.com/apk/res/android"
		    android:layout_width="match_parent"
		    android:layout_height="match_parent">
		 
		    <View
		        android:layout_width="300dp"
		        android:layout_height="300dp"
		        android:background="#ff0000"
		        android:layout_gravity="center"
		        android:textSize="20sp" />
		 
		    <View
		        android:layout_width="200dp"
		        android:layout_height="200dp"
		        android:layout_gravity="center"
		        android:background="#00ff00"
		        android:textSize="20sp" />
		 
		    <View
		        android:layout_width="100dp"
		        android:layout_height="100dp"
		        android:layout_gravity="center"
		        android:background="#0000ff"
		        android:textSize="20sp" />
		 
		</FrameLayout>

	Можно комбинировать расположение элементов с помощью гравитации. Пример:

		    <View
		        android:layout_gravity="center_horizontal|bottom" />
*/

/*
	RelativeLayout.

	RelativeLayout — прямой наследник ViewGroup, в котором дочерние элементы располагаются относительно друг друга или же самого RelativeLayout.

	В RelativeLayout дочерние элементы по умолчанию выравниваются по левому верхнему краю.

	Варианты расположения дочерних элементов:

		- Относительно самого RelativeLayout. За это отвечают атрибуты layout_alignParentStart,  layout_alignParentEnd, layout_alignParentTop, layout_alignParentBottom, layout_centerVertical, layout_centerHorizontal, layout_centerInParent.

			<RelativeLayout xmlns:android="http://schemas.android.com/apk/res/android"
				android:layout_width="match_parent"
				android:layout_height="match_parent">
				
				<View 
					android:layout_width="100dp"
					android:layout_height="100dp"
					android:backgroung="#ff0000"
					android:textSize="20sp" />
			<RelativeLayout/>

			Чтобы выровнять элемент по центру относительно самого RelativeLayout, добавьте атрибут layout_centerInParent со значением true:

				<View 
					android:layout_centerInParent="true" />

			Для центрирования по вертикали нужно использовать атрибут layout_centerVertical со значением true:

				<View 
					android:layout_centerVertical="true" />

			Для выравнивания по горизонтали нужно испльзовать атрибут android:layout_centerHorizontal со значением true:

				<View 
					android:layout_centerVertical="true" />

			Остались атрибуты layout_alignParentStart, layout_alignParentEnd, layout_alignParentTop, layout_alignParentBottom. Их можно комбинировать между собой (если они не противоречат друг другу). Нужно поместить квадрат в правый нижний угол экрана:

				<View 
					android:layout_alignParentEnd="true"
					android:layout_alignParentRight="true"
					android:layout_alignParentBottom="true" />


		- Относительно других элементов внутри RelativeLayout. Для этого используются атрибуты layout_toStartOf, layout_toEndOf, layout_above, layout_below, layout_alignStart, layout_alignEnd, layout_alignTop, layout_alignBottom.

			Существует два способа расположения одного дочернего элемента относительно другого:

				- После/до/под/над элементом

					- потребуются атрибуты layout_toStartOf, layout_toEndOf, layout_above, layout_below

						Например android:layout_toEndOf="@id/red_view" задаёт относительно какого элемента будет располагаться тукущий элемент.

						Полный пример:

							<RelativeLayout xmlns:android="http://schemas.android.com/apk/res/android"
								android:layout_width="match_parent"
								android:layout_height="match_parent">

							    <View
							        android:id="@+id/red_view"
							        android:layout_width="100dp"
							        android:layout_height="100dp"
							        android:layout_centerInParent="true"
							        android:background="#ff0000"
							        android:textSize="20sp" />

							    <View
							        android:layout_width="100dp"
							        android:layout_height="100dp"
							        android:layout_toEndOf="@id/red_view"
							        android:layout_toRightOf="@id/red_view"
							        android:background="#00ff00"
							        android:textSize="20sp" />

							    <View
							        android:layout_width="100dp"
							        android:layout_height="100dp"
							        android:layout_toStartOf="@id/red_view"
							        android:layout_toLeftOf="@id/red_view"
							        android:background="#0000ff"
							        android:textSize="20sp" />
							</RelativeLayout>

				- По краю элемента — левому, правому, верхнему или нижнему

					- потребуются атрибуты layout_alignStart, layout_alignEnd, layout_alignTop, layout_alignBottom

						Мы просто добавили атрибут layout_alignTop ко второму и третьему View, и они автоматически выровнялись по верхнему краю первого View.

						<RelativeLayout xmlns:android="http://schemas.android.com/apk/res/android"
						    android:layout_width="match_parent"
						    android:layout_height="match_parent">
						 
						    <View
						        android:id="@+id/red_view"
						        android:layout_width="100dp"
						        android:layout_height="100dp"
						        android:layout_centerInParent="true"
						        android:background="#ff0000"
						        android:textSize="20sp" />
						 
						    <View
						        android:layout_width="100dp"
						        android:layout_height="100dp"
						        android:layout_toEndOf="@id/red_view"
						        android:layout_toRightOf="@id/red_view"
						        android:layout_alignTop="@id/red_view"
						        android:background="#00ff00"
						        android:textSize="20sp" />
						 
						    <View
						        android:layout_width="100dp"
						        android:layout_height="100dp"
						        android:layout_toLeftOf="@id/red_view"
						        android:layout_alignTop="@id/red_view"
						        android:layout_toStartOf="@id/red_view"
						        android:background="#0000ff"
						        android:textSize="20sp" />
						 
						</RelativeLayout>
*/

/*
	ConstraintLayout.

	Похож на RelativeLayout, но без вложенных view groups. 

	Преимущество в том, что можно создавать макет без редактирования xml, более высокая скорость работы по сравнению с другими layouts и сделан на замену RelativeLayout.

	Совместим с Android 2.3.
	
	Чтобы определить макет ConstraintLayout нужно добавить к view горизонтальное или вертикальное ограничение. Ограничение в данном случае - это выравнивание или соединение относительно другого view или относительно родительского макета.

	Каждое ограничение определяет положение view вдоль вертикальной или горизонтальной оси. Если представление не имеет ограничений при запуске макета на устройстве, оно отображается в позиции [0,0] (верхний левый угол).

	Если ограничения не выставленны будет показана ошибка. Можно выставить автоматическое добавление ограничений с помощью Turn on Autoconnect and infer constraints.

	У каждого вида должно быть как минимум два ограничения: одно горизонтальное и одно вертикальное.

	Ручное создание ограничений:

		- По периметру каждого view появляются кружки с помощью которых можно создать ограничение

		- Зажимаем кружок и тянем к соседнему элементу или краю макета. При этом можно притянуть верхнюю часть одного view к ниждей или левой части другого.

		- Ограничение создано

		- Для центрирования view между элементами, можно сделать ограничения относительно другого view слева и справа. Для этого нужно потянуть за кружок с обеих сторон. В этом случае представление центрируется между ограничениями.

		- Смещение view по оси y или x можно задать передвинув ползунок в правой части экрана в разделе attributes (линия с левой и нижней стороны квадрата)

		- Если задаётся например ограничение элемента B относительно элемента A (слева), то оно будет действовать не зависимо от того куда сдвинулся элемент A

	Выравнивание:

		- Выбираем все виды (через зажатый shift) и нажимаем align (панель, где turn autoconnect)

		- Выравнивание одного текста с другим создаётся по схеме:

			- поместили на экран 2 textView

			- выбрали одно из них

			- ниже появилась иконка с надписью ab

			- нажали на неё

			- в центре textView появилась полоска

			- зажали полоску и потянули стрелку в центр textView с относительно которого нужно выровнять текст

		Вертикальная или горизонтальная ограничивающая линия (можно располагать элементы по верх):

			- находится выше вида экрана (справа от выравнивания)

			- от чего отступает линия (например от левого края) задаётся с помощью переключения кружка, который находится сверху линии

		Барьер (нельзя располагать элементы поверх):

			- В android studio 3 (походу одно и то же, что и ограничивающая линия)

	Позиционирование элемента:

		- На вкладке attributes (справа от экрана) задаётся позиция сторон view

		- Позиции:

			- линия с отчерченными краями - даёт возможность задать любой размер руками и для каждой стороны

			- три стрелочки вправа - view расширяется настолько, насколько необходимо, чтобы соответствовать его содержимому

			- линия, как пульс с отчерченными краями - максимально расширяется для удовлетворения ограничений с каждой стороны

		- Чтобы все view были равномерно распределены нужно выбрать необходимый margin (находится на панели справа от infer constraints). Можно задать общий margin для всех view и для отдельно выбранного.

		- Цепь (цепочки view)

			- Цепь позволяет распределить группу view по горизонтали или по вертикали

			- Выделили любое кол-во view

			- Нажали правой кнопкой и выбрали например center gorizontaly

			- Также можно выделить все view и ниже кадого появится значок в виде цепи, нажимаем и видим например склеивание всех элементов

			- Цепь работает правильно, только если каждый конец цепи привязан к другому объекту на той же оси

	Turn on Autoconnect - функция, которая при включении автоматически создается два или более ограничений для каждого представления. Autoconnect не создает ограничений для других view в макете.

	infer constraints- функция, которая сканирует макет, чтобы определить наиболее эффективный набор ограничений для всех представлений. Накидали view как нам нужно и нажали infer constraints

	Для преобразования макета в ConstaintLayout выбираем вкладку desing, нажимаем правой кнопкой на текущий макет (открывается окно), выбираем convert to ConstaintLayout

	Для создания нового ConstaintLayout делаем следующее layout (правой кнопкой) > New > XML > Layout XML file > в открывшемся окне (поле Root Tag) пишем - android.support.constraint.ConstraintLayout

	Крестик ниже view позволяет удалить ограничение
*/

/*
	Гравитация.

	У лэйаутов есть понятие gravity. Gravity задает положение элемента внутри контейнера. 

	Гравитация может быть следующей:
		bottom — элемент «прижимается» к нижней границе контейнера

		center — элемент располагается в центре контейнера

		center_horizontal — элемент находится в центре по оси X

		center_vertical — элемент находится в центре по оси Y

		end — элемент находится «в конце» контейнера. Обычно это означает, что он будет находиться справа, но на локали с написанием справа-налево он будет находиться слева

		start — элемент находится «в начале» контейнера. Обычно — слева, на RTL локалях — справа

		top — элемент «прижимается» к верхней границе контейнера

		left и right использовать не рекомендуется, поскольку это вызовет проблемы с версткой на RTL локалях.

	Гравитация может быть задана двумя способами:

		- Атрибутом gravity у лэйаута. В таком случае она будет применена для всех дочерних элементов

		- Атрибутом layout_gravity у дочернего элемента. Тогда она будет применена только для этого элемента.
*/

/*
	Атрибуты.

	android:orientation="horizontal" - горизонтальное направление контента в лэйауте

	android:orientation="vertical" - вертикальное направление» контента в лэйауте

	android:layout_weight - сколько пространства должен занимать элемент. В качестве значения можно использовать любое число. Например, если мы хотим равномерно распределить пространство между двумя кнопками, мы можем задать обеим кнопкам layout_weight = 1. Тогда они разделят имеющееся пространство на две равных части. Если мы зададим одной кнопке вес = 1, а второй = 2, то вторая кнопка будет занимать в 2 раза больше места, чем первая. Также при использовании атрибута layout_weight рекомендуется заменить ширину (если лэйаут горизонтальный) или высоту (если лэйаут вертикальный) на 0dp.

	android:background="#ff0000" - задаёт цвет заднего плана

	android:textSize="20sp" - задаёт размер те

*/

/*
	Значения измерения.

	dp - независимые от плотности пиксели, единица измерения основанная на плотности экрана. 

		Эти единицы относятся к экрану 160 точек на дюйм (точек на дюйм), на котором 1dp примерно равно 1px. При работе на экране с более высокой плотностью количество пикселей, используемых для рисования 1dp, масштабируется в соответствии с коэффициентом, соответствующим типу экрана. Аналогично, когда на экране с более низкой плотностью количество пикселей, используемых для 1dp, уменьшается.

	sp - маштабируемые пиксели, масштабируется по предпочтению размера шрифта пользователя.

		Рекомендуется использовать этот аппарат при задании размеров шрифта, поэтому они будут настроены как по плотности экрана, так и по предпочтениям пользователя.

	px - пиксели, единица измерения, которая соответствует фактическим пикселям на экране. 

		Эта единица измерения не рекомендуется, поскольку каждое устройство может иметь различное количество пикселей на дюйм и может иметь больше или меньше общих пикселей, доступных на экране.

	mm - милиметры, единица измерения на основе физического размера экрана.

	in - дюймы, единица измерения на основе физического размера экрана.
*/

/*
	Адаптивность.

	Чтобы создать масштабируемый макет, способный адаптироваться к разным экранам, используйте в качестве значений ширины и высоты отдельных компонентов представления параметры "wrap_content" и "match_parent".

	Однако LinearLayout не дает возможности точно управлять взаимным расположением дочерних представлений: в LinearLayout они просто помещаются в ряд друг за другом. Если необходимо расположить дочерние представления иным образом, используйте объект RelativeLayout, позволяющий задать относительные позиции компонентов.

	С помощью квалификаторов конфигураций можно подставлять разные макеты, в зависимости от экрана.

	Многие приложения отображаются на больших экранах в двухпанельном режиме. Такой режим просмотра удобен на достаточно больших экранах планшетных ПК и телевизоров, однако на экране телефона эти панели следует отображать по отдельности. Для каждого режима просмотра нужно создать отдельный файл.

	Пример:

		- res/layout/main.xml (однопанельный макет для телефона)

			<LinearLayout xmlns:android="http://schemas.android.com/apk/res/android"
				android:orientation="vertical"
				android:layout_width="match_parent"
				android:layout_height="match_parent">

				<fragment 
					android:id="@+id/headlines"
					android:layout_height="fill_parent"
					android:name="com.example.android.newsreader.HeadLinesFragment"
					android:layout_width="match_parent" />
			</LinearLayout>

		- res/layout-large/main.xml (двухпанельный макет для больших экранов 7 дюймов и более)

			<LinearLayout xmlns:android="http://schemas.android.com/apk/res/android"
			    android:layout_width="fill_parent"
			    android:layout_height="fill_parent"
			    android:orientation="horizontal">
			    <fragment android:id="@+id/headlines"
			              android:layout_height="fill_parent"
			              android:name="com.example.android.newsreader.HeadlinesFragment"
			              android:layout_width="400dp"
			              android:layout_marginRight="10dp"/>
			    <fragment android:id="@+id/article"
			              android:layout_height="fill_parent"
			              android:name="com.example.android.newsreader.ArticleFragment"
			              android:layout_width="fill_parent" />
			</LinearLayout>

			Обратите внимание, здесь использован квалификатор large.

		- res/layout-sw600dp/main.xml (двухпанельный макет)

			Многие приложения требуется по-разному отображать на разных устройствах (например, с 5- и 7-дюймовыми экранами), хотя они и относятся к одной категории "больших" экранов. В Android версии 3.2 и более поздних доступен квалификатор Smallest-width. Он позволяет определять экраны с заданной минимальной шириной в dp. Например, типичный планшетный ПК с экраном 7 дюймов имеет минимальную ширину 600 dp, и если вы хотите, чтобы приложение работало на нем в двухпанельном режиме (а на меньших экранах в однопанельном), используйте два макета из предыдущего раздела, но вместо квалификатора размера large укажите sw600dp. В таком случае на экранах, минимальная ширина которых составляет 600 dp, будет использоваться двухпанельный макет.

			Квалификатор Smallest-width работает только на устройствах Android 3.2 или более поздних версий. Для совместимости с более ранними устройствами по-прежнему следует использовать абстрактные размеры (small, normal, large и xlarge).

			<LinearLayout xmlns:android="http://schemas.android.com/apk/res/android"
			    android:layout_width="fill_parent"
			    android:layout_height="fill_parent"
			    android:orientation="horizontal">
			    <fragment android:id="@+id/headlines"
			              android:layout_height="fill_parent"
			              android:name="com.example.android.newsreader.HeadlinesFragment"
			              android:layout_width="400dp"
			              android:layout_marginRight="10dp"/>
			    <fragment android:id="@+id/article"
			              android:layout_height="fill_parent"
			              android:name="com.example.android.newsreader.ArticleFragment"
			              android:layout_width="fill_parent" />
			</LinearLayout>
*/

/*
	Псевдонимы макетов.

	Чтобы не создавать дубликаты файлов и упростить процесс поддержки приложения, используйте псевдонимы. Например, можно определить следующие макеты:

		- res/layout/main.xml (однопанельный макет)

		- res/layout/main_twopanes.xml (двухпанельный макет)

	Затем добавьте следующие два файла:

		- res/values-large/layout.xml

			<resources>
				<item name="main" type="layout">@layout/main_twopanes</item>
			</resources>

		- res/values-sw600dp/layout.xml

			<resources>
				<item name="main" type="layout">@layout/main_twopanes</item>
			</resources>

		Содержание последних двух файлов одинаково, но сами по себе они не определяют макет. Они служат для того, чтобы назначить файл main в качестве псевдонима main_twopanes. Так как в них используются селекторы large и sw600dp, они применяются к планшетным ПК и телевизорам на платформе Android независимо от версии (для версий до 3.2 используется large, а для более новых – sw600dp).
*/

/*
	Использование растровых изображений nine-patch.

	Чтобы интерфейс был совместим с экранами разных размеров, используемые в нем графические элементы также должны быть адаптированы соответствующим образом. Если использовать для компонентов, размеры которых меняются, обычные изображения, то они будут равномерно сжиматься и растягиваться, и результат будет далек от идеального. Решением являются растровые изображения формата nine-patch.

	nine-patch – специальные PNG-файлы, содержащие информацию о том, какие области можно растягивать, а какие нет.
*/

/*
	Использование квалификаторов ориентации.

	Хотя некоторые макеты одинаково хорошо смотрятся в вертикальной и горизонтальной ориентациях, в большинстве случаев интерфейс все же приходится адаптировать.

	Есть следующие размеры и ориентации экрана:

		- Маленький экран, вертикальная ориентация: однопанельный вид с логотипом

		- Маленький экран, горизонтальная ориентация: однопанельный вид с логотипом

		- Планшетный ПК с 7-дюймовым экраном, вертикальная ориентация: однопанельный вид с панелью действий

		- Планшетный ПК с 7-дюймовым экраном, горизонтальная ориентация: двухпанельный вид с панелью действий

		- Планшетный ПК с 10-дюймовым экраном, вертикальная ориентация: двухпанельный вид (узкий вариант) с панелью действий

		- Планшетный ПК с 10-дюймовым экраном, горизонтальная ориентация: двухпанельный вид (широкий вариант) с панелью действий

		- Телевизор, горизонтальная ориентация: двухпанельный вид с панелью действий

	Каждый из этих макетов определен в XML-файле в каталоге res/layout/.

		- res/layout/onepane.xml

			<LinearLayout xmlns:android="http://schemas.android.com/apk/res/android"
			    android:orientation="vertical"
			    android:layout_width="match_parent"
			    android:layout_height="match_parent">

			    <fragment android:id="@+id/headlines"
			              android:layout_height="fill_parent"
			              android:name="com.example.android.newsreader.HeadlinesFragment"
			              android:layout_width="match_parent" />
			</LinearLayout>

		- res/layout/onepane_with_bar.xml:

			<LinearLayout xmlns:android="http://schemas.android.com/apk/res/android"
			    android:orientation="vertical"
			    android:layout_width="match_parent"
			    android:layout_height="match_parent">
			    <LinearLayout android:layout_width="match_parent" 
			                  android:id="@+id/linearLayout1"  
			                  android:gravity="center"
			                  android:layout_height="50dp">
			        <ImageView android:id="@+id/imageView1" 
			                   android:layout_height="wrap_content"
			                   android:layout_width="wrap_content"
			                   android:src="@drawable/logo"
			                   android:paddingRight="30dp"
			                   android:layout_gravity="left"
			                   android:layout_weight="0" />
			        <View android:layout_height="wrap_content" 
			              android:id="@+id/view1"
			              android:layout_width="wrap_content"
			              android:layout_weight="1" />
			        <Button android:id="@+id/categorybutton"
			                android:background="@drawable/button_bg"
			                android:layout_height="match_parent"
			                android:layout_weight="0"
			                android:layout_width="120dp"
			                style="@style/CategoryButtonStyle"/>
			    </LinearLayout>

			    <fragment android:id="@+id/headlines" 
			              android:layout_height="fill_parent"
			              android:name="com.example.android.newsreader.HeadlinesFragment"
			              android:layout_width="match_parent" />
			</LinearLayout>

		- res/layout/twopanes.xml

			<LinearLayout xmlns:android="http://schemas.android.com/apk/res/android"
			    android:layout_width="fill_parent"
			    android:layout_height="fill_parent"
			    android:orientation="horizontal">
			    <fragment android:id="@+id/headlines"
			              android:layout_height="fill_parent"
			              android:name="com.example.android.newsreader.HeadlinesFragment"
			              android:layout_width="400dp"
			              android:layout_marginRight="10dp"/>
			    <fragment android:id="@+id/article"
			              android:layout_height="fill_parent"
			              android:name="com.example.android.newsreader.ArticleFragment"
			              android:layout_width="fill_parent" />
			</LinearLayout>

		- res/layout/twopanes_narrow.xml

			<LinearLayout xmlns:android="http://schemas.android.com/apk/res/android"
			    android:layout_width="fill_parent"
			    android:layout_height="fill_parent"
			    android:orientation="horizontal">
			    <fragment android:id="@+id/headlines"
			              android:layout_height="fill_parent"
			              android:name="com.example.android.newsreader.HeadlinesFragment"
			              android:layout_width="200dp"
			              android:layout_marginRight="10dp"/>
			    <fragment android:id="@+id/article"
			              android:layout_height="fill_parent"
			              android:name="com.example.android.newsreader.ArticleFragment"
			              android:layout_width="fill_parent" />
			</LinearLayout>

	Чтобы сопоставить их с определенными конфигурациями экрана, в приложении используются псевдонимы:

		- res/values/layouts.xml

			<resources>
			    <item name="main_layout" type="layout">@layout/onepane_with_bar</item>
			    <bool name="has_two_panes">false</bool>
			</resources>

		- res/values-sw600dp-land/layouts.xml

			<resources>
			    <item name="main_layout" type="layout">@layout/twopanes</item>
			    <bool name="has_two_panes">true</bool>
			</resources>

		- res/values-sw600dp-port/layouts.xml

			<resources>
			    <item name="main_layout" type="layout">@layout/onepane</item>
			    <bool name="has_two_panes">false</bool>
			</resources>

		- res/values-large-land/layouts.xml

			<resources>
			    <item name="main_layout" type="layout">@layout/twopanes</item>
			    <bool name="has_two_panes">true</bool>
			</resources>

		- res/values-large-port/layouts.xml

			<resources>
			    <item name="main_layout" type="layout">@layout/twopanes_narrow</item>
			    <bool name="has_two_panes">true</bool>
			</resources>
*/

/*
	Разные размеры экранов.

	- Выбрали в макете design

	- На второй панели выше макета выбираем ориентацию экрана
*/