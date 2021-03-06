/*
	Общее.

	Самые важные понятия в интерфейсе Android — это Activity, View, ViewGroup, Layout.

		Activity — это та часть приложения, с которой взаимодействует пользователь.

		View — элемент интерфейса.

		ViewGroup — это модифицированный View, созданный для того, чтобы служить контейнером для других View.

		Layout — общее название для нескольких наследников ViewGroup. Лэйауты служат контейнерами для View, и созданы они для того, чтобы мы могли удобно располагать всяческие кнопочки, поля для ввода текста и прочие элементы интерфейса.

		Пример: 

			поле для ввода и 2 кнопки - View

			2 кнопки объединены зелёной рамкой (схематично) - ViewGroup

			рамка вокрук поля ввода и двух кнопок - другое ViewGroup

	Все группы представлений включают в себя параметры ширины и высоты (layout_width и layout_height), и каждое представление должно определять их.
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
	Позиционирование:

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