<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

//*
function endDetail(){
	$Detalhe = ' nº '.str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT).' '.(rand(0, 4) ? '' : '- '.chr(rand(65, 71)));

	$Detalhe = str_replace(' - E', ', Bloco '.str_pad(mt_rand(1, 99), 2, '0', STR_PAD_LEFT).', Ap '.str_pad(mt_rand(100, 999), 4, '0', STR_PAD_LEFT).'-A', $Detalhe);
	$Detalhe = str_replace(' - F', ', Bloco '.str_pad(mt_rand(1, 99), 2, '0', STR_PAD_LEFT).', Ap '.str_pad(mt_rand(100, 999), 4, '0', STR_PAD_LEFT).'-B', $Detalhe);
	$Detalhe = str_replace('- G', ', 2º andar', $Detalhe);
	$Detalhe = str_replace('- H', ' (fundos)', $Detalhe);
	return $Detalhe;
}/**/

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
        	['nome' => 'João Müller Schmidt', 'cpf' => '78420702021', 'email' => 'joao.schmidt@sistemapdv.com', 'telefone' => '(11) 98765-4321', 'endereco' => 'Rua das Moças'.endDetail(), 'bairro' => 'Centro', 'cidade' => 'São Paulo', 'cep' => '01000-000', 'map' => '-23.5505,-46.6333', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Maria Schneider Fischer', 'cpf' => '98102323060', 'email' => 'maria.fischer@sistemapdv.com', 'telefone' => '(21) 98765-4321', 'endereco' => 'Avenida das Acácias'.endDetail(), 'bairro' => 'Copacabana', 'cidade' => 'Rio de Janeiro', 'cep' => '22000-000', 'map' => '-22.9739,-43.1857', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'José Weber Meyer', 'cpf' => '05848809011', 'email' => 'jose.meyer@sistemapdv.com', 'telefone' => '(51) 98765-4321', 'endereco' => 'Rua dos Cravos'.endDetail(), 'bairro' => 'Centro', 'cidade' => 'Porto Alegre', 'cep' => '90000-000', 'map' => '-30.0330,-51.2300', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Ana Wagner Becker', 'cpf' => '38702929031', 'email' => 'ana.becker@sistemapdv.com', 'telefone' => '(41) 98765-4321', 'endereco' => 'Avenida das Begônias'.endDetail(), 'bairro' => 'Batel', 'cidade' => 'Curitiba', 'cep' => '80000-000', 'map' => '-25.4322,-49.2722', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Francisco Hoffmann Schäfer', 'cpf' => '22288198087', 'email' => 'francisco.schaefer@sistemapdv.com', 'telefone' => '(48) 98765-4321', 'endereco' => 'Rua das Rosas'.endDetail(), 'bairro' => 'Centro', 'cidade' => 'Florianópolis', 'cep' => '88000-000', 'map' => '-27.5954,-48.5480', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Paula Koch Richter', 'cpf' => '59766500070', 'email' => 'paula.richter@sistemapdv.com', 'telefone' => '(54) 98765-4321', 'endereco' => 'Avenida dos Lírios'.endDetail(), 'bairro' => 'Centro', 'cidade' => 'Caxias do Sul', 'cep' => '95000-000', 'map' => '-29.1670,-51.1794', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Luiz Bauer Klein', 'cpf' => '49217402087', 'email' => 'luiz.klein@sistemapdv.com', 'telefone' => '(55) 98765-4321', 'endereco' => 'Rua das Violetas'.endDetail(), 'bairro' => 'Centro', 'cidade' => 'Santa Maria', 'cep' => '97000-000', 'map' => '-29.6881,-53.8265', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Carla Wolf Neumann', 'cpf' => '61400535018', 'email' => 'carla.neumann@sistemapdv.com', 'telefone' => '(31) 98765-4321', 'endereco' => 'Avenida dos Girassóis'.endDetail(), 'bairro' => 'Savassi', 'cidade' => 'Belo Horizonte', 'cep' => '30000-000', 'map' => '-19.9386,-43.9379', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Antonio Schwarz Zimmermann', 'cpf' => '97961788000', 'email' => 'antonio.zimmermann@sistemapdv.com', 'telefone' => '(61) 98765-4321', 'endereco' => 'Rua das Orquídeas'.endDetail(), 'bairro' => 'Asa Sul', 'cidade' => 'Brasília', 'cep' => '70000-000', 'map' => '-15.7936,-47.8825', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Renata Braun Schmitt', 'cpf' => '90110695011', 'email' => 'renata.schmitt@sistemapdv.com', 'telefone' => '(67) 98765-4321', 'endereco' => 'Avenida dos Lírios'.endDetail(), 'bairro' => 'Centro', 'cidade' => 'Campo Grande', 'cep' => '79000-000', 'map' => '-20.4509,-54.6163', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Pedro Lange Schmitz', 'cpf' => '02383090026', 'email' => 'pedro.schmitz@sistemapdv.com', 'telefone' => '(24) 98765-4321', 'endereco' => 'Rua dos Cravos'.endDetail(), 'bairro' => 'Centro', 'cidade' => 'Petrópolis', 'cep' => '25600-000', 'map' => '-22.5100,-43.1808', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Camila Krüger Schulz', 'cpf' => '22672529027', 'email' => 'camila.schulz@sistemapdv.com', 'telefone' => '(27) 98765-4321', 'endereco' => 'Avenida das Begônias'.endDetail(), 'bairro' => 'Praia do Canto', 'cidade' => 'Vitória', 'cep' => '29000-000', 'map' => '-20.3155,-40.2922', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Marcio Lehmann Huber', 'cpf' => '00791034054', 'email' => 'marcio.huber@sistemapdv.com', 'telefone' => '(85) 98765-4321', 'endereco' => 'Rua das Rosas'.endDetail(), 'bairro' => 'Aldeota', 'cidade' => 'Fortaleza', 'cep' => '60000-000', 'map' => '-3.7172,-38.5433', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Fernanda Kaiser Fuchs', 'cpf' => '95405448079', 'email' => 'fernanda.fuchs@sistemapdv.com', 'telefone' => '(84) 98765-4321', 'endereco' => 'Avenida dos Girassóis'.endDetail(), 'bairro' => 'Tirol', 'cidade' => 'Natal', 'cep' => '59000-000', 'map' => '-5.7945,-35.2120', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Rafael Peters Haas', 'cpf' => '38576265001', 'email' => 'rafael.haas@sistemapdv.com', 'telefone' => '(92) 98765-4321', 'endereco' => 'Rua dos Cravos'.endDetail(), 'bairro' => 'Adrianópolis', 'cidade' => 'Manaus', 'cep' => '69000-000', 'map' => '-3.0969,-60.0188', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Gabriela Schuster Engel', 'cpf' => '87767507017', 'email' => 'gabriela.engel@sistemapdv.com', 'telefone' => '(91) 98765-4321', 'endereco' => 'Avenida dos Lírios'.endDetail(), 'bairro' => 'Nazaré', 'cidade' => 'Belém', 'cep' => '66000-000', 'map' => '-1.4579,-48.5034', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Carlos Walter Vogel', 'cpf' => '07282733066', 'email' => 'carlos.vogel@sistemapdv.com', 'telefone' => '(68) 98765-4321', 'endereco' => 'Rua das Orquídeas'.endDetail(), 'bairro' => 'Centro', 'cidade' => 'Rio Branco', 'cep' => '69900-000', 'map' => '-9.9718,-67.8076', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Aline Otto Simon', 'cpf' => '25916691041', 'email' => 'aline.simon@sistemapdv.com', 'telefone' => '(16) 98765-4321', 'endereco' => 'Avenida das Acácias'.endDetail(), 'bairro' => 'Centro', 'cidade' => 'Ribeirão Preto', 'cep' => '14000-000', 'map' => '-21.1703,-47.8099', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Roberto Günther Keller', 'cpf' => '24747418016', 'email' => 'roberto.keller@sistemapdv.com', 'telefone' => '(95) 98765-4321', 'endereco' => 'Rua dos Cravos'.endDetail(), 'bairro' => 'Centro', 'cidade' => 'Boa Vista', 'cep' => '69300-000', 'map' => '2.8220,-60.6695', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Mariana Frank Berger', 'cpf' => '54195035066', 'email' => 'mariana.berger@sistemapdv.com', 'telefone' => '(32) 98765-4321', 'endereco' => 'Avenida dos Lírios'.endDetail(), 'bairro' => 'Centro', 'cidade' => 'Juiz de Fora', 'cep' => '36000-000', 'map' => '-21.7627,-43.3431', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Rodrigo Roth Meier', 'cpf' => '93514732019', 'email' => 'rodrigo.meier@sistemapdv.com', 'telefone' => '(49) 98765-4321', 'endereco' => 'Rua das Orquídeas'.endDetail(), 'bairro' => 'Centro', 'cidade' => 'Chapecó', 'cep' => '89800-000', 'map' => '-27.1002,-52.6152', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Patricia Geiger Sauer', 'cpf' => '26217807092', 'email' => 'patricia.sauer@sistemapdv.com', 'telefone' => '(14) 98765-4321', 'endereco' => 'Avenida das Begônias'.endDetail(), 'bairro' => 'Centro', 'cidade' => 'Bauru', 'cep' => '17000-000', 'map' => '-22.3246,-49.0880', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Thiago Dietrich Schreiber', 'cpf' => '94442114013', 'email' => 'thiago.schreiber@sistemapdv.com', 'telefone' => '(98) 98765-4321', 'endereco' => 'Rua dos Cravos'.endDetail(), 'bairro' => 'Ponta do Farol', 'cidade' => 'São Luís', 'cep' => '65000-000', 'map' => '-2.5326,-44.2663', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Letícia Bender Krause', 'cpf' => '18954563040', 'email' => 'leticia.krause@sistemapdv.com', 'telefone' => '(12) 98765-4321', 'endereco' => 'Avenida dos Lírios'.endDetail(), 'bairro' => 'Centro', 'cidade' => 'São José dos Campos', 'cep' => '12000-000', 'map' => '-23.1806,-45.8840', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Gabriel Brandt Winkler', 'cpf' => '18954563040', 'email' => 'gabriel.winkler@sistemapdv.com', 'telefone' => '(54) 98765-4321', 'endereco' => 'Rua das Rosas'.endDetail(), 'bairro' => 'Centro', 'cidade' => 'Caxias do Sul', 'cep' => '95000-000', 'map' => '-29.1670,-51.1794', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Raquel Roth Vetter', 'cpf' => '60506440044', 'email' => 'raquel.vetter@sistemapdv.com', 'telefone' => '(55) 98765-4321', 'endereco' => 'Avenida das Acácias'.endDetail(), 'bairro' => 'Centro', 'cidade' => 'Santa Maria', 'cep' => '97000-000', 'map' => '-29.6881,-53.8265', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Marcelo Nowak Heinz', 'cpf' => '80073292001', 'email' => 'marcelo.heinz@sistemapdv.com', 'telefone' => '(92) 98765-4321', 'endereco' => 'Rua dos Cravos'.endDetail(), 'bairro' => 'Adrianópolis', 'cidade' => 'Manaus', 'cep' => '69000-000', 'map' => '-3.0969,-60.0188', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Beatriz Müller Schmidt', 'cpf' => '78833517020', 'email' => 'beatriz.schmidt@sistemapdv.com', 'telefone' => '(41) 98765-4321', 'endereco' => 'Avenida das Acácias'.endDetail(), 'bairro' => 'Batel', 'cidade' => 'Curitiba', 'cep' => '80000-000', 'map' => '-25.4322,-49.2722', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Diego Schneider Fischer', 'cpf' => '91818636085', 'email' => 'diego.fischer@sistemapdv.com', 'telefone' => '(31) 98765-4321', 'endereco' => 'Rua dos Lírios'.endDetail(), 'bairro' => 'Centro', 'cidade' => 'Belo Horizonte', 'cep' => '30000-000', 'map' => '-19.9386,-43.9379', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Juliana Wagner Becker', 'cpf' => '77295220046', 'email' => 'juliana.becker@sistemapdv.com', 'telefone' => '(61) 98765-4321', 'endereco' => 'Avenida dos Cravos'.endDetail(), 'bairro' => 'Asa Sul', 'cidade' => 'Brasília', 'cep' => '70000-000', 'map' => '-15.7936,-47.8825', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Douglas Hoffmann Schäfer', 'cpf' => '33970764041', 'email' => 'douglas.schaefer@sistemapdv.com', 'telefone' => '(14) 98765-4321', 'endereco' => 'Rua das Rosas'.endDetail(), 'bairro' => 'Centro', 'cidade' => 'Bauru', 'cep' => '17000-000', 'map' => '-22.3246,-49.0880', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Renata Koch Richter', 'cpf' => '64730050053', 'email' => 'renata.richter@sistemapdv.com', 'telefone' => '(92) 98765-4321', 'endereco' => 'Avenida dos Girassóis'.endDetail(), 'bairro' => 'Adrianópolis', 'cidade' => 'Manaus', 'cep' => '69000-000', 'map' => '-3.0969,-60.0188', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Vinícius Bauer Klein', 'cpf' => '00845741004', 'email' => 'vinicius.klein@sistemapdv.com', 'telefone' => '(27) 98765-4321', 'endereco' => 'Rua das Orquídeas'.endDetail(), 'bairro' => 'Praia do Canto', 'cidade' => 'Vitória', 'cep' => '29000-000', 'map' => '-20.3155,-40.2922', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Jéssica Wolf Neumann', 'cpf' => '89953018057', 'email' => 'jessica.neumann@sistemapdv.com', 'telefone' => '(54) 98765-4321', 'endereco' => 'Avenida dos Cravos'.endDetail(), 'bairro' => 'Centro', 'cidade' => 'Caxias do Sul', 'cep' => '95000-000', 'map' => '-29.1670,-51.1794', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Eduardo Schwarz Zimmermann', 'cpf' => '82382062002', 'email' => 'eduardo.zimmermann@sistemapdv.com', 'telefone' => '(68) 98765-4321', 'endereco' => 'Rua dos Lírios'.endDetail(), 'bairro' => 'Centro', 'cidade' => 'Rio Branco', 'cep' => '69900-000', 'map' => '-9.9718,-67.8076', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Amanda Braun Schmitt', 'cpf' => '93532283018', 'email' => 'amanda.schmitt@sistemapdv.com', 'telefone' => '(51) 98765-4321', 'endereco' => 'Avenida das Acácias'.endDetail(), 'bairro' => 'Copacabana', 'cidade' => 'Rio de Janeiro', 'cep' => '22000-000', 'map' => '-22.9739,-43.1857', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Alan Lange Schmitz', 'cpf' => '35946184040', 'email' => 'alan.schmitz@sistemapdv.com', 'telefone' => '(14) 98765-4321', 'endereco' => 'Rua dos Cravos'.endDetail(), 'bairro' => 'Centro', 'cidade' => 'Bauru', 'cep' => '17000-000', 'map' => '-22.3246,-49.0880', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Bruna Krüger Schulz', 'cpf' => '62117582001', 'email' => 'bruna.schulz@sistemapdv.com', 'telefone' => '(55) 98765-4321', 'endereco' => 'Avenida dos Lírios'.endDetail(), 'bairro' => 'Centro', 'cidade' => 'Santa Maria', 'cep' => '97000-000', 'map' => '-29.6881,-53.8265', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Fernando Lehmann Huber', 'cpf' => '08596919007', 'email' => 'fernando.huber@sistemapdv.com', 'telefone' => '(61) 98765-4321', 'endereco' => 'Rua das Rosas'.endDetail(), 'bairro' => 'Asa Sul', 'cidade' => 'Brasília', 'cep' => '70000-000', 'map' => '-15.7936,-47.8825', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Isabela Kaiser Fuchs', 'cpf' => '13206637023', 'email' => 'isabela.fuchs@sistemapdv.com', 'telefone' => '(92) 98765-4321', 'endereco' => 'Avenida das Begônias'.endDetail(), 'bairro' => 'Adrianópolis', 'cidade' => 'Manaus', 'cep' => '69000-000', 'map' => '-3.0969,-60.0188', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Lucas Peters Haas', 'cpf' => '57145728079', 'email' => 'lucas.haas@sistemapdv.com', 'telefone' => '(84) 98765-4321', 'endereco' => 'Rua dos Cravos'.endDetail(), 'bairro' => 'Ponta do Farol', 'cidade' => 'São Luís', 'cep' => '65000-000', 'map' => '-2.5326,-44.2663', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Laura Schuster Engel', 'cpf' => '31984316036', 'email' => 'laura.engel@sistemapdv.com', 'telefone' => '(91) 98765-4321', 'endereco' => 'Avenida dos Girassóis'.endDetail(), 'bairro' => 'Nazaré', 'cidade' => 'Belém', 'cep' => '66000-000', 'map' => '-1.4579,-48.5034', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Adriano Walter Vogel', 'cpf' => '30355484048', 'email' => 'adriano.vogel@sistemapdv.com', 'telefone' => '(68) 98765-4321', 'endereco' => 'Rua das Orquídeas'.endDetail(), 'bairro' => 'Centro', 'cidade' => 'Rio Branco', 'cep' => '69900-000', 'map' => '-9.9718,-67.8076', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Caroline Otto Simon', 'cpf' => '62873212020', 'email' => 'caroline.simon@sistemapdv.com', 'telefone' => '(16) 98765-4321', 'endereco' => 'Avenida das Acácias'.endDetail(), 'bairro' => 'Centro', 'cidade' => 'Ribeirão Preto', 'cep' => '14000-000', 'map' => '-21.1703,-47.8099', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'André Günther Keller', 'cpf' => '11265615098', 'email' => 'andre.keller@sistemapdv.com', 'telefone' => '(95) 98765-4321', 'endereco' => 'Rua dos Cravos'.endDetail(), 'bairro' => 'Centro', 'cidade' => 'Boa Vista', 'cep' => '69300-000', 'map' => '2.8220,-60.6695', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Valéria Frank Berger', 'cpf' => '39411795005', 'email' => 'valeria.berger@sistemapdv.com', 'telefone' => '(32) 98765-4321', 'endereco' => 'Avenida dos Lírios'.endDetail(), 'bairro' => 'Centro', 'cidade' => 'Juiz de Fora', 'cep' => '36000-000', 'map' => '-21.7627,-43.3431', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Gustavo Roth Meier', 'cpf' => '66760091027', 'email' => 'gustavo.meier@sistemapdv.com', 'telefone' => '(49) 98765-4321', 'endereco' => 'Rua das Orquídeas'.endDetail(), 'bairro' => 'Centro', 'cidade' => 'Chapecó', 'cep' => '89800-000', 'map' => '-27.1002,-52.6152', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Camila Geiger Sauer', 'cpf' => '70177308010', 'email' => 'camila.sauer@sistemapdv.com', 'telefone' => '(14) 98765-4321', 'endereco' => 'Avenida das Begônias'.endDetail(), 'bairro' => 'Centro', 'cidade' => 'Bauru', 'cep' => '17000-000', 'map' => '-22.3246,-49.0880', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Leandro Dietrich Schreiber', 'cpf' => '37817752087', 'email' => 'leandro.schreiber@sistemapdv.com', 'telefone' => '(98) 98765-4321', 'endereco' => 'Rua dos Cravos'.endDetail(), 'bairro' => 'Adrianópolis', 'cidade' => 'Manaus', 'cep' => '69000-000', 'map' => '-3.0969,-60.0188', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Nathalia Bender Krause', 'cpf' => '55050524016', 'email' => 'nathalia.krause@sistemapdv.com', 'telefone' => '(12) 98765-4321', 'endereco' => 'Avenida dos Lírios'.endDetail(), 'bairro' => 'Centro', 'cidade' => 'São José dos Campos', 'cep' => '12000-000', 'map' => '-23.1806,-45.8840', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Guilherme Brandt Winkler', 'cpf' => '80303899069', 'email' => 'guilherme.winkler@sistemapdv.com', 'telefone' => '(54) 98765-4321', 'endereco' => 'Rua das Rosas'.endDetail(), 'bairro' => 'Centro', 'cidade' => 'Caxias do Sul', 'cep' => '95000-000', 'map' => '-29.1670,-51.1794', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Ana Clara Roth Vetter', 'cpf' => '23490620070', 'email' => 'anaclara.vetter@sistemapdv.com', 'telefone' => '(55) 98765-4321', 'endereco' => 'Avenida das Acácias'.endDetail(), 'bairro' => 'Centro', 'cidade' => 'Santa Maria', 'cep' => '97000-000', 'map' => '-29.6881,-53.8265', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Raul Nowak Heinz', 'cpf' => '56757487098', 'email' => 'raul.heinz@sistemapdv.com', 'telefone' => '(92) 98765-4321', 'endereco' => 'Rua dos Cravos'.endDetail(), 'bairro' => 'Adrianópolis', 'cidade' => 'Manaus', 'cep' => '69000-000', 'map' => '-3.0969,-60.0188', 'created_at' => now(), 'updated_at' => now()],
			['nome' => 'Júlia Müller Schmidt', 'cpf' => '12977356096', 'email' => 'julia.schmidt@sistemapdv.com', 'telefone' => '(41) 98765-4321', 'endereco' => 'Avenida das Acácias'.endDetail(), 'bairro' => 'Batel', 'cidade' => 'Curitiba', 'cep' => '80000-000', 'map' => '-25.4322,-49.2722', 'created_at' => now(), 'updated_at' => now()],
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
    }
}
