@php
    $title = $content['title'] ?? 'Título Principal';
    $subtitle = $content['subtitle'] ?? '';
    $ctaText = $content['cta_text'] ?? 'Comenzar';
    $ctaUrl = $content['cta_url'] ?? '#';
    $bgStyle = $settings['background'] ?? 'gradient';
    $textAlign = $settings['text_align'] ?? 'center';
@endphp

<section class="hero-section {{ $bgStyle === 'gradient' ? 'gradient-bg' : 'bg-gray-100' }} text-white py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-{{ $textAlign }}">
            <h1 class="text-5xl md:text-6xl font-bold mb-6">
                {{ $title }}
            </h1>
            
            @if($subtitle)
                <p class="text-xl md:text-2xl mb-8 opacity-90">
                    {{ $subtitle }}
                </p>
            @endif
            
            @if($ctaText)
                <a href="{{ $ctaUrl }}" 
                   class="inline-block bg-white text-purple-600 px-8 py-4 rounded-lg font-semibold text-lg hover:bg-gray-100 transition duration-200 shadow-lg">
                    {{ $ctaText }}
                </a>
            @endif
        </div>
    </div>
</section>
