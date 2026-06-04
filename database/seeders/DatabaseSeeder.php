<?php

namespace Database\Seeders;

use App\Models\Resume;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Resume::updateOrCreate(['slug' => 'exemplo1'], [
            'user_id' => null,
            'title' => 'Currículo de demonstração',
            'template' => 'modern',
            'data' => [
                'personal' => [
                    'name' => 'Joana Modelo (exemplo)',
                    'title' => 'Desenvolvedora Back-end • Laravel',
                    'email' => 'ana.souza@exemplo.dev',
                    'phone' => '+55 (11) 99999-0000',
                    'location' => 'São Paulo, Brasil',
                    'website' => 'anasouza.dev',
                    'linkedin' => 'linkedin.com/in/anasouza',
                    'github' => 'github.com/anasouza',
                    'summary' => "Desenvolvedora back-end com 6 anos de experiência construindo APIs e aplicações web com PHP/Laravel. Foco em código limpo, testes automatizados e boas práticas de arquitetura. Experiência com Docker, MySQL e filas.",
                ],
                'experiences' => [
                    [
                        'role' => 'Desenvolvedora Back-end Sênior',
                        'company' => 'TechFarm',
                        'start' => '2021',
                        'end' => 'Atual',
                        'description' => "Liderança técnica de um time de 4 pessoas. Migração de monólito para serviços em Laravel. Redução de 40% no tempo de resposta das APIs.",
                    ],
                    [
                        'role' => 'Desenvolvedora Full Stack',
                        'company' => 'Startup XYZ',
                        'start' => '2018',
                        'end' => '2021',
                        'description' => "Desenvolvimento de produto SaaS do zero com Laravel e Vue. Implementação de cobrança recorrente e relatórios.",
                    ],
                ],
                'education' => [
                    [
                        'degree' => 'Bacharelado em Ciência da Computação',
                        'institution' => 'Universidade de São Paulo (USP)',
                        'start' => '2014',
                        'end' => '2018',
                        'description' => '',
                    ],
                ],
                'skills' => ['PHP', 'Laravel', 'MySQL', 'Docker', 'Redis', 'PHPUnit', 'JavaScript', 'Tailwind CSS', 'Git'],
                'projects' => [
                    [
                        'name' => 'Devfolio',
                        'link' => 'github.com/anasouza/devfolio',
                        'description' => 'Gerador de currículos open-source em Laravel 12.',
                    ],
                ],
                'languages' => [
                    ['name' => 'Português', 'level' => 'Nativo'],
                    ['name' => 'Inglês', 'level' => 'Avançado'],
                    ['name' => 'Espanhol', 'level' => 'Intermediário'],
                ],
            ],
        ]);
    }
}
