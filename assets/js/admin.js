/**
 * Admin Panel Helpers
 * Sarahswati Agni Brand Website
 */

document.addEventListener('DOMContentLoaded', () => {
    
    // 1. Auto-Dismiss Alert Messages
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s ease-out, transform 0.5s ease-out, max-height 0.5s ease-out';
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            alert.style.maxHeight = '0';
            alert.style.paddingTop = '0';
            alert.style.paddingBottom = '0';
            alert.style.marginTop = '0';
            alert.style.marginBottom = '0';
            setTimeout(() => {
                alert.remove();
            }, 500);
        }, 5000);
    });

    // 2. Client-side Image Size Validation
    const fileInputs = document.querySelectorAll('input[type="file"]');
    fileInputs.forEach(input => {
        input.addEventListener('change', (e) => {
            const files = e.target.files;
            if (files.length > 0) {
                const file = files[0];
                const maxSize = 5 * 1024 * 1024; // 5MB
                
                if (file.size > maxSize) {
                    alert(`The file "${file.name}" is too large. Maximum file size allowed is 5MB.`);
                    input.value = ''; // Reset input
                }
            }
        });
    });

    // 3. YouTube URL Helper (for testimonials video URL format)
    const ytInput = document.getElementById('video_url');
    if (ytInput) {
        ytInput.addEventListener('blur', () => {
            const url = ytInput.value.trim();
            if (url) {
                // If it is a full watch link or share link, extract the ID
                const ytRegExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
                const match = url.match(ytRegExp);
                
                if (match && match[2].length === 11) {
                    const videoId = match[2];
                    // Convert to standard shareable watch URL
                    ytInput.value = `https://www.youtube.com/watch?v=${videoId}`;
                }
            }
        });
    }
});

