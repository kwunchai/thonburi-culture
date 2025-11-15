{{-- Modern CSS Styles --}}
<style>
    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .border-l-3 {
        border-left-width: 3px;
    }

    .prose {
        line-height: 1.8;
        color: #374151;
    }

    .prose p {
        margin-bottom: 1.5em;
        text-align: justify;
    }

    .prose h1, .prose h2, .prose h3, .prose h4, .prose h5 {
        color: #1f2937;
        margin-top: 2.5em;
        margin-bottom: 1em;
        font-weight: 600;
        line-height: 1.3;
    }

    .prose h1 { 
        font-size: 2.25rem; 
        font-weight: 700; 
    }
    
    .prose h2 { 
        font-size: 1.875rem; 
        font-weight: 600; 
    }
    
    .prose h3 { 
        font-size: 1.5rem; 
        font-weight: 600; 
    }

    .prose h4 { 
        font-size: 1.25rem; 
        font-weight: 600; 
    }

    .prose ul, .prose ol {
        margin: 1.5em 0;
        padding-left: 2em;
    }

    .prose li {
        margin-bottom: 0.75em;
        line-height: 1.7;
    }

    .prose blockquote {
        border-left: 4px solid #f97316;
        padding: 1.5rem 2rem;
        margin: 2em 0;
        background: linear-gradient(135deg, #fef7f0 0%, #fdedd4 100%);
        border-radius: 0.75rem;
        font-style: italic;
        color: #6b7280;
        position: relative;
    }

    .prose blockquote::before {
        content: '"';
        font-size: 4rem;
        color: #f97316;
        position: absolute;
        top: -0.5rem;
        left: 1rem;
        line-height: 1;
        opacity: 0.3;
    }

    .prose a {
        color: #ea580c;
        text-decoration: underline;
        text-decoration-color: rgba(234, 88, 12, 0.3);
        text-underline-offset: 3px;
        text-decoration-thickness: 2px;
        transition: all 0.2s ease;
    }

    .prose a:hover {
        color: #c2410c;
        text-decoration-color: #ea580c;
    }

    .prose code {
        background: #f3f4f6;
        padding: 0.25rem 0.5rem;
        border-radius: 0.375rem;
        font-size: 0.875em;
        font-family: 'Courier New', monospace;
        color: #1f2937;
    }

    .prose pre {
        background: #1f2937;
        color: #f9fafb;
        padding: 1.5rem;
        border-radius: 0.75rem;
        overflow-x: auto;
        margin: 2em 0;
        font-family: 'Courier New', monospace;
    }

    .prose img {
        border-radius: 0.75rem;
        margin: 2em 0;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease;
    }

    .prose img:hover {
        transform: scale(1.02);
    }

    .prose table {
        width: 100%;
        margin: 2em 0;
        border-collapse: collapse;
        border-radius: 0.5rem;
        overflow: hidden;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .prose th, .prose td {
        border: 1px solid #e5e7eb;
        padding: 0.75rem 1rem;
        text-align: left;
    }

    .prose th {
        background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
        font-weight: 600;
        color: #374151;
    }

    .prose tbody tr:nth-child(even) {
        background: #f9fafb;
    }

    /* Enhanced social share buttons */
    .social-btn {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        transform: translateY(0) scale(1);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .social-btn:hover {
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
    }

    .social-btn:active {
        transform: translateY(0) scale(0.98);
    }

    /* Smooth scroll behavior */
    html {
        scroll-behavior: smooth;
    }

    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #f97316, #ea580c);
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(135deg, #ea580c, #c2410c);
    }

    /* Enhanced animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }

    .fade-in-up {
        animation: fadeInUp 0.8s ease-out;
    }

    .slide-in-left {
        animation: slideInLeft 0.6s ease-out;
    }

    .animate-pulse {
        animation: pulse 2s infinite;
    }

    /* Sticky sidebar enhancements */
    .sticky {
        position: sticky;
        top: 2rem;
    }

    /* Loading states */
    .loading {
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: loading 1.5s infinite;
    }

    @keyframes loading {
        0% { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }

    /* Enhanced responsive design */
    @media (max-width: 768px) {
        .prose h1 { font-size: 2rem; }
        .prose h2 { font-size: 1.75rem; }
        .prose h3 { font-size: 1.5rem; }
        .prose h4 { font-size: 1.25rem; }
        
        .prose p, .prose li {
            text-align: left;
        }
        
        .prose {
            font-size: 1rem;
        }
    }

    @media (max-width: 640px) {
        .prose h1 { font-size: 1.75rem; }
        .prose h2 { font-size: 1.5rem; }
        .prose h3 { font-size: 1.25rem; }
        
        .prose blockquote {
            padding: 1rem 1.5rem;
            margin: 1.5em 0;
        }
        
        .prose blockquote::before {
            font-size: 3rem;
            top: -0.25rem;
            left: 0.75rem;
        }
    }

    /* Print styles */
    @media print {
        .social-btn, #backToTop, .sticky {
            display: none !important;
        }
        
        .prose {
            color: #000 !important;
        }
        
        .prose a {
            color: #000 !important;
            text-decoration: none !important;
        }
        
        .prose a::after {
            content: " (" attr(href) ")";
            font-size: 0.8em;
            color: #666;
        }
    }
</style>
</style>