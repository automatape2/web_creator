@php
    $html = $content['html'] ?? $content['text'] ?? '';
    $textAlign = $settings['text_align'] ?? 'left';
@endphp

<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto prose lg:prose-xl text-{{ $textAlign }}">
            {!! $html !!}
        </div>
    </div>
</section>
