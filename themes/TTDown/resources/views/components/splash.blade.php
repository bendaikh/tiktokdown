<section class="hero">
    <div class="container">
        <h1>Download TikTok Video</h1>
        <p class="hero-subtitle">
            The ultimate tool for downloading TikTok videos without watermarks.
        </p>
        
        <div class="download-form">
            <form id="downloadForm" action="{{ route('fetch') }}" method="POST">
                @csrf
                <div class="form-group">
                    <input 
                        type="url" 
                        name="url" 
                        class="url-input" 
                        placeholder="Just insert TikTok URL"
                        required
                        autocomplete="off"
                    >
                    <button type="button" class="paste-btn">
                        📋 Paste
                    </button>
                    <button type="submit" class="download-btn" id="downloadBtn">
                        Download
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Download Results -->
        <div id="downloadResults" style="display: none; margin-top: 2rem;">
            <div class="download-card" style="background: var(--card-bg); border-radius: 16px; padding: 2rem; border: 1px solid var(--border-color); max-width: 600px; margin: 0 auto;">
                <div id="videoInfo" style="margin-bottom: 1.5rem;"></div>
                <div id="downloadLinks"></div>
            </div>
        </div>
        
        <!-- Error Message -->
        <div id="errorMessage" style="display: none; margin-top: 1rem;">
            <div style="background: var(--error-color); color: white; padding: 1rem; border-radius: 8px; text-align: center; max-width: 600px; margin: 0 auto;">
                <span id="errorText"></span>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('downloadForm');
    const downloadBtn = document.getElementById('downloadBtn');
    const downloadResults = document.getElementById('downloadResults');
    const errorMessage = document.getElementById('errorMessage');
    const videoInfo = document.getElementById('videoInfo');
    const downloadLinks = document.getElementById('downloadLinks');
    const errorText = document.getElementById('errorText');
    
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        // Reset previous results
        downloadResults.style.display = 'none';
        errorMessage.style.display = 'none';
        
        // Show loading state
        downloadBtn.disabled = true;
        downloadBtn.textContent = 'Processing...';
        
        try {
            const formData = new FormData(form);
            const response = await fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': window.csrf_token,
                    'Accept': 'application/json'
                }
            });
            
            const data = await response.json();
            
            if (data.success && data.video) {
                showVideoResults(data.video);
            } else {
                showError(data.error || 'Failed to fetch video. Please check the URL and try again.');
            }
        } catch (error) {
            showError('Network error. Please try again.');
            console.error('Download error:', error);
        } finally {
            // Reset button state
            downloadBtn.disabled = false;
            downloadBtn.textContent = 'Download';
        }
    });
    
    function showVideoResults(video) {
        // Video info
        videoInfo.innerHTML = `
            <div style="display: flex; gap: 1rem; align-items: center;">
                <img src="${video.cover?.url || ''}" alt="Video thumbnail" style="width: 80px; height: 80px; border-radius: 8px; object-fit: cover;" onerror="this.style.display='none'">
                <div>
                    <h3 style="font-size: 1.125rem; margin-bottom: 0.5rem;">${video.caption || 'TikTok Video'}</h3>
                    <p style="color: var(--text-secondary); font-size: 0.875rem;">@${video.author?.username || 'Unknown'}</p>
                </div>
            </div>
        `;
        
        // Download links
        let linksHtml = '<div style="display: flex; flex-direction: column; gap: 0.75rem;">';
        
        if (video.downloads && video.downloads.length > 0) {
            video.downloads.forEach((download, index) => {
                const quality = download.isHD ? 'HD' : 'SD';
                const size = download.size ? ` (${download.size})` : '';
                
                linksHtml += `
                    <a href="${download.url}" 
                       target="_blank" 
                       style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 1rem; background: var(--gradient-accent); color: white; text-decoration: none; border-radius: 8px; font-weight: 500; transition: transform 0.3s ease;"
                       onmouseover="this.style.transform='scale(1.02)'"
                       onmouseout="this.style.transform='scale(1)'">
                        <span>📹 Download ${quality} Video${size}</span>
                        <span>⬇️</span>
                    </a>
                `;
            });
        }
        
        // Add watermark download if available
        if (video.watermark?.url) {
            linksHtml += `
                <a href="${video.watermark.url}" 
                   target="_blank" 
                   style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 1rem; background: var(--border-color); color: var(--text-primary); text-decoration: none; border-radius: 8px; font-weight: 500; transition: transform 0.3s ease;"
                   onmouseover="this.style.transform='scale(1.02)'"
                   onmouseout="this.style.transform='scale(1)'">
                    <span>💧 Download with Watermark</span>
                    <span>⬇️</span>
                </a>
            `;
        }
        
        linksHtml += '</div>';
        downloadLinks.innerHTML = linksHtml;
        
        downloadResults.style.display = 'block';
    }
    
    function showError(message) {
        errorText.textContent = message;
        errorMessage.style.display = 'block';
    }
});
</script>
