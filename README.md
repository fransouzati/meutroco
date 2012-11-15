Meu Troco
=========
Projeto meutroco open-source - Gerenciador financeiro pessoal. Ainda não conhece? Leia em: <http://www.rafaheringer.com.br/meu-troco-gestao-financeira-pessoal/>

Próximos passos
---------------

SEGURANÇA:
+	Nas ações da API, verificar o tempo de expiração do token.
+	Nas ações da API, verificar se o token está associado ao APIKEY da aplicação.
+	Enviar informacoes de login/senha para a pagina login/index.php. Nesta página, criptografar a senha; Mascarar a API_KEY com uma máscara única (criptografar). Essa máscara terá uma parte "random", de apr. 7 caracteres. Essa mascara será cadastrada no BD e NUNCA mais poderá ser usada.  Assim evita que alguém copie a API_KEY e use  como um outro aplicativo.
+	Criptografar a senha também na página de edição do perfil.

TOKEN:
+	Gerar token quando o usuário logar-se. Assim não vai ser preciso cookie e session.
+	Antes de gerar o token, verificar a APIKEY do aplicativo e suas permissões.
+	Para cada atividade do usuário, resetar o tempo de expiração do token.
+	Tempo de expiração para token inativo: 30min.
+	O token terá sempre que ser passado como querystring, para a API pegar via _GET, junto com a API key.

LOGIN:
+	Login via post.
+	Verificar se existe e suas permissões.
+	Retornar mensagem de erro ou apenas o token gerado.
+	Ao logar, verificar se já não existe um token ativo para o usuário e para o aplicativo. Se sim, retornar este.
+	Salvar o token atrelado ao ID do usuário, ao horário de login e ao tempo de expiração do token sem atividade.

DESIGN:
+	Fazer a landing-page do site

Contas:
+	Ao criar uma conta do tipo Cartão de Crédito, dar a opção do usuário setar a data de vencimento do cartão. Ao inserir uma transação no cartão, dar a opção de escolher em qual mês será o vencimento.
+	Então, no menu, terá um ítem "Lançamentos Futuros" que, além de listar a fatura do cartão, irá listar as transações marcadas para o futuro.
+	No Cartão de Crédito, não existirá "adicionar transação". Existirá duas opções "pagar fatura" e "adicionar compra".
+	Nas transações, inserir opção de parcelamento.
+	Ao excluir uma conta, dar a opção de passar todas as transações para outra conta ou deletar todas as transações.


Changelog
----------
v0.8
+	Nova página de edição de perfil
+	Correção bugs #1, #2 e #5
+	Alterações de textos no menu
+	Avatar padrão para homens e mulheres

API (Não incluso no GIT, projeto privado)
-----------------------------------------

### Definições iniciais ###
+	Tipo de dados: JSON
+	Toda e qualquer ação, verificar se o aplicativo (api_key) tem permissão para isso
+	Toda e qualquer ação, verificar o token gerado
+	Verificar também se o TOKEN está ativo e pertence ao usuário
+	Toda e qualquer ação, verificar a sessão de login e permissão do usuário
+	Criar uma lógica melhor para TOKEN

### Métodos de Requisições ###
+	Usaremos métodos de requisições HTTP para as ações da API. 
+	As requisições, basicamente, são:
	+	GET: Carregar, retornar
	+	POST: Criar
	+	PUT: Atualizar
	+	DELETE: Remover

### HTTP HEADER códigos de status ###
+	201 = Created (ex.: Sucesso ao criar usuário)
+	500 = Internal Server Error (ex.: Falhou ao criar usuário)
+	400 = Bad Request (ex.: Errou ao formatar o request)
+	501 = Not Implemented (ex.: funcionalidade não suportada)
+	503 = Service unavailable (ex.: servidor off)

### Tipos de Transações ###
+	1 = Despesa
+	2 = Receita
+	3 = Transferência

### Tipos de Contas ###
+	1 - Cartão de Crédito
+	2 - Carteira
+	3 - Poupança
+	4 - conta Corrente
+	5 - Outro

### FUTURO ###
+	Download de programa via ADOBE AIR. Verificar conexão com internet.