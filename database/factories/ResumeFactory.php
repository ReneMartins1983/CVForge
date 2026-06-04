<?php

namespace Database\Factories;

use App\Models\Resume;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Resume>
 */
class ResumeFactory extends Factory
{
    protected $model = Resume::class;

    public function definition(): array
    {
        $name = $this->faker->name();

        return [
            'slug' => Str::lower(Str::random(8)),
            'title' => 'Currículo de '.Str::before($name, ' '),
            'template' => $this->faker->randomElement(array_keys(Resume::TEMPLATES)),
            'data' => [
                'personal' => [
                    'name' => $name,
                    'title' => $this->faker->jobTitle(),
                    'email' => $this->faker->safeEmail(),
                    'phone' => $this->faker->phoneNumber(),
                    'location' => $this->faker->city().', Brasil',
                    'website' => '',
                    'linkedin' => 'linkedin.com/in/'.Str::slug($name),
                    'github' => 'github.com/'.Str::slug($name),
                    'summary' => $this->faker->paragraph(4),
                ],
                'experiences' => [
                    [
                        'role' => 'Desenvolvedor(a) Full Stack',
                        'company' => $this->faker->company(),
                        'start' => '2022',
                        'end' => 'Atual',
                        'description' => $this->faker->paragraph(3),
                    ],
                ],
                'education' => [
                    [
                        'degree' => 'Bacharelado em Ciência da Computação',
                        'institution' => 'Universidade Federal',
                        'start' => '2016',
                        'end' => '2020',
                        'description' => '',
                    ],
                ],
                'skills' => ['PHP', 'Laravel', 'JavaScript', 'MySQL', 'Docker', 'Tailwind CSS'],
                'projects' => [],
                'languages' => [
                    ['name' => 'Português', 'level' => 'Nativo'],
                    ['name' => 'Inglês', 'level' => 'Avançado'],
                ],
            ],
        ];
    }
}
