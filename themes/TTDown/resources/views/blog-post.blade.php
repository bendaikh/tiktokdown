<x-theme::layout>
    <section class="blog-post">
        <div class="container" style="max-width:768px; margin:2rem auto;">
            <article>
                <h1 style="font-size:2.25rem; font-weight:800; margin-bottom:1rem;">{{ $post->title }}</h1>
                <p style="color:#6b7280; margin-bottom:1.5rem;">{{ $post->published_at?->format('M d, Y') }} • by {{ $post->author->name ?? 'Admin' }}</p>

                @if($post->featured_image)
                    <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" style="width:100%; height:auto; border-radius:8px; margin-bottom:1.5rem;">
                @endif

                <div class="post-content prose">{!! $post->content !!}</div>
            </article>
        </div>
    </section>
</x-theme::layout>
