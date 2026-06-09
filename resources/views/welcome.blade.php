<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('welcome.title') }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
            background: #faf9f7;
            color: #2d2d2d;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .container {
            text-align: center;
            max-width: 640px;
            padding: 40px;
            position: relative;
        }

        .breathing-circle {
            width: 120px;
            height: 120px;
            border: 2px solid #c4b8a8;
            border-radius: 50%;
            margin: 0 auto 48px;
            position: relative;
            animation: breathe 6s ease-in-out infinite;
        }

        .breathing-circle::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 8px;
            height: 8px;
            background: #a89880;
            border-radius: 50%;
            transform: translate(-50%, -50%);
        }

        @keyframes breathe {
            0%, 100% {
                transform: scale(1);
                opacity: 0.6;
            }
            50% {
                transform: scale(1.15);
                opacity: 1;
            }
        }

        h1 {
            font-size: 2.5rem;
            font-weight: 300;
            letter-spacing: -0.02em;
            margin-bottom: 16px;
            color: #1a1a1a;
        }

        .subtitle {
            font-size: 1.125rem;
            color: #6b6560;
            margin-bottom: 48px;
            line-height: 1.6;
            font-weight: 300;
        }

        .benefits {
            display: flex;
            justify-content: center;
            gap: 48px;
            margin-bottom: 48px;
        }

        .benefit {
            text-align: center;
        }

        .benefit-number {
            font-size: 2rem;
            font-weight: 200;
            color: #a89880;
            display: block;
            margin-bottom: 4px;
        }

        .benefit-label {
            font-size: 0.875rem;
            color: #8a847e;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .cta-button {
            display: inline-block;
            padding: 16px 40px;
            background: #2d2d2d;
            color: #faf9f7;
            text-decoration: none;
            border-radius: 4px;
            font-size: 0.9375rem;
            letter-spacing: 0.02em;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .cta-button:hover {
            background: #1a1a1a;
            transform: translateY(-1px);
        }

        .quote {
            margin-top: 40px;
            font-size: 0.875rem;
            color: #9a948e;
            font-style: italic;
            font-weight: 300;
        }

        .language-switcher {
            position: absolute;
            top: 24px;
            right: 24px;
            display: flex;
            gap: 8px;
        }

        .language-switcher a {
            font-size: 0.875rem;
            color: #8a847e;
            text-decoration: none;
            padding: 4px 8px;
            border-radius: 4px;
            transition: all 0.2s ease;
        }

        .language-switcher a:hover {
            color: #2d2d2d;
        }

        .language-switcher a.active {
            color: #2d2d2d;
            background: rgba(168, 152, 128, 0.15);
        }

        @media (max-width: 640px) {
            h1 {
                font-size: 1.875rem;
            }

            .benefits {
                gap: 32px;
            }

            .benefit-number {
                font-size: 1.5rem;
            }

            .language-switcher {
                top: 16px;
                right: 16px;
            }
        }
    </style>
</head>
<body>
{{--    <div class="language-switcher">--}}
{{--        <a href="{{ route('welcome', ['locale' => 'en']) }}" class="{{ app()->getLocale() === 'en' ? 'active' : '' }}">EN</a>--}}
{{--        <a href="{{ route('welcome', ['locale' => 'ru']) }}" class="{{ app()->getLocale() === 'ru' ? 'active' : '' }}">RU</a>--}}
{{--    </div>--}}

    <div class="container">
        <div class="breathing-circle"></div>

        <h1>{{ __('welcome.title') }}</h1>

        <p class="subtitle">
            {!! nl2br(e(__('welcome.subtitle'))) !!}
        </p>

        <div class="benefits">
            <div class="benefit">
                <span class="benefit-number">{{ __('welcome.benefits.stress.value') }}</span>
                <span class="benefit-label">{{ __('welcome.benefits.stress.label') }}</span>
            </div>
            <div class="benefit">
                <span class="benefit-number">{{ __('welcome.benefits.focus.value') }}</span>
                <span class="benefit-label">{{ __('welcome.benefits.focus.label') }}</span>
            </div>
            <div class="benefit">
                <span class="benefit-number">{{ __('welcome.benefits.sleep.value') }}</span>
                <span class="benefit-label">{{ __('welcome.benefits.sleep.label') }}</span>
            </div>
        </div>

        <a href="#start" class="cta-button">{{ __('welcome.cta_button') }}</a>

        <p class="quote">{{ __('welcome.quote') }}</p>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const elements = document.querySelectorAll('.container > *');
            elements.forEach((el, index) => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(20px)';
                el.style.transition = 'opacity 0.8s ease, transform 0.8s ease';

                setTimeout(() => {
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                }, index * 150);
            });
        });
    </script>
</body>
</html>
