Meu Troco
=========
Projeto meutroco open-source - Gerenciador financeiro pessoal. Ainda não conhece? Leia em: <http://www.rafaheringer.com.br/meu-troco-gestao-financeira-pessoal/>

Quer opinar? Sugerir uma funcionalidade? Ver o que está sendo discutido? Veja em <https://trello.com/board/meu-troco-backlog/>

Changelog
----------
**11.08.2013**
+	Ordenação das contas agora por TIPO e por NOME
+	Exclusão de contas não apaga mais as transações

**...**
+	Correção de bugs #6, #7, #8 e #9
+	Adicionado UserVoice
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
