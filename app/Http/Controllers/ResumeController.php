<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreResumeRequest;
use App\Models\Resume;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ResumeController extends Controller
{
    /** Lista apenas os currículos do usuário logado. */
    public function index(Request $request): View
    {
        $resumes = $request->user()->resumes()->latest()->get();

        return view('resumes.index', compact('resumes'));
    }

    /** Galeria pública dos modelos disponíveis (não exige login). */
    public function gallery(): View
    {
        $sample = $this->sampleData();

        $samples = collect(Resume::TEMPLATES)->map(function ($meta, $key) use ($sample) {
            return new Resume([
                'slug' => $key,
                'title' => $meta['label'],
                'template' => $key,
                'data' => $sample,
            ]);
        });

        return view('templates', ['samples' => $samples]);
    }

    /** Dados fictícios usados na galeria de modelos. */
    private function sampleData(): array
    {
        return [
            'personal' => [
                'name' => 'Ana Martins',
                'title' => 'Desenvolvedora Full Stack',
                'email' => 'ana@exemplo.dev',
                'phone' => '+55 (11) 90000-0000',
                'location' => 'São Paulo, Brasil',
                'website' => 'ana.dev',
                'linkedin' => 'linkedin.com/in/ana',
                'github' => 'github.com/ana',
                'summary' => 'Desenvolvedora com 6 anos de experiência em aplicações web modernas, APIs e bancos de dados.',
            ],
            'experiences' => [
                ['role' => 'Desenvolvedora Sênior', 'company' => 'TechFarm', 'start' => '2021', 'end' => 'Atual', 'description' => 'Liderança técnica e arquitetura de serviços.'],
                ['role' => 'Desenvolvedora', 'company' => 'Startup XYZ', 'start' => '2018', 'end' => '2021', 'description' => 'Produto SaaS do zero.'],
            ],
            'education' => [
                ['degree' => 'Ciência da Computação', 'institution' => 'USP', 'start' => '2014', 'end' => '2018', 'description' => ''],
            ],
            'skills' => ['PHP', 'Laravel', 'JavaScript', 'MySQL', 'Docker', 'Tailwind'],
            'projects' => [
                ['name' => 'Projeto Exemplo', 'link' => 'github.com/ana/projeto', 'description' => 'Aplicação open-source.'],
            ],
            'languages' => [
                ['name' => 'Português', 'level' => 'Nativo'],
                ['name' => 'Inglês', 'level' => 'Avançado'],
            ],
        ];
    }

    /** Formulário de criação (builder vazio). */
    public function create(): View
    {
        return view('resumes.builder', [
            'resume' => null,
            'initial' => [
                'title' => 'Meu currículo',
                'template' => 'modern',
                'data' => null,
            ],
        ]);
    }

    /** Persiste um novo currículo e leva ao link compartilhável. */
    public function store(StoreResumeRequest $request): RedirectResponse
    {
        $resume = Resume::create([
            'user_id' => $request->user()->id,
            'title' => $request->validated('title'),
            'template' => $request->validated('template'),
            'data' => $request->validated('data'),
            'photo_path' => $this->handlePhotoUpload($request),
        ]);

        return redirect()
            ->route('resumes.show', $resume)
            ->with('status', 'Currículo criado! Compartilhe o link abaixo.');
    }

    /** Builder pré-preenchido para edição (apenas do dono). */
    public function edit(Resume $resume): View
    {
        $this->authorizeOwner($resume);

        return view('resumes.builder', [
            'resume' => $resume,
            'initial' => [
                'title' => $resume->title,
                'template' => $resume->template,
                'data' => $resume->data,
            ],
        ]);
    }

    /** Atualiza um currículo existente (apenas do dono). */
    public function update(StoreResumeRequest $request, Resume $resume): RedirectResponse
    {
        $this->authorizeOwner($resume);

        $attributes = [
            'title' => $request->validated('title'),
            'template' => $request->validated('template'),
            'data' => $request->validated('data'),
        ];

        if ($request->boolean('remove_photo')) {
            $this->deletePhoto($resume);
            $attributes['photo_path'] = null;
        } elseif ($request->hasFile('photo')) {
            $this->deletePhoto($resume);
            $attributes['photo_path'] = $this->handlePhotoUpload($request);
        }

        $resume->update($attributes);

        return redirect()
            ->route('resumes.show', $resume)
            ->with('status', 'Currículo atualizado com sucesso.');
    }

    /** Página pública do currículo (link compartilhável) — sem login. */
    public function show(Resume $resume): View
    {
        return view('resumes.show', compact('resume'));
    }

    /** Versão limpa para impressão / salvar em PDF — sem login. */
    public function print(Resume $resume): View
    {
        return view('resumes.print', compact('resume'));
    }

    /** Remove um currículo (apenas do dono). */
    public function destroy(Resume $resume): RedirectResponse
    {
        $this->authorizeOwner($resume);
        $this->deletePhoto($resume);
        $resume->delete();

        return redirect()
            ->route('resumes.index')
            ->with('status', 'Currículo removido.');
    }

    /** Garante que o currículo pertence ao usuário logado. */
    private function authorizeOwner(Resume $resume): void
    {
        abort_unless($resume->user_id === auth()->id(), 403);
    }

    /** Salva a foto enviada (se houver) e devolve o caminho. */
    private function handlePhotoUpload(Request $request): ?string
    {
        if ($request->hasFile('photo')) {
            return $request->file('photo')->store('photos', 'public');
        }

        return null;
    }

    /** Apaga o arquivo de foto do disco, se existir. */
    private function deletePhoto(Resume $resume): void
    {
        if ($resume->photo_path) {
            Storage::disk('public')->delete($resume->photo_path);
        }
    }
}
