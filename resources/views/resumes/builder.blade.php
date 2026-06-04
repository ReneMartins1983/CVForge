@extends('layouts.app')

@section('title', $resume ? 'Editar currículo' : 'Novo currículo')

@php
    $templates = \App\Models\Resume::TEMPLATES;
    $bootstrap = [
        'title' => old('title', $initial['title']),
        'template' => old('template', $initial['template']),
        'data' => old('payload') ? json_decode(old('payload'), true) : $initial['data'],
        'withPhoto' => \App\Models\Resume::templatesWithPhoto(),
        'photoUrl' => $resume?->photoUrl(),
    ];

    $inputCls = 'w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm transition focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-200 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:focus:ring-brand-900/60';
    $labelCls = 'mb-1 block text-xs font-semibold text-slate-600 dark:text-slate-300';
    $sectionCls = 'rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900';
    $addBtnCls = 'mt-2 inline-flex items-center gap-1 rounded-lg border border-dashed border-slate-300 px-3 py-2 text-sm font-medium text-slate-600 transition hover:border-brand-400 hover:text-brand-600 dark:border-slate-700 dark:text-slate-300';
    $removeBtnCls = 'rounded-md p-1.5 text-slate-400 transition hover:bg-red-50 hover:text-red-600 dark:hover:bg-red-900/30';
@endphp

@section('content')
<form method="POST" enctype="multipart/form-data"
      action="{{ $resume ? route('resumes.update', $resume) : route('resumes.store') }}"
      x-data="builder(@js($bootstrap))"
      x-cloak>
    @csrf
    @if ($resume)
        @method('PUT')
    @endif

    {{-- inputs enviados ao servidor --}}
    <input type="hidden" name="title" :value="title">
    <input type="hidden" name="template" :value="template">
    <input type="hidden" name="payload" :value="payload">
    <input type="hidden" name="remove_photo" :value="removePhoto ? 1 : 0">

    {{-- Barra superior --}}
    <div class="sticky top-[57px] z-20 border-b border-slate-200 bg-slate-50/90 backdrop-blur dark:border-slate-800 dark:bg-slate-950/90">
        <div class="mx-auto flex max-w-7xl flex-col gap-3 px-4 py-3 sm:flex-row sm:items-center sm:justify-between">
            <input type="text" x-model="title" placeholder="Título do currículo"
                   class="w-full max-w-xs rounded-lg border border-transparent bg-transparent px-2 py-1 text-lg font-bold focus:border-slate-300 focus:bg-white focus:outline-none dark:focus:border-slate-700 dark:focus:bg-slate-900">

            <div class="flex items-center gap-3">
                {{-- seletor de modelo (10 opções) --}}
                <label class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
                    Modelo
                    <select x-model="template"
                            class="rounded-lg border border-slate-300 bg-white px-3 py-1.5 text-sm font-medium text-slate-700 shadow-sm focus:border-brand-500 focus:ring-brand-200 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200">
                        <optgroup label="Sem foto">
                            @foreach ($templates as $key => $t)
                                @if (! $t['photo'])
                                    <option value="{{ $key }}">{{ $t['label'] }}</option>
                                @endif
                            @endforeach
                        </optgroup>
                        <optgroup label="Com foto">
                            @foreach ($templates as $key => $t)
                                @if ($t['photo'])
                                    <option value="{{ $key }}">📷 {{ $t['label'] }}</option>
                                @endif
                            @endforeach
                        </optgroup>
                    </select>
                </label>

                <button type="submit"
                        class="rounded-lg bg-brand-600 px-5 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-700">
                    {{ $resume ? 'Salvar alterações' : 'Salvar currículo' }}
                </button>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="mx-auto mt-4 max-w-7xl px-4">
            <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700 dark:border-red-800/50 dark:bg-red-900/30 dark:text-red-300">
                <ul class="list-inside list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="mx-auto grid max-w-7xl gap-6 px-4 py-6 lg:grid-cols-2">
        {{-- ============================= FORMULÁRIO ============================= --}}
        <div class="space-y-5">
            {{-- Dados pessoais --}}
            <section class="{{ $sectionCls }}">
                <h2 class="mb-4 text-sm font-bold uppercase tracking-wide text-slate-500 dark:text-slate-400">Dados pessoais</h2>
                <div class="grid gap-3 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label class="{{ $labelCls }}">Nome completo *</label>
                        <input type="text" x-model="resume.personal.name" class="{{ $inputCls }}" placeholder="Digite seu nome completo">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="{{ $labelCls }}">Cargo / título</label>
                        <input type="text" x-model="resume.personal.title" class="{{ $inputCls }}" placeholder="Ex.: Desenvolvedor(a) Full Stack">
                    </div>
                    <div>
                        <label class="{{ $labelCls }}">E-mail</label>
                        <input type="email" x-model="resume.personal.email" class="{{ $inputCls }}" placeholder="voce@email.com">
                    </div>
                    <div>
                        <label class="{{ $labelCls }}">Telefone</label>
                        <input type="text" x-model="resume.personal.phone" class="{{ $inputCls }}" placeholder="+55 (00) 00000-0000">
                    </div>
                    <div>
                        <label class="{{ $labelCls }}">Localização</label>
                        <input type="text" x-model="resume.personal.location" class="{{ $inputCls }}" placeholder="Cidade, Estado">
                    </div>
                    <div>
                        <label class="{{ $labelCls }}">Website</label>
                        <input type="text" x-model="resume.personal.website" class="{{ $inputCls }}" placeholder="seusite.com">
                    </div>
                    <div>
                        <label class="{{ $labelCls }}">LinkedIn</label>
                        <input type="text" x-model="resume.personal.linkedin" class="{{ $inputCls }}" placeholder="linkedin.com/in/usuario">
                    </div>
                    <div>
                        <label class="{{ $labelCls }}">GitHub</label>
                        <input type="text" x-model="resume.personal.github" class="{{ $inputCls }}" placeholder="github.com/usuario">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="{{ $labelCls }}">Resumo profissional</label>
                        <textarea x-model="resume.personal.summary" rows="4" class="{{ $inputCls }}" placeholder="Conte brevemente sobre sua experiência, stack e objetivos."></textarea>
                    </div>
                </div>
            </section>

            {{-- Foto (apenas modelos com foto) --}}
            <section class="{{ $sectionCls }}" x-show="usesPhoto" x-cloak>
                <h2 class="mb-4 text-sm font-bold uppercase tracking-wide text-slate-500 dark:text-slate-400">Foto de perfil</h2>
                <div class="flex items-center gap-4">
                    <template x-if="shownPhoto">
                        <img :src="shownPhoto" alt="Foto" class="h-20 w-20 rounded-full object-cover ring-2 ring-slate-200 dark:ring-slate-700">
                    </template>
                    <template x-if="!shownPhoto">
                        <div class="flex h-20 w-20 items-center justify-center rounded-full bg-slate-100 text-2xl text-slate-400 dark:bg-slate-800">👤</div>
                    </template>
                    <div class="space-y-2">
                        <input type="file" name="photo" accept="image/*" x-ref="photoInput" @change="onPhoto($event)"
                               class="block text-sm text-slate-600 file:mr-3 file:rounded-lg file:border-0 file:bg-brand-50 file:px-3 file:py-2 file:text-sm file:font-semibold file:text-brand-700 hover:file:bg-brand-100 dark:text-slate-300 dark:file:bg-brand-900/40 dark:file:text-brand-300">
                        <button type="button" x-show="shownPhoto" @click="clearPhoto()"
                                class="text-xs font-medium text-red-600 hover:underline">Remover foto</button>
                        <p class="text-xs text-slate-400">JPG ou PNG, até 2&nbsp;MB.</p>
                    </div>
                </div>
            </section>

            {{-- Experiências --}}
            <section class="{{ $sectionCls }}">
                <h2 class="mb-4 text-sm font-bold uppercase tracking-wide text-slate-500 dark:text-slate-400">Experiência</h2>
                <template x-for="(exp, i) in resume.experiences" :key="i">
                    <div class="mb-4 rounded-xl border border-slate-200 p-4 dark:border-slate-700">
                        <div class="mb-2 flex items-center justify-between">
                            <span class="text-xs font-semibold text-slate-400" x-text="'Experiência ' + (i + 1)"></span>
                            <button type="button" class="{{ $removeBtnCls }}" @click="removeExperience(i)" aria-label="Remover">✕</button>
                        </div>
                        <div class="grid gap-3 sm:grid-cols-2">
                            <input type="text" x-model="exp.role" class="{{ $inputCls }}" placeholder="Cargo">
                            <input type="text" x-model="exp.company" class="{{ $inputCls }}" placeholder="Empresa">
                            <input type="text" x-model="exp.start" class="{{ $inputCls }}" placeholder="Início (ex: 2021)">
                            <input type="text" x-model="exp.end" class="{{ $inputCls }}" placeholder="Fim (ex: Atual)">
                            <textarea x-model="exp.description" rows="3" class="{{ $inputCls }} sm:col-span-2" placeholder="O que você fez, conquistas, tecnologias..."></textarea>
                        </div>
                    </div>
                </template>
                <button type="button" class="{{ $addBtnCls }}" @click="addExperience()">+ Adicionar experiência</button>
            </section>

            {{-- Formação --}}
            <section class="{{ $sectionCls }}">
                <h2 class="mb-4 text-sm font-bold uppercase tracking-wide text-slate-500 dark:text-slate-400">Formação</h2>
                <template x-for="(edu, i) in resume.education" :key="i">
                    <div class="mb-4 rounded-xl border border-slate-200 p-4 dark:border-slate-700">
                        <div class="mb-2 flex items-center justify-between">
                            <span class="text-xs font-semibold text-slate-400" x-text="'Formação ' + (i + 1)"></span>
                            <button type="button" class="{{ $removeBtnCls }}" @click="removeEducation(i)" aria-label="Remover">✕</button>
                        </div>
                        <div class="grid gap-3 sm:grid-cols-2">
                            <input type="text" x-model="edu.degree" class="{{ $inputCls }}" placeholder="Curso / grau">
                            <input type="text" x-model="edu.institution" class="{{ $inputCls }}" placeholder="Instituição">
                            <input type="text" x-model="edu.start" class="{{ $inputCls }}" placeholder="Início">
                            <input type="text" x-model="edu.end" class="{{ $inputCls }}" placeholder="Fim">
                            <textarea x-model="edu.description" rows="2" class="{{ $inputCls }} sm:col-span-2" placeholder="Detalhes (opcional)"></textarea>
                        </div>
                    </div>
                </template>
                <button type="button" class="{{ $addBtnCls }}" @click="addEducation()">+ Adicionar formação</button>
            </section>

            {{-- Habilidades --}}
            <section class="{{ $sectionCls }}">
                <h2 class="mb-4 text-sm font-bold uppercase tracking-wide text-slate-500 dark:text-slate-400">Habilidades</h2>
                <div class="flex flex-wrap gap-2">
                    <template x-for="(skill, i) in resume.skills" :key="i">
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-brand-50 py-1 pl-3 pr-1.5 text-sm font-medium text-brand-700 dark:bg-brand-900/40 dark:text-brand-300">
                            <span x-text="skill"></span>
                            <button type="button" @click="removeSkill(i)" class="rounded-full px-1 text-brand-400 hover:text-brand-700 dark:hover:text-brand-200">✕</button>
                        </span>
                    </template>
                </div>
                <input type="text" x-model="skillInput" @keydown.enter.prevent="addSkill()" @keydown.,.prevent="addSkill()"
                       class="{{ $inputCls }} mt-3" placeholder="Digite uma habilidade e pressione Enter">
            </section>

            {{-- Projetos --}}
            <section class="{{ $sectionCls }}">
                <h2 class="mb-4 text-sm font-bold uppercase tracking-wide text-slate-500 dark:text-slate-400">Projetos</h2>
                <template x-for="(proj, i) in resume.projects" :key="i">
                    <div class="mb-4 rounded-xl border border-slate-200 p-4 dark:border-slate-700">
                        <div class="mb-2 flex items-center justify-between">
                            <span class="text-xs font-semibold text-slate-400" x-text="'Projeto ' + (i + 1)"></span>
                            <button type="button" class="{{ $removeBtnCls }}" @click="removeProject(i)" aria-label="Remover">✕</button>
                        </div>
                        <div class="grid gap-3 sm:grid-cols-2">
                            <input type="text" x-model="proj.name" class="{{ $inputCls }}" placeholder="Nome do projeto">
                            <input type="text" x-model="proj.link" class="{{ $inputCls }}" placeholder="Link (opcional)">
                            <textarea x-model="proj.description" rows="2" class="{{ $inputCls }} sm:col-span-2" placeholder="Descrição"></textarea>
                        </div>
                    </div>
                </template>
                <button type="button" class="{{ $addBtnCls }}" @click="addProject()">+ Adicionar projeto</button>
            </section>

            {{-- Idiomas --}}
            <section class="{{ $sectionCls }}">
                <h2 class="mb-4 text-sm font-bold uppercase tracking-wide text-slate-500 dark:text-slate-400">Idiomas</h2>
                <template x-for="(lang, i) in resume.languages" :key="i">
                    <div class="mb-3 flex items-center gap-3">
                        <input type="text" x-model="lang.name" class="{{ $inputCls }}" placeholder="Idioma">
                        <input type="text" x-model="lang.level" class="{{ $inputCls }}" placeholder="Nível (ex: Avançado)">
                        <button type="button" class="{{ $removeBtnCls }}" @click="removeLanguage(i)" aria-label="Remover">✕</button>
                    </div>
                </template>
                <button type="button" class="{{ $addBtnCls }}" @click="addLanguage()">+ Adicionar idioma</button>
            </section>
        </div>

        {{-- ============================= PREVIEW ============================= --}}
        <div class="lg:sticky lg:top-[120px] lg:h-[calc(100vh-140px)] lg:overflow-y-auto">
            <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-slate-400">Prévia ao vivo <span class="normal-case text-slate-300">(tamanho A4 real)</span></p>
            <div class="preview-frame" x-ref="previewFrame">
              <div class="preview-page" :style="`zoom:${previewZoom}`">
                <div class="cv-paper">
                <article :class="'cv cv--' + template + (usesPhoto && shownPhoto ? ' cv--has-photo' : '')">
                    <header class="cv__header">
                        <template x-if="usesPhoto && shownPhoto">
                            <img :src="shownPhoto" class="cv__photo" alt="">
                        </template>
                        <h1 class="cv__name" x-text="resume.personal.name || 'Seu nome'"></h1>
                        <p class="cv__role" x-show="resume.personal.title" x-text="resume.personal.title"></p>
                        <div class="cv__contacts" x-show="hasContacts">
                            <span x-show="resume.personal.email" x-text="resume.personal.email"></span>
                            <span x-show="resume.personal.phone" x-text="resume.personal.phone"></span>
                            <span x-show="resume.personal.location" x-text="resume.personal.location"></span>
                            <span x-show="resume.personal.website" x-text="resume.personal.website"></span>
                            <span x-show="resume.personal.linkedin" x-text="resume.personal.linkedin"></span>
                            <span x-show="resume.personal.github" x-text="resume.personal.github"></span>
                        </div>
                    </header>

                    <section class="cv__section" x-show="resume.personal.summary">
                        <h2 class="cv__section-title">Resumo</h2>
                        <p class="cv__summary" x-text="resume.personal.summary"></p>
                    </section>

                    <section class="cv__section" x-show="resume.experiences.length">
                        <h2 class="cv__section-title">Experiência</h2>
                        <template x-for="(exp, i) in resume.experiences" :key="i">
                            <div class="cv__item">
                                <div class="cv__item-head">
                                    <div>
                                        <span class="cv__item-title" x-text="exp.role"></span>
                                        <span class="cv__item-sub" x-show="exp.company" x-text="'· ' + exp.company"></span>
                                    </div>
                                    <span class="cv__item-period" x-show="exp.start || exp.end"
                                          x-text="[exp.start, exp.end].filter(Boolean).join(' — ')"></span>
                                </div>
                                <p class="cv__item-desc" x-show="exp.description" x-text="exp.description"></p>
                            </div>
                        </template>
                    </section>

                    <section class="cv__section" x-show="resume.education.length">
                        <h2 class="cv__section-title">Formação</h2>
                        <template x-for="(edu, i) in resume.education" :key="i">
                            <div class="cv__item">
                                <div class="cv__item-head">
                                    <div>
                                        <span class="cv__item-title" x-text="edu.degree"></span>
                                        <span class="cv__item-sub" x-show="edu.institution" x-text="'· ' + edu.institution"></span>
                                    </div>
                                    <span class="cv__item-period" x-show="edu.start || edu.end"
                                          x-text="[edu.start, edu.end].filter(Boolean).join(' — ')"></span>
                                </div>
                                <p class="cv__item-desc" x-show="edu.description" x-text="edu.description"></p>
                            </div>
                        </template>
                    </section>

                    <section class="cv__section" x-show="resume.projects.length">
                        <h2 class="cv__section-title">Projetos</h2>
                        <template x-for="(proj, i) in resume.projects" :key="i">
                            <div class="cv__item">
                                <div class="cv__item-head">
                                    <span class="cv__item-title" x-text="proj.name"></span>
                                </div>
                                <a class="cv__link" x-show="proj.link" x-text="proj.link" href="#"></a>
                                <p class="cv__item-desc" x-show="proj.description" x-text="proj.description"></p>
                            </div>
                        </template>
                    </section>

                    <section class="cv__section" x-show="resume.skills.length">
                        <h2 class="cv__section-title">Habilidades</h2>
                        <div class="cv__chips">
                            <template x-for="(skill, i) in resume.skills" :key="i">
                                <span class="cv__chip" x-text="skill"></span>
                            </template>
                        </div>
                    </section>

                    <section class="cv__section" x-show="resume.languages.length">
                        <h2 class="cv__section-title">Idiomas</h2>
                        <div class="cv__langs">
                            <template x-for="(lang, i) in resume.languages" :key="i">
                                <div class="cv__lang">
                                    <span x-text="lang.name"></span><span class="lvl" x-show="lang.level" x-text="' · ' + lang.level"></span>
                                </div>
                            </template>
                        </div>
                    </section>
                </article>
                </div>
              </div>
            </div>
        </div>
    </div>
</form>
@endsection
