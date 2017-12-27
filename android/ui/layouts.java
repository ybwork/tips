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