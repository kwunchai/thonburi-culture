{{-- Modern CSS Styles --}}
<style>
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

    .prose {
        line-height: 1.8;
    }

    .prose p {
        margin-bottom: 1.5em;
    }

    .prose h1, .prose h2, .prose h3, .prose h4, .prose h5 {
        color: #1f2937;
        margin-top: 2em;
        margin-bottom: 1em;
        font-weight: 600;
    }

    .prose h1 { 
        font-size: 2rem; 
        font-weight: 700; 
    }
    
    .prose h2 { 
        font-size: 1.75rem; 
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
        margin-bottom: 0.5em;
    }

    .prose blockquote {
        border-left: 4px solid #f97316;
        padding-left: 1.5rem;
        font-style: italic;
        color: #6b7280;
        margin: 2em 0;
        background: #fef7f0;
        padding: 1.5rem;
        border-radius: 0.5rem;
    }

    .prose a {
        color: #ea580c;
        text-decoration: underline;
        text-underline-offset: 2px;
    }

    .prose a:hover {
        color: #c2410c;
    }

    .prose code {
        background: #f3f4f6;
        padding: 0.125rem 0.25rem;
        border-radius: 0.25rem;
        font-size: 0.875em;
    }

    .prose pre {
        background: #1f2937;
        color: #f9fafb;
        padding: 1.5rem;
        border-radius: 0.5rem;
        overflow-x: auto;
        margin: 1.5em 0;
    }

    .prose img {
        border-radius: 0.5rem;
        margin: 1.5em 0;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
    }

    .prose table {
        width: 100%;
        margin: 2em 0;
        border-collapse: collapse;
    }

    .prose th, .prose td {
        border: 1px solid #e5e7eb;
        padding: 0.75rem;
        text-align: left;
    }

    .prose th {
        background: #f9fafb;
        font-weight: 600;
    }

    /* Social share buttons hover effects */
    .social-btn {
        transition: all 0.3s ease;
        transform: translateY(0);
    }

    .social-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    /* Smooth scroll behavior */
    html {
        scroll-behavior: smooth;
    }

    /* Custom scrollbar for webkit browsers */
    ::-webkit-scrollbar {
        width: 8px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    ::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #a1a1a1;
    }

    /* Animation for cards */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fade-in-up {
        animation: fadeInUp 0.6s ease-out;
    }

    /* Responsive text sizes */
    @media (max-width: 768px) {
        .prose h1 { font-size: 1.75rem; }
        .prose h2 { font-size: 1.5rem; }
        .prose h3 { font-size: 1.25rem; }
    }
</style>
</style>