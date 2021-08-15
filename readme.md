## Рекомендации для запуска приложения

* После того как спулите приложение, выполните комманду - `docker-compose up -d`
* Пропишите в файл hosts - `127.0.0.1 tic-tac-toe.local`, в браузере набирайте `http://tic-tac-toe.local:8080/`, далее роутинг согласно задания и файла 
  `/public/tictactoe.yaml`
* Можете воспользоваться коллекцией сохраненных запросов. Лежит в папке `/public/TicTacToe.postman_collection.json`
* В качестве хранилища использовал файл `games.txt`, генерируется автоматически
* Время примерно затратил 8 часов, использовал Lumen, так как по нему задавали вопросы на собеседовании
* Логика компьютера для ответа человеку использовалась случайная, без учета оптимального хода

## Game flow

* The client (player) starts a game, makes a request to server to initiate a TicTakToe board. ( Client (player) will always use cross )
* The backend responds with the location URL of the started game.
* Client gets the board state from the URL.
* Client makes a move; move is sent back to the server.
* Backend validates the move, makes it's own move and updates the game state. The updated game state is returned in the response.
* And so on. The game is over once the computer or the player gets 3 noughts or crosses, horizontally, vertically or diagonally or there are no moves to be made.
