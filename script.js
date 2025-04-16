// Фильтры каталога
const genreFilter = document.getElementById("genreFilter");
if (genreFilter) {
  genreFilter.addEventListener("change", (e) => {
    const genre = e.target.value;
    const cards = document.querySelectorAll(".game-card");
    cards.forEach((card) => {
      if (genre === "all" || card.dataset.genre === genre) {
        card.style.display = "block";
      } else {
        card.style.display = "none";
      }
    });
  });
}

// Проверка формы
const contactForm = document.getElementById("contactForm");
if (contactForm) {
  contactForm.addEventListener("submit", (e) => {
    e.preventDefault();
    const name = document.getElementById("name").value;
    const email = document.getElementById("email").value;
    if (name && email) {
      alert("Спасибо, " + name + "! Мы свяжемся с вами.");
      contactForm.reset();
    } else {
      alert("Пожалуйста, заполните все поля.");
    }
  });
}

// Крестики-нолики
const canvas = document.getElementById("gameCanvas");
if (canvas) {
  const ctx = canvas.getContext("2d");
  let board = ["", "", "", "", "", "", "", "", ""];
  let currentPlayer = "X";

  // Рисуем сетку
  ctx.beginPath();
  ctx.moveTo(100, 0); ctx.lineTo(100, 300);
  ctx.moveTo(200, 0); ctx.lineTo(200, 300);
  ctx.moveTo(0, 100); ctx.lineTo(300, 100);
  ctx.moveTo(0, 200); ctx.lineTo(300, 200);
  ctx.stroke();

  // Обработка кликов
  canvas.addEventListener("click", (e) => {
    const rect = canvas.getBoundingClientRect();
    const x = e.clientX - rect.left;
    const y = e.clientY - rect.top;
    const cellX = Math.floor(x / 100);
    const cellY = Math.floor(y / 100);
    const index = cellY * 3 + cellX;

    if (board[index] === "") {
      board[index] = currentPlayer;
      drawMove(cellX, cellY, currentPlayer);
      if (checkWin()) {
        alert(currentPlayer + " победил!");
        resetBoard();
      } else {
        currentPlayer = currentPlayer === "X" ? "O" : "X";
      }
    }
    if (board.every((cell) => cell !== "")) {
      alert("Ничья!");
      resetBoard();
    }
  });

  function drawMove(x, y, player) {
    ctx.font = "50px Arial";
    ctx.fillText(player, x * 100 + 35, y * 100 + 65);
  }

  function checkWin() {
    const wins = [
      [0, 1, 2], [3, 4, 5], [6, 7, 8],
      [0, 3, 6], [1, 4, 7], [2, 5, 8],
      [0, 4, 8], [2, 4, 6]
    ];
    return wins.some((win) =>
      board[win[0]] !== "" &&
      board[win[0]] === board[win[1]] &&
      board[win[1]] === board[win[2]]
    );
  }

  function resetBoard() {
    board = ["", "", "", "", "", "", "", "", ""];
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    ctx.beginPath();
    ctx.moveTo(100, 0); ctx.lineTo(100, 300);
    ctx.moveTo(200, 0); ctx.lineTo(200, 300);
    ctx.moveTo(0, 100); ctx.lineTo(300, 100);
    ctx.moveTo(0, 200); ctx.lineTo(300, 200);
    ctx.stroke();
  }
}