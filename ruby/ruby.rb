=begin
    Оглавление:
        История
        Вывод
        Строки
        Числа
        Массивы
        Символ
        Ассоциативный массив (hash)
        Блоки
        Аргументы
        Цикл
        Условия
        Истина/Ложь
        Классы
        Выполнение файла
=end

# История
=begin
    Ruby - интерпретируемый, динамический, рефлективный, объектно-ориентированный язык программирования.

    Появлися в 1995. Автор Юкихиро Мацумото.
=end

# Вывод
puts 3 + 1

# puts всегда возвращает nil

# Строки
puts 'Ilya'

puts 'Ilya'.reverse
puts 'Ilya'.length
puts 'Ilya' * 3
puts 22.to_s
puts 'Ilya'.gsub('I', 'i')

poem = 'The Koans walk you along the path to enlightenment in order to learn Ruby. The goal is to learn the Ruby language, syntax, structure, and some common functions and libraries.'
puts poem.lines.reverse # выводит строку в одну линию

puts poem.lines.reverse.join('\n') # добавляет к каждой строчке перенос

puts 'Hello, my name is # {name}' # форматирование строк (подставляет name на нужное место)

puts 'xyz'.empty?

puts 'ilya'.capitalize # делает первую букву большой

# Числа
# 40.reverse (выдаст ошибку)
puts 40.to_s.reverse
puts '80'.to_i
puts 3 ** 2 # возводит число в степень, то есть 3 в квадрате
Math.sqrt(9) # квадратный корень (какое число умноженное на себя даёт входное число), возвращает 3.0

# Массивы
puts [22, 48, 33]

puts [22, 48, 33].max

ticket = [12, 47, 35]
puts ticket

puts ticket.sort! # восклицательный знак говорит о том, что переменная будет изменена навсегда

puts ticket[0]

# ticket << User.new(name, age) - символ << означает добавление в конец массива

# Символ
puts :yes # использовать вместо строк, потому что хранит в памяти только одну копию 

# Ассоциативный массив (hash)
books = {}

books['title'] = :good

puts books.length
puts books['title']

puts books.keys
puts books.values

# Блоки (куски кода, которые можно привязать к любому строенному методу)
5.times { print "Odelay! " } # блоки всегда привязаны к методам, метод times повторяет блок

5.times { |time| # time это аргумент, который мы передаём в блок
  puts time # значение переменной time доступно только внутри блока (локальная) 
}

# Аргументы
puts 'test'.gsub 't', 'T' # можно передавать аргументы без круглых скобок

# Функции
def show_name(name)
    return name
end

puts show_name('Ilya')

# Цикл

=begin
author = '{"William Shakespeare" => {"1" => {"title" => "The Two Gentlemen of Verona", "finished"=>1591}, "2" => {"title" => "The Taming of the Shrew", "finished"=>1591},}}' # здесь должен быть валидный json.

author['William Shakespeare'].each { |key, val|
    puts val['title']
}
=end

fruits = {
    'apple' => 'green', 
    'banana' => 'yellow',
    'orange' => 'red'
}

fruits.each { |key, val|
    puts val
}

# Условия
a = 1

if a == 0
  puts "a is zero"
elsif a == 1
  puts "a is one"
else
  puts "a is some other value"
end

puts a if a == 1

# Истина/Ложь
5 <= 10 # => true
'abc' == 'def' # => false
true # => true
123456 # => true
0 # => true
nil # => false
# 'a' > 5 # => error

# Классы
class User
    attr_accessor :content, :time, :mood # attr_accessor устанавливает атрибуты для класса

    def initialize(mood, content='') # конструктор
        @content = content[0..39] # @content объектная переменная
        @time = Time.now
        @mood = mood
        @names = ['Ilya', 'Nastya', 'Oleg']
    end

    def say
        if @mood.nil? # проверяет значение на пустоту
            @names.each do |name| # бежит по итерируемому (если это не итерируемое, то преобразовали к строке и цикл сработал). Код менжду do и end это блок, блок это что наподобии анонимной функции
                puts 'Hello #{name}' 
            end
        end
        return :bye
    end

    def do
        return @content # ссылка на объектную переменную
    end
end

user = User.new(:good, 'simple user class')
# puts user.@content # нельзя напрямую получить св-во
puts user.instance_methods # позволяет увидеть все методы класса (включая методы родителя)
puts user.instance_methods(false) # позволяет увидеть только методы класса, которые мы определили
puts user.respond_to?('say') # позволяет узнать на какие методы может отвечать объект
puts user.say # переменные, которые могут использоваться вне класса (называются аксессоры)
# можно изменять св-ва и методы класса


# Выполнение файла

if __FILE__ == $0

=begin
    __FILE__ – это магическая переменная, которая содержит имя текущего файла. $0 – это имя файла, которое было использовано при запуске программы. Данная проверка говорит: “Если это тот самый файл, который был запущен изначально…”. Это позволяет файлу быть использованным как библиотека, и не выполнять код в данном контексте. Но если файл используется как выполняемый – тогда выполняем этот код.
=end