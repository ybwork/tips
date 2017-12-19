/*
	Список.

	Список — пронумерованное последовательность значений, где одно и то же значение может присутствовать сколько угодно раз.

	Обычный список позволяет очень быстро получить доступ к памяти, поскольку вы уже знаете нужный адрес.

	Списки отлично справляются с быстрым доступом к элементам (в конце списка) и работой с ними. Однако, как мы увидели, для элементов из начала или середины они не слишком хороши, так как приходится вручную обрабатывать адреса памяти.
*/
class List {

    constructor() {
        this.memory = [];
        this.length = 0;
    }

    /*
		Первым делом нужно получать данные из списка. Обычный список позволяет очень быстро получить доступ к памяти, поскольку вы уже знаете нужный адрес.

		Сложность операции доступа в список — O(1) — «ОХРЕНЕННО»
    */
    get(address) {
    	return this.memory[address];
	}

	/*
		Добавление элемента в конец списка — константа O(1) — «ОХРЕНЕННО!!»
	*/
	push(value) {
	    this.memory[this.length] = value;
	    this.length++;
	}

	/*
		Удаление элемента из конца списка — константа O(1) — «ОХРЕНЕННО!!»
	*/
	pop() {
	    if (this.length === 0) {
	    	return;
	    } else {
	    	var lastAddress = this.length - 1;
		    var value = this.memory[lastAddress];
		    delete this.memory[lastAddress];
		    this.length--;

	    	return value;
	    }
	}

	/*
		Чтобы добавить новый элемент в начало списка, нужно освободить пространство для этого значения, сдвинув на один все последующие значения. Чтобы сделать такой сдвиг, нужно пройтись по каждому из элементов и поставить на его место предыдущий.

		Добавление элемента в начало списка — линейно O(N) — «НОРМАС.»
	*/
	unshift(value) {
	    // Cохраняем значение, которое хотим добавить в начало.
	    var previous = value;

	    // Проходимся по каждому элементу...
	    for (var address = 0; address < this.length; address++) {
	        /*
				Заменяя текущее значение «current» на предыдущее значение «previous»,
				и сохраняя значение «current» для следующей итерации.
	        */
	        var current = this.memory[address];
	        this.memory[address] = previous;
	        previous = current;
	    }

	    // Добавляем последний элемент на новую позицию в конце списка.
	    this.memory[this.length] = previous;
	    this.length++;
	}

	/*
		Удаление элемента из начала списка — линейно O(N) — «НОРМАС.»
	*/
	shift() {
	    // Нет элементов — ничего не делаем.
	    if (this.length === 0) return;

	    var value = this.memory[0];

	    // Проходимся по каждому элементу, кроме последнего
	    for (var address = 0; address < this.length - 1; address++) {
	        // и заменяем его на следующий элемент списка.
	        this.memory[address] = this.memory[address + 1];
	    }

	    // Удаляем последний элемент, поскольку значение теперь в предыдущем адресе.
	    delete this.memory[this.length - 1];
	    this.length--;

	    return value;
	}
}

/*
	Хеш-таблицы.

	Хеш-таблица — неупорядоченная структура данных. Вместо индексов мы работаем с «ключами» и «значениями», вычисляя адрес памяти по ключу.

	Смысл в том, что ключи «хешируются» и позволяют эффективно работать с памятью — добавлять, получать, изменять и удалять значения.

	В Hash Table (хэщ-таблица) есть две главные сущности, первая — это собственно сам Hash Table, и вторая — это Bucket (ведро).

	В ведрах хранятся сами значения, то есть на каждое значение — свое ведро. Таким образом, когда вы добавляете новый элемент в массив, если такого ключа там еще нет, то под него создается новое ведро и добавляется в Hash Table.

	Каждое ведро имеет также указатель на предыдущее и следующее ведро, у которых индексы (хеши от ключей) равны.

	У хэщ-таблицы есть массив указателей на вёдра, в этом массиве вёдра доступны по индексу. Этот индекс можно вычислить зная ключ ведра.
*/
class HashTable {

    constructor() {
        this.memory = [];
    }

    /*
		Чтобы сохранять пары ключ-значение из хеш-таблицы в память, нужно превращать ключи в адреса. Этим занимается операция «хеширования». Она принимает на вход ключ и преобразовывает его в уникальное число, соответствующее этому ключу. Такая операция требует осторожности. Если ключ слишком большой, он будет сопоставляться несуществующему адресу в памяти. Следовательно, хеш-функция должна ограничивать размер ключей.
    */
    hashKey("abc") =>  96354

    /*
		Принимает на вход строку и возвращает (практически всегда) уникальный адрес, который мы будем использовать в остальных функциях.
    */
    hashKey(key) {
	    var hash = 0;

	    for (var index = 0; index < key.length; index++) {
	        var code = key.charCodeAt(index);
	        hash = ((hash << 5) - hash) + code | 0;
	    }

	    return hash;
	}

	/*
		Добавляет значение в хэщ-таблицу.

		Сложность установки значения в хеш-таблицу — константа O(1) — «ОХРЕНЕННО!!»
	*/
	set(key, value) {
	    // И вновь начинаем с превращения ключа в адрес.
	    var address = this.hashKey(key);
	    // Затем просто записываем значение по этому адресу.
	    this.memory[address] = value;
	}

	/*
		Получает значение по ключу.

		Сложность чтения значения из хеш-таблицы — константа O(1) — «ОХРЕНЕННО!!
	*/
	get(key) {
	    // Сперва получим адрес по ключу.
	    var address = this.hashKey(key);

	    // Затем просто вернём значение, находящееся по этому адресу.
	    return this.memory[address];
	}

	/*
		Удаление значений у хэш-таблицы.

		Сложность удаления значения из хеш-таблицы — константа O(1) — «ОХРЕНЕННО!!»
	*/
	remove(key) {
	    // Как обычно, хешируем ключ, получая адрес.
	    var address = this.hashKey(key);
	    // Удаляем значение, если оно существует.
	    if (this.memory[address]) {
	        delete this.memory[address];
	    }
	}
}

/*
	Стеки.

	Стеки похожи на списки. Они также упорядочены, но ограничены в действиях: можно лишь добавлять и убирать значения из конца списка.

	Наиболее общий пример использования стеков — у вас есть один процесс, добавляющий элементы в стек и второй, удаляющий их из конца
*/
class Stack {

    constructor() {
        this.list = [];
        this.length = 0;
    }
}

/*
	Добавляет элементы на верхушку стека.
*/
push(value) {
    this.length++;
    this.list.push(value);
}

/*
	Удаляет элементы из верхушки.
*/
pop() {
    // Нет элементов — ничего не делаем.
    if (this.length === 0) return;

    // Возьмём последний элемент списка, удалим и вернём значение.
    this.length--;
    return this.list.pop();
}

/*
	Показывает элемент на верхушке стека без его удаления. 
*/
peek() {
    // Возвращаем последний элемент, не удаляя его.
    return this.list[this.length - 1];
}

/*
	Очереди.

	Разница в том, что элементы очереди удаляются из начала, а не из конца, т.е. сначала старые элементы, потом новые.

	Важно заметить, что, поскольку для реализации очереди использовался список, она наследует линейную производительность метода shift (т.е. O(N) — «НОРМАС.»).
*/
class Queue {

    constructor() {
        this.list = [];
        this.length = 0;
    }
}

/*
	Добавление в конец списка
*/
enqueue(value) {
    this.length++;
    this.list.push(value);
}

/*
	Элемент удаляется не из конца списка, а из начала.
*/
dequeue() {
    // Нет элементов — ничего не делаем.
    if (this.length === 0) return;

    // Убираем первый элемент методом shift и возвращаем значение.
    this.length--;
    return this.list.shift();
}

/*
	Получает значение в начале очереди без его удаления.
*/
peek() {
    return this.list[0];
}

/*
	Граф.

	Граф - множество «вершин» (A, B, C, D, ...), связанных линиями.
*/
class Graph {

    constructor() {
        this.nodes = [];
    }
}

/*
	Добавляет значения в граф, создавая вершины без каких-либо линий.
*/
addNode(value) {
    this.nodes.push({
        value: value,
        lines: []
    });
}

/*
	Ищем вершины в графе
*/
find(value) {
    return this.nodes.find(function(node) {
        return node.value === value;
    });
}

/*
	Связываем две вершины проводя линию
*/
addLine(startValue, endValue) {
    // Найдём вершины для каждого из значений.
    var startNode = this.find(startValue);
    var endNode = this.find(endValue);

    // Ругнёмся, если не нашли одной или другой.
    if (!startNode || !endNode) {
        throw new Error('Обе вершины должны существовать');
    }

    // В стартовую вершину startNode добавим ссылку на конечную вершину endNode.
    startNode.lines.push(endNode);
}

/*
	Получаем граф.

	Графами можно представлять уйму вещей: пользователей и их друзей, 800 зависимостей в папке node_modules.
*/
var graph = new Graph();
graph.addNode(1);
graph.addNode(2);
graph.addLine(1, 2);
var two = graph.find(1).lines[0];


/*
	Связные списки.

	Связные списки — распространённая структура данных, зачастую используемая для реализации других структур. Преимущество связного списка — эффективность добавления элементов в начало, середину и конец.

	Структура в виде JSON:
*/
{
    value: 1,
    next: {
        value: 2,
        next: {
            value: 3,
            next: {...}
        }
    }
}

/*
	Связный список имеет единственную вершину, из которой начинается внутренняя цепочка. Её называют «головой»
*/
class LinkedList {
    constructor() {
        this.head = null;
        this.length = 0;
    }

    /*
		В отличие от обычных списков мы не можем перепрыгнуть на нужную позицию. Вместо этого мы должны перейти к ней через отдельные вершины
    */
    get(position) {
	    // Выведем ошибку, если искомая позиция превосходит число вершин в списке.
	    if (position >= this.length) {
	        throw new Error('Позиция выходит за пределы списка');
	    }

	    // Начнём с головного элемента списка.
	    var current = this.head;

	    // Пройдём по всем элементам при помощи node.next,
	    // пока не достигнем требуемой позиции.
	    for (var index = 0; index < position; index++) {
	        current = current.next;
	    }

	    // Вернём найденную вершину.
	    return current;
	}

	/*
		Добавляем вершину в выбранную позицию
	*/
	add(value, position) {
	    // Сначала создадим вершину, содержащую значение.
	    var node = {
	        value: value,
	        next: null
	    };

	    /*
			Нужно обработать частный случай, когда вершина вставляется в начало. Установим поле «next» в текущий головной элемент и заменим. Головной элемент нашей вершиной. Если мы добавляем вершину на любую другую позицию, мы должны вставить её между текущей вершиной current и предыдущей previous.
	    */
	    if (position === 0) {
	        node.next = this.head;
	        this.head = node;
	    } else {
			// Сперва найдём предыдущую и текущую вершины.
			var prev = this.get(position - 1);
			var current = prev.next;

			/*
				Затем вставим новую вершину между ними, установив поле «next», на текущую вершину current, и поле «next» предыдущей вершины previous — на вставляемую.
			*/
			node.next = current;
			prev.next = node;
	    }

	    this.length++;
	}

	/*
		Найдём вершину по позиции и выкинем её из цепочки.
	*/
	remove(position) {
	    /*
			Если мы удаляем головной элемент, просто переставим указатель head на следующую вершину. Для остальных случаев требуется найти предыдущую вершину и поставить в ней ссылку на вершину, следующую за текущей.
	    */
	    if (position === 0) {
	        this.head = this.head.next;
	    } else {
	        var prev = this.get(position - 1);
	        prev.next = prev.next.next;
	    }

	    this.length--;
	}
}

/*
	Деревья.

	
*/
Tree {
    root: {
        value: 1,
        children: [{
            value: 2,
            children: [...]
        }, {
            value: 3,
            children: [...]
        }]
    }
}

/*
	Дерево должно начинаться с единственного родителя, «корня» дерева.
*/
class Tree {
    constructor() {
        this.root = null;
    }

    /*
		Обходит наше дерево и вызывает определённую функцию в каждой его вершине.
    */
    traverse(callback) {
	    /*
			Определим функцию обхода walk, которую можно рекурсивно вызывать в каждой вершине дерева.
	    */
	    function walk(node) {
	        // Сперва вызовем callback на самой вершине.
	        callback(node);
	        // Затем рекурсивно вызовем walk на всех её потомках.
	        node.children.forEach(walk);
	    }

	    // А теперь запустим процесс обхода.
	    walk(this.root);
	}

	/*
		Добавляет вершины в дерево
	*/
	add(value, parentValue) {
	    var newNode = {
	        value: value,
	        children: []
	    };

	    // Если корня не существует, установим в него новую вершину.
	    if (this.root === null) {
	        this.root = newNode;
	        return;
	    }

	    // В остальных случаях переберём внутреннее дерево, найдём вершину
	    // с соответствующим значением parentValue и добавим новую вершину
	    // к его потомкам.
	    this.traverse(function(node) {
	        if (node.value === parentValue) {
	            node.children.push(newNode);
	        }
	    });
	}
}