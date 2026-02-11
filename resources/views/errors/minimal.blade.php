<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title')</title>
        
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
        
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
                background: linear-gradient(135deg, #f5f7fa 0%, #e8ecf1 100%);
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 20px;
                color: #2d3748;
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
            }

            .error-container {
                max-width: 600px;
                width: 100%;
                background: white;
                border-radius: 16px;
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.08);
                overflow: hidden;
                animation: slideUp 0.6s ease-out;
            }

            @keyframes slideUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .error-header {
                background: linear-gradient(135deg, #8B0000 0%, #a30000 100%);
                padding: 40px 30px;
                text-align: center;
                position: relative;
                overflow: hidden;
            }

            .error-header::before {
                content: '';
                position: absolute;
                top: -50%;
                right: -50%;
                width: 200%;
                height: 200%;
                background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
                animation: pulse 4s ease-in-out infinite;
            }

            @keyframes pulse {
                0%, 100% { transform: scale(1); opacity: 0.5; }
                50% { transform: scale(1.1); opacity: 0.3; }
            }

            .error-code {
                font-size: 96px;
                font-weight: 700;
                color: white;
                line-height: 1;
                margin-bottom: 10px;
                position: relative;
                text-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            }

            .error-message {
                font-size: 24px;
                font-weight: 500;
                color: rgba(255, 255, 255, 0.95);
                position: relative;
                letter-spacing: 0.5px;
            }

            .error-body {
                padding: 40px 30px;
                text-align: center;
            }

            .error-description {
                font-size: 16px;
                color: #718096;
                line-height: 1.6;
                margin-bottom: 30px;
            }

            .error-actions {
                display: flex;
                gap: 12px;
                justify-content: center;
                flex-wrap: wrap;
            }

            .btn {
                display: inline-flex;
                align-items: center;
                padding: 12px 28px;
                border-radius: 8px;
                font-size: 15px;
                font-weight: 600;
                text-decoration: none;
                transition: all 0.3s ease;
                border: none;
                cursor: pointer;
                font-family: inherit;
            }

            .btn-primary {
                background: #8B0000;
                color: white;
                box-shadow: 0 4px 12px rgba(139, 0, 0, 0.2);
            }

            .btn-primary:hover {
                background: #a30000;
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(139, 0, 0, 0.3);
            }

            .btn-secondary {
                background: #f7fafc;
                color: #4a5568;
                border: 2px solid #e2e8f0;
            }

            .btn-secondary:hover {
                background: #edf2f7;
                border-color: #cbd5e0;
                transform: translateY(-2px);
            }

            .error-icon {
                width: 80px;
                height: 80px;
                margin: 0 auto 20px;
                background: #fee;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #8B0000;
                font-size: 40px;
            }

            /* Responsive */
            @media (max-width: 640px) {
                .error-code {
                    font-size: 72px;
                }

                .error-message {
                    font-size: 20px;
                }

                .error-header {
                    padding: 30px 20px;
                }

                .error-body {
                    padding: 30px 20px;
                }

                .error-actions {
                    flex-direction: column;
                }

                .btn {
                    width: 100%;
                    justify-content: center;
                }
            }
        </style>
    </head>
    <body>
        <div class="error-container">
            <div class="error-header">
                <div class="error-code">@yield('code')</div>
                <div class="error-message">@yield('message')</div>
            </div>
            
            <div class="error-body">
                <div class="error-icon">
                    @yield('icon', '⚠️')
                </div>
                
                <p class="error-description">
                    @yield('description', 'The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.')
                </p>

                <div class="error-actions">
                    <a href="{{ url('/') }}" class="btn btn-primary">
                        ← Back to Home
                    </a>
                    <a href="javascript:history.back()" class="btn btn-secondary">
                        Go Back
                    </a>
                </div>
            </div>
        </div>
    </body>
</html>