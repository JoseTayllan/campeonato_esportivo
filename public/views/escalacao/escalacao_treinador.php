<?php
session_start();
$restrito_para = ['Treinador'];
require_once __DIR__ . '/../../../app/middleware/verifica_sessao.php';
?>

<?php include '../cabecalho/header.php'; ?>
<?php include '../cabecalho/tabela_treinador.php'; ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Escalação do Time</title>
  <style>
    body { background-color: #0b6623; margin: 0; font-family: Arial, sans-serif; color: white; }
    #campo {
      width: 100%;
      height: 90vh;
      position: relative;
      background: url('../../img/campo_futebol.png') no-repeat center center;
      background-size: cover;
      border: 4px solid #fff;
    }

    .jogador {
      width: 60px; height: 60px;
      border-radius: 50%; background-color: #f0ad4e;
      display: flex; justify-content: center; align-items: center;
      position: absolute; cursor: grab; user-select: none;
      overflow: visible; flex-direction: column;
    }
    .jogador img {
      width: 100%; height: 100%; object-fit: cover; position: absolute; top: 0; left: 0; z-index: 0; border-radius: 50%;
    }
    .jogador span {
      z-index: 1; font-size: 11px; font-weight: bold; background-color: rgba(0,0,0,0.6); padding: 2px 4px; border-radius: 4px;
      color: white; margin-top: 65px; position: relative;
    }

    #formacao {
      padding: 10px; background-color: #222; display: flex; gap: 10px; align-items: center;
    }
    select, button {
      padding: 8px; font-size: 16px;
    }
    .modal {
      position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);
      background: white; padding: 20px; color: black;
      display: none; z-index: 1000; border-radius: 10px;
      width: 300px;
    }
    .modal input, .modal select {
      width: 100%; margin-bottom: 10px; padding: 6px;
    }
  </style>
</head>
<body>
  <div id="formacao">
    <label for="selectFormacao">Formação:</label>
    <select id="selectFormacao">
  <option value="4-3-3">4-3-3</option>
  <option value="4-4-2">4-4-2</option>
  <option value="3-5-2">3-5-2</option>
  <option value="5-4-1">5-4-1</option>
  <option value="5-3-2">5-3-2</option>
  <option value="3-4-3">3-4-3</option>
  <option value="4-5-1">4-5-1</option>
  <option value="3-6-1">3-6-1</option>
  <option value="2-3-5">2-3-5 (clássica)</option>
</select>
    <button onclick="gerarEscalacao()">Gerar</button>
  </div>

  <div id="campo"></div>

  <div class="modal" id="modalSelecionar">
    <label>Nome do Jogador:</label>
    <input type="text" id="inputNome" placeholder="Nome do Jogador">

    <label>Número da Camisa:</label>
    <input type="text" id="inputNumero" placeholder="Ex: 10">

    <label>Imagem:</label>
    <input type="file" id="inputImagem" accept="image/*">

    <button onclick="atribuirJogador()">Atribuir</button>
  </div>

  <div style="text-align: center; margin: 15px;">
    <button onclick="baixarEscalacaoComoImagem()" style="padding: 10px 20px; font-size: 16px;">Salvar como Imagem</button>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
  <script>
    let jogadorSelecionado = null;

    function gerarEscalacao() {
      const campo = document.getElementById('campo');
      campo.innerHTML = '';

      // Adiciona o goleiro fixo
      const goleiro = document.createElement('div');
      goleiro.className = 'jogador';
      goleiro.style.left = '30px';
      goleiro.style.top = (campo.clientHeight / 2 - 30) + 'px';
      goleiro.innerHTML = '<span>1 - Goleiro</span>';
      goleiro.ondblclick = () => {
        jogadorSelecionado = goleiro;
        document.getElementById('modalSelecionar').style.display = 'block';
      };
      dragElement(goleiro);
      campo.appendChild(goleiro);

      const formacao = document.getElementById('selectFormacao').value.split('-');
    

      const altura = campo.clientHeight;
      const largura = campo.clientWidth;

      formacao.forEach((qtd, linha) => {
        const x = (linha + 1) * (largura / (formacao.length + 1));
        for (let i = 0; i < qtd; i++) {
          const y = (i + 1) * (altura / (parseInt(qtd) + 1));
          const div = document.createElement('div');
          div.className = 'jogador';
          div.style.left = `${x - 30}px`;
          div.style.top = `${y - 30}px`;
          div.innerHTML = '<span>?</span>';

          div.ondblclick = () => {
            jogadorSelecionado = div;
            document.getElementById('modalSelecionar').style.display = 'block';
          };

          dragElement(div);
          campo.appendChild(div);
        }
      });
    }

    function atribuirJogador() {
      const nome = document.getElementById('inputNome').value;
      const numero = document.getElementById('inputNumero').value;
      const imagem = document.getElementById('inputImagem').files[0];

      if (jogadorSelecionado) {
        const span = jogadorSelecionado.querySelector('span');
        span.innerText = `${numero} - ${nome}`;

        if (imagem) {
          const reader = new FileReader();
          reader.onload = function(e) {
            let img = jogadorSelecionado.querySelector('img');
            if (!img) {
              img = document.createElement('img');
              jogadorSelecionado.insertBefore(img, jogadorSelecionado.firstChild);
            }
            img.src = e.target.result;
          }
          reader.readAsDataURL(imagem);
        }
      }
      document.getElementById('modalSelecionar').style.display = 'none';
    }

    function baixarEscalacaoComoImagem() {
  html2canvas(document.getElementById('campo')).then(canvas => {
    const link = document.createElement('a');
    link.download = 'escalacao.png';
    link.href = canvas.toDataURL();
    link.click();
  });
}

function dragElement(elmnt) {
      let pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
      elmnt.onmousedown = dragMouseDown;

      function dragMouseDown(e) {
        e = e || window.event;
        e.preventDefault();
        pos3 = e.clientX;
        pos4 = e.clientY;
        document.onmouseup = closeDragElement;
        document.onmousemove = elementDrag;
      }

      function elementDrag(e) {
        e = e || window.event;
        e.preventDefault();
        pos1 = pos3 - e.clientX;
        pos2 = pos4 - e.clientY;
        pos3 = e.clientX;
        pos4 = e.clientY;
        elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
        elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
      }

      function closeDragElement() {
        document.onmouseup = null;
        document.onmousemove = null;
      }
    }
  </script>
</body>
</html>
