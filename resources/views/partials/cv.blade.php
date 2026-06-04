@php
    $d = $resume->data ?? [];
    $p = $d['personal'] ?? [];
    $photoSrc = ($photoOverride ?? null) ?: $resume->photoUrl();
    $showPhoto = $resume->usesPhoto() && $photoSrc;
    $contacts = collect([
        $p['email'] ?? null,
        $p['phone'] ?? null,
        $p['location'] ?? null,
        $p['website'] ?? null,
        $p['linkedin'] ?? null,
        $p['github'] ?? null,
    ])->filter()->values();
@endphp

<article class="cv cv--{{ $resume->template }}{{ $showPhoto ? ' cv--has-photo' : '' }}">
    <header class="cv__header">
        @if ($showPhoto)
            <img src="{{ $photoSrc }}" class="cv__photo" alt="Foto de {{ $p['name'] ?? '' }}">
        @endif
        <h1 class="cv__name">{{ $p['name'] ?? 'Sem nome' }}</h1>
        @if (!empty($p['title']))
            <p class="cv__role">{{ $p['title'] }}</p>
        @endif
        @if ($contacts->isNotEmpty())
            <div class="cv__contacts">
                @foreach ($contacts as $contact)
                    <span>{{ $contact }}</span>
                @endforeach
            </div>
        @endif
    </header>

    @if (!empty($p['summary']))
        <section class="cv__section">
            <h2 class="cv__section-title">Resumo</h2>
            <div class="cv__section-body">
                <p class="cv__summary">{{ $p['summary'] }}</p>
            </div>
        </section>
    @endif

    @if (!empty($d['experiences']))
        <section class="cv__section">
            <h2 class="cv__section-title">Experiência</h2>
            <div class="cv__section-body">
                @foreach ($d['experiences'] as $exp)
                    <div class="cv__item">
                        <div class="cv__item-head">
                            <div>
                                <span class="cv__item-title">{{ $exp['role'] ?? '' }}</span>
                                @if (!empty($exp['company']))
                                    <span class="cv__item-sub">· {{ $exp['company'] }}</span>
                                @endif
                            </div>
                            @if (!empty($exp['start']) || !empty($exp['end']))
                                <span class="cv__item-period">{{ trim(($exp['start'] ?? '').' — '.($exp['end'] ?? ''), ' —') }}</span>
                            @endif
                        </div>
                        @if (!empty($exp['description']))
                            <p class="cv__item-desc">{{ $exp['description'] }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    @if (!empty($d['education']))
        <section class="cv__section">
            <h2 class="cv__section-title">Formação</h2>
            <div class="cv__section-body">
                @foreach ($d['education'] as $edu)
                    <div class="cv__item">
                        <div class="cv__item-head">
                            <div>
                                <span class="cv__item-title">{{ $edu['degree'] ?? '' }}</span>
                                @if (!empty($edu['institution']))
                                    <span class="cv__item-sub">· {{ $edu['institution'] }}</span>
                                @endif
                            </div>
                            @if (!empty($edu['start']) || !empty($edu['end']))
                                <span class="cv__item-period">{{ trim(($edu['start'] ?? '').' — '.($edu['end'] ?? ''), ' —') }}</span>
                            @endif
                        </div>
                        @if (!empty($edu['description']))
                            <p class="cv__item-desc">{{ $edu['description'] }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    @if (!empty($d['projects']))
        <section class="cv__section">
            <h2 class="cv__section-title">Projetos</h2>
            <div class="cv__section-body">
                @foreach ($d['projects'] as $proj)
                    <div class="cv__item">
                        <div class="cv__item-head">
                            <span class="cv__item-title">{{ $proj['name'] ?? '' }}</span>
                        </div>
                        @if (!empty($proj['link']))
                            <a class="cv__link" href="#">{{ $proj['link'] }}</a>
                        @endif
                        @if (!empty($proj['description']))
                            <p class="cv__item-desc">{{ $proj['description'] }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    @if (!empty(array_filter($d['skills'] ?? [])))
        <section class="cv__section">
            <h2 class="cv__section-title">Habilidades</h2>
            <div class="cv__section-body">
                <div class="cv__chips">
                    @foreach ($d['skills'] as $skill)
                        <span class="cv__chip">{{ $skill }}</span>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if (!empty($d['languages']))
        <section class="cv__section">
            <h2 class="cv__section-title">Idiomas</h2>
            <div class="cv__section-body">
                <div class="cv__langs">
                    @foreach ($d['languages'] as $lang)
                        <div class="cv__lang">{{ $lang['name'] ?? '' }} @if (!empty($lang['level']))<span class="lvl">· {{ $lang['level'] }}</span>@endif</div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</article>
