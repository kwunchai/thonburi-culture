import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                // PRIMARY PALETTE - Thonburi Cultural Theme
                thonburi: {
                    // Gold Series (Temple ornaments, Buddhist heritage)
                    gold: {
                        50: '#FFFBEB',
                        100: '#FEF3C7',
                        200: '#FDE68A',
                        300: '#FCD34D',
                        400: '#FBBF24',
                        500: '#F59E0B',
                        600: '#D97706',
                        700: '#B45309',
                        800: '#92400E',
                        900: '#78350F',
                    },
                    // Navy Series (Chao Phraya River depth)
                    navy: {
                        50: '#F0F9FF',
                        100: '#E0F2FE',
                        200: '#BAE6FD',
                        300: '#7DD3FC',
                        400: '#38BDF8',
                        500: '#0EA5E9',
                        600: '#0284C7',
                        700: '#0369A1',
                        800: '#075985',
                        900: '#0C4A6E',
                    },
                    // River Series (Chao Phraya River - for navigation)
                    river: {
                        50: '#eff6ff',
                        100: '#dbeafe',
                        200: '#bfdbfe',
                        300: '#93c5fd',
                        400: '#60a5fa',
                        500: '#1e40af',
                        600: '#1e3a8a',
                        700: '#1e3a8a',
                        800: '#1e3a8a',
                        900: '#0f172a',
                    },
                    // Wood Series (Teak houses, traditional architecture)
                    wood: {
                        50: '#FDF8F6',
                        100: '#F2E8E5',
                        200: '#EADDD7',
                        300: '#E0CBBE',
                        400: '#D2B8AA',
                        500: '#BC9F8B',
                        600: '#9C6644',
                        700: '#8B4513',
                        800: '#6F3609',
                        900: '#582C0A',
                    },
                    // Terracotta Series (Clay pottery, temple roofs)
                    terra: {
                        50: '#FEF2F2',
                        100: '#FEE2E2',
                        200: '#FECACA',
                        300: '#FCA5A5',
                        400: '#F87171',
                        500: '#EF4444',
                        600: '#DC2626',
                        700: '#B91C1C',
                        800: '#991B1B',
                        900: '#7F1D1D',
                    },
                    // Sand Series (Riverside sand, neutral warm)
                    sand: {
                        50: '#FDFCFB',
                        100: '#FBF9F7',
                        200: '#F7F4EE',
                        300: '#F3EDE3',
                        400: '#E8DCC8',
                        500: '#D4C5A9',
                        600: '#B8A588',
                        700: '#9B8767',
                        800: '#7D6B4F',
                        900: '#5C4F3A',
                    },
                    // Emerald Series (Lotus leaves, Thai gardens)
                    emerald: {
                        50: '#ECFDF5',
                        100: '#D1FAE5',
                        200: '#A7F3D0',
                        300: '#6EE7B7',
                        400: '#34D399',
                        500: '#10B981',
                        600: '#059669',
                        700: '#047857',
                        800: '#065F46',
                        900: '#064E3B',
                    },
                    // Lotus Series (Sacred flower, festivals)
                    lotus: {
                        50: '#FDF4FF',
                        100: '#FAE8FF',
                        200: '#F5D0FE',
                        300: '#F0ABFC',
                        400: '#E879F9',
                        500: '#D946EF',
                        600: '#C026D3',
                        700: '#A21CAF',
                        800: '#86198F',
                        900: '#701A75',
                    },
                },
                
                // SEMANTIC COLORS
                heritage: {
                    primary: '#F59E0B',
                    secondary: '#0369A1',
                    accent: '#EF4444',
                    warm: '#FBF9F7',
                    dark: '#0C4A6E',
                },
                
                // SPECIAL HERITAGE COLORS
                temple: {
                    gold: '#f59e0b',
                    marble: '#F8F8FF',
                    ruby: '#E0115F',
                    shadow: '#78350f',
                },
                
                river: {
                    blue: '#1e40af',
                    dark: '#1e3a8a',
                    foam: '#B0E0E6',
                },
                
                neutral: {
                    bg: {
                        DEFAULT: '#fafaf9',
                        secondary: '#f5f5f4',
                        tertiary: '#e7e5e4',
                    },
                    border: {
                        DEFAULT: '#d6d3d1',
                        light: '#e7e5e4',
                        dark: '#a8a29e',
                    },
                    text: {
                        primary: '#1c1917',
                        secondary: '#44403c',
                        tertiary: '#78716c',
                        disabled: '#a8a29e',
                    },
                },
                
                market: {
                    orange: '#FF8C42',
                    green: '#7CB342',
                },
            },
            
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                thai: ['Sarabun', 'Noto Sans Thai', 'sans-serif'],
                display: ['Prompt', 'sans-serif'],
                body: ['Kanit', 'sans-serif'],
            },
            
            spacing: {
                '18': '4.5rem',
                '88': '22rem',
                '112': '28rem',
                '128': '32rem',
            },
            
            borderRadius: {
                'heritage': '0.75rem',
                'xl': '1rem',
                '2xl': '1.5rem',
                '3xl': '2rem',
            },
            
            boxShadow: {
                'heritage': '0 4px 14px 0 rgba(30, 64, 175, 0.1)',
                'river': '0 8px 24px 0 rgba(30, 64, 175, 0.15)',
                'gold': '0 4px 14px 0 rgba(245, 158, 11, 0.2)',
                'soft': '0 2px 8px 0 rgba(28, 25, 23, 0.05)',
            },
            
            backgroundImage: {
                'thai-pattern': "url('/images/patterns/thai-pattern.svg')",
                'gradient-gold': 'linear-gradient(135deg, #F59E0B 0%, #D97706 100%)',
                'gradient-river': 'linear-gradient(135deg, #0EA5E9 0%, #0369A1 100%)',
                'gradient-sunset': 'linear-gradient(135deg, #F59E0B 0%, #EF4444 100%)',
            },
        },
    },

    plugins: [forms],
};
