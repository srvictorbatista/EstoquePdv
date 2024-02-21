<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

//*



// Funções para gerar dados aleatórios
function removerAcentos($string) {
    // Remove acentos
    $stringSemAcento = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
    // Remove caracteres especiais
    $stringSemEspeciais = preg_replace('/[^a-zA-Z0-9]/', '', $stringSemAcento);
    return $stringSemEspeciais;
}


function gerarNomeAleatorio() {
    $nomes = [
    	'ABC', 'BRAS', 'National', 'Marcos', 'Eficiente', 'Angelica', 'Total', 'GenteInteli', 'Veloz', 'BetoÁgil', 'RapidLog', 'Brasileirissima', 'A3', 'Rápida', 'Central', 'Velocidade', 'Águia', 'Segura', 'SulLog', 'DuNorte', 'Amazônense', 'Certa', 'SENEX', 'Pratica', 'Servisa', 'VIP', 'Cerrado', 'Mercosul', 'Garantida', 'Global', 'Valencia', 'Sul', 'Apeú', 'Amiga', 'Panamericana', 'Máxima', 'Ultra', 'Alpha', 'Beta', 'Gama', 'Delta', 'Omega', 'Sigmund', 'Reta', 'Primus', 'Marcone', 'Vitoria', 'O Sorvetão', 'Goiano'];

    $tipo = ['& Corp', 'S.A', 'Ltda', 'Comércio', 'Distribuidora', 'Suprimentos', 'Rápido', 'Atacado', 'Entregas', 'Expresso', 'Transportadora', 'Logística', 'Distribuição', 'Motors', 'Veiculos', 'Express', 'Produtos', '24 Horas', 'Transporte', 'Cargas', 'Log', '& Cia', 'Expressos'];

    $nome = $nomes[array_rand($nomes)] . ' ' . $tipo[array_rand($tipo)];
    return $nome;
}

// Gera CNPJs aleatorios. Porém, válidos
function gerarCNPJAleatorio($mask=0) {
    $DV01 = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
    $DV02 = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
    $cnpj = "";
    for ($i = 0; $i < 14; $i++): $cnpj .= ($i > 7 && $i < 11) ? '0' : (($i == 11) ? '1' : rand(0, 9)); endfor;
    $gerNum = str_split($cnpj);
    $i = count($gerNum) - 2;
    $y = count($gerNum) - 1;

    $total[]=0;$total[]=0;$resul[]=0;$resul[]=0;
    for ($j = 0; $j < count($DV01); $j++): $resul[0] += ($gerNum[$j] * $DV01[$j]); endfor;
    $rest[0] = ($resul[0] % 11);
    $check[0] =  $rest[0] < 2 ? 0 : $rest[0];
    $total[0] = $check[0] == 0 ? $check[0] : abs(11 - $rest[0]);

    $gerNum[$i] = $total[0];
    for ($k = 0; $k < count($DV02); $k++): $resul[1] += ($gerNum[$k] * $DV02[$k]); endfor;
    $rest[1] = ($resul[1] % 11);
    $check[1] =  $rest[1] < 2 ? 0 : $rest[1];
    $total[1] = $check[1] == 0 ? $check[1] : abs(11 - $rest[1]);
    $gerNum[$y] = $total[1];
    $value =  count(array_unique($gerNum));
    
    // return $value <= 1 ? "err-cnpj" : implode($gerNum);
    // return $value <= 1 ? "err-cnpj" : vsprintf("%s%s.%s%s%s.%s%s%s/%s%s%s%s-%s%s", $gerNum);
    return $value >= 1 ?     	$mask==0 ? implode($gerNum):     	vsprintf("%s%s.%s%s%s.%s%s%s/%s%s%s%s-%s%s", $gerNum): "err-cnpj";
} 

// Gera CPFs aleatorios. Porém, válidos
function gerarCPFAleatorio($mask=0)
{
    $DV01 = [10, 9, 8, 7, 6, 5, 4, 3, 2];
    $DV02 = [11, 10, 9, 8, 7, 6, 5, 4, 3, 2];
    $cpf = "";
    for ($i = 0; $i < 11; $i++): $cpf .= rand(0, 9); endfor;
    $gerNum = str_split($cpf);
    $i = count($gerNum) - 2;
    $y = count($gerNum) - 1;

    $total[]=0;$total[]=0;$resul[]=0;$resul[]=0;
    for ($j = 0; $j < count($DV01); $j++): $resul[0] += ($gerNum[$j] * $DV01[$j]); endfor;
    $rest[0] = ($resul[0] % 11);
    $check[0] = $rest[0] < 2 ? 0 : $rest[0];
    $total[0] = $check[0] == 0 ? $check[0] : abs(11 - $rest[0]);

    $gerNum[$i] = $total[0];
    for ($k = 0; $k < count($DV02); $k++): $resul[1] += ($gerNum[$k] * $DV02[$k]); endfor;
    $rest[1] = ($resul[1] % 11);
    $check[1] = $rest[1] < 2 ? 0 : $rest[1];
    $total[1] = $check[1] == 0 ? $check[1] : abs(11 - $rest[1]);
    $gerNum[$y] = $total[1];
    $value = count(array_unique($gerNum));

    return $value >= 1 ?     	$mask==0 ? implode($gerNum):     	vsprintf("%s%s%s.%s%s%s.%s%s%s-%s%s", $gerNum): "err-cpf";
}

function gerarEmailAleatorio($nome='') {
	$nome = removerAcentos($nome ? $nome : $nome=gerarNomeAleatorio());

    $dominios = ['gmail.com', 'yahoo.com', 'uol.com', 'mail.com'];
    $departamentos = ['contato', 'vendas', 'comercial', 'pedidos', 'atendimento', 'gestaocomercial', 'relacionamentocliente', 'fale', 'planejamentovendas', 'televendas', 'varejo', 'atacado', 'mercadologia', 'expansaomercado', 'trade', 'inteligenciamercado', 'vendasonline', 'estrategiasvendas', 'negocios', 'comercioexterno', 'gerenciamentovendas', 'comerciointeligente', 'vendasdiretas', 'treinamentovendas', 'analisedemercado', 'vendasglobais', 'canaisdevendas', 'vendasestrategicas', 'vendasdigitais', 'operacoesvendas', 'vendasfuturas', 'suportevendas', 'vendasregionais', 'logisticavendas', 'parceriascomerciais', 'consultoriacomercial', 'negociacaocomercial', 'inovacaovendas', 'equipecomercial', 'captacaonovosclientes', 'vendaslocais', 'expansao', 'ofertacomercial', 'comercializacao', 'vendasproativas', 'relacionamentoparcerias', 'vendasexternas', 'vendasvarejistas', 'prospectovendas', 'expansaocomercial', 'analisevendas', 'vendasb2b', 'vendasb2c', 'mercadovendas', 'tecnologiavendas', 'supervisaocomercial', 'gerenciamentoparcerias', 'vendasvolumosas', 'desenvolvimentocomercial', 'vendasconcorrencia', 'estrategiacomercial', 'vendasinteligentes', 'liderancacomercial', 'novosnegocios'];

    $email = empty($nome) ? $departamentos[array_rand($departamentos)]."@$nome.com" : $departamentos[array_rand($departamentos)].'.' . $nome . '@' . $dominios[array_rand($dominios)];
    return strtolower($email);
}

function gerarTelefoneAleatorio() {
    $telefone =  '('.mt_rand(11, 99).') ';
    $telefone .= mt_rand(1000, 9999) . '-' . mt_rand(1000, 9999);
    return $telefone;
}

function gerarEnderecoAleatorio() {
    $enderecos = [
    //*
    'Rua das Rosas', 'Rua Quintino B.', 'Rua Rota do Mar', 'Rua Victor Batista', 'Rua Paraiso',
    'Avenida Principal', 'Avenida Hyroshi Yamada', 'Avenida Viletta',
    'Alameda Alphandegah', 'Alameda Beatriz Flores', 'Alameda Gamma Abreu',
    'Praça Central', 'Praça das Moças', 'Praça do Comércio',
    'Largo da Paz', 'Largo do Centro', 'Largo da Amizade',
    'Travessa da Sorte', 'Travessa do Sol', 'Travessa da Lua',
    'Estrada da Montanha', 'Estrada do Vale', 'Estrada da Serra',
    'Beco das Almas', 'Beco Sossego', 'Beco do Silêncio',
    'Rodovia Veloz', 'Rodovia Expressa', 'Rodovia do Progresso',
    'Ladeira do Comerciário', 'Ladeira da Carolina', 'Ladeira da Leitura',
    'Passagem Tulipa', 'Passagem Flávia Maria', 'Passagem Rozangela P.',
    'Campo dos Matias', 'Fazenda Paraiso', 'Bosque da Liberdade',
    'Pátio das Borboletas', 'Pátio dos Pássaros', 'Pátio das Virgens',
    'Bulevar das Rosas', 'Bulevar das Orquídeas', 'Bulevar das Tulipas',
    'Elevado das Nuvens', 'Elevado das Estrelas', 'Elevado do Céu',
    'Passarela da Amizade', 'Passarela do Sucesso', 'Passarela da Harmonia',
    'Vereda das Solteiras', 'Vereda da Esperança', 'Vereda do Amor',
    'Vila do Bosque', 'Vila das Árvores', 'Vila do Riacho',/**/ 
    //*   
    'Condomínio Industrial, Av Tavares Souza', 'Condomínio Primavera, Av. Paraiso', 'Condomínio Arterial, Rua Violeta Maria', 'Condomínio Major Souza, R. Brigadeiro Rocha', 'Condomínio Ruy Pereira I, Av Vic Press J. Alencar', 'Condomínio Ruy Pereira II, Rua Sto Antonio', 'Condomínio Arantes, Travessa Três','Condomínio Vilas Boas II, Rua Cloves Algusto',
    'Mirante do Sol', 'Mirante da Lua', 'Mirante das Estrelas', 'Torre das Rocas', 'Torre da Alegria', 'Torre da Serenidade',
    'Conjunto da Harmonia, Rua Cezar VIlar', 'Conjunto das Cores, Av. Rufino Jr.', 'Conjunto do Encanto, Av. Liberdade', 'Conjunto Orlando Lobato, Av. Alg. Montenegro',/**/
];
    return gerarEndDetail($enderecos[array_rand($enderecos)]);
}

function gerarEndDetail($logradouro=''){
	$Detalhe = ' nº '.str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT).' '.(rand(0, 4) ? '' : '- '.chr(rand(65, 71)));
	$Detalhe = str_replace(' - E', ', Bloco '.str_pad(mt_rand(1, 99), 2, '0', STR_PAD_LEFT).', Ap '.str_pad(mt_rand(100, 999), 4, '0', STR_PAD_LEFT).'-A', $Detalhe);
	$Detalhe = str_replace(' - F', ', Bloco '.str_pad(mt_rand(1, 99), 2, '0', STR_PAD_LEFT).', Ap '.str_pad(mt_rand(100, 999), 4, '0', STR_PAD_LEFT).'-B', $Detalhe);
	$Detalhe = str_replace('- G', ', 2º andar', $Detalhe);
	$Detalhe = str_replace('- H', ' (fundos)', $Detalhe);

	$cond = ', Bloco '.str_pad(mt_rand(1, 99), 2, '0', STR_PAD_LEFT).', Ap '.str_pad(mt_rand(100, 999), 4, '0', STR_PAD_LEFT).'-A';
	$conj = ', Qua. '.str_pad(mt_rand(1, 99), 2, '0', STR_PAD_LEFT).', Cas. '.str_pad(mt_rand(100, 999), 4, '0', STR_PAD_LEFT);
	$Bule = ', '.str_pad(mt_rand(1, 99), 2, '0', STR_PAD_LEFT).'º Piso';
	$logradouro .= (preg_match('/condomínio|Mirante/i', $logradouro) ? $cond : $Detalhe);
	$logradouro = (preg_match('/Conjunto/i', $logradouro) ? trim($logradouro).$conj : $logradouro);
	$logradouro = (preg_match('/Bulevar|Torre/i', $logradouro) ? trim($logradouro).$Bule : $logradouro);

	return $logradouro;
}

function gerarBairroAleatorio() {
    $bairros = ['Centro', 'PraiaFormosa', 'Mangabeira', 'BoaViagem', 'Piedade', 'Candeias', 'Tambau', 'JardimOceania', 'Parnamirim', 'Aldeota', 'Meireles', 'Cocotá', 'Itapuã', 'CaboBranco', 'Bessa', 'Manaíra', 'Barra', 'Cambeba', 'CristoRedentor', 'Capela', 'Maraponga', 'LagoaRedonda', 'Benfica', 'Guararapes', 'CasaForte', 'Imbiribeira', 'AltoJoséBonifácio', 'Petrópolis', 'JardimAmérica', 'Pina', 'CidadeDosFuncionários', 'Guararapes', 'CidadeNova', 'Joaquina', 'Grageru', 'Centro', 'PraiaDaCosta', 'Piedade', 'Ribeira', 'Tibiri', 'Camurupim', 'CapimMacio', 'Alecrim', 'AreiaPreta', 'Candelária', 'CidadeAlta', 'LagoaNova', 'Neópolis', 'Pitimbu', 'Planalto', 'PontaNegra', 'Quintas', 'Redinha', 'Rocas', 'Tirol', 'Liberdade', 'BairroNovo', 'BoaEsperança', 'BomSucesso', 'CasaCaiada', 'CaixaD´Agua', 'Cajueiro', 'Candeias', 'Carmo', 'Centro', 'CidadeAlta', 'CidadeNova', 'Cohab', 'ConjuntoPanatis', 'FelipeCamarão', 'Guarapes', 'Igapó', 'Jiqui', 'LagoaSeca', 'LagoaNova', 'MãeLuiza', 'NossaSenhoraDaApresentação', 'NossaSenhoraDeNazareth', 'NovaDescoberta', 'Nordeste', 'Pajuçara', 'Petrópolis', 'Pitimbu', 'Planalto', 'PontaNegra', 'Potengi', 'PraiaDoMeio', 'Quintas', 'Redinha', 'Ribeira', 'RioBraga', 'Rocas', 'SantosReis', 'SãoGeraldo', 'Tirol', 'Varzea', 'Viagem'];

    return $bairros[array_rand($bairros)];
}

function gerarCEPAleatorio() {
    $cep = '';
    for ($i = 0; $i < 8; $i++) {
    	//$a = $i=6 ? '-' : '';
        $cep .= $i==4 ?  mt_rand(0, 9).'-' : mt_rand(0, 9);
    }
    return $cep;
}

function gerarCidadeAleatoria(){
	$cidadesBrasileiras = ['São Paulo - SP', 'Rio de Janeiro - RJ', 'Belo Horizonte - MG', 'Porto Alegre - RS', 'Salvador - BA', 'Fortaleza - CE', 'Recife - PE', 'Curitiba - PR', 'Brasília - DF', 'Manaus - AM', 'Belém - PA', 'Vitória - ES', 'Goiânia - GO', 'João Pessoa - PB', 'São Luís - MA', 'Campo Grande - MS', 'Cuiabá - MT', 'Florianópolis - SC', 'Teresina - PI', 'Natal - RN', 'Aracaju - SE', 'Maceió - AL', 'Palmas - TO', 'Boa Vista - RR', 'Rio Branco - AC', 'Macapá - AP', 'Porto Velho - RO', 'Caxias do Sul - RS', 'Campos dos Goytacazes - RJ', 'Maringá - PR', 'Paulista - PE', 'Limeira - SP', 'São José dos Campos - SP', 'Uberlândia - MG', 'Jundiaí - SP', 'Feira de Santana - BA', 'Anápolis - GO', 'Petrópolis - RJ', 'Viamão - RS', 'Montes Claros - MG', 'Ponta Grossa - PR', 'Itaquaquecetuba - SP', 'Praia Grande - SP', 'Cabo de Santo Agostinho - PE', 'Governador Valadares - MG', 'Camaçari - BA', 'São Vicente - SP', 'Piracicaba - SP', 'Santarém - PA', 'Guarujá - SP', 'Pelotas - RS', 'Floriano - PI', 'Barra Mansa - RJ', 'Santa Maria - RS', 'Divinópolis - MG', 'Sete Lagoas - MG', 'Araraquara - SP', 'Itabira - MG', 'Patrocínio - MG', 'Paracatu - MG', 'São João del Rei - MG', 'Campo Belo - MG', 'Ouro Preto - MG', 'São Lourenço - MG', 'Conselheiro Lafaiete - MG', 'Iguatu - CE', 'Itabaiana - SE', 'Ceres - GO', 'São Miguel do Araguaia - GO', 'Niquelândia - GO'];
	return $cidadesBrasileiras[array_rand($cidadesBrasileiras)];
}







class BKP_Teste_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
    	/* Back-up de tados para teste
    	DB::table('clientes')->insert([
	    // Insira os dados dos clientes aqui
	    ]);

	    DB::table('categorias')->insert([
	        // Insira os dados das categorias aqui
	    ]);

	    DB::table('produtos')->insert([
	        // Insira os dados dos produtos aqui
	    ]);
	    /**/


        // Inserir dados na tabela 'clientes'
        DB::table('clientes')->insert([
        	['nome' => 'João Müller Schmidt', 'cpf' => '78420702021', 'email' => 'joao.schmidt@sistemapdv.com', 'telefone' => '(11) 98765-4321', 'endereco' => 'Rua das Moças'.gerarEndDetail(), 'bairro' => 'Centro', 'cidade' => 'São Paulo', 'cep' => '01000-000', 'map' => '-23.5505,-46.6333', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Maria Schneider Fischer', 'cpf' => '98102323060', 'email' => 'maria.fischer@sistemapdv.com', 'telefone' => '(21) 98765-4321', 'endereco' => 'Avenida das Acácias'.gerarEndDetail(), 'bairro' => 'Copacabana', 'cidade' => 'Rio de Janeiro', 'cep' => '22000-000', 'map' => '-22.9739,-43.1857', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'José Weber Meyer', 'cpf' => '05848809011', 'email' => 'jose.meyer@sistemapdv.com', 'telefone' => '(51) 98765-4321', 'endereco' => 'Rua dos Cravos'.gerarEndDetail(), 'bairro' => 'Centro', 'cidade' => 'Porto Alegre', 'cep' => '90000-000', 'map' => '-30.0330,-51.2300', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Ana Wagner Becker', 'cpf' => '38702929031', 'email' => 'ana.becker@sistemapdv.com', 'telefone' => '(41) 98765-4321', 'endereco' => 'Avenida das Begônias'.gerarEndDetail(), 'bairro' => 'Batel', 'cidade' => 'Curitiba', 'cep' => '80000-000', 'map' => '-25.4322,-49.2722', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Francisco Hoffmann Schäfer', 'cpf' => '22288198087', 'email' => 'francisco.schaefer@sistemapdv.com', 'telefone' => '(48) 98765-4321', 'endereco' => 'Rua das Rosas'.gerarEndDetail(), 'bairro' => 'Centro', 'cidade' => 'Florianópolis', 'cep' => '88000-000', 'map' => '-27.5954,-48.5480', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Paula Koch Richter', 'cpf' => '59766500070', 'email' => 'paula.richter@sistemapdv.com', 'telefone' => '(54) 98765-4321', 'endereco' => 'Avenida dos Lírios'.gerarEndDetail(), 'bairro' => 'Centro', 'cidade' => 'Caxias do Sul', 'cep' => '95000-000', 'map' => '-29.1670,-51.1794', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Luiz Bauer Klein', 'cpf' => '49217402087', 'email' => 'luiz.klein@sistemapdv.com', 'telefone' => '(55) 98765-4321', 'endereco' => 'Rua das Violetas'.gerarEndDetail(), 'bairro' => 'Centro', 'cidade' => 'Santa Maria', 'cep' => '97000-000', 'map' => '-29.6881,-53.8265', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Carla Wolf Neumann', 'cpf' => '61400535018', 'email' => 'carla.neumann@sistemapdv.com', 'telefone' => '(31) 98765-4321', 'endereco' => 'Avenida dos Girassóis'.gerarEndDetail(), 'bairro' => 'Savassi', 'cidade' => 'Belo Horizonte', 'cep' => '30000-000', 'map' => '-19.9386,-43.9379', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Antonio Schwarz Zimmermann', 'cpf' => '97961788000', 'email' => 'antonio.zimmermann@sistemapdv.com', 'telefone' => '(61) 98765-4321', 'endereco' => 'Rua das Orquídeas'.gerarEndDetail(), 'bairro' => 'Asa Sul', 'cidade' => 'Brasília', 'cep' => '70000-000', 'map' => '-15.7936,-47.8825', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Renata Braun Schmitt', 'cpf' => '90110695011', 'email' => 'renata.schmitt@sistemapdv.com', 'telefone' => '(67) 98765-4321', 'endereco' => 'Avenida dos Lírios'.gerarEndDetail(), 'bairro' => 'Centro', 'cidade' => 'Campo Grande', 'cep' => '79000-000', 'map' => '-20.4509,-54.6163', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Pedro Lange Schmitz', 'cpf' => '02383090026', 'email' => 'pedro.schmitz@sistemapdv.com', 'telefone' => '(24) 98765-4321', 'endereco' => 'Rua dos Cravos'.gerarEndDetail(), 'bairro' => 'Centro', 'cidade' => 'Petrópolis', 'cep' => '25600-000', 'map' => '-22.5100,-43.1808', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Camila Krüger Schulz', 'cpf' => '22672529027', 'email' => 'camila.schulz@sistemapdv.com', 'telefone' => '(27) 98765-4321', 'endereco' => 'Avenida das Begônias'.gerarEndDetail(), 'bairro' => 'Praia do Canto', 'cidade' => 'Vitória', 'cep' => '29000-000', 'map' => '-20.3155,-40.2922', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Marcio Lehmann Huber', 'cpf' => '00791034054', 'email' => 'marcio.huber@sistemapdv.com', 'telefone' => '(85) 98765-4321', 'endereco' => 'Rua das Rosas'.gerarEndDetail(), 'bairro' => 'Aldeota', 'cidade' => 'Fortaleza', 'cep' => '60000-000', 'map' => '-3.7172,-38.5433', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Fernanda Kaiser Fuchs', 'cpf' => '95405448079', 'email' => 'fernanda.fuchs@sistemapdv.com', 'telefone' => '(84) 98765-4321', 'endereco' => 'Avenida dos Girassóis'.gerarEndDetail(), 'bairro' => 'Tirol', 'cidade' => 'Natal', 'cep' => '59000-000', 'map' => '-5.7945,-35.2120', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Rafael Peters Haas', 'cpf' => '38576265001', 'email' => 'rafael.haas@sistemapdv.com', 'telefone' => '(92) 98765-4321', 'endereco' => 'Rua dos Cravos'.gerarEndDetail(), 'bairro' => 'Adrianópolis', 'cidade' => 'Manaus', 'cep' => '69000-000', 'map' => '-3.0969,-60.0188', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Gabriela Schuster Engel', 'cpf' => '87767507017', 'email' => 'gabriela.engel@sistemapdv.com', 'telefone' => '(91) 98765-4321', 'endereco' => 'Avenida dos Lírios'.gerarEndDetail(), 'bairro' => 'Nazaré', 'cidade' => 'Belém', 'cep' => '66000-000', 'map' => '-1.4579,-48.5034', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Carlos Walter Vogel', 'cpf' => '07282733066', 'email' => 'carlos.vogel@sistemapdv.com', 'telefone' => '(68) 98765-4321', 'endereco' => 'Rua das Orquídeas'.gerarEndDetail(), 'bairro' => 'Centro', 'cidade' => 'Rio Branco', 'cep' => '69900-000', 'map' => '-9.9718,-67.8076', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Aline Otto Simon', 'cpf' => '25916691041', 'email' => 'aline.simon@sistemapdv.com', 'telefone' => '(16) 98765-4321', 'endereco' => 'Avenida das Acácias'.gerarEndDetail(), 'bairro' => 'Centro', 'cidade' => 'Ribeirão Preto', 'cep' => '14000-000', 'map' => '-21.1703,-47.8099', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Roberto Günther Keller', 'cpf' => '24747418016', 'email' => 'roberto.keller@sistemapdv.com', 'telefone' => '(95) 98765-4321', 'endereco' => 'Rua dos Cravos'.gerarEndDetail(), 'bairro' => 'Centro', 'cidade' => 'Boa Vista', 'cep' => '69300-000', 'map' => '2.8220,-60.6695', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Mariana Frank Berger', 'cpf' => '54195035066', 'email' => 'mariana.berger@sistemapdv.com', 'telefone' => '(32) 98765-4321', 'endereco' => 'Avenida dos Lírios'.gerarEndDetail(), 'bairro' => 'Centro', 'cidade' => 'Juiz de Fora', 'cep' => '36000-000', 'map' => '-21.7627,-43.3431', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Rodrigo Roth Meier', 'cpf' => '93514732019', 'email' => 'rodrigo.meier@sistemapdv.com', 'telefone' => '(49) 98765-4321', 'endereco' => 'Rua das Orquídeas'.gerarEndDetail(), 'bairro' => 'Centro', 'cidade' => 'Chapecó', 'cep' => '89800-000', 'map' => '-27.1002,-52.6152', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Patricia Geiger Sauer', 'cpf' => '26217807092', 'email' => 'patricia.sauer@sistemapdv.com', 'telefone' => '(14) 98765-4321', 'endereco' => 'Avenida das Begônias'.gerarEndDetail(), 'bairro' => 'Centro', 'cidade' => 'Bauru', 'cep' => '17000-000', 'map' => '-22.3246,-49.0880', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Thiago Dietrich Schreiber', 'cpf' => '94442114013', 'email' => 'thiago.schreiber@sistemapdv.com', 'telefone' => '(98) 98765-4321', 'endereco' => 'Rua dos Cravos'.gerarEndDetail(), 'bairro' => 'Ponta do Farol', 'cidade' => 'São Luís', 'cep' => '65000-000', 'map' => '-2.5326,-44.2663', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Letícia Bender Krause', 'cpf' => '18954563040', 'email' => 'leticia.krause@sistemapdv.com', 'telefone' => '(12) 98765-4321', 'endereco' => 'Avenida dos Lírios'.gerarEndDetail(), 'bairro' => 'Centro', 'cidade' => 'São José dos Campos', 'cep' => '12000-000', 'map' => '-23.1806,-45.8840', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Gabriel Brandt Winkler', 'cpf' => '18954563040', 'email' => 'gabriel.winkler@sistemapdv.com', 'telefone' => '(54) 98765-4321', 'endereco' => 'Rua das Rosas'.gerarEndDetail(), 'bairro' => 'Centro', 'cidade' => 'Caxias do Sul', 'cep' => '95000-000', 'map' => '-29.1670,-51.1794', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Raquel Roth Vetter', 'cpf' => '60506440044', 'email' => 'raquel.vetter@sistemapdv.com', 'telefone' => '(55) 98765-4321', 'endereco' => 'Avenida das Acácias'.gerarEndDetail(), 'bairro' => 'Centro', 'cidade' => 'Santa Maria', 'cep' => '97000-000', 'map' => '-29.6881,-53.8265', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Marcelo Nowak Heinz', 'cpf' => '80073292001', 'email' => 'marcelo.heinz@sistemapdv.com', 'telefone' => '(92) 98765-4321', 'endereco' => 'Rua dos Cravos'.gerarEndDetail(), 'bairro' => 'Adrianópolis', 'cidade' => 'Manaus', 'cep' => '69000-000', 'map' => '-3.0969,-60.0188', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Beatriz Müller Schmidt', 'cpf' => '78833517020', 'email' => 'beatriz.schmidt@sistemapdv.com', 'telefone' => '(41) 98765-4321', 'endereco' => 'Avenida das Acácias'.gerarEndDetail(), 'bairro' => 'Batel', 'cidade' => 'Curitiba', 'cep' => '80000-000', 'map' => '-25.4322,-49.2722', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Diego Schneider Fischer', 'cpf' => '91818636085', 'email' => 'diego.fischer@sistemapdv.com', 'telefone' => '(31) 98765-4321', 'endereco' => 'Rua dos Lírios'.gerarEndDetail(), 'bairro' => 'Centro', 'cidade' => 'Belo Horizonte', 'cep' => '30000-000', 'map' => '-19.9386,-43.9379', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Juliana Wagner Becker', 'cpf' => '77295220046', 'email' => 'juliana.becker@sistemapdv.com', 'telefone' => '(61) 98765-4321', 'endereco' => 'Avenida dos Cravos'.gerarEndDetail(), 'bairro' => 'Asa Sul', 'cidade' => 'Brasília', 'cep' => '70000-000', 'map' => '-15.7936,-47.8825', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Douglas Hoffmann Schäfer', 'cpf' => '33970764041', 'email' => 'douglas.schaefer@sistemapdv.com', 'telefone' => '(14) 98765-4321', 'endereco' => 'Rua das Rosas'.gerarEndDetail(), 'bairro' => 'Centro', 'cidade' => 'Bauru', 'cep' => '17000-000', 'map' => '-22.3246,-49.0880', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Renata Koch Richter', 'cpf' => '64730050053', 'email' => 'renata.richter@sistemapdv.com', 'telefone' => '(92) 98765-4321', 'endereco' => 'Avenida dos Girassóis'.gerarEndDetail(), 'bairro' => 'Adrianópolis', 'cidade' => 'Manaus', 'cep' => '69000-000', 'map' => '-3.0969,-60.0188', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Vinícius Bauer Klein', 'cpf' => '00845741004', 'email' => 'vinicius.klein@sistemapdv.com', 'telefone' => '(27) 98765-4321', 'endereco' => 'Rua das Orquídeas'.gerarEndDetail(), 'bairro' => 'Praia do Canto', 'cidade' => 'Vitória', 'cep' => '29000-000', 'map' => '-20.3155,-40.2922', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Jéssica Wolf Neumann', 'cpf' => '89953018057', 'email' => 'jessica.neumann@sistemapdv.com', 'telefone' => '(54) 98765-4321', 'endereco' => 'Avenida dos Cravos'.gerarEndDetail(), 'bairro' => 'Centro', 'cidade' => 'Caxias do Sul', 'cep' => '95000-000', 'map' => '-29.1670,-51.1794', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Eduardo Schwarz Zimmermann', 'cpf' => '82382062002', 'email' => 'eduardo.zimmermann@sistemapdv.com', 'telefone' => '(68) 98765-4321', 'endereco' => 'Rua dos Lírios'.gerarEndDetail(), 'bairro' => 'Centro', 'cidade' => 'Rio Branco', 'cep' => '69900-000', 'map' => '-9.9718,-67.8076', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Amanda Braun Schmitt', 'cpf' => '93532283018', 'email' => 'amanda.schmitt@sistemapdv.com', 'telefone' => '(51) 98765-4321', 'endereco' => 'Avenida das Acácias'.gerarEndDetail(), 'bairro' => 'Copacabana', 'cidade' => 'Rio de Janeiro', 'cep' => '22000-000', 'map' => '-22.9739,-43.1857', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Alan Lange Schmitz', 'cpf' => '35946184040', 'email' => 'alan.schmitz@sistemapdv.com', 'telefone' => '(14) 98765-4321', 'endereco' => 'Rua dos Cravos'.gerarEndDetail(), 'bairro' => 'Centro', 'cidade' => 'Bauru', 'cep' => '17000-000', 'map' => '-22.3246,-49.0880', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Bruna Krüger Schulz', 'cpf' => '62117582001', 'email' => 'bruna.schulz@sistemapdv.com', 'telefone' => '(55) 98765-4321', 'endereco' => 'Avenida dos Lírios'.gerarEndDetail(), 'bairro' => 'Centro', 'cidade' => 'Santa Maria', 'cep' => '97000-000', 'map' => '-29.6881,-53.8265', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Fernando Lehmann Huber', 'cpf' => '08596919007', 'email' => 'fernando.huber@sistemapdv.com', 'telefone' => '(61) 98765-4321', 'endereco' => 'Rua das Rosas'.gerarEndDetail(), 'bairro' => 'Asa Sul', 'cidade' => 'Brasília', 'cep' => '70000-000', 'map' => '-15.7936,-47.8825', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Isabela Kaiser Fuchs', 'cpf' => '13206637023', 'email' => 'isabela.fuchs@sistemapdv.com', 'telefone' => '(92) 98765-4321', 'endereco' => 'Avenida das Begônias'.gerarEndDetail(), 'bairro' => 'Adrianópolis', 'cidade' => 'Manaus', 'cep' => '69000-000', 'map' => '-3.0969,-60.0188', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Lucas Peters Haas', 'cpf' => '57145728079', 'email' => 'lucas.haas@sistemapdv.com', 'telefone' => '(84) 98765-4321', 'endereco' => 'Rua dos Cravos'.gerarEndDetail(), 'bairro' => 'Ponta do Farol', 'cidade' => 'São Luís', 'cep' => '65000-000', 'map' => '-2.5326,-44.2663', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Laura Schuster Engel', 'cpf' => '31984316036', 'email' => 'laura.engel@sistemapdv.com', 'telefone' => '(91) 98765-4321', 'endereco' => 'Avenida dos Girassóis'.gerarEndDetail(), 'bairro' => 'Nazaré', 'cidade' => 'Belém', 'cep' => '66000-000', 'map' => '-1.4579,-48.5034', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Adriano Walter Vogel', 'cpf' => '30355484048', 'email' => 'adriano.vogel@sistemapdv.com', 'telefone' => '(68) 98765-4321', 'endereco' => 'Rua das Orquídeas'.gerarEndDetail(), 'bairro' => 'Centro', 'cidade' => 'Rio Branco', 'cep' => '69900-000', 'map' => '-9.9718,-67.8076', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Caroline Otto Simon', 'cpf' => '62873212020', 'email' => 'caroline.simon@sistemapdv.com', 'telefone' => '(16) 98765-4321', 'endereco' => 'Avenida das Acácias'.gerarEndDetail(), 'bairro' => 'Centro', 'cidade' => 'Ribeirão Preto', 'cep' => '14000-000', 'map' => '-21.1703,-47.8099', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'André Günther Keller', 'cpf' => '11265615098', 'email' => 'andre.keller@sistemapdv.com', 'telefone' => '(95) 98765-4321', 'endereco' => 'Rua dos Cravos'.gerarEndDetail(), 'bairro' => 'Centro', 'cidade' => 'Boa Vista', 'cep' => '69300-000', 'map' => '2.8220,-60.6695', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Valéria Frank Berger', 'cpf' => '39411795005', 'email' => 'valeria.berger@sistemapdv.com', 'telefone' => '(32) 98765-4321', 'endereco' => 'Avenida dos Lírios'.gerarEndDetail(), 'bairro' => 'Centro', 'cidade' => 'Juiz de Fora', 'cep' => '36000-000', 'map' => '-21.7627,-43.3431', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Gustavo Roth Meier', 'cpf' => '66760091027', 'email' => 'gustavo.meier@sistemapdv.com', 'telefone' => '(49) 98765-4321', 'endereco' => 'Rua das Orquídeas'.gerarEndDetail(), 'bairro' => 'Centro', 'cidade' => 'Chapecó', 'cep' => '89800-000', 'map' => '-27.1002,-52.6152', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Camila Geiger Sauer', 'cpf' => '70177308010', 'email' => 'camila.sauer@sistemapdv.com', 'telefone' => '(14) 98765-4321', 'endereco' => 'Avenida das Begônias'.gerarEndDetail(), 'bairro' => 'Centro', 'cidade' => 'Bauru', 'cep' => '17000-000', 'map' => '-22.3246,-49.0880', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Leandro Dietrich Schreiber', 'cpf' => '37817752087', 'email' => 'leandro.schreiber@sistemapdv.com', 'telefone' => '(98) 98765-4321', 'endereco' => 'Rua dos Cravos'.gerarEndDetail(), 'bairro' => 'Adrianópolis', 'cidade' => 'Manaus', 'cep' => '69000-000', 'map' => '-3.0969,-60.0188', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Nathalia Bender Krause', 'cpf' => '55050524016', 'email' => 'nathalia.krause@sistemapdv.com', 'telefone' => '(12) 98765-4321', 'endereco' => 'Avenida dos Lírios'.gerarEndDetail(), 'bairro' => 'Centro', 'cidade' => 'São José dos Campos', 'cep' => '12000-000', 'map' => '-23.1806,-45.8840', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Guilherme Brandt Winkler', 'cpf' => '80303899069', 'email' => 'guilherme.winkler@sistemapdv.com', 'telefone' => '(54) 98765-4321', 'endereco' => 'Rua das Rosas'.gerarEndDetail(), 'bairro' => 'Centro', 'cidade' => 'Caxias do Sul', 'cep' => '95000-000', 'map' => '-29.1670,-51.1794', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Ana Clara Roth Vetter', 'cpf' => '23490620070', 'email' => 'anaclara.vetter@sistemapdv.com', 'telefone' => '(55) 98765-4321', 'endereco' => 'Avenida das Acácias'.gerarEndDetail(), 'bairro' => 'Centro', 'cidade' => 'Santa Maria', 'cep' => '97000-000', 'map' => '-29.6881,-53.8265', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Raul Nowak Heinz', 'cpf' => '56757487098', 'email' => 'raul.heinz@sistemapdv.com', 'telefone' => '(92) 98765-4321', 'endereco' => 'Rua dos Cravos'.gerarEndDetail(), 'bairro' => 'Adrianópolis', 'cidade' => 'Manaus', 'cep' => '69000-000', 'map' => '-3.0969,-60.0188', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Júlia Müller Schmidt', 'cpf' => '12977356096', 'email' => 'julia.schmidt@sistemapdv.com', 'telefone' => '(41) 98765-4321', 'endereco' => 'Avenida das Acácias'.gerarEndDetail(), 'bairro' => 'Batel', 'cidade' => 'Curitiba', 'cep' => '80000-000', 'map' => '-25.4322,-49.2722', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Inserir dados na tabela 'categorias'
        DB::table('categorias')->insert([
        	['nome' => 'Bedidas, Carnes e Frios'],
			['nome' => 'Condimentos, Chas, Temperos e Ervas'],
			['nome' => 'Enlatados, Petiscos, Defumados e Conservas'],
			['nome' => 'Peixes e Mariscos'],
			['nome' => 'Padaria e lanchonete'],
			['nome' => 'Cereais, Molhos e Massas'],
			['nome' => 'Higiene, Cosmeticos e Beleza'],
			['nome' => 'Descartaveis e Festas'],
			['nome' => 'Ferragens e Utilidades para o Lar'],
        ]);

        // Inserir dados na tabela 'produtos'
        DB::table('produtos')->insert([
			['nome' => 'Suco de Laranja', 'descricao' => 'Refrescante para acompanhar momentos especiais.', 'preco' => '8.15', 'quantidade_em_estoque' => '1000'],
			['nome' => 'Chá gelado', 'descricao' => 'Uma bebida gelada e deliciosa para se refrescar.', 'preco' => '6.50', 'quantidade_em_estoque' => '1000'],
			['nome' => 'Bolo Pequeno', 'descricao' => 'Perfeito para adoçar seu dia com um toque especial.', 'preco' => '8.00', 'quantidade_em_estoque' => '1000'],
			['nome' => 'Salgado de festa (cento)', 'descricao' => 'Ideal para festas e eventos, com sabor inigualável.', 'preco' => '16.50', 'quantidade_em_estoque' => '1000'],
			['nome' => 'Salgado de festa (1/2 cento)', 'descricao' => 'A opção perfeita para celebrar com praticidade.', 'preco' => '8.50', 'quantidade_em_estoque' => '1000'],
			['nome' => 'Torta salgada', 'descricao' => 'Deliciosa torta que agrada a todos os paladares.', 'preco' => '42.70', 'quantidade_em_estoque' => '1000'],
			['nome' => 'Bolo Grande', 'descricao' => 'Um bolo incrível para compartilhar em grandes momentos.', 'preco' => '12.00', 'quantidade_em_estoque' => '1000'],
			['nome' => 'Bolo Grande confeitado', 'descricao' => 'Decorado com carinho, é a estrela de qualquer celebração.', 'preco' => '19.90', 'quantidade_em_estoque' => '1000'],
			['nome' => 'Bolo Pequeno Confeitado', 'descricao' => 'Pequeno em tamanho, mas grande em sabor e beleza.', 'preco' => '12.30', 'quantidade_em_estoque' => '1000'],
			['nome' => 'Pastel Folheado', 'descricao' => 'Folhas crocantes recheadas com os melhores sabores.', 'preco' => '4.30', 'quantidade_em_estoque' => '1000'],
			['nome' => 'Pastel Risole', 'descricao' => 'Risoles dourados e deliciosos para agradar a todos.', 'preco' => '3.00', 'quantidade_em_estoque' => '1000'],
			['nome' => 'Coxinha', 'descricao' => 'Saborosa e irresistível, a coxinha que todos amam.', 'preco' => '3.50', 'quantidade_em_estoque' => '1000'],
			['nome' => 'Empada', 'descricao' => 'Uma opção clássica, recheada com sabores incríveis.', 'preco' => '5.00', 'quantidade_em_estoque' => '1000'],
			['nome' => 'Empadão', 'descricao' => 'O empadão perfeito para reunir a família ao redor da mesa.', 'preco' => '8.20', 'quantidade_em_estoque' => '1000'],
			['nome' => 'Pizza brotinho', 'descricao' => 'Pequena, mas cheia de sabor para os amantes de pizza.', 'preco' => '4.50', 'quantidade_em_estoque' => '1000'],
			['nome' => 'Pizza Media', 'descricao' => 'Tamanho médio, com uma explosão de sabores em cada pedaço.', 'preco' => '8.00', 'quantidade_em_estoque' => '1000'],
			['nome' => 'Pizza Grande', 'descricao' => 'Uma pizza grande para grandes momentos e grandes apetites.', 'preco' => '14.30', 'quantidade_em_estoque' => '1000'],
			['nome' => 'Pizza Gigante', 'descricao' => 'Para os amantes de pizza que nunca têm o suficiente.', 'preco' => '28.50', 'quantidade_em_estoque' => '1000'],
			['nome' => 'Pizza Extra Gigante', 'descricao' => 'A pizza que faz jus ao nome, para compartilhar com todos.', 'preco' => '42.20', 'quantidade_em_estoque' => '1000'],
			['nome' => 'Pizza Extra Grande Gigante', 'descricao' => 'A maior pizza, perfeita para festas e eventos especiais.', 'preco' => '68.10', 'quantidade_em_estoque' => '1000'],
			['nome' => 'Pão doce', 'descricao' => 'Delicioso pão doce, um clássico para qualquer ocasião.', 'preco' => '15.40', 'quantidade_em_estoque' => '1000'],
			['nome' => 'Pão Francês', 'descricao' => 'O tradicional pão francês, sempre fresco e crocante.', 'preco' => '12.50', 'quantidade_em_estoque' => '1000'],
			['nome' => 'Pão de Hamburguer', 'descricao' => 'Pão macio e perfeito para qualquer tipo de hambúrguer.', 'preco' => '12.50', 'quantidade_em_estoque' => '1000'],
			['nome' => 'Pão de Cachorroquente', 'descricao' => 'Ideal para cachorros-quentes deliciosos e bem recheados.', 'preco' => '9.90', 'quantidade_em_estoque' => '1000'],
			['nome' => 'Pão de Milho', 'descricao' => 'Saboroso pão de milho, uma opção diferente e deliciosa.', 'preco' => '9.00', 'quantidade_em_estoque' => '1000'],
			['nome' => 'Pão de Chocolate', 'descricao' => 'Pão macio com pedaços de chocolate, uma sobremesa irresistível.', 'preco' => '12.70', 'quantidade_em_estoque' => '1000'],
			['nome' => 'Pão de Aveia', 'descricao' => 'Pão saudável e nutritivo, perfeito para um café da manhã equilibrado.', 'preco' => '18.00', 'quantidade_em_estoque' => '1000'],
			['nome' => 'Pão de Ervas Finas', 'descricao' => 'Pão com um toque especial de ervas finas, para paladares refinados.', 'preco' => '14.00', 'quantidade_em_estoque' => '1000'],
			['nome' => 'Pão de Erva Doce', 'descricao' => 'Pão doce com erva-doce, uma combinação única de sabores.', 'preco' => '13.30', 'quantidade_em_estoque' => '1000'],
			['nome' => 'Pão Baguete', 'descricao' => 'A clássica baguete, perfeita para acompanhar diversos pratos.', 'preco' => '12.50', 'quantidade_em_estoque' => '1000'],
			['nome' => 'Rocambole de Goiabada', 'descricao' => 'O doce sabor da goiabada em um rocambole incrivelmente macio.', 'preco' => '18.00', 'quantidade_em_estoque' => '1000'],
			['nome' => 'Rocambole de Doce de Leite', 'descricao' => 'Um rocambole irresistível, recheado com o delicioso doce de leite.', 'preco' => '12.00', 'quantidade_em_estoque' => '1000'],
			['nome' => 'Rocambole de Chocolate', 'descricao' => 'O clássico rocambole de chocolate, para os amantes do cacau.', 'preco' => '12.50', 'quantidade_em_estoque' => '1000'],
			['nome' => 'Rocambole de Atum', 'descricao' => 'Um rocambole salgado, perfeito para os amantes de frutos do mar.', 'preco' => '14.20', 'quantidade_em_estoque' => '1000'],
			['nome' => 'Rocambole de Frango', 'descricao' => 'Saboroso rocambole recheado com frango, uma opção leve e deliciosa.', 'preco' => '15.60', 'quantidade_em_estoque' => '1000'],
			['nome' => 'Pão Carioquinha', 'descricao' => 'Tradicional pão carioquinha, perfeito para café da manhã ou lanches.', 'preco' => '12.30', 'quantidade_em_estoque' => '1000'],
			['nome' => 'Pão Carioquinha Grande', 'descricao' => 'Grande versão do pão carioquinha, ideal para compartilhar.', 'preco' => '14.00', 'quantidade_em_estoque' => '1000'],
			['nome' => 'Bisc. Olho de Sogra', 'descricao' => 'Biscoitos delicados e saborosos, perfeitos para momentos especiais.', 'preco' => '5.00', 'quantidade_em_estoque' => '1000'],
			['nome' => 'Bisc. Do Conde', 'descricao' => 'Biscoitos crocantes com um toque especial do conde, uma verdadeira iguaria.', 'preco' => '3.80', 'quantidade_em_estoque' => '1000'],
			['nome' => 'Bisc. Sortidos', 'descricao' => 'Variedade de biscoitos deliciosos, uma explosão de sabores em cada mordida.', 'preco' => '2.00', 'quantidade_em_estoque' => '1000'],
			['nome' => 'Bisc. Monteiro Lopes', 'descricao' => 'Biscoitos com a assinatura do renomado Monteiro Lopes, uma experiência única.', 'preco' => '9.00', 'quantidade_em_estoque' => '1000'],
			['nome' => 'Bisc. 7 Capas', 'descricao' => 'Biscoitos finos com sete camadas de sabor, uma verdadeira obra-prima.', 'preco' => '9.90', 'quantidade_em_estoque' => '1000'],
			['nome' => 'Bisc. 12 Capas', 'descricao' => 'Biscoitos luxuosos com doze camadas de indulgência, uma experiência inigualável.', 'preco' => '12.90', 'quantidade_em_estoque' => '1000'],
			['nome' => 'Bisc. Raivinha', 'descricao' => 'Biscoitos irresistíveis da marca Raivinha, perfeitos para qualquer ocasião.', 'preco' => '8.20', 'quantidade_em_estoque' => '14'],
			['nome' => 'Salada de Frutas', 'descricao' => 'Salada fresca e saudável de frutas selecionadas, uma explosão de vitaminas.', 'preco' => '5.80', 'quantidade_em_estoque' => '14'],
			['nome' => 'Bisc. Rosquinha', 'descricao' => 'Rosquinhas crocantes e deliciosas, uma opção de lanche perfeita.', 'preco' => '8.20', 'quantidade_em_estoque' => '14'],
			['nome' => 'Bisc. Broa', 'descricao' => 'Biscoitos tipo broa, uma combinação perfeita de sabor e textura.', 'preco' => '8.00', 'quantidade_em_estoque' => '1000'],
			['nome' => 'Bisc. De Leite', 'descricao' => 'Biscoitos delicados com sabor suave de leite, ideal para acompanhar um café.', 'preco' => '8.10', 'quantidade_em_estoque' => '1000'],
			['nome' => 'Bisc. de Chocolate', 'descricao' => 'Biscoitos irresistíveis de chocolate, uma tentação para os amantes do cacau.', 'preco' => '8.50', 'quantidade_em_estoque' => '1000'],
			['nome' => 'Bisc. de Côco', 'descricao' => 'Biscoitos com coco fresco, uma explosão tropical de sabor em cada mordida.', 'preco' => '5.60', 'quantidade_em_estoque' => '1000'],
			['nome' => 'Bisc. de Amendoas', 'descricao' => 'Biscoitos delicados com amêndoas crocantes, uma combinação perfeita.', 'preco' => '2.90', 'quantidade_em_estoque' => '1000'],
			['nome' => 'Bisc. de Castanha', 'descricao' => 'Biscoitos com castanhas selecionadas, um deleite para os apreciadores de frutas secas.', 'preco' => '3.00', 'quantidade_em_estoque' => '1000'],
			['nome' => 'Bisc. de Amendoin', 'descricao' => 'Biscoitos com amendoins crocantes, uma opção deliciosa para qualquer momento.', 'preco' => '3.50', 'quantidade_em_estoque' => '1000'],
			['nome' => 'Bisc. de Aveia', 'descricao' => 'Biscoitos nutritivos com aveia integral, uma escolha saudável para os amantes de grãos.', 'preco' => '16.50', 'quantidade_em_estoque' => '1000'],
			['nome' => 'Panetone', 'descricao' => 'Tradicional panetone com frutas cristalizadas, perfeito para celebrar momentos especiais.', 'preco' => '13.90', 'quantidade_em_estoque' => '1000'],
        ]);

	    // Inserir dados na tabela 'rel_categoriaprodutos'
		DB::table('rel_categoriaprodutos')->insert([
			['produto_id' => 1, 'categoria_id' => 5],
			['produto_id' => 2, 'categoria_id' => 5],
			['produto_id' => 3, 'categoria_id' => 5],
			['produto_id' => 4, 'categoria_id' => 5],
			['produto_id' => 5, 'categoria_id' => 5],
			['produto_id' => 6, 'categoria_id' => 5],
			['produto_id' => 7, 'categoria_id' => 5],
			['produto_id' => 8, 'categoria_id' => 5],
			['produto_id' => 9, 'categoria_id' => 5],
			['produto_id' => 10, 'categoria_id' => 5],
			['produto_id' => 11, 'categoria_id' => 5],
			['produto_id' => 12, 'categoria_id' => 5],
			['produto_id' => 13, 'categoria_id' => 5],
			['produto_id' => 14, 'categoria_id' => 5],
			['produto_id' => 15, 'categoria_id' => 5],
			['produto_id' => 16, 'categoria_id' => 5],
			['produto_id' => 17, 'categoria_id' => 5],
			['produto_id' => 18, 'categoria_id' => 5],
			['produto_id' => 19, 'categoria_id' => 5],
			['produto_id' => 20, 'categoria_id' => 5],
			['produto_id' => 21, 'categoria_id' => 5],
			['produto_id' => 22, 'categoria_id' => 5],
			['produto_id' => 23, 'categoria_id' => 5],
			['produto_id' => 24, 'categoria_id' => 5],
			['produto_id' => 25, 'categoria_id' => 5],
			['produto_id' => 26, 'categoria_id' => 5],
			['produto_id' => 27, 'categoria_id' => 5],
			['produto_id' => 28, 'categoria_id' => 5],
			['produto_id' => 29, 'categoria_id' => 5],
			['produto_id' => 30, 'categoria_id' => 5],
			['produto_id' => 31, 'categoria_id' => 5],
			['produto_id' => 32, 'categoria_id' => 5],
			['produto_id' => 33, 'categoria_id' => 5],
			['produto_id' => 34, 'categoria_id' => 5],
			['produto_id' => 35, 'categoria_id' => 5],
			['produto_id' => 36, 'categoria_id' => 5],
			['produto_id' => 37, 'categoria_id' => 5],
			['produto_id' => 38, 'categoria_id' => 5],
			['produto_id' => 39, 'categoria_id' => 5],
			['produto_id' => 40, 'categoria_id' => 5],
			['produto_id' => 41, 'categoria_id' => 5],
			['produto_id' => 42, 'categoria_id' => 5],
			['produto_id' => 43, 'categoria_id' => 5],
			['produto_id' => 45, 'categoria_id' => 9],
			['produto_id' => 46, 'categoria_id' => 9],
			['produto_id' => 47, 'categoria_id' => 5],
			['produto_id' => 44, 'categoria_id' => 9],
			['produto_id' => 48, 'categoria_id' => 5],
			['produto_id' => 49, 'categoria_id' => 5],
			['produto_id' => 50, 'categoria_id' => 5],
			['produto_id' => 51, 'categoria_id' => 5],
			['produto_id' => 52, 'categoria_id' => 5],
	    ]);

	    // Inserir dados na tabela 'forncedores'        
			$fornecedores='';
			for ($i = 0; $i < 54; $i++) {
				$fornNome = gerarNomeAleatorio();
				DB::table('fornecedores')->insert([
					['nome' => $fornNome, 'cnpj' => gerarCNPJAleatorio(), 'email' => gerarEmailAleatorio($fornNome), 'telefone' => gerarTelefoneAleatorio(), 'endereco' => gerarEnderecoAleatorio(), 'bairro' => gerarBairroAleatorio(), 'cidade' => gerarCidadeAleatoria(), 'cep' => gerarCEPAleatorio(), 'created_at' => now(), 'updated_at' => now()],
				]);

			}
    }
}
