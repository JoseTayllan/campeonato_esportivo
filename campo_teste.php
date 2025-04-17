<!-- campo_teste.php -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Teste de Escalação</title>
  <style>
    body { font-family: Arial; text-align: center; background: #d0f0c0; }
    .campo-container {
      position: relative;
      width: 600px;
      height: 800px;
      margin: auto;
    }
    .campo {
      width: 100%;
      height: 100%;
      background: green;
      border: 5px solid #fff;
      border-radius: 15px;
      position: relative;
    }
    .desenho {
      position: absolute;
      top: 0; left: 0;
      width: 100%;
      height: 100%;
      z-index: 10;
      pointer-events: auto;
    }
    .jogador {
      width: 30px; height: 30px;
      border-radius: 50%; background: yellow; color: black;
      text-align: center; line-height: 30px;
      position: absolute; font-weight: bold;
      cursor: move; user-select: none;
      z-index: 20;
    }
    .controle {
      margin: 20px auto; width: 300px;
    }
    .controle input, .controle select, .controle button {
      width: 100%; padding: 5px; margin-bottom: 10px;
    }
  </style>
</head>
<body>

  <h1>Simulador de Escalação + Desenho</h1>

  <div class="controle">
    <select id="formacao">
      <option value="4-3-3">4-3-3</option>
      <option value="5-3-2">5-3-2</option>
      <option value="3-5-2">3-5-2</option>
      <option value="4-4-2">4-4-2</option>
    </select>
    <input type="text" id="nomes" placeholder="(Opcional) Jogadores separados por vírgula">
    <button onclick="gerarEscalacao()">Aplicar Escalação</button>
    <button onclick="limparDesenho()">Limpar Desenho</button>
  </div>

  <div class="campo-container">
    <div class="campo" id="campo"></div>
    <canvas class="desenho" id="canvas"></canvas>
  </div>

  <script>
    let dragItem = null;
    let offsetX = 0, offsetY = 0;

    function gerarEscalacao() {
      const formacao = document.getElementById('formacao').value.split('-').map(Number);
      const nomesInput = document.getElementById('nomes').value;
      const nomes = nomesInput.length > 0 ? nomesInput.split(',') : [];
      const campo = document.getElementById('campo');
      campo.innerHTML = ''; // limpa bonecos

      const linhas = formacao.length + 1;
      const altura = campo.clientHeight / linhas;

      criarJogador(campo, nomes[0] || 'G', (campo.clientWidth / 2) - 15, altura * (linhas - 1));

      let idx = 1;
      formacao.forEach((num, i) => {
        const y = altura * (linhas - i - 2);
        for (let j = 0; j < num; j++) {
          const x = ((campo.clientWidth - 40) / (num + 1)) * (j + 1);
          criarJogador(campo, nomes[idx] || `J${idx}`, x, y);
          idx++;
        }
      });
    }

    function criarJogador(campo, nome, left, top) {
      const jogador = document.createElement('div');
      jogador.className = 'jogador';
      jogador.textContent = nome;
      jogador.style.left = `${left}px`;
      jogador.style.top = `${top}px`;

      jogador.ondblclick = function (e) {
        e.stopPropagation();
        const novoNome = prompt("Digite o nome do jogador:", jogador.textContent);
        if (novoNome !== null && novoNome.trim() !== "") {
          jogador.textContent = novoNome.trim();
        }
      };

      jogador.onmousedown = function (e) {
        dragItem = jogador;
        offsetX = e.clientX - jogador.offsetLeft;
        offsetY = e.clientY - jogador.offsetTop;
        document.onmousemove = moverJogador;
        document.onmouseup = soltarJogador;
      };

      campo.appendChild(jogador);
    }

    function moverJogador(e) {
      if (dragItem) {
        dragItem.style.left = `${e.clientX - offsetX}px`;
        dragItem.style.top = `${e.clientY - offsetY}px`;
      }
    }

    function soltarJogador() {
      dragItem = null;
      document.onmousemove = null;
      document.onmouseup = null;
    }

    // Canvas para desenho
    const canvas = document.getElementById('canvas');
    const ctx = canvas.getContext('2d');
    const container = document.querySelector('.campo-container');
    canvas.width = container.offsetWidth;
    canvas.height = container.offsetHeight;

    let desenhando = false;

    canvas.addEventListener('mousedown', (e) => {
      desenhando = true;
      ctx.beginPath();
      ctx.moveTo(e.offsetX, e.offsetY);
    });

    canvas.addEventListener('mousemove', (e) => {
      if (desenhando) {
        ctx.lineTo(e.offsetX, e.offsetY);
        ctx.strokeStyle = 'white';
        ctx.lineWidth = 2;
        ctx.stroke();
      }
    });

    canvas.addEventListener('mouseup', () => {
      desenhando = false;
    });

    function limparDesenho() {
      ctx.clearRect(0, 0, canvas.width, canvas.height);
    }
  </script>

</body>
</html>
