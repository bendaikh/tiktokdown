@php
    use Illuminate\Support\Str;
    $posts = \App\Models\Blog::published()->latest('published_at')->take(5)->get();
@endphp

@if($posts->count())
<section class="blog">
    <div class="container">
        <h2 class="section-title">Latest Blog Posts</h2>

        <div class="blog-grid">
            @foreach($posts as $post)
                <a href="{{ route('blog.show', $post) }}" class="blog-card">
                    @if($post->featured_image)
                        <div class="blog-image" style="background-image:url('{{ $post->featured_image }}')"></div>
                    @endif
                    <div class="blog-content">
                        <h3 class="blog-title">{{ $post->title }}</h3>
                        <p class="blog-excerpt">{{ Str::limit(strip_tags($post->description ?? $post->excerpt), 120) }}</p>
                        <span class="read-more">Read More →</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif
