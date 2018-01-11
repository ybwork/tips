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