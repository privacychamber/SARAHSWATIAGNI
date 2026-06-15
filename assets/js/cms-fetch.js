document.addEventListener('DOMContentLoaded', async () => {
    try {
        const res = await fetch('/api/content');
        if (!res.ok) throw new Error('Failed to fetch CMS content');
        const contentData = await res.json();
        
        // Find all elements with data-content-key
        const elements = document.querySelectorAll('[data-content-key]');
        
        elements.forEach(el => {
            const key = el.getAttribute('data-content-key');
            if (contentData[key]) {
                const value = contentData[key];
                // Check if it's an image
                if (el.tagName === 'IMG') {
                    el.src = value;
                } else {
                    // For text and HTML
                    el.innerHTML = value;
                }
            }
        });
    } catch (err) {
        console.error('CMS Fetch Error:', err);
    }
});
