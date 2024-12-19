<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "library";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

$register_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    
    if (empty($username) || empty($email) || empty($password)) {
        $register_message = "Все поля обязательны для заполнения.";
    } else {
        
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("sss", $username, $email, $hashed_password);

            
            if ($stmt->execute()) {
                $register_message = "Тіркелу сәтті өтті!";
            } else {
                $register_message = "Қате: " . $stmt->error;
            }

            $stmt->close();
        } else {
            $register_message = "Қате : " . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Онлайн кітапхана</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            color: #333;
            background-color: #f9f9f9;
        }

        /* Шапка */
        header {
            background-color: #2b4f60;
            color: #fff;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header .logo {
            font-size: 24px;
        }

        header nav ul {
            list-style: none;
            display: flex;
            gap: 15px;
        }

        header nav ul li a {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s;
        }

        header nav ul li a:hover {
            color: #ffcc00;
        }

        
.banner {
    background-color: #2b4f60; 
    padding: 50px;
    text-align: center;
    color: white; 
}

.banner h1 {
    font-size: 36px;
    color: white; 
}


.catalog, .search-section, .contact-section, .register-section {
    padding: 20px;
    text-align: center;
}


.search-section {
    background-color: #f4f4f4; 
}

.search-bar-container {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-top: 20px;
}

#search-bar {
    padding: 10px;
    font-size: 16px;
    border-radius: 5px;
    border: 1px solid #ccc;
}

.search-button {
    padding: 10px 20px;
    background-color: #1e3d58; 
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.search-button:hover {
    background-color: #165072; 


.catalog h2, .search-section h2, .contact-section h2, .register-section h2 {
    font-size: 28px;
    margin-bottom: 15px;
    color: #2b4f60;
}


        
        .genre-button {
            background-color: #2b4f60;
            color: #fff;
            border: none;
            padding: 10px 20px;
            margin: 5px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s, transform 0.2s;
        }

        .genre-button:hover {
            background-color: #ffcc00;
            color: #2b4f60;
            transform: scale(1.05);
        }

        
        .book {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
        }

        .book-item {
            background-color: #fff;
            padding: 15px;
            width: 150px;
            text-align: center;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s, transform 0.2s;
        }

        .book-item:hover {
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            transform: translateY(-5px);
        }

        .book-item h3 {
            font-size: 18px;
            margin-bottom: 5px;
            color: #2b4f60;
        }

        .book-item p {
            font-size: 14px;
            color: #555;

        }

       
.search-banner {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 20px;
    background-color: #eef7fa;
    background-image: linear-gradient(to right, #cfd9df, #e2ebf0);
}


.search-bar-container {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    margin-bottom: 20px;
    width: 100%;
    max-width: 800px;
    background: linear-gradient(145deg, #d1e8ef, #f4fbff);
    box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    padding: 10px;
}

#search-bar {
    flex: 1;
    padding: 10px;
    font-size: 16px;
    border: none;
    border-radius: 5px;
    outline: none;
    box-shadow: inset 2px 2px 5px rgba(0, 0, 0, 0.1), inset -2px -2px 5px rgba(255, 255, 255, 0.7);
}

.search-button {
    background: linear-gradient(145deg, #6fc6ff, #509ee3);
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease-in-out;
}

.search-button:hover {
    background: linear-gradient(145deg, #509ee3, #6fc6ff);
    transform: translateY(-3px);
}


.image-container {
    text-align: center;
    max-width: 800px;
    width: 100%;
}

.image-container img {
    width: 100%;
    height: auto;
    border-radius: 10px;
    object-fit: cover;
}



.register-section.hidden {
            display: none;
        }

        #register-form div {
            margin-bottom: 15px;
        }

        #register-form input {
            width: 80%;
            max-width: 300px;
            padding: 10px;
            border: 2px solid #2b4f60;
            border-radius: 5px;
            font-size: 14px;
        }

        #register-form input:focus {
            outline: none;
            border-color: #ffcc00;
            box-shadow: 0 0 5px rgba(255, 204, 0, 0.8);
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">📚 Онлайн кітапхана</div>
        <nav>
            <ul>
                <li><a href="#catalog">Каталогтар</a></li>
                <li><a href="#search">Іздеу</a></li>
                <li><a href="javascript:void(0)" id="toggle-register-btn">Тіркелу</a></li>
                <li><a href="#contact">Байланыс</a></li>
            </ul>
        </nav>
    </header>

    <section class="banner">
        <h1>Біздің онлайн кітапханамызға Қош келдіңіз!</h1>
        <p>Кітаптар әлемін дәл бізде ашыңыз!</p>
    </section>
    
    <section id="register" class="register-section hidden">
        <h1>Тіркелу</h1>
        <?php if (!empty($register_message)): ?>
            <p><?php echo htmlspecialchars($register_message); ?></p>
        <?php endif; ?>

        <form id="register-form" method="post" action="">
            <label for="username">Атыңыз</label><br>
            <input type="text" id="username" name="username" required><br><br>

            <label for="email">Email</label><br>
            <input type="email" id="email" name="email" required><br><br>

            <label for="password">Құпия сөз</label><br>
            <input type="password" id="password" name="password" required><br><br>

            <button type="submit">Тіркелу</button>
        </form>
    </section>

    <section id="search-banner" class="search-banner">
        <div class="search-bar-container">
            <input type="text" id="search-bar" placeholder="Кітаптың атын немесе авторды іздеңіз..." onkeyup="searchBooks()">
            <button type="button" class="search-button">🔍</button>
        </div>
        <div class="image-container">
            <img src="https://nkgacademy.com/wp-content/uploads/2021/04/articles.jpg" alt="Читающая девушка">
        </div>
    </section>

    <section id="catalog" class="catalog">
        <h2>Кітаптар Каталогы</h2>
        <div id="genre-list"></div>
        <div class="book" id="book-list"></div>
    </section>
    
    <section id="contact" class="contact-section">
        <h2>Байланыс</h2>
        <p>Мекен-жайы: Алматы қ., Гоголя к-сі, 114-үй</p>
        <p>Телефон: +7 (747) 565-89-14</p>
        <p>Email: info@bookstore.ru</p>
    </section>

    <script>
        // Ваши книги
        const books = [
            { title: "Махаббат, қызық мол жылдар", author: "Әзілхан Нұршайықов", genre: "Романтика", url: "http://dev-s.balatili.kz/uploads/books/e3c0b8aca955a2e22aa53f053550270c/%D0%9C%D0%B0%D1%85%D0%B0%D0%B1%D0%B1%D0%B0%D1%82%20%D2%9B%D1%8B%D0%B7%D1%8B%D2%9B%20%D0%BC%D0%BE%D0%BB%20%D0%B6%D1%8B%D0%BB%D0%B4%D0%B0%D1%80.pdf" },
            { title: "Абай Жолы", author: "Мұхтар Әуезов", genre: "Классика", url: "https://predmet.kz/adebiet/%D0%BA%D1%96%D1%82%D0%B0%D0%BF%D1%82%D0%B0%D1%80/%D0%90%D0%B1%D0%B0%D0%B9%20%D0%B6%D0%BE%D0%BB%D1%8B.1%20%D0%BA%D1%96%D1%82%D0%B0%D0%BF.pdf" },
            { title: "Қан мен Тер", author: "Әбдіжәміл Нұрпейісов", genre: "Классика", url: "https://adebiportal.kz/upload/iblock/0d5/0d581f528880c6ae74bf3685d2ef0add.pdf" },
            { title: "Ұшқан ұя", author: "Бауыржан Момышұлы", genre: "Мемуары", url: "https://adebiportal.kz/upload/iblock/5e1/5e13518fb629e466f3a930c56af4d672.pdf"  },
            { title: "Бақытсыз Жамал", author: "Міржақов Дулатұлы", genre: "Романтика", url: "http://dev-s.balatili.kz/uploads/books/c440d23f5b0133c2199ed66e3fb01ffd/%D0%91%D0%90%D2%9A%D0%AB%D0%A2%D0%A1%D0%AB%D0%97%20%D0%96%D0%90%D0%9C%D0%90%D0%9B%20-%20%D0%A0%D0%BE%D0%BC%D0%B0%D0%BD.pdf"  },
            { title: "Ұлпан", author: "Ғабит Мүсірепов", genre: "Исторический", url: "#"  },
            { title: "Қар қызы", author: "Оралхан Бөкей", genre: "Драма", url: "#"  },
            { title: "Ақ кеме", author: "Шыңғыс Айтматов", genre: "Притча", url: "#"  },
            { title: "ГауҺар тас", author: "Дулат Исабеков", genre: "Драма", url: "#"  },
            { title: "Сүйекші", author: "Дулат Исабеков", genre: "Драма", url: "#"  },
            { title: "Қызыл Жебе", author: "Шерхан Мұртаза", genre: "Исторический", url: "#"  },
            { title: "Балалық шақ", author: "Шыңғыс Айтматов", genre: "Мемуары", url: "#"  },
            { title: "Аштық жайлаған дала", author: "Сара Камерон", genre: "Исторический", url: "#"  },
            { title: "Еңлік - Кебек", author: "Мұхтар Әуезов", genre: "Драма", url: "#"  },
            { title: "Ай мен Айша", author: "Шерхан Мұртаза", genre: "Романтика", url: "#"  },
            { title: "Дермене", author: "Дулат Исабеков", genre: "Драма", url: "#"  },
            { title: "Қорғансыздың күні", author: "Мұхтар Әуезов", genre: "Классика", url: "#"  },
            { title: "Мөлдір Махаббат", author: "Сәбит Мұханов", genre: "Романтика", url: "#"  },
            { title: "Ақбілек", author: "Жүсіпбек Аймауытов", genre: "Классика", url: "#"  },
            { title: "Көшпенділер", author: "Ілияс Есенберлин", genre: "Исторический", url: "#"  },
            { title: "Оралу", author: "Төлен Әбдікұлы", genre: "Философия", url: "#"  },
            { title: "Қаһар", author: "Ілияс Есенберлин", genre: "Исторический", url: "#" }
        ];

        
        function toggleRegisterSection() {
            const registerSection = document.getElementById('register');
            registerSection.classList.toggle('hidden');
        }

        // Поиск книг
        function searchBooks() {
            const searchTerm = document.getElementById('search-bar').value.toLowerCase();
            const filteredBooks = books.filter(book =>
                book.title.toLowerCase().includes(searchTerm) || book.author.toLowerCase().includes(searchTerm)
            );
            const bookContainer = document.getElementById('book-list');
            bookContainer.innerHTML = `<h2>Результаты поиска</h2>`;
            displayBooks(filteredBooks);
        }

        // Отображение всех книг
        function displayBooks(bookArray = books) {
            const bookContainer = document.getElementById('book-list');
            bookContainer.innerHTML = "";
            bookArray.forEach(book => {
                const bookItem = document.createElement('div');
                bookItem.className = 'book-item';
                bookItem.innerHTML = `
                    <h3>${book.title}</h3>
                    <p>${book.author}</p>
                    <a href="${book.url}" target="_blank" class="read-button">Кітапты оқу</a>
                `;
                bookContainer.appendChild(bookItem);
            });
        }

        // Отображение жанров
        function displayGenres() {
            const genreContainer = document.getElementById('genre-list');
            const genres = [...new Set(books.map(book => book.genre))];
            genreContainer.innerHTML = "";
            genres.forEach(genre => {
                const genreButton = document.createElement('button');
                genreButton.textContent = genre;
                genreButton.className = 'genre-button';
                genreButton.onclick = () => {
                    const filteredBooks = books.filter(book => book.genre === genre);
                    document.getElementById('book-list').innerHTML = `<h2>Книги жанра: ${genre}</h2>`;
                    displayBooks(filteredBooks);
                };
                genreContainer.appendChild(genreButton);
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            displayGenres();
            displayBooks();
            document.getElementById('toggle-register-btn').addEventListener('click', toggleRegisterSection);
        });
    </script>
</body>
</html>


