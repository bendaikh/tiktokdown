@php
    $products = \App\Models\Product::active()->ordered()->limit(8)->get();
@endphp

@if($products->count() > 0)
<section class="affiliate-products" style="padding: 4rem 0; background: var(--secondary-bg);">
    <div class="container">
        <h2 class="section-title">Our Affiliate Products</h2>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem; margin-top: 3rem;">
            @foreach($products as $product)
            <div class="product-card" style="background: var(--card-bg); border-radius: 16px; overflow: hidden; border: 1px solid var(--border-color); transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                @if($product->image_url)
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" style="width: 100%; height: 200px; object-fit: cover;">
                @else
                    <div style="width: 100%; height: 200px; background: var(--gradient-primary); display: flex; align-items: center; justify-content: center; color: white; font-size: 2rem;">
                        🛍️
                    </div>
                @endif
                
                <div style="padding: 1.5rem;">
                    <h3 class="product-title" style="font-size: 1.25rem; font-weight: 600; margin-bottom: 0.5rem; color: var(--text-primary);">
                        {{ $product->name }}
                    </h3>
                    <p class="product-description" style="color: var(--text-secondary); font-size: 0.875rem; margin-bottom: 1rem; line-height: 1.5;">
                        {{ Str::limit($product->description, 80) }}
                    </p>
                    
                    @if($product->price)
                        <div style="margin-bottom: 1rem;">
                            <span style="color: var(--accent-pink); font-weight: 600; font-size: 1.125rem;">
                                {{ $product->currency ?? 'USD' }} ${{ number_format($product->price, 2) }}
                            </span>
                        </div>
                    @endif
                    
                    <a href="{{ $product->affiliate_url }}" target="_blank" class="buy-now-btn" style="display: block; width: 100%; background: var(--gradient-accent); color: white; border: none; padding: 0.75rem 1rem; border-radius: 8px; font-weight: 600; cursor: pointer; transition: transform 0.3s ease; text-decoration: none; text-align: center;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                        Buy Now
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
